<?php
namespace NoizuLabs\Core\DomainObject;

class QueuedTemplatedEmail extends \NoizuLabs\Core\DomainObject
{
    public $templateDataEntity = null;

    public $requiredFields = array("emailTemplate", "user", "status", "site");
    public $internalFields = array();
    public $optionalFields = array("sentSubject","sentTemplate");
    public $defaultFields = array(
    );

    public function load($mixed) {
        $this->entity = null;
        $this->loaded = false;

        if(is_object($mixed))
        {
            $this->entity = $mixed;
            $this->loaded = true;
        } else  if(is_int($mixed))
        {
            $r = $this->container['Do_Repository_TemplatedEmailQueue'];
            $this->entity = $r->getQueuedEmail($mixed);
            if($this->entity) {
                $this->loaded = true;
            }
        }
    }

    public function save($flush  = true)
    {
        $entityManager = $this->container['EntityManager'];
        $entityManager->persist($this->entity);
        if($this->templateDataEntity) {
            $entityManager->persist($this->templateDataEntity);
        }

        if($flush) {
            try {
                $entityManager->flush();
            } catch(\Exception $e) {
                $this->LogError("400:005", $e->getMessage());
                return null;
            }
        }
        return $this->entity->getId();
    }

    protected function init()
    {
        if($this->loaded == false)
        {
            $this->entity = $this->container['Entity_EmailTemplateQueue'];
            $this->loaded = true;
        }
    }

	function __construct()
	{
        $this->entity = $this->container['Entity_EmailTemplateQueue'];
        parent::__construct();
    }

    function __destruct()
    {
    }

    /**
     * @return \NoizuLabs\Core\Doctrine\Entity\Sites
     * (non-PHPdoc)
     * @see \NoizuLabs\Core\DomainObject::getSite()
     */
    public function getSite()
    {
        $e = $this->getEntity();
        if(isset($e)) {
            $site = $this->getEntity()->getSite();
        }
        if(!$site) {
            $site = parent::getSite();
        }
        return $site;
    }


    //===========================================
    // Send Email Logic
    //===========================================
    /**
     * If re-sending a previously sent (or attempted send) we should be using the saved template ids if present.
     * Note these are only saved on succesful binding. So if there was a major template glitch we can easily resolve by fixing the template and rerunning emails.
     * @param string $flushOnUpdate
     * @return boolean
     */
    public function send($flushOnUpdate = true)
    {
        $this->populateTemplateData();
        $additionalData = array();
        $errors = null;

        // Retrieve Strings,
        $doTemplate = $this->container['Do_EmailTemplate'];
        $doTemplate->setSiteId($this->entity->getSite()->getId());
        $doTemplate->Load($this->getEmailTemplate());

        $msSubject = $doTemplate->getFinalSubject();
        $msTemplate = $doTemplate->getFinalTemplate();

        // Retrieve Data
        $data = $this->getData();

        // Process Strings (get dynamic data)
        // - Grab all {Tags}, foreach tag see if there is a match (Special Sequence for $user and $site
        $r = $this->replaceEmailTags($msSubject->getApprovedText()->getString(), $data);
        $strSubject = $r['processed'];
        if(!empty($r['errors'])) {
            $errors['subject'] = $r['errors'];
        }
        $additionalData['subject'] = $r['additionalData'];

        $r = $this->replaceEmailTags($msTemplate->getApprovedText()->getString(), $data);
        $strTemplate = $r['processed'];
        if(!empty($r['errors'])) {
            $errors['template'] = $r['errors'];
        }
        $additionalData['template'] = $r['additionalData'];

        $status = null;
        // Save Errors if Any, Save SentData if Any
        if(!empty($errors)) {
            $this->setErrors($errors);
            $this->setStatus(\NoizuLabs\Core\DomainObject\Repository\TemplatedEmailQueue::STATUS_ERROR);
            $this->save($flushOnUpdate);
            return false;
        } else {
            $this->setSentSubject($msSubject->getApprovedText());
            $this->setSentTemplate($msTemplate->getApprovedText());
            $this->setSentData($additionalData);
            $email = $this->getUser()->getEmail();
            if(isset($this->container['OutgoingEmailsEnabled']) && $this->container['OutgoingEmailsEnabled'])
            {
                if($this->mail($email, $strSubject, $strTemplate)) {
                    $this->setStatus(\NoizuLabs\Core\DomainObject\Repository\TemplatedEmailQueue::STATUS_SENT);
                    $status = true;
                } else {
                    $this->setStatus(\NoizuLabs\Core\DomainObject\Repository\TemplatedEmailQueue::STATUS_ERROR);
                    $status = false;
                }
            } else {
            echo "
                to:$email
                from: support-email@site.com
                subject: $strSubject
                ======================= message ========================
                $strTemplate
                =======================================================
                ";
            $this->setStatus(\NoizuLabs\Core\DomainObject\Repository\TemplatedEmailQueue::STATUS_OUTGOING_DISABLED);
            $status = true;
            }

            if($status == true) {
                $this->setErrors(null);
            }
            $this->save($flushOnUpdate);
        }
        return $status;
    }

    protected function mail($to, $subject, $message)
    {
        $outgoingEmail = $this->getSite()->getSupportEmail();
        $outgoingEmailName = $this->getSite()->getSupportName();

        if(isset($this->container[$outgoingEmail . ':PASSWORD']))
        {
            $password = $this->container[$outgoingEmail . ':PASSWORD'];
        } else {
            $outgoingEmail = $this->container['DefaultSupportEmail:ADDRESS'];
            $password = $this->container['DefaultSupportEmail:PASSWORD'];
        }

        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
        ->setUsername($outgoingEmail)
        ->setPassword($password);

        $mailer = \Swift_Mailer::newInstance($transport);

        $message = \Swift_Message::newInstance($subject)
        ->setFrom(array($outgoingEmail => $outgoingEmailName))
        ->setTo(array($to))
        ->setBody($message, 'text/html');

        $result = $mailer->send($message);
        return $result;
    }

    protected function replaceEmailTags($string, $data) {
        $errors = array();
        $matches = array();
        $additionalData = array();

        if( preg_match_all("/{[^}]*}/", $string, $matches) === false )
        {
            // unexpected error
            throw new \Exception("Error Binding String Tags");
        } else {
            if(isset($matches[0])) {
                foreach($matches[0] as $match)
                {
                    $r = $this->getReplacement($match, $data);

                    if(array_key_exists("replacement", $r) && !empty($r['replacement']) )
                    {
                        // Do string replacement.
                        $string = str_replace($match, $r['replacement'], $string);
                    }

                    if(!empty($r['error'])) {
                        $errors[] = $r['error'];
                    }

                    if(isset($r['additionalData'])) {
                        $additionalData = array_merge($additionalData, $r['additionalData']);
                    }
                }
            }
        }
        return array("processed" => $string, "errors" => $errors, "additionalData" => $additionalData);
    }




    protected function _getUserTokenReplacement($tokenTree)
    {
        if(!isset($tokenTree[1])) {
            return array("errors" => "Malformed User Token provided");
        }

        /* @var $user \NoizuLabs\Core\DomainObject\User */
        $user = $this->getUser();

        $error = null;
        $replacement = null;
        $additionalData = null;
        switch($tokenTree[1])
        {
            case "LoginName":
                $replacement = $user->getLoginName();
                $additionalData = array("User"=> array("LoginName" => $replacement));
                break;
            case "UserName":
                if ($user->getUserName()->getApprovedText()) {
                    $replacement = $user->getUserName()->getApprovedText()->getString();
                } else {
                    $replacement = $user->getUserName()->getPendingText()->getString();
                }
                $additionalData = array("User"=> array("UserName" => $replacement));
                break;
            case "Email":
                $replacement = $user->getEmail();
                $additionalData = array("User"=> array("Email" => $replacement));
                break;

            default:
                $error =  "Malformed User Token provided. {User.{$tokenTree}} is not a valid token.";
                break;
        }
        return compact("replacement","additionalData", "error");
    }


    protected function _getSiteTokenReplacement($tokenTree)
    {
        $additionalData = null;
        $replacement = null;
        $site = $this->getSite();
        switch($tokenTree[1])
        {
            case "Name":
                $replacement = $site->getDisplayName();
                $additionalData = array("Site"=> array("Name" => $replacement));
                break;

            case "Description":
                $replacement = $site->getDisplayDescription();
                $additionalData = array("Site"=> array("Description" => $replacement));
                break;

            case "URL":
                $replacement = $site->getUrl();
                $additionalData = array("Site"=> array("URL" => $replacement));
                break;

            case "SupportEmail":
                $replacement = $site->getSupportEmail();
                $additionalData = array("Site"=> array("SupportEmail" => $replacement));
                break;

            case "SupportName":
                $replacement = $site->getSupportName();
                $additionalData = array("Site"=> array("SupportName" => $replacement));
                break;
            default:
                $error =  "Malformed Site Token provided. {Site.{$tokenTree}} is not a valid token.";
                break;
        }
        return compact("replacement","additionalData", "error");
    }

    protected function getReplacement($token, $data)
    {
        $error = null;
        $token = substr($token,1,-1);
        $tokenTree = explode(".", $token);
        if(count($tokenTree)) {
            switch(trim($tokenTree[0])) {
                case "User":
                    return $this->_getUserTokenReplacement($tokenTree);
                    break;
                case "Site":
                    return $this->_getSiteTokenReplacement($tokenTree);
                    break;

                default:
                    $dataPos = $data;
                    foreach($tokenTree as $leaf)
                    {
                        $leaf = trim($leaf);
                        if(is_array($dataPos) && array_key_exists($leaf, $dataPos)) {
                            $dataPos = $dataPos[$leaf];
                        } else {
                            return (array("error" => "Unable to find Token:$token in Email Data"));
                        }
                    }
                    return array("replacement" => $dataPos);
                break;
            }
        }
    }




    //==========================================
    // Getters and Setters
    //==========================================


    public function setEmailTemplate($mixed)
    {
        if(is_int($mixed))
        {
            $r = $this->container['Do_Repository_EmailTemplates'];
            $mixed = $r->getTemplate($mixed);
        }
        $this->setField("EmailTemplate", $mixed);
    }

    protected function populateTemplateData()
    {
        if(!isset($this->templateDataEntity)) {
            if($this->getId())
            {
                $entityManager = $this->container['EntityManager'];
                $query = $entityManager->createQuery('
                   SELECT d
                    FROM
                        \NoizuLabs\Core\Doctrine\Entity\EmailTemplateQueueData as d
                    WHERE
                        d.emailTemplateQueue = :email
                ');
                $query->setParameters(array(
                    ':email' => $this->getEntity(),
                ));
                $query->setMaxResults(1);
                $entities = $query->getResult();
                if($entities) {
                    $this->templateDataEntity = $entities[0];
                }
            }

            if(!$this->templateDataEntity) {
                $this->templateDataEntity = $this->container['Entity_EmailTemplateQueueData'];
                $this->templateDataEntity->setEmailTemplateQueue($this->getEntity());
            }
        }
    }


    public function setErrors($errors)
    {
        $this->populateTemplateData();
        if($errors) {
            $this->templateDataEntity->setErrors(json_encode($errors));
        } else {
            $this->templateDataEntity->setErrors(null);
        }
    }

    public function getErrors($assoc = true)
    {
        $this->populateTemplateData();
        return(json_decode($this->templateDataEntity->getErrors(), $assoc));
    }

    public function setData($data)
    {
        $this->bind($data);
    }

    public function setSentData($data)
    {
        $this->bind(null, $data);
    }

    public function getData($assoc = true)
    {
        $this->populateTemplateData();
        if($this->templateDataEntity) {
            return json_decode($this->templateDataEntity->getData(), $assoc);
        }
    }

    public function bindData($data)
    {
        $this->bind($data);
    }

    public function bindSentData($data)
    {
        $this->bind(null, $data);
    }

    protected function bind($data = null, $sentData = null)
    {
        $this->populateTemplateData();
        if(isset($data)) {
            $this->templateDataEntity->setData(json_encode($data));
        }

        if(isset($sentData)) {
            $this->templateDataEntity->setSentData(json_encode($sentData));
        }
    }
}