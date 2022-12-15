<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updated_queries extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->db->query("SET sql_mode = ''");
		$this->load->dbforge();
	}
	public function install_version($version){
		$data = [];

		do
		{
			 if($version > 1.2 && $version < 2.4)
		    {
		    	$new_version = 2.4;
		        $data = ['st'=>3,"msg" => 'You have to update it from using YOUR_URL/update','version'=> $new_version];
		        break;
		    }


		   
			if($version < 2.5):
				$new_version = 2.5;
				
				$check_slug = $this->check_slug('paystack','payment_method_list');
				if($check_slug==0):
					$this->db->query('INSERT INTO payment_method_list(name,slug,active_slug,status_slug,status) VALUES ("Paystack","paystack","paystack_status","is_paystack",1)');
				endif;


				$addColumnQueries = [ 
					
					'settings' => [
						'paystack_status' => "int  NOT NULL DEFAULT 1",
						'is_paystack' => "int  NOT NULL DEFAULT 0",
						'paystack_config' => "LONGTEXT NULL",
						'nearby_length' => "VARCHAR(20) NULL DEFAULT 5",
						'extras' => "LONGTEXT NULL",
						'notifications' => "LONGTEXT NULL",
					],

					'restaurant_list' => [
						'paystack_status' => "int  NOT NULL DEFAULT 1",
						'is_paystack' => "int  NOT NULL DEFAULT 0",
						'paystack_config' => "LONGTEXT NULL",
						'is_admin_onsignal' => "INT NOT NULL DEFAULT 0",
					],

					'item_extras' => [
						'ex_id' => "INT NOT NULL DEFAULT 0",
					],

					'users_active_order_types' => [
						'is_required' => "INT NOT NULL DEFAULT 0",
					],

				];
				// 

				if(!$this->db->table_exists('extra_libraries')):
					$this->db->query("CREATE TABLE `extra_libraries` ( `id` INT NOT NULL AUTO_INCREMENT , `user_id` INT NOT NULL , `shop_id` INT NOT NULL , `name` VARCHAR(255) NOT NULL ,`price` VARCHAR(255) NOT NULL , `status` VARCHAR(255) NOT NULL DEFAULT 1, PRIMARY KEY (`id`)) ENGINE = InnoDB;");
				endif;


				if(!$this->db->table_exists('extra_libraries')):
					 $this->db->query('CREATE TABLE `extra_libraries` (
					  	`id` int(11) NOT NULL AUTO_INCREMENT,
					  	`shop_id` int(11) NOT NULL,
					  	`auth_id` int(11) NOT NULL,
					  	`user_id` VARCHAR(255) NOT NULL,
					  	`created_at` datetime NOT NULL,
					  	`status` int(11) NOT NULL DEFAULT 1,
					  	PRIMARY KEY (`id`)
					  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;');
				endif;





				$keywords = ['payment_required','hide_pay_later','notifications_send_successfully','send_notifications','paystack_secret_key','all_extras'];
				$check_keywords = $this->check_keywords($keywords);
				if($check_keywords==0):
					$this->db->query("INSERT INTO `language_data` (`keyword`, `type`, `details`, `english`) VALUES
						('payment_required','admin','Payment Required','Payment Required'),
						('hide_pay_later','admin','Hide Pay later','Hide Pay later'),
						('notifications_send_successfully','admin','Notifications send successfully','Notifications send successfully'),
						('send_notifications','admin','Send Notification','Send Notification'),
						('custom_link','admin','Custom Link','Custom Link'),
						('disabled_onsignal_access','admin','Disabled onSignal Notification','Disabled onSignal Notification'),
						('allow_onsignal_access','admin','Allow onSignal Notification','Allow onSignal Notification'),
						('user_auth_key','admin','User Auth Key','User Auth Key'),
						('onsignal_app_id','admin','Onesignal App ID','Onesignal App ID'),
						('onsignal_api','admin','onSignal API','onSignal API'),
						('add_extra','admin','Add Extra','Add Extra'),
						('all_extras','admin','All Extras','All Extras'),
						('nearby_radius','admin','Nearby Radius','Nearby Radius'),
						('paystack_payment_gateways','admin','Paystack Payment Gateways','Paystack Payment Gateways'),
						('paystack_secret_key','admin','Paystack Secret Key','Paystack Secret Key'),
						('paystack_publick_key','admin','Paystack Public Key','Paystack Public Key'),
						('paystack','admin','Paystack','Paystack');");

				endif;



				$addColumn = $this->sql_command($addColumnQueries);

				if(isset($addColumn['st']) && $addColumn['st']==0):
					$data = ["st"=>0, "msg" => $addColumn['msg'],'version'=> $new_version];
				else:

					$data = ['st'=>1,"msg" => 'Updated Successfully','version'=> $new_version];
				endif;

				break;
			endif;
			/*----------------------------------------------
			  				End version 2.5
			----------------------------------------------*/


			if($version < 2.6):
				$new_version = 2.6;


				$this->db->query('ALTER TABLE items MODIFY 	allergen_id VARCHAR(255) NULL');
				$this->db->query('ALTER TABLE settings MODIFY `social_sites` LONGTEXT NULL');

				$addColumnQueries = [ 
					
					'order_user_list' => [
						'is_change' => "INT  NOT NULL DEFAULT 0",
						'change_amount' => "VARCHAR(50) NOT NULL DEFAULT 0",
					],

					'restaurant_list' => [
						'is_question' => "INT  NOT NULL DEFAULT 0",
						'is_radius' => "INT  NOT NULL DEFAULT 0",
						'radius_config' => "LONGTEXT NULL",
						'is_tax' => "INT NOT NULL DEFAULT 0",
						'tax_status' => "VARCHAR(10)  NOT NULL DEFAULT '+'",
						'is_kds_pin' => "INT(11)  NOT NULL DEFAULT 0",
						'kds_pin' => "VARCHAR(20) NULL",
					],

					'staff_list' => [
						'question' => "LONGTEXT  NULL",
					],

					'items' => [
						'tax_fee' => "VARCHAR(10)  NOT NULL DEFAULT 0",
						'tax_status' => "VARCHAR(10)  NOT NULL DEFAULT '+'",
					],

				];
				// 


				if(!$this->db->table_exists('question_list')):
					$this->db->query('CREATE TABLE `question_list` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`title` VARCHAR(255) NOT NULL,
						`user_id` VARCHAR(255) NOT NULL,
						`created_at` datetime NOT NULL,
						`status` int(11) NOT NULL DEFAULT 1,
						PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;');
				endif;



				$keywords = ['enter_pin','kds_pin','tax_excluded','tax_included','item_tax_status','security_question','signup_questions'];
				$check_keywords = $this->check_keywords($keywords);
				if($check_keywords==0):
					$this->db->query("INSERT INTO `language_data` (`keyword`, `type`, `details`, `english`) VALUES
						('enter_pin','admin','Enter Pin','Enter Pin'),
						('kds_pin','admin','KDS Pin','KDS Pin'),
						('tax_excluded','admin','Tax Excluded','Tax Excluded'),
						('tax_included','admin','Tax Included','Tax Included'),
						('item_tax_status','admin','Item Tax Status','Item Tax Status'),
						('price_tax_msg','admin','Tax are only for showing tax status in invoice. Set your price including/excluding tax','Tax are only for showing tax status in invoice. Set your price including/excluding tax'),
						('not_found_msg','admin','Not Found Message','Not Found Message'),
						('radius','admin','Radius','Radius'),
						('radius_base_delivery_settings','admin','Enable Radius Based Delivery Settings','Radius Based Delivery Settings'),
						('delivery_settings','admin','Delivery Settings','Delivery Settings'),
						('enable_radius_base_delivery','admin','Enable Raduis Based Delivery','Enable Radius Based Delivery'),
						('change_amount','admin','Change Amount','Change Amount'),
						('change','admin','Change','Change'),
						('security_question_ans_not_correct','admin','Security Questions answer is not correct','Security Questions answer is not correct'),
						('enable_security_question','admin','Enable Security Question','Enable Security Question'),
						('write_your_answer_here','admin','Write your answer here','Write your answer here'),
						('security_question','admin','Security Question','Security Question'),
						('signup_questions','admin','Signup Questions','Signup Questions'),
						('half_yearly','admin','Half Year / 6 month','Half Year- 6 month'),
						('6_month','admin','Half Year / 6 month','Half Year / 6 month'),
						('table_no','admin','Table No','Table No');");

				endif;



				$addColumn = $this->sql_command($addColumnQueries);

				if(isset($addColumn['st']) && $addColumn['st']==0):
					$data = ["st"=>0, "msg" => $addColumn['msg'],'version'=> $new_version];
				else:

					$data = ['st'=>1,"msg" => 'Updated Successfully','version'=> $new_version];
				endif;

				break;
			endif;


		   
		    if($version < 2.7)
		    {
		    	$new_version = 2.7;

		    	if($this->checkExistFields('restaurant_list','is_questions')==1){
		    		$this->db->query('ALTER TABLE restaurant_list CHANGE  `is_questions` `is_question` INT  NOT NULL DEFAULT 0');
		    	}

		    	if($this->checkExistFields('staff_list','questions')==1){
		    		$this->db->query('ALTER TABLE staff_list CHANGE  `questions` `question` INT  NOT NULL DEFAULT 0');
		    	}

		    	$addColumnQueries = [ 
					'settings' => [
						'restaurant_demo' => "VARCHAR(50) NULL",
						'sendgrid_api_key' => "LONGTEXT NULL",
						'currency_position' => "INT NOT NULL DEFAULT 1",
						'number_formats' => "INT NOT NULL DEFAULT 1",
						'offline_status' => "INT NOT NULL DEFAULT 1",
						'is_offline' => "INT NOT NULL DEFAULT 1",
						'offline_config' => "LONGTEXT NULL",
					],

					'user_settings' => [
						'onesignal_config' => "LONGTEXT NULL",
						'extra_config' => "LONGTEXT NULL",
					],

					'restaurant_list' => [
						'order_view_style' => "INT NOT NULL DEFAULT 1",
					],

					'reservation_date' => [
						'is_24' => "INT NOT NULL DEFAULT 0",
					],


				];


				$check_slug = $this->check_slug('offline','payment_method_list');
				if($check_slug==0):
					$this->db->query('INSERT INTO payment_method_list(name,slug,active_slug,status_slug,status) VALUES ("Offline","offline","offline_status","is_offline",1)');
				endif;

				$check_slug = $this->check_slug('pwa-push','features');
				if($check_slug==0):
					$this->db->query("INSERT INTO features(id,features,slug,status,is_features,created_at) VALUES 
						('11','OneSignal & PWA','pwa-push','1','1','2022-09-08 23:04:31')");
				endif;

				if(!$this->db->table_exists('admin_notification')):
					$this->db->query('CREATE TABLE `admin_notification` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`notification_id` INT(11) NULL,
						`restaurant_id` INT(11)  NULL,
						`status` INT(11)  NOT NULL DEFAULT 1,
						`seen_status` INT(11)  NOT NULL DEFAULT 0,
						`is_admin_enable` INT(11)  NOT NULL DEFAULT 1,
						`created_at` datetime  NULL,
						`send_at` datetime  NULL,
						`seen_time` datetime  NULL,
						PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;');
				endif;


				if(!$this->db->table_exists('admin_notification_list')):
					$this->db->query('CREATE TABLE `admin_notification_list` (
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`title` VARCHAR(255) NULL,
						`details` LONGTEXT NULL ,
						`status` INT(11)  NOT NULL DEFAULT 1,
						`created_at` datetime  NULL,
						PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;');
				endif;


				$addColumn = $this->sql_command($addColumnQueries);
				
				if(isset($addColumn['st']) && $addColumn['st']==0):
					$data = ["st"=>0, "msg" => $addColumn['msg'],'version'=> $new_version];
				else:

					$data = ['st'=>1,"msg" => 'Updated Successfully','version'=> $new_version];
				endif;

		        break;

		    }

		    

		    if($version < 2.8){
		    	$new_version = 2.8;

				$addColumnQueries = [ 
					
					'order_user_list' => [
						'is_restaurant_payment' => "INT NOT NULL DEFAULT 0",
						'is_db_request' => "INT NOT NULL DEFAULT 0",
						'db_completed_by' => "VARCHAR(255) NOT NULL DEFAULT 'staff'",
						'hotel_id' => "INT NOT NULL",
						'room_number' => "VARCHAR(255) NULL",
					],

					'restaurant_list' => [
						'room_number' => "VARCHAR(255) NULL",
						'is_db_request' => "INT NOT NULL DEFAULT 0",
						'db_completed_by' => "VARCHAR(255) NOT NULL DEFAULT 'staff'",
						'hotel_id' => "INT NOT NULL",
						'whatsapp_enable_for' => "longtext NOT NULL DEFAULT '{\"cash-on-delivery\":\"1\",\"booking\":\"0\",\"pickup\":\"1\",\"pay-in-cash\":\"0\",\"dine-in\":\"0\"}'",
					],

					'reservation_date' => [
						'is_24' => "INT NOT NULL DEFAULT 0",
					],

				];


				$this->db->query('ALTER TABLE settings MODIFY version VARCHAR(20) NULL');

				if(!$this->db->table_exists('hotel_list')):
					$this->db->query('CREATE TABLE `hotel_list`(
						`id` int(11) NOT NULL AUTO_INCREMENT,
						`hotel_name` VARCHAR(255) NULL,
						`user_id` INT(11) NOT NULL,
						`shop_id` INT(11) NOT NULL,
						`room_numbers` LONGTEXT NULL ,
						`status` INT(11)  NOT NULL DEFAULT 1,
						`created_at` datetime  NULL,
						PRIMARY KEY (`id`)
					) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;');
				endif;



				$check_slug = $this->check_slug('pay-cash','order_types');
				if($check_slug==0):
					$this->db->query("INSERT INTO order_types(id,name,slug,status,is_order_types,created_at) VALUES 
							('7','Pay cash','pay-cash','1','1','2022-09-20 23:04:31')");
				endif;


				$check_slug = $this->check_slug('room-service','order_types');
				if($check_slug==0):
					$this->db->query("INSERT INTO order_types(id,name,slug,status,is_order_types,created_at) VALUES 
							('8','Room Service','room-service','1','1','2022-09-20 23:04:31')");
				endif;



				
				$keywords = ['package_restaurant_dine_in','room_number','sorry_room_numbers_not_available','enable_whatsapp_for_order','completed_paid','add_delivery_boy'];
				$check_keywords = $this->check_keywords($keywords);
				if($check_keywords==0):
					 $this->db->query("INSERT INTO `language_data` (`keyword`, `type`, `details`, `english`) VALUES
						('package_restaurant_dine_in','admin','Package / Restaurant Dine-In','Package / Restaurant Dine-In'),
						('room_number','admin','Room Number','Room Number'),
						('sorry_room_numbers_not_available','admin','Sorry Room Not found','Sorry Room Not found'),
						('room_numbers','admin','Room Numbers','Room Numbers'),
						('hotel_list','admin','Hotel List','Hotel List'),
						('hotel_name','admin','Hotel Name','Hotel Name'),
						('room_services','admin','Room services','Room services'),
						('enable_whatsapp_for_order','admin','Enable WhatsApp For order','Enable WhatsApp For order'),
						('table-dine-in','admin','Table / Dine-in','Table / Dine-in'),
						('sorry_today_pickup_time_is_not_available','admin','Sorry, Pickup Time is not available today','Sorry, Pickup Time is not available today'),
						('please_login_to_continue','admin','Please Login to continue.','Please Login to continue.'),
						('account_confirmation_link_msg','admin','The account confirmation link has been emailed to you, follow the link in the email to continue.','The account confirmation link has been emailed to you, follow the link in the email to continue.'),
						('account_created_successfully','admin','Account Created Successfully','Account Created Successfully'),
						('vendor','admin','Vendor','Vendor'),
						('selectd_by_restaurant','admin','Selected by Restaurant','Selected by Restaurant'),
						('dboy_name','admin','Delivery Guy','Delivery Guy'),
						('add_delivery_boy','admin','Add delivery Boy','Add delivery guy'),
						('completed_paid','admin','Completed & Paid','Completed & Paid'),
						('mark_as_completed_paid','admin','Mark as completed & Paid','Mark as completed & Paid'),
						('unpaid','admin','Unpaid','Unpaid'),
						('mark_as_paid','admin','Mark as Paid','Mark as Paid'),
						('select_delivery_boy','admin','Select Delivery Boy','Select Delivery Boy'),
						('delivered','admin','Delivered','Delivered'),
						('open_24_hours','admin','Open 24 Hours','Open 24 Hours'),
						('enable_24_hours','admin','Enable 24 Hours','Enable 24 Hours'),
						('select_room_number','admin','Select Room Number','Select Room Number'),
						('mark_as_delivered','admin','Mark as delivered','Mark as delivered');");

				endif;
				
				$addColumn = $this->sql_command($addColumnQueries);
				
				if(isset($addColumn['st']) && $addColumn['st']==0):
					$data = ["st"=>0, "msg" => $addColumn['msg'],'version'=> $new_version];
				else:

					$data = ['st'=>1,"msg" => 'Updated Successfully','version'=> $new_version];
				endif;

				
			}



		/*----------------------------------------------
		  				VERSION END 
		----------------------------------------------*/

		} while($version==NEW_VERSION);


		return $data;		
	} //install_version


	/*----------------------------------------------
	  		ADD Fields SQL Comments
	----------------------------------------------*/
	public function sql_command($addColumnQueries=[]){
		if(!empty($addColumnQueries)):
			try{
				foreach ($addColumnQueries as $tableName => $queryValue) {
					foreach ($queryValue as $fieldName => $attribute) {
						if($this->checkExistFields($tableName,$fieldName)==1){
							$this->dbforge->add_column($tableName, $fieldName.' '.$attribute);;
						}
					}

				}
			}catch(Exception $e){
				return ['st'=>0,'msg'=>$e->getMessage()];
			}
			

		endif;
	}




	public function  checkExistFields($table,$fields)
	{
		if(!$this->db->field_exists($fields, $table)){
			return 1;
		}else{
			return 0;
		}
	}


	public function check_keywords($keywords)
  	{
        $this->db->select();
        $this->db->from('language_data');
        $this->db->or_where_in('keyword',$keywords);
        $query = $this->db->get();
        if($query->num_rows() > 1){
            return 1;
        }else{
            return 0;
        }

    }

    public function check_slug($slug,$table)
  	{
        $this->db->select();
        $this->db->from($table);
        $this->db->where('slug',$slug);
        $query = $this->db->get();
        if($query->num_rows() > 0){
            return 1;
        }else{
            return 0;
        }

    }
	

}

