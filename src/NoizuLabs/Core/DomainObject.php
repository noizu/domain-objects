<?php
namespace NoizuLabs\Core;

abstract class DomainObject {
    protected $container;
    protected $logs;
    protected $loaded = false;
    protected $entity;
    protected $siteEntity;
    protected $siteId;

    protected $requiredFields;
    protected $internalFields;
    protected $optionalFields;

    protected $createAnyRole = null;
    protected $createContainedRole = null;
    protected $editAnyRole = null;
    protected $editAnyContainedRole = null;
    protected $editAnyInternalFieldRole = null;
    protected $editContainedInternalFields = null;
    protected $identifierName = null;

    /**
     * Key of entity to pull from DI container.
     * @var string
     */
    protected $entityDIName = null;


    /**
     * Entity Classname used by this domain object.
     * @var string
     */
    protected $entityName = null;


    //=========================================================
    // Init
    //=========================================================
    protected function init()
    {
        if($this->loaded == false)
        {     
            $this->entity = $this->container[$this->entityDIName];
            $this->loaded = true;
        }
    }

    public function load($mixed)
    {
        $this->loaded = false;
        if(is_int($mixed))
        {
            $entityManager =  $this->container['EntityManager'];
            $this->entity = $entityManager->find($this->entityName, $mixed);
            $this->loaded = true;
        }  else if (IS_A($mixed, $this->entityName)) {
            $this->entity = $mixed;
            $this->loaded = true;
        } else if (is_string($mixed)) {
            $this->loadByString($mixed);
        }
    }


    public function loadByString()
    {
        throw new \Exception( "LoadByString not Implemented for " . get_class($this));
    }

    /**
     * Get Site, used for multi-tenant sites.
     * @param string $siteId
     * @param string $partial
     */
    public function getSite($siteId = null, $partial = true)
    {
        if($siteId == null)
        {
            if($this->siteId) {
                $siteId = $this->siteId;
            } else {
                $siteId = $this->container['SiteId'];
            }
        }

        if($siteId) {
            $entityManager = $this->container['EntityManager'];
            return $entityManager->getPartialReference($this->container['EntityClass_Sites'], $siteId);
        }
    }

    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }


    public function CreateAnyRole()
    {
        return $this->createAnyRole;
    }

    public function CreateContainedRole()
    {
        return $this->createContainedRole;
    }

    public function EditAnyRole()
    {
        return $this->editAnyRole;
    }

    public function EditAnyContainedRole()
    {
        return $this->editAnyContainedRole;
    }

    public function EditAnyInternalFieldRole()
    {
        return $this->editAnyInternalFieldRole;
    }

    public function EditContainedInternalFields()
    {
        return $this->editContainedInternalFields;
    }

    public function getIdentifierName()
    {
        return $this->identifierName;
    }

    public function __construct()
    {
        global $container;
        $this->container = &$container;
        $this->errors = array();
        $this->logs[LOG_LEVEL_ERROR] = array();
        $this->logs[LOG_LEVEL_WARNING] = array();
        $this->logs[LOG_LEVEL_DEBUG] = array();
    }

    public function getRequiredFields()
    {
        return $this->requiredFields;
    }

    public function getInternalFields()
    {
        return $this->internalFields;
    }

    public function getOptionalFields()
    {
        return $this->optionalFields;
    }

    public function setDefaultFields()
    {
        foreach($this->defaultFields as $field => $value)
        {
            $m = "set{$field}";
            $this->$m($value);
        }
    }


    public function _moveFile($subDir, $tmpPath, $originalFileName, array $extensions, $name = "File", $throwOnFileExists = true, $moveMethod = null)
    {
        $ext = explode(".", $originalFileName);
        $ext = strtolower(end($ext));
        if(!in_array($ext, $extensions)) {
            throw new \Exception("$name must be of type " . implode(",", $extensions) . " and have appropriate  file extension");
        }
        $fileName = md5_file($tmpPath) . "." . $ext;
        $hashDir = substr($fileName,0,3);
        $saveFolder = $this->continer['WWW_ROOT'] . "/{$subDir}/{$hashDir}";

        if(!file_exists($saveFolder)) {
            echo "Create File $saveFolder";
            mkdir($saveFolder, 0770,true);
        }

        if(file_exists($saveFolder . "/" . $fileName)) {
            if($throwOnFileExists) throw new \Exception("$name already exists");
        } else {
            if(!$moveMethod($tmpPath, $saveFolder . "/" . $fileName))
            {
                throw new \Exception("Error Attempting To Upload $name.");
            }
        }
        return "{$hashDir}/{$fileName}";
    }

    public function importFile($subDir, $tmpPath, $originalFileName, array $extensions, $name = "File", $throwOnFileExists = true)
    {
        $moveMethod = function($from,$to) { return copy($from, $to); };
        return $this->_moveFile($subDir, $tmpPath, $originalFileName, $extensions, $name, $throwOnFileExists, $moveMethod);
    }

    public function uploadFile($subDir, $tmpPath, $originalFileName, array $extensions, $name = "File", $throwOnFileExists = true)
    {
        $moveMethod = function($from,$to) { return move_uploaded_file($from, $to); };
        return $this->_moveFile($subDir, $tmpPath, $originalFileName, $extensions, $name, $throwOnFileExists, $moveMethod);
    }

    //==================================================================================================================
    // Error & Warning Logging
    //==================================================================================================================
    protected function _Log($level, $code, $msg = null)
    {
        if($msg === null) {
            //ToDo set default message based on code if available.
            $msg = "No Additional Details Given";
        }
        $this->logs[$level][] = array("error" => $msg, "code" => $code);
    }

    protected function _GetLogs($level)
    {
        return empty($this->logs[$level]) ? null : $this->logs[$level];
    }

    protected function _GetLastLog($level)
    {
        if (count($this->logs[$level])) {
            return $this->logs[$level][count($this->logs[$level]) - 1];
        } else {
            return null;
        }
    }

    protected function LogError($code, $msg = null)
    {
        return $this->_Log(LOG_LEVEL_ERROR, $code, $msg);
    }

    public function GetErrors()
    {
        return $this->_GetLogs(LOG_LEVEL_ERROR);
    }

    public function GetLastError()
    {
        return $this->_GetLastLog(LOG_LEVEL_ERROR);
    }

    protected function LogWarning($code, $msg = null)
    {
        return $this->_Log(LOG_LEVEL_WARNING, $code, $msg);
    }

    public function GetWarnings()
    {
        return $this->_GetLogs(LOG_LEVEL_WARNING);
    }

    public function GetLastWarning()
    {
        return $this->_GetLastLog(LOG_LEVEL_WARNING);
    }

    protected function LogDebug($code, $msg = null)
    {
        return $this->_Log(LOG_LEVEL_DEBUG, $code, $msg);
    }

    public function GetDebugMessages()
    {
        return $this->_GetLogs(LOG_LEVEL_DEBUG);
    }

    public function GetLastDebugMessage()
    {
        return $this->_GetLastLog(LOG_LEVEL_DEBUG);
    }

    //==================================================================================================================
    // Save Entity
    //==================================================================================================================
    public function save($flush = true)
    {
        $this->init(); 
        $entityManager = $this->container['EntityManager'];
        $entityManager->persist($this->entity);


        if($this->siteEntity) {
            $entityManager->persist($this->siteEntity);
        }

        if($flush) {
            try {
                $entityManager->flush();
            } catch(\Exception $e) {
                $this->LogError("400:005", $e->getMessage());
               die($e); 
                return null;
            }
        }
        return $this->entity->getId();
    }

    public function delete($flush = true)
    {
        $entityManager = $this->container['EntityManager'];
        $entityManager->remove($this->entity);
        if($this->siteEntity) {
            $entityManager->remove($this->siteEntity);
        }
        $this->loaded = false;
        $this->siteLoaded = false;
        $this->entity = null;
        $this->siteEntity = null;

        if($flush) {
            try {
                $entityManager->flush();
            } catch(\Exception $e) {
                $this->LogError("400:006", $e->getMessage());
                return false;
            }
        }
        return true;
    }

    public function flush($halt = false)
    {
        $entityManager = $this->container['EntityManager'];
        $entityManager->flush();
    }

    //==================================================================================================================
    // Magic Methods
    //==================================================================================================================

    public function __call($method, $args)
    {
        if(substr($method,0,3) == "get")
        {
            if(substr($method,0,3) == "getSite")
            {
                if(method_exists($this->entity, $method))
                {
                    $method = str_replace("getSite", "get", $method);
                    return $this->siteEntity->$method();
                }
            } else {
                if(method_exists($this->entity, $method))
                {
                    return $this->entity->$method();
                }
            }
        }


        if(substr($method,0,3) == "set" && isset($args[0]))
        {
            if(substr($method,0,3) == "getSite")
            {
                $field = str_replace("setSite", "", $method);
                $method = "setSiteField";
            } else {
                $field = str_replace("set", "", $method);
                $method = "setField";
            }
            $this->$method($field, $args[0]);
        }
    }


    //==================================================================================================================
    // Setters
    //==================================================================================================================
    public function setSite($mixed = null) {
        if(is_null($mixed)) {
            $this->setField("site", $this->getSite());
        } if(is_int($mixed))
        {
            $this->setSiteId($mixed);
            $this->setField("site", $this->getSite());
        } else {
            $this->setField("site", $mixed);
        }
    }

    public function setSiteId($id) {
        $this->siteId = $id;
    }

    public function getModeratedStringField($field, $raw = false)
    {
        $e = $this->getFieldCore($this->entity, $field);
        if($e && !$raw) {
            $ms = $this->container['Do_ModeratedString'];
            $ms->load($e);
            return $ms;
        }
        return $e;
    }

    public function setModeratedStringFieldCore(&$entity, $field, $stringType, $value, $options)
    {
        $user = isset($options['user']) ? $options['user'] : null;
        $empty = isset($options['empty']) ? $options['empty'] : null;
        $action = isset($options['action']) ? $options['action'] : null;
        $author = isset($options['author']) ? $options['author'] : null;
        $autoApprove = isset($options['autoApprove']) ? $options['autoApprove'] : false;

        if(is_string($value))
        {
            $e = $this->getFieldCore($entity, $field);
            if($e) {
                $ms = $this->container['Do_ModeratedString'];
                $ms->load($e);
                $ms->edit($value, $options);
            } else {
                $ms = $this->container['Do_Repository_ModeratedStrings'];
                $string = $ms->CreateModeratedString($value, $stringType, $author, $autoApprove);
                $this->setFieldCore($entity, $field, $string->getEntity(), $empty);
            }
        } else if(is_object($value) && is_a($value, $this->container['DoClass_ModeratedString'])) {
            $this->setFieldCore($entity, $field, $value->getEntity(), $empty);
        } else if(is_object($value) && is_a($value, $this->container['DoClass_ModeratedString'])) {
            $this->setFieldCore($entity, $field, $value, $empty);
        } else if (is_null($value) ) {
            $this->setFieldCore($entity, $field, $value, $empty);
        } else {
            throw new \Exception("set field ($field) expects a string, or a ModeratedString DomainObject or Entity");
        }
    }

    public function setModeratedStringFieldAutoApprove($field, $stringType, $value, $options = array()) {
        $options['autoApprove'] = true;
        $this->setModeratedStringFieldCore($this->entity, $field, $stringType, $value, $options);
    }

    public function setModeratedStringSiteFieldAutoApprove($field, $stringType, $value, $options = array()) {
        $options['autoApprove'] = true;
        $this->setModeratedStringFieldCore($this->siteEntity, $field, $stringType, $value, $options);
    }

    public function setModeratedStringField($field, $stringType, $value, $options = array()) {
        $this->setModeratedStringFieldCore($this->entity, $field, $stringType, $value, $options);
    }

    public function setModeratedStringSiteField($field, $stringType, $value, $options = array()) {
        $this->setModeratedStringFieldCore($this->siteEntity, $field, $stringType, $value, $options);
    }

    protected function setFieldCore(&$entity, $field, $value, $empty = false, $default = null)
    {
        $this->init();
        if((!$empty) && $value === null)
        {
            $this->LogError("400:002", "Invalid Field - $field must be set");
            return false;
        }

        if($value === null) {
            $value = $default;
        }

        $field = ucfirst($field);
        $method = "set$field";


        if(is_a($value, $this->container['DoClass_DomainObject']))
        {
            $entity->$method($value->getEntity());
        } else if(is_a($value, $this->container['EntityClass_Entity'])){
            $entity->$method($value);
        } else {
            $entity->$method($value);
        }

        return true;
    }

    protected function getFieldCore(&$entity, $field)
    {
        $this->init();
        $field = ucfirst($field);
        $method = "get$field";
        return $entity->$method();
    }


    protected function setSiteField($field, $value, $empty = false, $default = null)
    {
        return $this->setFieldCore($this->siteEntity, $field, $value, $empty, $default);
    }

    protected function getSiteField($field)
    {
        return $this->getFieldCore($this->siteEntity, $field);
    }

    public function setField($field, $value, $empty = false, $default = null)
    {
        return $this->setFieldCore($this->entity, $field, $value, $empty, $default);
    }

    protected function getField($field)
    {
        return $this->getFieldCore($this->entity, $field);
    }

    public function getSiteEntity()
    {
        return $this->siteEntity;
    }

    public function getEntity()
    {
        return $this->entity;
    }
}
