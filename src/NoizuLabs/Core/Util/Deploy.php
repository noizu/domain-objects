<?php
namespace NoizuLabs\Core\Util;

class Deploy {
    protected $settings; 
    public function __construct($configFile) 
    {
        if(is_null($configFile) || !is_string($configFile) ) {
             error_log("DeployScript - Valid Config file not provided");
             return;
        }

        if($configFile{0} != "/") {
            $configPath = getcwd() . "/$configFile";    
        } else {
            $configPath = $configFile;
        }
 
        if(!file_exists($configPath)) {
           error_log("DeployScript - unable to access config file [$configPath]");
           return;
        } 

          
        $raw = file_get_contents($configPath); 
        $this->settings = json_decode($raw, true);

	echo "Loaded Deploy with " . getcwd() . "/$configFile\n"; 

    }

    public function deploy() 
    {   
         echo "Preparing to deploy . . . \n";
         $this->checkRequiredSetting("method"); 

         switch(strtolower($this->settings['method'])) {
            case 'rsync':
                 return $this->deployRsync();
              break;
         }
    }

    protected function checkRequiredSettings(array $settings) {
       $failures = false; 
       $missedSettings = array();   

       foreach($settings as $setting)
       {
              try {
                  $this->checkRequiredSetting($setting);
              } catch (\Exception $e) {
                  $missedSettings[] = $setting;
                  $failures = true; 
              }  
       } 

       if ($failures) {
            $error = "Some Required settings not found: " . implode(",", $missedSettings);
            error_log($error); 
            throw new \Exception($error);
       } 
    }

    protected function checkRequiredSetting($setting, $error = null)
    {
        if(!array_key_exists($setting, $this->settings) ) {
            if($error == null) {
               $error = "Required setting '$setting' was not supplied";
            }
            error_log($error);
            throw new \Exception($error);        
        }
    }

    protected function deployRsync()
    {
        $this->checkRequiredSettings(array("user","sentinel","project-dir","deploy-to", "server"));
        // Ths needs to be run from root directory of project!
 
        $user = $this->settings['user'];
        $sentinel = $this->settings['sentinel'];
        $projectDir = $this->settings['project-dir'];
        $deployTo = $this->settings['deploy-to'];
        $server = $this->settings['server'];
        $excludes = $this->settings['exclude'];

        $excludeString = "";
        if(is_array($excludes)) {
          foreach($excludes as $exclude) {
         $excludeString .= " --exclude '$exclude' ";
          }         
        } else if(!empty($excludes)) {
          $excludeString = " --exclude '$excludes' ";
        }

        if(substr($deployTo,-1,1) == "/") $deployTo = substr($deployTo,0,-1);

        // Todo wait for ongoing deployment to finish for up to five minutes

        $ts = time(); 
 
        while($this->isOngoingDeployment() && $ts < (time() + 60*5)) {
        echo "Waiting 30 seconds for current deployment to finish ...\n"; 
            sleep(30);
        }        

        if(!$this->isOngoingDeployment())
        {
           $cwd = getcwd(); 
           $cmd = "rsync -avz $excludeString --delete {$cwd}/ {$user}@{$server}:{$projectDir}/{$deployTo}/";
           echo "running $cmd";
           echo `$cmd` . "\n";

           $cmd = "ssh {$user}@{$server} \"touch {$projectDir}/{$deployTo}/{$sentinel}\"";
           echo "running $cmd";
           echo `$cmd` . "\n";
        } else {
           error_log("unable to deploy, deployment in progress"); 
           throw new \Exception("Deployment already in progress"); 
        }
    }

    public function isOngoingDeployment() {

        $user = $this->settings['user'];
        $sentinel = $this->settings['sentinel'];
        $projectDir = $this->settings['project-dir'];
        $deployTo = $this->settings['deploy-to'];
        $server = $this->settings['server'];
         
        $cmd = "ssh {$user}@{$server} \"ls {$projectDir}/{$deployTo}/{$sentinel}\"";
          
        $returnCode = 0;
        $response = array(); 
        $r = exec($cmd, $response, $returnCode);
        return ($returnCode == 0);
    }


    public function validate()
    {


    }

    public function promote() 
    {


    }
}
