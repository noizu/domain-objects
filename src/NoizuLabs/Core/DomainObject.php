<?php
namespace NoizuLabs\Core;

abstract class DomainObject {
    protected $container;
    protected $logs;
    protected $loaded = false;
    protected $siteLoaded = false;
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
    protected $autoInitSiteEntity = false;
    
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
    public function __construct()
    {
        global $container;
        $this->container = &$container;
        $this->errors = array();
        $this->logs[LOG_LEVEL_ERROR] = array();
        $this->logs[LOG_LEVEL_WARNING] = array();
        $this->logs[LOG_LEVEL_DEBUG] = array();
    }    
    
    protected function init() 
    {
        if($this->loaded == false)
        {     
            $this->entity = $this->container[$this->entityDIName];
            $this->loaded = true;
            
            if(isset($this->siteEntityDIName) && !empty($this->siteEntityDIName))
            {
                if($this->autoInitSiteEntity) 
                {
                    $this->_siteInit(); 
                } else {
                    $this->siteEntity = null;
                    $this->siteLoaded = false;            
                }                                
            }            
        }
    }

    public function _siteInit()
    {
            $this->siteEntity = $this->container[$this->siteEntityDIName];
            $this->siteLoaded = true;
    }
    
    public function load($mixed,$site = null)
    {
        $this->loaded = false;
        $this->siteLoaded = false;
        if(is_int($mixed))
        {
            $entityManager =  $this->container['EntityManager'];
            $this->entity = $entityManager->find($this->entityName, $mixed);
            $this->loaded = true;
        }  else if (is_a($mixed, $this->entityName)) {
            $this->entity = $mixed;
            $this->loaded = true;
        } else if (is_string($mixed)) {
            $this->loadByString($mixed);
        }
        
        if($this->loaded && !$this->siteLoaded ) {            
            $this->siteLoad($site);
        }
        return $this->loaded;
    }

    
    public function siteLoad($mixed) {        
        $this->siteLoaded = false; 
        if(isset($this->siteEntityName) && !empty($this->siteEntityName) && !is_null($mixed)) {      
            if(is_int($mixed))
            {
                $entityManager =  $this->container['EntityManager'];
                $this->siteEntity = $entityManager->find($this->siteEntityName, $mixed);
                $this->siteLoaded = true;
            }  else if (is_a($mixed, $this->siteEntityName)) {
                $this->entity = $mixed;
                $this->loaded = true;
            } else if (is_string($mixed)) {                
                $this->siteLoadByString($mixed);
            } else {
                $this->_siteLoad();
            }
        } else if(isset($this->siteEntityName) && !empty($this->siteEntityName)) {      
            $this->_siteLoad();             
        }
        return $this->siteLoaded; 
    }
    
    /**
     * NVI method for loading site entity based off of current site. 
     */
    protected function _siteLoad()
    {
        throw new \Exception( "_siteLoad() not Implemented for " . get_class($this));
    }
    
    public function siteLoadByString($value)
    {
        $entityManager =  $this->container['EntityManager'];
        $f = $entityManager->getClassMetadata($this->siteEntityName)->getFieldNames();
        if(in_array("handle", $f)) {
            $this->siteEntity = $entityManager->getRepository($this->siteEntityName)->findOneBy(array('handle' => $value));    
            $this->siteLoaded = true; 
            return true; 
        } else {                        
            throw new \Exception( "SiteLoadLoadByString not Implemented for " . get_class($this));
        }                
    }
    
    public function loadByString($value)
    {
        $entityManager =  $this->container['EntityManager'];
        $f = $entityManager->getClassMetadata($this->entityName)->getFieldNames();
        if(in_array("handle", $f)) {
            $this->entity = $entityManager->getRepository($this->entityName)->findOneBy(array('handle' => $value));    
            if($this->entity) {
                $this->loaded = true; 
            }
        } else {                        
            throw new \Exception( "LoadByString not Implemented for " . get_class($this));
        }
    }
        
    //==================================================================================================================
    // Rights Management (InProgress)
    //==================================================================================================================
    public function slugify($text)
    {
        // replace non letter or digits or [\.\-\_] by -
        $text = preg_replace('~[^\\pL\d\.\-_]+~u', '-', $text);

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
    
    //==================================================================================================================
    // Rights Management (InProgress)
    //==================================================================================================================
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

    //==================================================================================================================
    // File Uploading
    //==================================================================================================================    
    public function _moveFile($subDir, $tmpPath, $originalFileName, array $extensions, $name = "File", $throwOnFileExists = true, $moveMethod = null, $isUserData = false)
    {
        $ext = explode(".", $originalFileName);
        $ext = strtolower(end($ext));
        if(!in_array($ext, $extensions)) {
            throw new \Exception("$name must be of type " . implode(",", $extensions) . " and have appropriate  file extension");
        }
        $fileName = md5_file($tmpPath) . "." . $ext;
        $hashDir = substr($fileName,0,3);
        
        if($isUserData) {
            if(!isset($this->container['Settings.UploadUserContentFolder'])) {
                throw new \Exception("You must set Settings.UploadUserContentFolder in your configuration DI object to upload user content");
            }
            $saveFolder = $this->container['Settings.UploadUserContentFolder'] . "/{$subDir}/{$hashDir}";
        } else {
            if(!isset($this->container['Settings.UploadFolder'])) {
                throw new \Exception("You must set Settings.UploadFolder in your configuration DI object to upload content");
            }            
            $saveFolder = $this->container['Settings.UploadFolder'] . "/{$subDir}/{$hashDir}";
        }
        
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
        $callMethod = $method; 
        if(!$this->loaded){
            $this->init();
        }
        if(!$this->loaded){
            throw new \Exception("You must succesfully instantiate a domain object before calling it's getter and setter methods " . __LINE__);
        }        
        if(substr($method,0,3) == "get")
        {
            if(substr($method,0,7) == "getSite")
            {
                $method = str_replace("getSite", "get", $method);
                if(method_exists($this->siteEntity, $method))
                {
                    return $this->siteEntity->$method();
                } else if (method_exists($this->entity, $callMethod)){
                    return $this->entity->$callMethod(); 
                } else  {               
                    throw new \Exception("Method $callMethod does not exist on class" . get_class($this) . " or it's entities " . __LINE__);
                }
            } else {
                if(isset($this->siteEntity) && method_exists($this->siteEntity, $method))
                {
                    return $this->siteEntity->$method();
                } else if (method_exists($this->entity, $method))
                {
                    return $this->entity->$method();
                } else {          
                    throw new \Exception("Method $callMethod does not exist on class" . get_class($this) . " or it's entities - "  . __LINE__);
                }
            }
        } else if(substr($method,0,3) == "set")
        {
            $arg = isset($args[0]) ? $args[0] : null;
            if(substr($method,0,7) == "setSite")
            {
                $method = str_replace("setSite", "set", $method);
                if(isset($this->siteEntity) && method_exists($this->siteEntity, $method))
                {
                    $field = str_replace("setSite", "", $callMethod);
                    $method = "setSiteField";
                } else if( method_exists($this->entity, $callMethod)) {
                    $field = str_replace("set", "", $callMethod);
                    $method = "setField";                    
                } else {
                    throw new \Exception("Method $callMethod does not exist on class" . get_class($this) . " or it's entities - " . __LINE__);
                }             
            } else {                
                if(isset($this->siteEntity) && method_exists($this->siteEntity, $method))
                {
                    $field = str_replace("set", "", $method);
                    $method = "setSiteField";
                } else if (method_exists($this->entity, $method))
                {
                    $field = str_replace("set", "", $method);
                    $method = "setField";                    
                } else {
                    throw new \Exception("Method $callMethod does not exist on class" . get_class($this) . " or it's entities - " .  __LINE__);
                }
            }
            $this->$method($field, $arg);
        } else {             
            throw new \Exception("Method $callMethod does not exist on class" . get_class($this) . " or it's entities - " .  __LINE__);
        }                
    }


    //==================================================================================================================
    // Getters/Setters helpers
    //==================================================================================================================
    public function getOptionOrDefault($field, $default, $options)
    {
        return array_key_exists($field, $options) ? $options[$field] : $default;        
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
            if($partial) {
                return $entityManager->getPartialReference($this->container['Settings.Entity_Site'], $siteId);   
            } else {
                if(is_numeric($siteId)) {
                    return $entityManager->getRepository($this->container['Settings.Entity_Site'])->findOneBy(array('id' => $id));    
                } else {
                    return $entityManager->getRepository($this->container['Settings.Entity_Site'])->findOneBy(array('handle' => $id));    
                }
            }
        }
    }
    
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

    public function getSystemStringField($field, $raw = false)
    {
        return $this->getModeratedStringField($field, $raw);
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
        $systemString = isset($options['isSystemString']) ? $options['isSystemString'] : null;
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
                $string = $ms->CreateModeratedString($value, $stringType, $author, $autoApprove, $systemString);                                
                $this->setFieldCore($entity, $field, $string->getEntity(), $empty);
            }
        } else if(is_object($value) && is_a($value, $this->container['Settings.DoClass'])) {
            $this->setFieldCore($entity, $field, $value->getEntity(), $empty);
        } else if(is_object($value) && is_a($value, $this->container['Settings.EntityClass'])) {
            $this->setFieldCore($entity, $field, $value, $empty);
        } else if (is_null($value) ) {
            $this->setFieldCore($entity, $field, $value, $empty);
        } else {
            throw new \Exception("set field ($field) expects a string, or a ModeratedString DomainObject or Entity");
        }
    }
    
    public function setSystemStringFieldAutoApprove($field, $stringType, $value, $options = array()) {
        $options['autoApprove'] = true;
        $options['isSystemString'] = true;
        $this->setModeratedStringFieldCore($this->entity, $field, $stringType, $value, $options);
    }

    public function setSystemStringSiteFieldAutoApprove($field, $stringType, $value, $options = array()) {
        $options['autoApprove'] = true;
        $options['isSystemString'] = true;
        $this->setModeratedStringFieldCore($this->siteEntity, $field, $stringType, $value, $options);
    }

    public function setSystemStringField($field, $stringType, $value, $options = array()) {
        $options['isSystemString'] = true;
        $this->setModeratedStringFieldCore($this->entity, $field, $stringType, $value, $options);
    }

    public function setSystemStringSiteField($field, $stringType, $value, $options = array()) {
        $options['isSystemString'] = true;
        $this->setModeratedStringFieldCore($this->siteEntity, $field, $stringType, $value, $options);
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


        if(is_a($value, $this->container['Settings.DoClass_DomainObject']))
        {
            $entity->$method($value->getEntity());
        } else if(is_a($value, $this->container['Settings.EntityClass_Entity'])){
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
    
    //===========================================================================================================    
    // Convienence Methods
    //===========================================================================================================    
    
    /**
     * Get all entities (with basic pagination).
     * Caution, this will not perform joins which may impact performance. 
     * @param int $page
     * @param null $entriesPerPage
     * @param type $cache
     */
    public function getAllEntities($page = 1, $entriesPerPage = null, $cache = true)
    {
        $entityManager = $this->container['EntityManager'];       
        if($page < 0) $page = 1;
        if(is_null($entriesPerPage)) {
            if(!isset($this->container['Settings.EntriesPerPage'])) {
                throw new \Exception("Settings.EntriesPerPage must be set to call " . __FUNCTION__);
            }
            $entriesPerPage = $this->container['Settings.EntriesPerPage'];            
        }
        if(!isset($this->entityName)) {
            throw new \Exception("class member entityName (Doctrine Entity Name) must be set to call" . __FUNCTION__);
        }
        
        
        $offset = ($page - 1) * $entriesPerPage; 
        $joins = isset($this->defaultJoins) ? $this->defaultJoins : "";        
        $r = $entityManager->createQuery("Select e FROM {$this->entityName} e {$joins}")
            ->setMaxResults($entriesPerPage)->setFirstResult($offset)->Execute(); 
        return $r;
    }
    
    /**
     * get all entities and return as array. 
     * @param type $page
     * @param type $entriesPerPage
     * @param type $cache
     * @return type
     */
    public function getAllEntitiesArray($page = 1, $entriesPerPage = null, $cache = true)
    {
        $entities = $this->getAllEntities($page, $entriesPerPage, $cache);
        return $this->entitiesToArray($entities); 
    }
        
    /**
     * @param string $di DependencyInjection Handle for DomainObject
     * @param array $entities array of entities to convert to array
     * @param string $version  
     */
    public function entitiesToArray($entities, $di = null,  $version = 'latset')
    {                
        if(is_null($di)) {
            if(!isset($this->doDIName)) {
                throw new \Exception("class member doDIName (DomainObject DependencyInjection Name) must be set to call" . __FUNCTION__);
            }
            $di = $this->doDIName; 
        }
        if(!isset($this->container[$di])) {
            throw new \Exception("$di entry must be populated in your Container object to proceed." . __FUNCTION__);
        }                
        $r = array(); 
        foreach($entities as $entity) {
            $do = $this->container[$di]; 
            $do->load($entity); 
            $r[] = $do->ToArray($version);                         
        }
        return $r; 
    }
    
    /**
     * Default Convert to array method
     * @param type $version
     * @return type
     * @throws \Exception
     */
    public function toArray($version) {
        $entityManager = $this->container['EntityManager'];      
        if(!isset($this->entityName)) {
            throw new \Exception("class member entityName (Doctrine Entity Name) must be set to call" . __FUNCTION__);
        }
        
        $f = $entityManager->getClassMetadata($this->entityName)->getFieldNames();
        $r = array(); 
        foreach($f as $field) {
            $method = "get$field";
            $r[$field] = $this->$method(); 
        }
        return $r; 
    }
    
    public function generateGuid(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = chr(123)// "{"
                    .substr($charid, 0, 8).$hyphen
                    .substr($charid, 8, 4).$hyphen
                    .substr($charid,12, 4).$hyphen
                    .substr($charid,16, 4).$hyphen
                    .substr($charid,20,12)
                    .chr(125);// "}"
            return $uuid;
        }
    }    
}   