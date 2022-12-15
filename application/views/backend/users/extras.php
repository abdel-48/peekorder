<div class="row">
		<?php include APPPATH.'views/backend/users/inc/leftsidebar.php'; ?>
	<div class="col-md-8">
		<form action="<?= base_url("admin/auth/add_extra_config");?>" method="post">
			<?= csrf();?>
			<div class="card">
				<div class="card-header"> <h5 class="m-0 mr-5"><?= lang('extras');?> </h5></div>
				<div class="card-body">
					<div class="card-content">
						<div class="thirdparty-app">
							<h4 class="extra-title"><?= lang('third-party_chatting_app');?></h4>
							<hr>
							<?php $apps = !empty($settings['extra_config'])?json_decode($settings['extra_config']):'' ?>

							<div class="form-group">
								<label for=""><?= lang('choose_an_app');?></label>
								<select name="app" id="Third-party" class="form-control">
									<option value="1" <?= isset($apps->app) && $apps->app=='elfsight'?"selected":"";?>>Elfsight</option>
								</select>
							</div>
							<div class="form-group">
								<label><?= lang('app_id');?></label>
								<input type="text" name="app_id" class="form-control" value="<?= isset($apps->app_id)?$apps->app_id:'';?>" placeholder="<?= lang('app_id');?>">
							</div>

							<div class="form-group">
								<label class="custom-radio-2 mr-10"><input type="radio" name="elfsight_status" value="1" <?= isset($apps->elfsight_status) && $apps->elfsight_status==1?"checked":"";?> checked><?= lang('active');?></label>
								<label class="custom-radio-2"><input type="radio" name="elfsight_status" value="0" <?= isset($apps->elfsight_status) && $apps->elfsight_status==0?"checked":"";?>><?= lang('deactive');?></label>
								
							</div>
						</div>

					</div><!-- card-content -->
				</div><!-- card-body -->
				<div class="card-footer text-right"> 
					<input type="hidden" name="id" value="<?= isset($settings['id'])?$settings['id']:0;?>">
					<button type="submit" class="btn btn-secondary"><?= lang('save_change');?></button>
				</div>
			</div><!-- card -->
		</form>
	</div>
</div>