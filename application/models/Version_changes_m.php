<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Version_changes_m extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->db->query("SET sql_mode = ''");
		$this->load->model('Updated_queries','up_m');
		$this->load->dbforge();
		$this->config->load('config');
	}

	/*----------------------------------------------
	  IF Update Available, First verify the purchase code
	----------------------------------------------*/

	public function verify_purchase_code($purchase_code){
		$form_data = [
			'purchase_code' => $purchase_code,
			'site_url' => SITE_URL,
			'author' => AUTHOR,
			'is_localhost' => $this->isLocalHost(),
		];

		$form_data = json_encode($form_data);
		$ch = curl_init("https://api.thinkncode.net/verify-purchase");  
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                     
		curl_setopt($ch, CURLOPT_POSTFIELDS, $form_data); 

		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_POST, 1);                                          
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			$error_msg = curl_error($ch);
			echo "<pre>";print_r($error_msg);exit();
		}

		curl_close($ch);
		$result = @json_decode($result);

		if(isset($result->st) && $result->st==1):
			return ['st'=>1, 'msg' =>''];
		else:
			return ['st'=>0,'msg'=>$result->msg];
		endif;
	}







	/*----------------------------------------------
	  				FROM MY_CONTROLLER
	----------------------------------------------*/
	public function  import_database_changes($purchase_code,$version)
	{
			$data = [];
			$installed = $this->up_m->install_version($version);

			if(isset($installed['st']) && $installed['st']==1):

				if(isset($installed['version']) && $installed['version']==$this->config->item('app_version')):
					$this->createVersion($purchase_code,$installed['version'],settings()['license_code']);
					$this->checkFolders();
				endif;
				
				$data = ['st'=>1,'msg'=> $installed['msg'],'version'=>$installed['version']];
			else:
				$data = ['st'=>0,'msg'=>$installed['msg'],'version'=>$installed['version']];
			endif;
		

		return $data;
	}

	

	public function  checkExistFields($table,$fields)
	{
		if(!$this->db->field_exists($fields, $table)){
			return 1;
		}else{
			return 0;
		}
	}


	

	
	public function createVersion($purchase_code,$app_version,$license_code=''){
		error_reporting(0);
		$version = "<?php \n";
		$version .= "define('VERSION', '". $app_version ."'); \n";
		$version .= "define('SCRIPT_NAME', 'qmenu'); \n";
		$version .= "define('AUTHOR', 'codetrick'); \n";
		$version .= "define('CODECANYON_LICENSE', '".$purchase_code."'); \n";
		$version .= "define('AUTHOR_LICENSE', '".$license_code."'); \n";
		file_put_contents(APPPATH."config/version.php", $version);
		
	}


	public function checkFolders()
	{
		$rootDir = ['big','files','orders_qr','pwa','qr_image','site_banners','site_images','thumb'];
		$mainDir = 'uploads';
		$base = FCPATH;
		 foreach ($rootDir as $key => $dir) {
            $directory = $base.$mainDir.'/'.$dir;
            if (!file_exists($directory)) {
               $create = mkdir($directory, 0777, true);
               echo 'done';
            } else{
              $msg[] = "{$dir} Is Not Writable, Set 777 Permission to: {$mainDir} / {$dir}";
            }

        }

	}

  

    protected function isLocalHost(){
        $localhost = array(
            '127.0.0.1',
            '::1'
        );

        return in_array($_SERVER['REMOTE_ADDR'], $localhost);
    }


}
