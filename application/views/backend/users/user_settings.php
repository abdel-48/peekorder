<div class="row">
	<?php include APPPATH.'views/backend/users/inc/leftsidebar.php'; ?>
	<form class="email_setting_form" action="<?= base_url('admin/auth/add_email_settings') ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<?= csrf() ;?>
		<div class="col-md-5">
			<div class="card">
				<div class="card-body">
					<div class="row p-15">
						<div class="email_areas">
							<div class="email_content">
								<div class="row">
									<div class="col-md-12 ">
										<div class="form-group">
											<label class=""><?= lang('contact_email'); ?></label>
											<div class="">
												<input type="text" name="smtp_mail" placeholder="<?= lang('contact_email'); ?>" class="form-control" value="<?= !empty($settings['smtp_mail'])?html_escape($settings['smtp_mail']):'';  ?>">
												<span class="error"><?= form_error('email'); ?></span>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label><?= lang('color_picker'); ?>:</label>

											<div class="color_picker">
												<div class="input-group my-colorpicker2 colorpicker-element">
													<input type="text" class="form-control" name="colors" value="<?= $this->my_info['colors'];?>">

													<div class="input-group-addon">
														<i style="background-color: rgb(0, 0, 0);"></i>
													</div>
												</div>
												<!-- /.input group -->		
											</div>
										</div>
									</div>
									<div class="form-group col-md-12">
										<label class=""><?= !empty(lang('default_email'))?lang('default_email'):"Default Email";?></label>
										<div class="">
											<select name="email_type"  class="form-control email_option">
												<option value="1" <?= isset($settings['email_type']) && $settings['email_type']==1?'selected':''?>> <?= lang('php_mail'); ?></option>
												<option value="2" <?= isset($settings['email_type']) && $settings['email_type']==2?'selected':''?>> <?= lang('smtp'); ?></option>
												
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									<?php $smtp = json_decode(!empty($settings['smtp_config'])?$settings['smtp_config']:'',TRUE); ?>
									<div class="smtpArea " style="display:<?= isset($settings['email_type'])  &&  $settings['email_type']==2?'block':'none'?>">
										<div class="form-group col-md-6">
											<label class=""><?= lang('smtp_host'); ?></label>
											<div class="">
												<input type="text" name="smtp_host" placeholder="<?= lang('smtp_host'); ?>" class="form-control" value="<?= !empty($smtp['smtp_host'])?html_escape($smtp['smtp_host']):'';  ?>">
												<span class="error"><?= form_error('smtp_host'); ?></span>
											</div>
										</div>

										<div class="form-group col-md-6 ">
											<label class=""><?= lang('smtp_port'); ?></label>
											<div class="">
												<input type="text" name="smtp_port" placeholder="<?= lang('smtp_port'); ?>" class="form-control" value="<?= !empty($smtp['smtp_port'])?html_escape($smtp['smtp_port']):'';  ?>" autocomplete="off">
												<span class="error"><?= form_error('smtp_port'); ?></span>
											</div>
										</div>
										<div class="form-group col-md-6">
											<label><?= lang('smtp_password'); ?></label>
											<div class="">
												<input type="password" name="smtp_password" placeholder=" <?= lang('smtp_password'); ?>" class="form-control" value="<?= !empty($smtp['smtp_password'])?html_escape(base64_decode($smtp['smtp_password'])):'';  ?>" autocomplete="off">
												<span class="error"><?= form_error('smtp_password'); ?></span>
											</div>
										</div>
									</div>
								</div>	
							</div><!-- email_content -->
						</div><!-- email_area -->
					</div><!-- row -->
						
				</div><!-- card-body -->
				<div class="card-footer">
					<input type="hidden" name="id" value="<?= isset($settings['id'])?html_escape($settings['id']):0; ?>">
					<button type="submit" class="btn btn-primary btn-block"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):"Save Change";?></button>
				</div>
			</div><!-- card -->
		</div><!-- col-9 -->
	</form>
	<div class="col-md-4">
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title"> <?= !empty(lang('preloader'))?lang('preloader'):'preloader';?></h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body fix" >
						<div class="upcoming_events">
							<form action="<?= base_url('admin/auth/add_loader'); ?>" method="post"> 

								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

								<div class="row">
									<div class="preloaderList">
										<div class="col-sm-3">
											<div class="form-group">
												<label class="pointer custom-radio">
													<div class="admin_preloader">
														<div id="preloaders"><div class="preloader_1"><span></span> <span></span></div></div>
													</div>
													<input type="radio" name="preloader" value="1" <?= isset($settings['preloader']) && $settings['preloader']==1?'checked':'';?>>
												</label>
											</div>
										</div>
										<div class="col-sm-3">
											<div class="form-group">
												<label class="pointer custom-radio">
													<div class="admin_preloader">
														<div id="preloaders"><div class="preloader_2"><span></span> <span></span></div></div>

													</div>
													<input type="radio" name="preloader" value="2" <?= isset($settings['preloader']) && $settings['preloader']==2?'checked':'';?>>
												</label>
											</div>
										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label class="pointer custom-radio">
													<div class="admin_preloader">
														<div id="preloaders"><div class="preloader_3"><span></span> <span></span></div></div>

													</div>
													<input type="radio" name="preloader" value="3" <?= isset($settings['preloader']) && $settings['preloader']==3?'checked':'';?>>
												</label>
											</div>
										</div>

										<div class="col-sm-3">
											<div class="form-group">
												<label class="pointer custom-radio">
													<div class="admin_preloader">
														<div id="preloaders"><div class="preloader_4"><span></span> <span></span></div></div>

													</div>
													<input type="radio" name="preloader" value="4" <?= isset($settings['preloader']) && $settings['preloader']==4?'checked':'';?>>
												</label>
											</div>
										</div>


										<div class="col-sm-3">
											<div class="form-group">
												<label class="pointer custom-radio custom-radio text-center">
													<div class="admin_preloader">
														<div id="preloaders"> <?= lang('off'); ?> </div>
													</div>
													<input type="radio" name="preloader" value="0" <?= isset($settings['preloader']) && $settings['preloader']==0?'checked':'';?>>
												</label>
											</div>
										</div>
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10 text-right">
										<input type="hidden" name="id" value="<?= isset($settings['id'])?$settings['id']:0; ?>">
										<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):'save change';?></button>
									</div>
								</div>
							</form>
						</div>	
					</div><!-- /.box-body -->
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="box box-info">
					<div class="box-header with-border">
						<h3 class="box-title"> <?= !empty(lang('layouts'))?lang('layouts'):'layouts';?></h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
						</div>
					</div>
					<!-- /.box-header -->
					<div class="box-body" >
						<div class="upcoming_events">
							<form action="<?= base_url('admin/auth/add_themes'); ?>" method="post"> 

								<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

								<div class="row">
									<div class="">
										<?php for ($i=1; $i <=3 ; $i++) { ?>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="pointer custom-radio layoutImg">
														<div class="layouts">
															<img src="<?= base_url(IMG_PATH.'layouts/layout_'.$i.'.png') ;?>" alt="">
														</div>
														<input type="radio" name="theme" value="<?= $i; ;?>" <?= isset($u_info->theme) && $u_info->theme==$i?'checked':'';?>>
													</label>
												</div>
											</div>
										<?php  }?>
										
									</div>
								</div>
								<div class="form-group">
									<div class="col-sm-offset-2 col-sm-10 text-right">
										<input type="hidden" name="id" value="<?= isset($u_info->id)?$u_info->id:0; ?>">
										<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> &nbsp;<?= !empty(lang('save_change'))?lang('save_change'):'save change';?></button>
									</div>
								</div>
							</form>
						</div>	
					</div><!-- /.box-body -->
				</div>
			</div>
		</div>
	</div>		
</div>



