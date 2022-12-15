<div class="row">
	<?php include APPPATH."views/backend/dashboard/admin_inc/alert_info.php"; ?>
</div>
<div class="row">
	<div class="col-md-4 ">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('owner_profile'))?lang('owner_profile'):"Owner Profile";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body" >
				<div class="user_profile_view">
						<div class="image_field">
							<img src="<?= base_url(!empty($auth_info['thumb'])?$auth_info['thumb']:'assets/frontend/images/avatar.png');?>" alt="">
						</div>
						<div class="single_details_profile mt-10">
							<div class="user_contact_details">
								<h4> <i class="fa fa-user-circle"></i> <?= html_escape($auth_info['name']) ;?> - <label title="Member Since" data-toggle="tooltip" data-placement="top"><i class="fa fa-clock-o"></i> <?= html_escape(full_date($auth_info['created_at']),$auth_info['id']) ;?></label> </h4>
								
								<div class=" profile_bottom_details">
									<?php if($auth_info['country'] !=0): ?>
								    <p><b><i class="fa fa-map-marker"></i> <?= html_escape(get_country($auth_info['country'])['name']) ;?> - <?= html_escape(get_country($auth_info['country'])['currency_symbol']) ;?> - <?= !empty($auth_info['dial_code'])?$auth_info['dial_code']: get_country($auth_info['country'])['dial_code'] ;?></b> </p>
								<?php endif;?>

								<?php if(isset($auth_info['email']) && !empty($auth_info['email'])): ?>
									<p><b><i class="fa fa-envelope-o"></i> <?=  ucfirst($auth_info['email']);?></b></p>
								<?php endif;?>

								<?php if(isset($auth_info['phone']) && !empty($auth_info['phone'])): ?>
									<p><b><i class="fa fa-phone"></i><?= !empty($auth_info['dial_code'])?$auth_info['dial_code']: get_country($auth_info['country'])['dial_code'] ;?> <?=  $auth_info['phone'];?></b></p>
								<?php endif;?>

								    <p><b title="last login" data-toggle="tooltip" data-placement="top"><i class="fa fa-laptop"></i>  <?= html_escape(full_time($auth_info['last_login'])) ;?></b> </p>
								    

								    <p class="text-center verified_item"> 
								    	<span data-toggle="tooltip" data-placement="top" title=" <?= $auth_info['is_active']==1?"Active User":"User is not active" ;?>"><i class="fas fa-user-shield <?= $auth_info['is_active']==1?"c_green":"c_red" ;?>"></i></span> 

								   	<span data-toggle="tooltip" data-placement="top" title="<?= $auth_info['is_verify']==1?"Email Verified":"Email is not Verified" ;?> "><i class="fa fa-envelope <?= $auth_info['is_verify']==1?"c_green":"c_red" ;?>"></i></span> 
								     <span data-toggle="tooltip" data-placement="top" title="<?= $auth_info['is_payment']==1?"Payment Verified":"Payment is not Verified" ;?>"><i class="fa fa-credit-card <?= $auth_info['is_payment']==1?"c_green":"c_red" ;?>"></i>
								     </span>
								     <?php if($auth_info['is_expired']==1): ?>
								     	<span data-toggle="tooltip" data-placement="top" title="Account Expired"><i class="fa fa-ban c_red"></i></span>
								     <?php endif;?>
								 </p>
								</div>
							</div>
						</div>
						<?php if($auth_info['id']==auth('id')): ?>
							<div class="edit_add_info text-center">
								<a href="<?= base_url('admin/auth/edit_profile/'.md5($auth_info['id'])) ;?>" class="btn btn-success btn-flat"> <i class="fa fa-plus mr-5"></i> <?= lang('add_edit_info'); ?></a>
							</div>
						<?php endif;?>
				</div><!-- user_profile_img -->
				<?php if(USER_ROLE==1 && $auth_info['id'] != auth('id')): ?>
				<div class="user_profile_details text-center mt-20">
					<div class="form-group profile-btn-group">
						<?php if(restaurant($auth_info['id'])->is_admin_gmap==0): ?>
							<a href="<?= base_url("admin/settings/enable_extras/{$auth_info['id']}/is_admin_gmap/1"); ?>" class="btn btn-secondary" data-toggle="tooltip" title="<?= lang('allow_gmap_access'); ?>"><i class="fa fa-map-marker"></i> <?= lang('enable'); ?></a>
						<?php else: ?>
							<a href="<?= base_url("admin/settings/enable_extras/{$auth_info['id']}/is_admin_gmap/0"); ?>" class="btn btn-primary" data-toggle="tooltip"><i class="fa fa-map-marker"></i> <?= lang('disable'); ?></a>
						<?php endif;?>

						<?php if(restaurant($auth_info['id'])->is_admin_onsignal==0): ?>
							<a href="<?= base_url("admin/settings/enable_extras/{$auth_info['id']}/is_admin_onsignal/1"); ?>" class="btn btn-secondary hidden" data-toggle="tooltip" title="<?= lang('allow_onsignal_access'); ?>"><i class="icofont-hand-drag1"></i> <?= lang('enable'); ?></a>
						<?php else: ?>
							<a href="<?= base_url("admin/settings/enable_extras/{$auth_info['id']}/is_admin_onsignal/0"); ?>" class="btn btn-primary action_btn hidden" data-toggle="tooltip" title="<?= lang('disabled_onsignal_access'); ?>"><i class="icofont-hand-drag1"></i> <?= lang('disable'); ?></a>
						<?php endif;?>
						<a href="#usernameModal" data-toggle="modal" class="btn btn-info"><i class="fa fa-edit"></i> <?= lang('username'); ?></a>
						 <?php if(check()==1): ?>
							<?php $unseen_notify = $this->admin_m->get_last_unseen_notification($restaurant['id']); ?>
							<?php if(isset($unseen_notify['check']) && $unseen_notify['check']==1): ?>
								<a href="#notificationModal" class="btn btn-danger" data-toggle="modal" title="<?= lang('unseen_last_notification'); ?>"> <?= lang('unseen');?> <i class="icofont-notification"></i></a>
							<?php else: ?>
								<a href="#notificationModal" class="btn btn-secondary" data-toggle="modal" title="<?= lang('send_notification'); ?>"><i class="icofont-notification"></i></a>
							<?php endif; ?>
						<?php endif; ?>



					</div>
					<div class="text-center">
						<a href="<?= base_url('admin/dashboard/delete_user/'.$auth_info['id']) ?>" data-msg=" <?= lang('delete_user_msg'); ?>" class="btn btn-danger action_btn" data-toggle="tooltip" data-placement="top" title="Delete user" ><i class="fa fa-trash-o"></i> <?= lang('delete');?></a>
					</div>
				</div>
				<?php endif;?>
			</div><!-- /.box-body -->
		</div>
	</div>
<?php if(USER_ROLE ==0): ?>
	<div class="col-md-4 hidden">
		<div class="box box-info">
			<div class="box-header with-border">
				<h3 class="box-title"><?= !empty(lang('store_profile'))?lang('store_profile'):"Store Profile";?></h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body" >
				<?php if(!empty($restaurant)): ?>
					<div class="user_profile_view">
							<div class="image_field br-5">
								<img src="<?= base_url(!empty($auth_info['thumb'])?$auth_info['thumb']:'assets/frontend/images/avatar.png');?>" alt="">
							</div>
							<div class="single_details_profile mt-10">
								<div class="user_contact_details">
									<div class=" profile_bottom_details">
										<h4> <i class="fa fa-user-circle"></i> <?= !empty($restaurant['name'])?html_escape($restaurant['name']):html_escape($restaurant['username']) ;?> - <label title="Member Since" data-toggle="tooltip" data-placement="top"><i class="fa fa-clock-o"></i> <?= html_escape(full_date($restaurant['created_at']),$auth_info['id']) ;?></label> </h4>
										<p class="verified_item"> 
									    	<i class="icofont-id"></i> <?= !empty($restaurant['shop_id'])?$restaurant['shop_id']:'' ;?>
									 	</p>
										<?php if($restaurant['country_id'] !=0): ?>
									    <p><b><i class="fa fa-map-marker"></i> <?= html_escape(get_country($restaurant['country_id'])['name']) ;?> - <?= $restaurant['icon'] ;?> - &nbsp;<?=  $restaurant['dial_code'];?></b> </p>
									<?php endif;?>

									<?php if(isset($restaurant['email']) && !empty($restaurant['email'])): ?>
										<p><b><i class="fa fa-envelope-o"></i> <?=  $restaurant['email'];?></b></p>
									<?php endif;?>

									<?php if(isset($restaurant['phone']) && !empty($restaurant['phone'])): ?>
										<p><b><i class="fa fa-phone"></i><?= isset($restaurant['country_id']) && $restaurant['country_id'] !=0?$restaurant['dial_code']:"" ;?> <?=  $restaurant['phone'];?></b></p>
									<?php endif;?>
									</div>
								</div>
							</div>
							<?php if($auth_info['id']==auth('id')): ?>
								<div class="edit_add_info text-center">
									<a href="<?= base_url('admin/auth/edit_restaurant/'.md5($auth_info['id'])) ;?>" class="btn btn-success btn-flat"> <i class="fa fa-plus mr-5"></i> <?= lang('add_edit_info'); ?></a>
								</div>
							<?php endif;?>
					</div><!-- user_profile_img -->
				<?php else: ?>
					<a href="<?= base_url('admin/auth/edit_restaurant/'.md5(auth('id'))) ;?>">
						<div class="restaurant_profile_details">
							<i class="fa fa-plus"></i>
							<h4><?= lang('create_your_restaurant'); ?></h4>
						</div>
					</a>
				<?php endif;?>
			</div><!-- /.box-body -->
		</div>
	</div>
<?php endif;?>
<?php if($auth_info['id']==auth('id') && auth('user_role')==0): ?>
	<?php $lang =  $this->config->load('messages_config')?>
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-6">
				<?php if($this->is_empty['country']==0 && $this->is_empty['profile_pix']==0 && $this->is_empty['phone']==0): ?>
					<div class="single_alert alert alert-warning alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<div class="d_flex_alert">
							<h4><i class="icon fas fa-warning"></i> <?= lang('Warning'); ?></h4>
							<div class="double_text">
								 <h4 class="mb-5">Those Steps are most important to configure first</h4>
								<?php if($this->is_empty['phone']==0): ?>
									<p><?= $this->config->item('empty-phone');?></p>
								<?php endif;?>
								<?php  if($this->is_empty['profile_pix']==0):?>
									<p><?= $this->config->item('empty-profile');?></p>
								<?php endif;?>
								<?php if($this->is_empty['country']==0): ?>	
									<p><?= $this->config->item('empty-country-1');?> </p>
									<p><?= $this->config->item('empty-country-2');?> </p>
								<?php endif;?>

								<a href="<?= base_url('admin/restaurant/general') ;?>" class="re_url"><?= lang('click_here'); ?></a>
							</div>
						</div>
					</div>
				<?php endif;?>


				<?php if(empty(restaurant()->phone) && isset(restaurant()->country_id) && restaurant()->country_id == 0 && auth('user_role')==0): ?>
					<div class="single_alert alert alert-danger alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<div class="d_flex_alert">
							<h4><i class="icon fas fa-warning"></i> <?= lang('Warning'); ?></h4>
							<div class="">
								<h4><?= $this->config->item('restaurant_empty_msg-0');?></h4>
								<p><?= $this->config->item('restaurant_empty_msg-1');?></p>
								<p><?= $this->config->item('restaurant_empty_msg-2');?></p>
							</div>
							 <a href="<?= base_url('admin/restaurant/general') ;?>" class="re_url"><?= lang('click_here'); ?></a>
						</div>
					</div>
				<?php endif;?>
			</div>
		</div>
	</div>
	<?php endif;?>
	<?php if(auth('user_role')==1): ?>
		<?php $order_type_list = @$this->admin_m->get_active_order_types_by_shop_id($restaurant['id']); ?>
		<?php if(isset($order_type_list) && count($order_type_list) > 0): ?>
			<div class="col-md-4">
				<div class="card">
					<form action="<?= base_url("admin/auth/enable_order_types");?>" method="post">
						<?= csrf() ;?>
						<div class="card-header">
							<h3 class="card-title"><?= lang('manage_order_types');?></h3>
						</div>
						<div class="card-body">
							
							<ul class="order_type_lists">
								<?php foreach ($order_type_list as $key => $order): ?>
									<li><label class="custom-checkbox"><input type="checkbox" name="is_admin_enable[<?= $order['type_id'];?>]" <?= isset($order['is_admin_enable']) && $order['is_admin_enable']==1?"checked" :""; ;?> value="<?= $order['type_id'];?>"><?= $order['name'];?></label></li>
									<input type="hidden" name="type_ids[]" value="<?= $order['type_id'];?>">
								<?php endforeach; ?>
								
							</ul>
						</div>
						<div class="card-footer text-right">
							<input type="hidden" name="shop_id" value="<?= $restaurant['id'];?>">
							<button type="submit" class="btn btn-secondary"><?= lang('save_change');?></button>
						</div>
					</form>
				</div>
			</div>
		<?php endif; ?>
	<?php endif ?>

	<div class="modal fade" id="usernameModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><?= lang('username'); ?></h4>
				</div>
				<form action="<?= base_url("admin/auth/change_username"); ?>" method="POST">
					<?=  csrf();?>
					<div class="modal-body">
						<div class="form-group">
							<label>	<?= lang('username'); ?></label>
							<input type="text" name="username" id="username" class="form-control" value="<?=  $auth_info['username'];?>">
							<span class="alert_msg mt-5"></span>
						</div>
						<input type="hidden" name="id" value="<?=  $auth_info['id'];?>">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary reg_btn" disabled><?= lang('save_change');?></button>
					</div>
				</form>
			</div>
		</div>
	</div>



	<div class="modal fade" id="notificationModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><?= lang('send_notification'); ?></h4>
				</div>
				<form action="<?= base_url("admin/notify/send?action=admin"); ?>" method="POST">
					<?=  csrf();?>
					<div class="modal-body">
						<div class="form-group">
							<label>	<?= lang('notification_list'); ?></label>
							<select name="notification_id" id="notify_id" class="form-control">
								<option value=""><?= lang('select_notification');?></option>
								<?php foreach ($notification_list as $key => $notify): ?>
									<option value="<?= $notify['id'];?>"><?= $notify['title'];?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<input type="hidden" name="restaurant_id[]" value="<?=  $restaurant['id'];?>">
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('close');?></button>
						<button type="submit" class="btn btn-primary"><?= lang('send');?></button>
					</div>
				</form>
			</div>
		</div>
	</div>