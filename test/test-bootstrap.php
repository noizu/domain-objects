<?php

if(file_exists(__DIR__ . '/../vendor/autoload.php')) {
    require_once(__DIR__ . '/../vendor/autoload.php');
} else if(file_exists(__DIR__ . '/../../../vendor/autoload.php')){
    require_once(__DIR__ . '/../../../vendor/autoload.php');
}

global $container;
$container = new \Pimple;

$container['Doctrine_DevMode'] = true; 

define('LOG_LEVEL_ERROR','errors');
define('LOG_LEVEL_WARNING','warnings');
define('LOG_LEVEL_DEBUG','debug');

$container['Entity_ModeratedStringAction_CreateUser'] = 1; 



$container['EntityClass_Entity'] = "\\NoizuLabs\\Core\\Doctrine\\Entity";
$container['EntityClass_Users'] = "\\NoizuLabs\\Core\\Doctrine\\Entity\\Users";
$container['EntityClass_Sites'] = "\\NoizuLabs\\Core\\Doctrine\\Entity\\Sites";
$container['EntityClass_ModeratedStrings'] = "\\NoizuLabs\\Core\\Doctrine\\Entity\\ModeratedStrings";
$container['EntityClass_ModeratedStringActions'] = "\\NoizuLabs\\Core\\Doctrine\\Entity\\ModeratedStringActions";
$container['EntityClass_ModeratedStringChanges'] = "\\NoizuLabs\\Core\\Doctrine\\Entity\\ModeratedStringChanges";
$container['EntityClass_ModeratedStringTypes'] = "\\NoizuLabs\\Core\\Doctrine\\Entity\\ModeratedStringTypes";
$container['EntityClass_EmailTemplateQueue'] = "\\NoizuLabs\\Core\\Doctrine\\Entity\\EmailTemplateQueue";
$container['EntityClass_EmailTemplateQueueData'] = "\\NoizuLabs\\Core\\Doctrine\\Entity\\EmailTemplateQueueData";
$container['EntityClass_EmailTemplates'] = "\\NoizuLabs\\Core\Doctrine\\Entity\\EmailTemplates";


$container['Entity_EmailTemplateQueueData'] = function () { return new NoizuLabs\Core\Doctrine\Entity\EmailTemplateQueueData(); };


$container['Entity_ModeratedStrings'] = function () { return new NoizuLabs\Core\Doctrine\Entity\ModeratedStrings(); };

$container['DoClass_User'] = "\\NoizuLabs\\Core\\DomainObject\\User";
$container['DoClass_ModeratedString'] = "\\NoizuLabs\\Core\DomainObjects\\ModeratedString";
$container['DoClass_DomainObject'] = "\\NoizuLabs\\Core\DomainObjects";

$container['SiteId'] = 1;
$container['WWW_ROOT'] = "";
$container['OutgoingEmailsEnabled'] = false;
$container['Enum_ModeratedStringAction_CreateUser'] = 1;

$container['Entity_ModeratedStringChangeLogs']  = function () { return new NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs(); };
$container['Entity_EmailTemplateQueue']  = function () { return new NoizuLabs\Core\Doctrine\Entity\EmailTemplateQueue(); };

$container['Do_ModeratedString'] = function () { return new NoizuLabs\Core\DomainObject\ModeratedString(); };
$container['Do_EmailTemplate'] = function () { return new NoizuLabs\Core\DomainObject\EmailTemplate(); };
$container['Do_QueuedTemplatedEmail'] = function () { return new NoizuLabs\Core\DomainObject\QueuedTemplatedEmail(); };
$container['Do_EmailTemplate']  = function () { return new NoizuLabs\Core\DomainObject\EmailTemplate(); };



$container['Do_User'] = function () { return new NoizuLabs\Core\DomainObject\User(); };
$container['Do_Repository_Users'] = function () { return new NoizuLabs\Core\DomainObject\Repository\Users(); };
$container['Do_Repository_ModeratedStrings'] = function () { return new NoizuLabs\Core\DomainObject\Repository\ModeratedStrings(); };
$container['Do_Repository_EmailTemplates'] = function () { return new NoizuLabs\Core\DomainObject\Repository\EmailTemplates(); };
$container['Do_Repository_TemplatedEmailQueue'] = function () { return new NoizuLabs\Core\DomainObject\Repository\TemplatedEmailQueue(); };

$container['Entity_ModeratedStringChangeLogs']  = function () { return new NoizuLabs\Core\Doctrine\Entity\ModeratedStringChangeLogs(); };
$container['Entity_EmailTemplateQueue']  = function () { return new NoizuLabs\Core\Doctrine\Entity\EmailTemplateQueue(); };
$container["Entity_Users"] = function () { return new NoizuLabs\Core\Doctrine\Entity\Users(); };

if(!FILE_EXISTS(__DIR__ . '/db_settings.php' ) ) trigger_error("You must setup a database with the schema structure from the schema folder and add connectivity information to db_settings.phpin order to run these tests");

require_once(__DIR__ . '/db_settings.php');
require_once(__DIR__ . '/../src/NoizuLabs/Core/Doctrine/bootstrap.php');




require_once(__DIR__ . '/Fixture.php'); 
require_once(__DIR__ . '/Fixtures/User.php'); 
require_once(__DIR__ . '/Steps/Given.php'); 
require_once(__DIR__ . '/Steps/Then.php');
