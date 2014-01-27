<?php
namespace NoizuLabs\Core\Tests\Suites\Unit\ModeratedString;
require_once(__DIR__ . '/../UnitTestBase.php');

/**
 * @stepClass \NoizuLabs\Core\Tests\Steps\Given
 * @stepClass \NoizuLabs\Core\Tests\Steps\Then
 */
class EmailTemplateQueueTest extends \NoizuLabs\Core\Tests\Suites\Unit\UnitTestBase
{

    protected $testTemplateId = null;
    protected $user = null;
    protected $queuedEmail = null;
    protected $emailAttributes = null;
    protected $emailQueue = null;

    public function SetUp() {
        parent::SetUp();
        $this->container["SiteId"] = 1;
    }


    //===============================================
    // Given
    //===============================================
    /**
     * @Given the email queue
     */
    public function GivenTheEmailQueue()
    {
        $this->emailQueue = $this->container['Do_Repository_TemplatedEmailQueue'];
    }

    /**
     * @Given the $template email template
     */
    public function GivenEmailTemplate($template)
    {
        /* Todo lookup template by friendly name */
        switch(strtolower($template)) {
            case 'email_verification' :
                $this->testTemplateId = 1;
                $this->emailAttributes = array();
                break;
            case 'username_recovery':
                $this->testTemplateId = 2;
                $this->emailAttributes = array();
                break;
            case 'password_recovery':
                $this->testTemplateId = 3;
                $this->emailAttributes = array();
                break;
            case 'registration' :
                $this->testTemplateId = 4;
                $this->emailAttributes = array();
                break;
            default:
                $this->fail("Test Suite Does Not Recognize email template '$template'");
                break;
        }

        $this->emailAttributes["testSentinal"] = true;
    }


    /**
     * @Given a test user
     */
    public function GivenATestUser()
    {
        $ur = $this->container['Do_Repository_Users'];
        $this->user = $ur->getAnonymousUser();
    }

    //===============================================
    // When
    //===============================================
    /**
     * @When the system queues an email
     */
    public function WhenTheSystemQueuesAnEmail()
    {
        $this->queuedEmail = $this->emailQueue->queueEmail($this->testTemplateId, $this->user, $this->emailAttributes);
    }

    /**
     * @When it is processed
     */
    public function WhenItIsProcessed()
    {
        $this->queuedEmail->send();
    }

    //===============================================
    // Then
    //===============================================
    /**
     * @Then the email should be saved to the email queue
     */
    public function ThenTheEmailShouldBeSavedToTheEmailQueue()
    {
        $this->assertNotNull($this->queuedEmail, "the queueEmail method did not return our queued Email");
        $this->assertTrue($this->queuedEmail->getId() > 0, "the queuedEmail was not correctly saved to the database");
    }

    /**
     * @Then the email specific data should be available
     */
    public function ThenTheEmailSpecificDataShouldBeAvailable()
    {
        $do = $this->emailQueue->getQueuedEmail($this->queuedEmail->getId());
        $data = $do->getData();
        $this->assertTrue($data['testSentinal'], "Special testSentinal flag wasn't set on email data");
    }
}
