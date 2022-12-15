<div class="row">
	<?php include APPPATH.'views/backend/common/inc/leftsidebar.php'; ?>
	<form class="email_setting_form" action="<?= base_url('admin/restaurant/add_reservation/'.$shop_id) ?>" method="post" enctype= "multipart/form-data" autocomplete="off">
		<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" autocomplete="off">
		<div class="col-md-5">
			<div class="card">
				<div class="card-body">
					<div class="row p-15">
						<div class="table-responsive">
							<table class="table table-condensed table-striped">
								<thead>
									<tr class="text-center">
										<th width="20%"><?= !empty(lang('days'))?lang('days'):"days";?></th>
										<th width="30%"><?= !empty(lang('start_time'))?lang('start_time'):"Start Time";?></th>
										<th width="30%"><?= !empty(lang('end_time'))?lang('end_time'):"End Time";?></th>
										<th width="30%"><?= !empty(lang('open_24_hours'))?lang('open_24_hours'):"Open 24 hours";?></th>
									</tr>
								</thead>
								<tbody>
									<?php $days = get_days(); ?>
									<?php foreach ($days as $key=>$day): ?>
										<?php  $my_days = $this->admin_m->single_appoinment($key); ?>
										<tr>
											<td class="flex-td">
												<div class="form-group">
													<label class="custom-checkbox"> <input type="checkbox"  name="days[]" <?= isset($my_days['days']) && html_escape($my_days['days'])==$key?"checked":'';?>  value="<?= $key;?>">&nbsp;&nbsp; <?= $day;?> </label>
												</div>	
											</td>
											<td>
												<div class="bootstrap-timepicker">
													<div class="form-group">
														<label><?= !empty(lang('time_picker'))?lang('time_picker'):"Time picker";?>:</label>
														<div class="input-group">
															<input type="text" name="start_time[<?= $key?>]" value="<?php if(!empty($my_days['start_time'])){echo html_escape($my_days['start_time']);}?>" class="form-control timepicker">
															<div class="input-group-addon">
																<i class="fa fa-clock-o"></i>
															</div>
														</div>
														<!-- /.input group -->
													</div>
													<!-- /.form group -->
												</div>
											</td>

											<td>
												<div class="bootstrap-timepicker">
													<div class="form-group">
														<label><?= !empty(lang('time_picker'))?lang('time_picker'):"Time picker";?>:</label>
														<div class="input-group">
															<input type="text" name="end_time[<?= $key?>]" class="form-control timepicker" value="<?php if(!empty($my_days['end_time'])){echo html_escape($my_days['end_time']);}?>">
															<div class="input-group-addon">
																<i class="fa fa-clock-o"></i>
															</div>
														</div>
														<!-- /.input group -->
													</div>
													<!-- /.form group -->
												</div>
											</td>

											<td class="flex-td text-center">
												<div class="form-group text-center">
														<label class="custom-checkbox"><input type="checkbox" name="is_24[<?= $key?>]" value="1" <?= isset($my_days['is_24']) && html_escape($my_days['is_24'])==1?"checked":'';?> /><?= lang('active');?></label>
												</div>
											</td>
										</tr>
									<?php endforeach ?>
								</tbody>
							</table>
						</div>
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
				<div class="box box-primary">
					<div class="box-header with-border">
						<h3 class="box-title"><?= !empty(lang('reservation_types'))?lang('reservation_types'):"reservation types";?></h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
						</div>
					</div>
					<form action="<?= base_url('admin/restaurant/add_reservation_type/'.$shop_id) ?>" method="post" autocomplete="off">
						<div class="box-body" >
							<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
							<div class="form-group">
								<label for=""><?= lang('type_name'); ?></label>
								<input type="text" name="name" class="form-control" value="<?= !empty($data['name'])?$data['name']:"" ;?>">
							</div>

						</div><!-- /.box-body -->
						<div class="box-footer" > 
							<?php if(isset($data['id']) && $data['id'] !=0): ?>
								<div class="pull-left">
									<a href="<?= base_url('admin/restaurant/reservation/'.$shop_id) ;?>" class="btn btn-default">Cancel</a>
								</div>
							<?php endif;?>
							<div class="pull-right">
								<input type="hidden" name="id" value="<?= isset($data['id']) && !empty($data['id'])?$data['id']:0 ;?>">
								
								<button type="submit" name="register" class="btn btn-primary btn-block btn-flat"><?= !empty(lang('submit'))?lang('submit'):"submit";?></button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="col-md-12">
				<div class="box box-primary p-5">
					<div class="box-header with-border">
						<h3 class="box-title"><?= !empty(lang('reservation_type_list'))?lang('reservation_type_list'):"reservation Type List";?></h3>
						<div class="box-tools pull-right">
							<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
							<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-condensed table-striped">
							<thead>
								<tr class="text-center">
									<th><?= !empty(lang('sl'))?lang('sl'):"sl";?></th>
									<th><?= !empty(lang('name'))?lang('name'):"Name";?></th>
									<th><?= !empty(lang('status'))?lang('status'):"Status";?></th>
									<th><?= !empty(lang('action'))?lang('action'):"Action";?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($reservation_type_list as $key=> $list): ?>
									<tr>
										<td><?=  $key+1;?></td>
										<td><?= html_escape($list['name']) ;?></td>
										<td><a href="javascript:;" data-id="<?= html_escape($list['id']);?>" data-status="<?= html_escape($list['status']);?>" data-table="reservation_types" class="label <?= $list['status']==1?'label-success':'label-danger'?> change_status"> <i class="fa <?= $list['status']==1?'fa-check':'fa-close'?>"></i>&nbsp; <?= $list['status']==1? (!empty(lang('live'))?lang('live'):"Live"): (!empty(lang('hide'))?lang('hide'):"Hide");?></a></td>
										<td>
											<a href="<?= base_url('admin/restaurant/edit_reservation_types/'.$shop_id.'/'.html_escape($list['id'])); ?>" class="btn btn-info btn-sm"> <i class="fa fa-edit"></i> <?= !empty(lang('edit'))?lang('edit'):"edit";?></a>
											<a href="<?= base_url('delete-item/'.html_escape($list['id']).'/reservation_types'); ?>" class="btn btn-danger action_btn btn-sm" data-msg="<?= !empty(lang('want_to_delete'))?lang('want_to_delete'):"want to delete";?>"><i class="fa fa-trash"></i> <?= !empty(lang('delete'))?lang('delete'):"Delete";?></a>
										</td>
									</tr>
								<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>		
</div>
