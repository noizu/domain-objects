<?php
// bootstrap.php
global $container; 

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\ORM\Proxy\Autoloader;

$paths = array(__DIR__ . "/src/");
$isDevMode = true;

// the connection configuration
$dbParams = array(
    'driver'   => 'pdo_mysql',
    'user'     => $container['DB_USER'],
    'password' => $container['DB_PASS'],
    'dbname'   => $container['DB_NAME'],
    'host'     => $container['DB_HOST'],
);


//$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, null, null, false);

$config = Setup::createConfiguration($container['Doctrine_DevMode']);
$driver = new AnnotationDriver(new AnnotationReader(), $paths);
// registering noop annotation autoloader - allow all annotations by default

AnnotationRegistry::registerLoader('class_exists');
$config->setMetadataDriverImpl($driver);

$config->setProxyDir(__DIR__ .  '/tmp');
$config->setAutoGenerateProxyClasses(true);

global $entityManager;
$entityManager = EntityManager::create($dbParams, $config);

$container['EntityManager'] = $entityManager; 
