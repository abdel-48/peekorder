<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function __construct(){
		parent::__construct();
		is_login();
	}


	public function index()
	{
		$this->profile(md5(auth('id')));
	}

	public function profile($user_id){

		$data = array();
		$data['page_title'] = "Auth Profile";
		$data['page'] = "Auth";
		$data['user_id'] = $user_id;
		$data['countries'] = $this->admin_m->select('country');
		$data['auth_info'] = $this->admin_m->get_auth_profile_info_md5($user_id);
		$data['restaurant'] = $this->admin_m->get_my_restaurant($user_id);
		$data['notification_list']=$this->admin_m->select('admin_notification_list');
		$data['main_content'] = $this->load->view('backend/common/profile', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	public function my_profile($user_id){

		$data = array();
		$data['page_title'] = "My Profile";
		$data['page'] = "Profile";
		$data['user_id'] = $user_id;
		$data['countries'] = $this->admin_m->select('country');
		$data['auth_info'] = $this->admin_m->get_auth_profile_info_md5($user_id);
		$data['main_content'] = $this->load->view('backend/profile/profile_thumb', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function edit_profile($user_id){
		$data = array();
		$data['page_title'] = "Edit profile";
		$data['page'] = "Auth";
		$data['user_id'] = $user_id;
		$data['countries'] = $this->admin_m->select('country');
		$data['auth_info'] = $this->admin_m->get_auth_profile_info_md5($user_id);
		$data['main_content'] = $this->load->view('backend/common/edit_profile', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function edit_restaurant($user_id){
		$data = array();
		$data['page_title'] = "Profile";
		$data['page'] = "Auth";
		$data['user_id'] = $user_id;
		$data['countries'] = $this->admin_m->select('country');
		$data['auth_info'] = $this->admin_m->get_auth_profile_info_md5($user_id);
		$data['restaurant'] = $this->admin_m->get_my_restaurant($user_id);
		$data['main_content'] = $this->load->view('backend/common/create_restaurant', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	public function import_cvs(){
		$data = array();
		$data['page_title'] = "Profile";
		$data['page'] = "Auth";
		$data['main_content'] = $this->load->view('backend/admin_activities/import_cvs', $data, TRUE);
		$this->load->view('backend/index',$data);
	}



public function upload_profile(){
	is_test();
	$data = array();
	if (!empty($_FILES['file']['name'])) {
	 	$up_load = $this->upload_m->upload(250);
	 	if($up_load['st']==1):
		 	foreach ($up_load['data'] as $key => $value) {
		 		$data = array(
		 			'image' => $value['image'],
		 			'thumb' => $value['thumb'],
		 		);
		 		$this->admin_m->update(array('thumb' => $value['thumb']),auth('id'),'users');
		 	}
		 	echo json_encode(array('st'=>1,'msg' =>'Upload Suceessfully','img'=>$value['thumb']));
		 else:
		 	echo json_encode(array('st'=>0,'msg' =>$up_load['data']));
		 endif;
	 	
	}else{
		echo json_encode(array('st'=>0,'msg' =>'Please select an image'));
	}

}


public function upload_restaurant_logo(){
	is_test();
	$data = array();
	if (!empty($_FILES['file']['name'])) {
	 	$up_load = $this->upload_m->upload(250);
	 	if($up_load['st']==1):
		 	foreach ($up_load['data'] as $key => $value) {
		 		$data = array(
		 			'image' => $value['image'],
		 			'thumb' => $value['thumb'],
		 		);
		 		$this->admin_m->update_user(array('thumb' => $value['thumb']),auth('id'),'restaurant_list');
		 	}
		 	echo json_encode(array('st'=>1,'msg' =>'Upload Suceessfully','img'=>$value['thumb']));
		 else:
		 	echo json_encode(array('st'=>0,'msg' =>$up_load['data']));
		 endif;
	 	
	}else{
		echo json_encode(array('st'=>0,'msg' =>'Please select an image'));
	}

}




	/**
  *** update profile action
**/ 

public function update_profile()
{
	is_test();
	if(users()->email == $this->input->post('email')){
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|valid_email');
	}else{
		$this->form_validation->set_rules('email', 'Email', 'trim|xss_clean|required|valid_email|is_unique[users.email]',array('is_unique'=>'Sorry This email already exits'));
	}

	if(users()->phone == $this->input->post('phone')){
		$this->form_validation->set_rules('phone', 'phone', 'trim|xss_clean');
	}else{
		$this->form_validation->set_rules('phone', 'phone', 'trim|xss_clean|required|is_unique[users.phone]|regex_match[/^[0-9]/]',array('is_unique'=>'Sorry This Phone already exits'));
	}
	$this->form_validation->set_rules('country', 'country', 'trim|xss_clean|required');
	$this->form_validation->set_rules('name', 'name', 'trim|xss_clean');
	$this->form_validation->set_rules('gender', 'Gender', 'trim|xss_clean');
	$this->form_validation->set_rules('designation', 'Designation', 'trim|xss_clean');
	$this->form_validation->set_rules('website', 'Website', 'trim|xss_clean');
	$this->form_validation->set_rules('address', 'Address', 'trim|xss_clean');
	$this->form_validation->set_rules('dial_code', 'Address', 'trim|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect($_SERVER['HTTP_REFERER']);
	}else{	
		$data = array(
			'name' => $this->input->post('name',TRUE),
			'email' => $this->input->post('email',TRUE),
			'phone' => $this->input->post('phone',TRUE),
			'country' => $this->input->post('country',TRUE),
			'gender' => $this->input->post('gender',TRUE),
			'designation' => $this->input->post('designation',TRUE),
			'website' => $this->input->post('website',TRUE),
			'dial_code' => $this->input->post('dial_code',TRUE),
			'address' => $this->input->post('address',TRUE),
		);
		$insert = $this->admin_m->update_profile($data,'users');
		if($insert){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/auth/'));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/auth/'));
		}	
	}
}

/**
    *** Change password 
 **/   
public function change_pass()
{	
	is_test();
	$this->form_validation->set_rules('old_pass', 'Old Password', 'trim|required|min_length[3]|xss_clean');		
	$this->form_validation->set_rules('new_pass', 'New Password', 'trim|required|min_length[3]|xss_clean');
	$this->form_validation->set_rules('c_pass', 'Confirm Password', 'trim|required|min_length[3]|xss_clean|matches[new_pass]');
	if ($this->form_validation->run() == FALSE) {
		$msg = '<div class="alert alert-danger alert-dismissible">
		<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		'.validation_errors().'
		</div>';
		echo json_encode(array('st' => 0, 'msg'=> $msg));
	}else{	
		$pass = $this->input->post('old_pass');

		$check = $this->admin_m->check_pass($pass);

		if($check){
			$data = array(
				'password' => md5($this->input->post('new_pass')),
			);	
			$insert = $this->admin_m->update($data,auth('id'),'users');
			if($insert){
				$msg = '<div class="alert alert-success alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Thank You ! </strong> Your password change successfully <i class="fa fa-smile-o"></i>
				</div>';

				echo json_encode(array('st' => 1, 'msg'=> $msg));

			}else{
				$msg = '<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong>Sorry </strong> Try again later
				</div>';

				echo json_encode(array('st' => 2, 'msg'=> $msg));
			}
		}else{
			$msg = '<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			<strong>Sorry </strong> Your Old password was wrong!
			</div>';

			echo json_encode(array('st' => 3, 'msg'=> $msg));
		}	

	}
}

/* Subscriptions
================================================== */

public function subscriptions(){
	if(USER_ROLE !=0){
		redirect(base_url('dashboard'));
	}
	$data = array();
	$data['page_title'] = "Subscriptions";
	$data['page'] = "Auth";
  $data['all_packages']=$this->admin_m->get_all_pacakges();
  $data['all_features'] = $this->common_m->select_with_status('features');
  $data['active_package'] = $this->admin_m->get_active_package();
	$data['main_content'] = $this->load->view('backend/users/subscriptions', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function resend_verify_mail($username){
	$send = $this->email_m->resend_verify_mail($username);
	if($send ==TRUE):
		$this->session->set_flashdata('success', 'your verification link send Successfully');
		redirect($_SERVER['HTTP_REFERER']);
	else:
		$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
		redirect($_SERVER['HTTP_REFERER']);
	endif;
}




/*  Profile home 
================================================== */
public function home_profile()
{
	$data = array();
	$data['page_title'] = "Home Profile";
	$data['page'] = "Profile";
	$data['data'] = false;
	$data['home'] = $this->admin_m->select_by_user('profile_home');
	$data['main_content'] = $this->load->view('backend/users/home_page', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function edit_home($id)
{
	$data = array();
	$data['page_title'] = "Home";
    $data['page'] = "Profile";
    $data['data'] =$this->admin_m->single_select_by_id($id,'profile_home');
    valid_user($data['data']['user_id']);
    $data['home'] = $this->admin_m->select_by_user('profile_home');
	$data['main_content'] = $this->load->view('backend/users/home_page', $data, TRUE);
	$this->load->view('backend/index',$data);
}


/**
  *** add home content
**/ 
public function add_home(){
	is_test();
	$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
	if ($this->form_validation->run() == FALSE) {
		$this->session->set_flashdata('error', validation_errors());
		redirect(base_url('admin/auth/add_home/'));
		}else{	

			$data = array(
				'title' => $this->input->post('title',true),
				'user_id' => auth('id'),
				'designation' => $this->input->post('designation',true),
				'institution' => $this->input->post('institution',true),
				'email' => $this->input->post('email',true),
				'whatsapp' => $this->input->post('whatsapp',true),
				'phone' => $this->input->post('phone',true),
				'website' => $this->input->post('website',true),
				'address' => $this->input->post('address'),
				'google_map' => $this->input->post('google_map'),
				'created_at' => d_time(),
			);
			$id = $this->input->post('id');
			if($id==0){
				$insert = $this->admin_m->insert($data,'profile_home');
			}else{
				$insert = $this->admin_m->update($data,$id,'profile_home');
			}

			if($insert){
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect(base_url('admin/auth/home_profile'));
			}else{
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect(base_url('admin/auth/home_profile'));
			}	
	}
}


/*  profile social sites
================================================== */
	public function social_sites()
	{
		$data = array();
		$data['page_title'] = "Social Sites";
	    $data['page'] = "Profile";
	    $data['data'] = false;
	    $data['social_sites'] = $this->admin_m->select_by_user('social_sites');
		$data['main_content'] = $this->load->view('backend/users/social_names', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function edit_social($id)
	{
		$data = array();
		$data['page_title'] = "Social Sites";
        $data['page'] = "Profile";
        $data['data'] = $this->admin_m->single_select_by_id($id,'social_sites');
        $data['social_sites'] = $this->admin_m->select_by_user('social_sites');
		$data['main_content'] = $this->load->view('backend/users/social_names', $data, TRUE);
		$this->load->view('backend/index',$data);
	}
	
	/**
	  *** add add_social_sites
	**/ 
	public function add_social_sites(){
		is_test();
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('icon', 'Icon', 'required|trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/auth/social_sites'));
			}else{	
				$data = array(
					'name' => $this->input->post('name',TRUE),
					'type' => $this->input->post('type',TRUE),
					'icon' => $this->input->post('icon',TRUE),
					'link' => $this->input->post('link'),
					'created_at' => d_time(),
				);
				$id = $this->input->post('id');
				if($id==0){
					$insert = $this->admin_m->insert($data,'social_sites');
				}else{
					$insert = $this->admin_m->update($data,$id,'social_sites');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/auth/social_sites'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/auth/social_sites'));
				}	
		}
	}

/*  profile services
================================================== */
/**
	  ** user services
	**/

	public function services()
	{
		$data = array();
		$data['page_title'] = "Services";
        $data['page'] = "Profile";
        $data['data'] = false;
        $data['services'] = $this->admin_m->select_all_by_user('services');
		$data['main_content'] = $this->load->view('backend/users/services', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	/**
	  ** edit user services
	**/

	public function edit_services($id)
	{
		$data = array();
		$data['page_title'] = "Services";
        $data['page'] = "Profile";
        $data['data'] =$this->admin_m->single_select_by_id($id,'services');
        $data['services'] = $this->admin_m->select_all_by_user('services');
        valid_user($data['data']['user_id']);
		$data['main_content'] = $this->load->view('backend/users/services', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	/**
	  *** add services
	**/ 
	public function add_services(){
		is_test();
		$this->form_validation->set_rules('title', 'Title', 'trim|required|xss_clean');
		$this->form_validation->set_rules('details', 'Details', 'required|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			$this->services();
			}else{	
				$data = array(
					'title' => $this->input->post('title',true),
					'user_id' => auth('id'),
					'icon' => $this->input->post('icon',true),
					'details' => $this->input->post('details'),
					'created_at' => d_time(),
				);
				$id = $this->input->post('id');
				if($id==0){
					$insert = $this->admin_m->insert($data,'services');
				}else{
					$insert = $this->admin_m->update($data,$id,'services');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/auth/services'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/auth/services'));
				}	
		}
	}



public function item_delete($id,$table){
	is_test();
	$del=$this->admin_m->item_delete($id,$table);
	if($del){
		$this->session->set_flashdata('success', 'Item Deleted');
		redirect($_SERVER['HTTP_REFERER']);
	}else{
		$this->session->set_flashdata('error', 'Somthing worng. Error!!');
		redirect($_SERVER['HTTP_REFERER']);
	}
}



	/**
	  *** delete user by admin
	**/ 
	public function delete_portfolio($id)
	{
		is_test();
		$img = single_select_by_id($id,'portfolio');

		$del= $this->admin_m->delete($id,"portfolio");
		if($del):
			delete_image_from_server($img['thumb']);
			delete_image_from_server($img['images']);
			$msg = 'Item Successfully Deleted';
			echo json_encode(array('st' => 1, 'msg'=> $msg));
		endif;
	}



	public function manage_features()
	{
		$data = array();
		$data['page_title'] = "Manage Features";
        $data['page'] = "Manage Features";
        $data['data'] = false;
        $data['pricing'] = $this->admin_m->get_all_users_features_by_id(auth('id'));
        $data['features'] = $this->admin_m->get_users_features();
		$data['main_content'] = $this->load->view('backend/users/manage_features', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function features_toggle($id,$value)
	{
		is_test();
		if($value==0){
			$data_value = 1;
		}else{
			$data_value = 0;
		}

		$data = array(
			'status' => $data_value,
		);

		$this->admin_m->update_feature($data,$id,'users_active_features');
		echo json_encode(array('st' => 1,'value'=>$data_value));
	}

	public function add_features_info(){
		is_test();
		$heading = $_POST['heading'];
		foreach ($heading as $key => $value) {
			$id =   $_POST['feature_id'][$key];
		    $data = array(
		    	'heading' => $value,
		    	'sub_heading' => $_POST['sub_heading'][$key],
		    );
		   $update = $this->admin_m->update_feature($data,$id,'users_active_features');
		}
		if($update){
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			redirect(base_url('admin/auth/manage_features'));
		}else{
			$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			redirect(base_url('admin/auth/manage_features'));
		}	

	}



	public function layouts()
	{
		$data = array();
		$data['page_title'] = "Layouts";
        $data['page'] = "Auth";
		$data['main_content'] = $this->load->view('backend/users/layouts', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function change_layouts($type,$value){
		is_test();
		$data = array(
			$type => $value,
		);
		$this->admin_m->update_profile($data,'users');
		echo json_encode(array('st'=>1,'value'=>$value));
	}


	public function cover_photo(){

		$data = array();
		$data['page_title'] = "Cover Photo";
		$data['page'] = "Auth";
		$data['user'] = $this->admin_m->get_auth_info();
		$data['main_content'] = $this->load->view('backend/users/add_cover_photo', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function add_cover()
{
	is_test();
	
	if(!empty($_FILES['file']['name'])){
		$directory = 'uploads/big/';	
		$dir = $directory;
		$name = $_FILES['file']['name'];
		list($txt, $ext) = explode(".", $name);
		$image_name = md5(time()).".".$ext;
		$tmp = $_FILES['file']['tmp_name'];
	   if(move_uploaded_file($tmp, $dir.$image_name)){
		    $url = $dir.$image_name;
		    $data = array('cover_photo' => $url);
			$this->admin_m->update($data,auth('id'),'users');	
			$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect(base_url('admin/auth/cover_photo'));
	   }else{
	   		$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
			 redirect(base_url('admin/auth/cover_photo'));
	   }
	}

}



	public function settings(){

		$data = array();
		$data['page_title'] = "Settings";
		$data['page'] = "Settings";
		$data['u_info'] = $this->admin_m->get_user_info();
		$data['settings'] = $this->admin_m->get_user_settings();
		$data['main_content'] = $this->load->view('backend/users/user_settings', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function whatsapp_config(){

		$data = array();
		$data['page_title'] = "Whatsapp Config";
		$data['page'] = "Whatsapp Config";
		$data['u_info'] = $this->admin_m->get_user_info();
		$data['settings'] = $this->admin_m->get_user_settings();
		$data['restaurant'] = $this->admin_m->get_my_restaurant(md5(auth('id')));
		$data['order_types'] = $this->admin_m->get_users_order_types_by_shop_id(restaurant()->id);
		$data['main_content'] = $this->load->view('backend/users/whatsapp_config', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function pwa_config(){

		$data = array();
		$data['page_title'] = "PWA Config";
		$data['page'] = "Settings";
		$data['settings'] = $this->admin_m->get_user_settings();
		$data['main_content'] = $this->load->view('backend/users/pwa', $data, TRUE);
		$this->load->view('backend/index',$data);

		$file = base_url('uploads/pwa/avatar.png');
		$filePath = 'assets/frontend/images/avatar.png';
		/* Store the path of destination file */
		$destinationFilePath = 'uploads/pwa/avatar.png';
		if (!file_exists($file)) {
			copy($filePath, $destinationFilePath);
		}
	}


	public function order_config(){

		$data = array();
		$data['page_title'] = "Order Configuration";
		$data['page'] = "Settings";
		$data['order_types'] = $this->admin_m->get_users_order_types(auth('id'),1);
		$data['main_content'] = $this->load->view('backend/users/order_config', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function order_type_config(){

		$data = array();
		$data['page_title'] = "Order Types Configuration";
		$data['page'] = "Settings";
		$data['order_types'] = $this->admin_m->get_users_order_types(auth('id'),1);
		$data['main_content'] = $this->load->view('backend/users/order_type_config', $data, TRUE);
		$this->load->view('backend/index',$data);
	}


	public function payment_config(){

		if(!is_feature(auth('id'),'online-payment')):
			redirect(base_url('dashboard'));
			exit();
		endif;
		$data = array();
		$data['page_title'] = "Payment Configuration";
		$data['page'] = "Settings";
		$data['settings'] = $this->admin_m->my_vendor_info(auth('id'));
		$data['url'] = 'admin/settings/add_payment_settings';
    $data['install_url'] = 'admin/auth/install_payment/';
		$data['main_content'] = $this->load->view('backend/users/payment_config', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function install_payment($field,$status){
		$settings = settings();
		$data = [$field => $status];
		$this->admin_m->update($data,restaurant()->id,'restaurant_list');
		$this->session->set_flashdata('success',!empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
		redirect(base_url('admin/auth/payment_config'));
	}

		/**
	  *** add themes
	**/ 
	public function add_whatsapp_config(){
		$this->form_validation->set_rules('whatsapp_number', 'Whatsapp Number', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/auth/whatsapp_config'));
			}else{	
				$id = $this->input->post('id',true);
				$is_whatsapp = $this->input->post('is_whatsapp',true);
				$data = array(
					'whatsapp_number' => $this->input->post('whatsapp_number',true),
					'whatsapp_msg' => json_encode($this->input->post('whatsapp_msg',true)),
					'is_whatsapp' => isset($is_whatsapp)?1:0,
					'whatsapp_enable_for' => json_encode($_REQUEST['whatsapp_for']),
				);

				if($id==0){
					$insert = $this->admin_m->insert($data,'restaurant_list');
				}else{
					$insert = $this->admin_m->update($data,$id,'restaurant_list');
				}	
				

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/auth/whatsapp_config'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/auth/whatsapp_config'));
				}	
		}
	}



	public function add_themes(){
		is_test();
		$this->form_validation->set_rules('theme', 'Theme', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/auth/settings'));
			}else{	
				$data = array(
					'theme' => $this->input->post('theme',true)
				);
				$insert = $this->admin_m->update($data,auth('id'),'users');

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/auth/settings'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/auth/settings'));
				}	
		}
	}


	/**
	  *** add themes
	**/ 
	public function add_loader(){
		is_test();
		$this->form_validation->set_rules('preloader', 'Pre-loader', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/auth/settings'));
			}else{	
				$data = array(
					'user_id' => auth('id'),
					'preloader' => $this->input->post('preloader',true),
				);
				
				$id = $this->input->post('id');
				if($id==0){
					$insert = $this->admin_m->insert($data,'user_settings');
				}else{
					$insert = $this->admin_m->update($data,$id,'user_settings');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/auth/settings'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/auth/settings'));
				}	
		}
	}

	public function add_email_settings(){
		is_test();
		$this->form_validation->set_rules('smtp_mail', 'Contact Email', 'required|trim|xss_clean|valid_email');


		if($this->input->post('email_type') ==2){
			$this->form_validation->set_rules('smtp_port', 'SMTP PORT', 'trim|required|xss_clean|numeric');
			$this->form_validation->set_rules('smtp_host', 'SMTP HOST', 'trim|required|xss_clean');
			$this->form_validation->set_rules('smtp_password', 'SMTP Email Password', 'trim|required|xss_clean');
		}

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/auth/settings'));
		}else{	
			$smtp = array(
				'smtp_host' => $this->input->post('smtp_host'),
				'smtp_port' => $this->input->post('smtp_port',TRUE),
				'smtp_password' => base64_encode($this->input->post('smtp_password',TRUE)),
			);
			$data = array(
				'smtp_mail' => $this->input->post('smtp_mail',TRUE),
				'email_type' => $this->input->post('email_type',TRUE),
				'smtp_config' => json_encode($smtp),
				
			);
			$id = $this->input->post('id',TRUE);

			if($id != 0):
				$insert = $this->admin_m->update($data,$id,'user_settings');
			else:
				$insert = $this->admin_m->insert($data,'user_settings');
			endif;

			if($insert){
				$data = array(
					'colors' => substr($this->input->post('colors'), 1),
				);
				$this->admin_m->update($data,auth('id'),'users');
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect(base_url('admin/auth/settings'));
			}else{
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect(base_url('admin/auth/settings'));
			}	
		}
	}


	public function deactive_account($status,$username){
		is_test();
		$user = get_id_by_slug($username);
		$data = array(
			'is_deactived' => $status
		);

		$up=$this->admin_m->update($data,$user['id'],'users');
		if($up){
			if($status==1):
				$this->session->set_flashdata('success', 'Your account is Deactive Now');
			else:
				$this->session->set_flashdata('success', 'Your account is Active Now');
			endif;
			redirect($_SERVER['HTTP_REFERER']);
		}else{
			$this->session->set_flashdata('error', 'Somthing worng. Error!!');
			redirect($_SERVER['HTTP_REFERER']);
		}
	}


	public function change_setting_status($id,$value,$table)
	{
		is_test();
		if($value==0){
			$data_value = 1;
		}else{
			$data_value = 0;
		}

		$data = array(
			'status' => $data_value,
		);

		$this->admin_m->update($data,$id,$table);
		echo json_encode(array('st' => 1,'value'=>$data_value));
	}

	public function seo_settings()
	{
		
		$data = array();
		$data['page_title'] = "Seo Settings";
    $data['page'] = "Settings";
    $data['settings'] = $this->admin_m->get_user_settings();
		$data['main_content'] = $this->load->view('backend/users/seo_settings', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function icon_settings()
	{
		
		$data = array();
		$data['page_title'] = "Icon Settings";
    $data['page'] = "Settings";
    $data['settings'] = $this->admin_m->get_user_settings();
		$data['main_content'] = $this->load->view('backend/users/icon_settings', $data, TRUE);
		$this->load->view('backend/index',$data);
	}






	public function add_seo_settings(){
		is_test();
    	$id = $this->input->post('id');
		$this->form_validation->set_rules('title', 'Title', 'trim|xss_clean|required');
		$this->form_validation->set_rules('description', 'Description', 'trim|xss_clean|required');
		$this->form_validation->set_rules('keywords', 'keywords', 'trim|xss_clean|required');
		$this->form_validation->set_rules('analytics_id', 'analytics id', 'trim|xss_clean');
		$this->form_validation->set_rules('pixel_id', 'pixel id', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/auth/seo_settings'));
			}else{	
				$social = array(
					'title' => $this->input->post('title',TRUE),
					'description' => $this->input->post('description',TRUE),
					'keywords' => $this->input->post('keywords',TRUE),
				);

				$data = array(
					'user_id' => auth('id'),
					'analytics_id' => $this->input->post('analytics_id',TRUE),
					'pixel_id' => $this->input->post('pixel_id',TRUE),
					'seo_settings' => json_encode($social),
				);
				if($id==0){
					$insert = $this->admin_m->insert($data,'user_settings');
				}else{
					$insert = $this->admin_m->update($data,$id,'user_settings');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/auth/seo_settings'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/auth/seo_settings'));
				}	
		}
	}

	public function twillo_sms_settings()
	{
		
		$data = array();
		$data['page_title'] = "Twillo SMS Settings";
    $data['page'] = "Settings";
    $data['settings'] = $this->admin_m->get_user_settings();
		$data['main_content'] = $this->load->view('backend/users/twillo_sms_settings', $data, TRUE);
		$this->load->view('backend/index',$data);
	}

	public function add_twillo_sms_settings(){
		is_test();
    	$id = $this->input->post('id');
		$this->form_validation->set_rules('account_sid', 'Account SID', 'trim|xss_clean|required');
		$this->form_validation->set_rules('auth_token', 'Auth token', 'trim|xss_clean|required');
		$this->form_validation->set_rules('virtual_number', 'Twillo virtual number', 'trim|xss_clean|required');
		$this->form_validation->set_rules('accept_msg', 'accept msg', 'trim|xss_clean|required');
		$this->form_validation->set_rules('complete_msg', 'complete msg', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/auth/twillo_sms_settings'));
			}else{	
				$social = array(
					'account_sid' => $this->input->post('account_sid',TRUE),
					'auth_token' => $this->input->post('auth_token',TRUE),
					'virtual_number' => $this->input->post('virtual_number',TRUE),
					'is_accept_sms' => $this->input->post('is_accept_sms',TRUE),
					'is_complete_sms' => $this->input->post('is_complete_sms',TRUE),
					'accept_msg' => json_encode($this->input->post('accept_msg',TRUE)),
					'complete_msg' => json_encode($this->input->post('complete_msg',TRUE)),
				);

				$data = array(
					'user_id' => auth('id'),
					'twillo_sms_settings' => json_encode($social),
				);
				if($id==0){
					$insert = $this->admin_m->insert($data,'user_settings');
				}else{
					$insert = $this->admin_m->update($data,$id,'user_settings');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/auth/twillo_sms_settings'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/auth/twillo_sms_settings'));
				}	
		}
	}

public function add_icon_settings(){
		is_test();
    	$id = $this->input->post('id');
		$this->form_validation->set_rules('title[]', 'Title', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/auth/icon_settings'));
			}else{	
				foreach($_POST['title'] as $key => $value) {
					$i = $key+1;
					$data[] = array(
						'title' => $value,
						'icon' => $_POST['icon'][$key],
						'img_url' => $_POST['img_url'][$key],
						'is_img' => $this->input->post('is_img_'.$i)?$this->input->post('is_img_'.$i):0,
					);
					
				}
				$data = ['icon_settings' => json_encode($data)];

				if($id==0){
					$insert = $this->admin_m->insert($data,'user_settings');
				}else{
					$insert = $this->admin_m->update($data,$id,'user_settings');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/auth/icon_settings'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/auth/icon_settings'));
				}	
		}
	}




public function upload_icon_img($i)
	{
		$data = [];
		$config['upload_path'] = 'uploads/';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']     = '100';
		// $config['max_width'] = '100';
		// $config['max_height'] = '100';
		$config['overwrite'] = TRUE;
		$config['encrypt_name'] = TRUE;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

			if (!$this->upload->do_upload('images'))
			{
				$error = array('error' => $this->upload->display_errors());
			}else{
				$data['images'] = $this->upload->data()['file_name'];
			}

			return $data;

	}


	public function add_pwa(){
		is_test();
		if(check() !=1):
			exit();
		endif;
    $id = $this->input->post('id');
		$this->form_validation->set_rules('title', 'Title', 'trim|xss_clean|required');
		$this->form_validation->set_rules('theme_color', 'Theme Color', 'trim|xss_clean');
		$this->form_validation->set_rules('background_color', 'background Color', 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/auth/pwa_config/'));
			}else{	
				$old_img = $this->input->post('old_img');
				$logo = $this->upload_logo($old_img);
				$is_pwa_active = $this->input->post('is_pwa_active');

				$pwaData = array(
					'title' => $this->input->post('title',TRUE),
					'theme_color' => substr($this->input->post('theme_color',TRUE),1),
					'background_color' => substr($this->input->post('background_color',TRUE),1),
					'is_pwa_active' => isset($is_pwa_active)?$is_pwa_active :0,
					'logo' => !empty($logo)?$logo:$old_img,
				);
				$data = array(
					'pwa_config' => json_encode($pwaData),
				);


				if($id==0){
					$insert = $this->admin_m->insert($data,'user_settings');
				}else{
					$insert = $this->admin_m->update($data,$id,'user_settings');
				}

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/auth/pwa_config'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/auth/pwa_config'));
				}	
		}
	}

	public function upload_logo()
	{
		
		if(!empty($_FILES['images']['name'])){
			$directory = 'uploads/pwa/';
			$dir = $directory;
			$name = $_FILES['images']['name'];
			list($txt, $ext) = explode(".", $name);
			$image_name = md5(time()).".".$ext;
			$tmp = $_FILES['images']['tmp_name'];
			if(move_uploaded_file($tmp, $dir.$image_name)){
				$url = $dir.$image_name;
				$data = array('logo' => $url);
				return $url;
			}else{
				echo "image uploading failed";
			};
		}

	}


	public function change_username(){
		is_test();
		$this->form_validation->set_rules('username', 'Username', 'trim|xss_clean|required|is_unique[users.username]');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
			}else{	

    	  $id = $this->input->post('id');
				$users = array(
					'username' => $this->input->post('username',TRUE),
				);

				$shop = array(
					'username' => $this->input->post('username',TRUE),
				);

				$insert = $this->admin_m->update($users,$id,'users');
				$insert = $this->admin_m->update_by_user_id($users,$id,'restaurant_list');

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect($_SERVER['HTTP_REFERER']);
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect($_SERVER['HTTP_REFERER']);
				}	
		}
	}


public function delivery_settings()
{
	$data = array();
	$data['page_title'] = "Delivery Settings";
	$data['page'] = "Settings";
	$data['data'] = false;
	$data['home'] = $this->admin_m->select_by_user('profile_home');
	$data['main_content'] = $this->load->view('backend/users/delivery_settings', $data, TRUE);
	$this->load->view('backend/index',$data);
}


public function add_delivery_settings(){
		$this->form_validation->set_rules('latitude', 'Latitude', 'trim|xss_clean|required');
		$this->form_validation->set_rules('longitude', 'Longitude', 'trim|xss_clean|required');
		$this->form_validation->set_rules('radius', 'Radius', 'trim|xss_clean|required');
		$this->form_validation->set_rules('msg', 'Msg', 'trim|xss_clean|required');

		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/auth/delivery_settings'));
			}else{	
				$id = $this->input->post('id',true);
				$is_radius = $this->input->post('is_radius',true);

				$d_data = [
						'latitude' => $this->input->post('latitude',TRUE),
						'longitude' => $this->input->post('longitude',TRUE),
						'radius' => $this->input->post('radius',TRUE),
						'msg' => $this->input->post('msg'),
				];
				$data = array(
					'is_radius' => isset($is_radius)?1:0,
					'radius_config' => json_encode($d_data),
				);
				

				if($id==0){
					$insert = $this->admin_m->insert($data,'restaurant_list');
				}else{
					$insert = $this->admin_m->update($data,$id,'restaurant_list');
				}	
				

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/auth/delivery_settings'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/auth/delivery_settings'));
				}	
		}
	}








public function whatsapp_message()
{
	$data = array();
	$data['page_title'] = "Whatsapp Message";
	$data['page'] = "Profile";
	$data['data'] = false;
	$data['home'] = $this->admin_m->select_by_user('profile_home');
	$data['main_content'] = $this->load->view('backend/users/whatsapp_message', $data, TRUE);
	$this->load->view('backend/index',$data);
}

	public function add_whatsapp_message(){
		$this->form_validation->set_rules('accept_message', 'Accept Message', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect(base_url('admin/auth/whatsapp_message'));
			}else{	
				$id = $this->input->post('id',true);
				$is_whatsapp = $this->input->post('is_whatsapp',true);
				$data = array(
					'accept_message' => json_encode($this->input->post('accept_message',true)),
					'completed_message' => json_encode($this->input->post('completed_message',true)),
					'delivered_message' => json_encode($this->input->post('delivered_message',true)),
				);
				if($id==0){
					$insert = $this->admin_m->insert($data,'restaurant_list');
				}else{
					$insert = $this->admin_m->update($data,$id,'restaurant_list');
				}	
				

				if($insert){
					$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
					redirect(base_url('admin/auth/whatsapp_message'));
				}else{
					$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
					redirect(base_url('admin/auth/whatsapp_message'));
				}	
		}
	}



	public function import_json($slug){
		$csvMimes = array('application/json','text/json','text/json','text/json');
		if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
			if(is_uploaded_file($_FILES['file']['tmp_name'])){
				$string = file_get_contents($_FILES['file']['tmp_name']);
				$json_a = json_decode($string, true);
				foreach ($json_a as $key => $value) {
					$data[] = array(
							'id' => $value['id'],
							$slug => $value[$slug],
					);
				}
				$this->db->update_batch('language_data',$data, 'id'); 
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
			}else{
				$this->session->set_flashdata('error', lang('error_text'));
			}
		}else{
			$this->session->set_flashdata('error', "Invalid File");
		}
		
		redirect(base_url('admin/home/dashboard_languages'));
	}



	public function upload_file__cvs(){
		$csvMimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');
		if(!empty($_FILES['file']['name']) && in_array($_FILES['file']['type'],$csvMimes)){
			if(is_uploaded_file($_FILES['file']['tmp_name'])){

	            //open uploaded csv file with read only mode
				$csvFile = fopen($_FILES['file']['tmp_name'], 'r');


	        // skip first line
	        // if your csv file have no heading, just comment the next line
				  //fgetcsv($csvFile);
			
	        //parse data from csv file line by line
				while(($line = fgetcsv($csvFile)) !== FALSE){
	                //check whether member already exists in database with same email
					$result = $this->db->get_where("language_data", array("bn"=>$line[3]))->result();
					$this->db->update("language_data", array("bn"=>$line[3]), array("id"=>$line[0]));
					// if(count($result) > 0){
	    //                 //update member data
					// 	$this->db->update("language_data", array("bn"=>$line[3]), array("id"=>$line[0]));
					// }else{
	    //                 //insert member data into database
					// 	$this->db->insert("member", array("name"=>$line[0], "email"=>$line[1], "phone"=>$line[2], "created"=>$line[3], "status"=>$line[4]));
					// }
				}

	            //close opened csv file
				fclose($csvFile);

				$qstring["status"] = 'Success';
			}else{
				$qstring["status"] = 'Error';
			}
		}else{
			$qstring["status"] = 'Invalid file';
		}
		echo "<pre>";print_r($qstring["status"]);exit();
	}




	public function exportjson($slug){ 
   // file name 
		$filename = $slug.'_'.date('Ymd').'.json'; 
		header("Content-Description: File Transfer"); 
		header("Content-Disposition: attachment; filename=$filename"); 
		header("Content-Type: application/json; charset=UTF-8");
		header('content-type:text/html;charset=utf-8');

   // get data 
		$usersData = $this->admin_m->get_cvs_data();
		$data = array();

		foreach ($usersData as $key => $row) {
			$data[] = array(
				'id' => $row['id'],
				'keyword' => $row['keyword'],
				'english' => $row['english'],
				$slug => !empty($row[$slug])?$row[$slug]:'',
			);
		}


		$fp = fopen('php://output', 'w');
		fwrite($fp, json_encode($data,JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE ));
		fclose($fp);


	}


	public function enable_order_types(){
		$this->form_validation->set_rules('is_admin_enable[]', 'Order Types', 'trim|xss_clean|required');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{	
			$shop_id = $this->input->post('shop_id',true);
			$type_ids = $this->input->post('type_ids',true);
				$data = [];
				foreach ($type_ids as $key => $value) {
					if(isset($_POST['is_admin_enable'][$value]) && $_POST['is_admin_enable'][$value]==$value){
						$update = $this->admin_m->update_order_types(['is_admin_enable'=>1,'status'=>1],$value,$shop_id);
					}else{
						$update = $this->admin_m->update_order_types(['is_admin_enable'=>0,'status'=>0],$value,$shop_id);
					}
					
				}

			if($update){
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect($_SERVER['HTTP_REFERER']);
			}	
		}
	}

public function change_order_layouts($status)
{
	$data = [
		'order_view_style' => $status
	];
	$this->admin_m->update($data,restaurant()->id,'restaurant_list');
	$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
	redirect($_SERVER['HTTP_REFERER']);
}


public function extras()
{
	$data = array();
	$data['page_title'] = "Extras";
	$data['page'] = "Settings";
	$data['data'] = false;
	$data['settings'] = $this->admin_m->get_user_settings();
	$data['main_content'] = $this->load->view('backend/users/extras', $data, TRUE);
	$this->load->view('backend/index',$data);
}

public function add_extra_config(){
		$this->form_validation->set_rules('app', lang('choose_an_app'), 'trim|xss_clean');
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata('error', validation_errors());
			redirect($_SERVER['HTTP_REFERER']);
		}else{	

				$id = $_POST['id'];
				$jsData = [
					'app' => $this->input->post('app'),
					'app_id' => $this->input->post('app_id'),
					'elfsight_status' => $this->input->post('elfsight_status'),
				];

				$data = ['extra_config' => json_encode($jsData)];

				$update  = $this->admin_m->update($data,$id,'user_settings');

			if($update){
				$this->session->set_flashdata('success', !empty(lang('success_text'))?lang('success_text'):'Save Change Successful');
				redirect($_SERVER['HTTP_REFERER']);
			}else{
				$this->session->set_flashdata('error', !empty(lang('error_text'))?lang('error_text'):'Somethings Were Wrong!!');
				redirect($_SERVER['HTTP_REFERER']);
			}	
		}
	}


}
