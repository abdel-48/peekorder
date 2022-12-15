<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->output->set_header('HTTP/1.0 200 OK');
		$this->output->set_header('HTTP/1.1 200 OK');
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
		$this->config->load('config');


		
		$globals['auth_id'] = auth('id');
		if(auth('is_login')==TRUE):
			$this->auth = $this->user_info();
			$this->is_empty = $this->active_profile();
			$this->is_redirect = $this->redirect_url()['is_redirect'];
			$this->redirect_url = $this->redirect_url()['url'];
			$this->is_active = $this->open_menu();
			$this->is_package = $this->check_package();
			$this->check_trial = $this->check_trial();
			$this->trial_type = $this->get_trial_package();
			$this->my_info = $this->common_m->get_user_all_info();

		endif;
		$this->settings = $this->single__settings();
		$this->load->vars($globals);

		define('CURRENCY_CODE', get_currency('currency_code')); 
		define('SITE_NAME', isset($this->settings['site_name'])?$this->settings['site_name']:''); 
		define('USER_ID', !empty(auth('id'))?auth('id'):0); 
		define('USERNAME', isset($this->auth['username'])?$this->auth['username']:''); 
		define('GET_LICENSE',md5($this->settings['site_info']));
		if(isset($this->settings['site_info']) && GET_LICENSE==MY_LICENSE){
			define('LICENSE', MY_LICENSE); 
		}elseif(isset($this->settings['site_info']) && GET_LICENSE=='6fa1b959a5580d843a4ea03422873009'){
			define('LICENSE', '6fa1b959a5580d843a4ea03422873009'); 
		}else{
			define('LICENSE', '79a130e4d38f6ad9e8864265bcacfd4a'); 
		}
		

		define('ACTIVATE', LICENSE==MY_LICENSE || LICENSE == '6fa1b959a5580d843a4ea03422873009'?1:0); 
		

		if(auth('is_login')==TRUE):
			define('USER_ROLE', isset($this->auth['user_role'])?$this->auth['user_role']:''); 
			define('PACKAGE_ID', isset($this->auth['account_type'])?$this->auth['account_type']:''); 
		endif;

		define('is_package', LICENSE==MY_LICENSE?1:'d_actived'); 

		define('overlay', LICENSE==MY_LICENSE?1:0); 



		define('AUTHOR', 'codetrick'); 
		define('SCRIPT_NAME', 'qmenu');

		$appVersion = $this->config->item('app_version');
		if(isset($this->settings ) && !empty($this->settings)):
			define('NEW_VERSION', $appVersion);
			define('SCRIPT_VERSION', $this->settings['version']);
			define('CODECANYON_LICENSE', $this->settings['purchase_code']);
			define('AUTHOR_LICENSE', $this->settings['license_code']);
		endif;

		if(isset($this->auth['user_role']) && $this->auth['user_role']==1):
			if(NEW_VERSION != SCRIPT_VERSION){
				if(NEW_VERSION > SCRIPT_VERSION):
					define('IS_UPDATE', 1);
				endif; //check app>version
			} //check app!=version

		endif; // UserType


		
	}

	public function single__settings(){
		$settings = $this->admin_m->get_settings();
		if(isset($settings)):
			$settings['email_subjects'] = json_decode(settings()['subjects']);
			$settings['smtp'] = json_decode(settings()['smtp_config']);
			$settings['paypal'] = json_decode(settings()['paypal_config']);
			$settings['stripe'] = json_decode(settings()['stripe_config']);
			$settings['recaptcha'] = json_decode(settings()['recaptcha_config']);
			return $settings;
		else:
			return [];
		endif;
	}

	function user_info(){
		$user_info = $this->common_m->get_user_info();
		if(isset($user_info) && count($user_info) >0):
			$users['auth_id'] = $user_info['id'];
			$users['user_role'] = $user_info['user_role'];
			$users['is_active'] = $user_info['is_active'];
			$users['is_verify'] = $user_info['is_verify'];
			$users['is_payment'] = $user_info['is_payment'];
			$users['is_expired'] = $user_info['is_expired'];
			$users['is_request'] = $user_info['is_request'];
			return $users;
		else:
			return array();
		endif;
	}

	public function active_profile(){
		$users_info = $this->admin_m->get_auth_info();
		isset($users_info['phone']) && !empty($users_info['phone'])?$active['phone']=1:$active['phone']=0;
		isset($users_info['thumb']) && !empty($users_info['thumb'])?$active['profile_pix']=1:$active['profile_pix']=0;
		isset($users_info['country']) && $users_info['country']!=0?$active['country']=1:$active['country']=0;
		return $active;
	}



	public function redirect_url(){
		$active_info = $this->active_profile();
		if($active_info['phone']==0){
		 	$data['is_redirect'] = 1;
		 	$data['url'] = base_url('admin/auth/');
		}elseif($active_info['country']==0){
			$data['is_redirect'] = 1;
			$data['url'] = base_url('admin/auth/');
		}else{
			$data['is_redirect'] = 0;
			$data['url'] = '';
		}
		return $data;
	}




	public function open_menu(){
		$user_info = $this->common_m->get_user_info();
		$settings = $this->admin_m->get_settings();
	

		if(isset($user_info['user_role']) && $user_info['user_role']==1):
			if(isset($settings) && !empty($settings)){
				if(!empty($settings['smtp_mail']) && !empty($settings['site_name']) && !empty($settings['language'])):
					 $open_menu['is_home'] = 1;
				else:
					 $open_menu['is_home'] = 0;
				endif;
				return $open_menu;
			};
		endif;
		
	}



	public function check_package(){
		$pack = array();
		$package = $this->admin_m->single_select('packages');
		$trail_package = $this->admin_m->get_trail_package_id(0);
		if(!empty($this->user_role()) && $this->user_role()==1):
			empty($package)?$pack['package'] = 0:$pack['package']=1;
			empty($trail_package)?$pack['trail']=0:$pack['trail'] =1;
			return $pack;
		endif;
		
	}

	public function check_trial(){
		$pack = 0;
		$trail_package = $this->admin_m->get_extra_trail_package_id(0);
		if(!empty($this->user_role()) && $this->user_role()==1):
			$trail_package == 1?1:0;
			return $trail_package;
		endif;
		
	}

	public function get_trial_package(){
		
		if(!empty($this->user_role()) && $this->user_role()==1):
			return ['trial','weekly','fifteen'];
		endif;
		
	}


	public function user_role(){
		$user_info = $this->common_m->get_user_info();
		return isset($user_info['user_role']) && !empty($user_info['user_role'])?$user_info['user_role']:'';
	}


	
}





