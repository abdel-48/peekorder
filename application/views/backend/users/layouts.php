<div class="row">
	<div class="col-md-8">
		<div id="theme" class="tab-pane fade in active">
			<h4>Themes</h4>
			<br>
			<div class="row">
				<div class="col-sm-3">
					<label class="layout_label">
						<div class="themes_select">
							<div class="setting_img top">
								<img src="<?= base_url('assets/frontend/images/themes/theme_1.png'); ?>" alt="">
								<label class="custom_radio">
									<input type="radio" name="" class="layout_action theme <?= html_escape(check_layouts('theme',1))==1?'active':'';?> none" data-type="theme" value="1" <?=  html_escape(check_layouts('theme',1))==1?'checked':'';?>>
									<span class="checkmark"></span>
								</label>
							</div>
							<p>Full Width</p>
						</div>
					</label>
				</div>
				<div class="col-sm-3">
					<label class="layout_label">
						<div class="themes_select">
							<div class="setting_img top">
								<img src="<?= base_url('assets/frontend/images/themes/theme_2.png'); ?>" alt="">
								<label class="custom_radio">
									<input type="radio" name="" class="layout_action theme <?=  html_escape(check_layouts('theme',2))==1?'active':'';?> none" data-type="theme" value="2" <?=  html_escape(check_layouts('theme',2))==1?'checked':'';?> >
									<span class="checkmark"></span>
								</label>
							</div>
							<p>Mobile screen fit </p>
						</div>
					</label>
				</div>

				<div class="col-sm-3">
					<label class="layout_label">
						<div class="themes_select">
							<div class="setting_img top">
								<img src="<?= base_url('assets/frontend/images/themes/theme_3.png'); ?>" alt="">
								<label class="custom_radio">
									<input type="radio" name="" class="layout_action theme <?=  html_escape(check_layouts('theme',3))==1?'active':'';?> none" data-type="theme" value="3" <?=  html_escape(check_layouts('theme',3))==1?'checked':'';?> >
									<span class="checkmark"></span>
								</label>
							</div>
							<p>Full width with cover photo</p>
						</div>
					</label>
				</div>
				<div class="col-sm-3">
					<label class="layout_label">
						<div class="themes_select">
							<div class="setting_img top">
								<img src="<?= base_url('assets/frontend/images/themes/theme_4.png'); ?>" alt="">
								<label class="custom_radio">
									<input type="radio" name="" class="layout_action theme <?=  html_escape(check_layouts('theme',4))==1?'active':'';?> none" data-type="theme" value="4" <?=  html_escape(check_layouts('theme',4))==1?'checked':'';?> >
									<span class="checkmark"></span>
								</label>
							</div>
							<p>Style 4 </p>
						</div>
					</label>
				</div>
			</div>
		</div> <!-- themes -->
	</div>
	<div class="col-md-4">
					<div class="accordions">
						<div class="accordion">
						    <div class="page_accordion_header active arrow_down">Theme color scheme</div>
						    <div class="accordion_content block">
						    	<div class="theme_color">
						    		<label class="layout_label themes_color">
											<div class="themes_select bg_white">
												<div class="setting_img">
													<label class="custom_radio">
														<input type="radio" name="" class="layout_action theme_color <?=  html_escape(check_layouts('theme_color',0))==1?'active':'';?> none" data-type="theme_color" value="0" <?=  html_escape(check_layouts('theme_color',0))==1?'checked':'';?>>
														<span class="checkmark"></span>
													</label>
												</div>
												
											</div>
										</label>
							    		<label class="layout_label themes_color">
											<div class="themes_select bg_black">
												<div class="setting_img">
													<label class="custom_radio">
														<input type="radio" name="" class="layout_action theme_color <?=  html_escape(check_layouts('theme_color',1))==1?'active':'';?> none" data-type="theme_color" value="1" <?=  html_escape(check_layouts('theme_color',1))==1?'checked':'';?> >
														<span class="checkmark"></span>
													</label>
												</div>
											</div>
										</label>
						    	</div>
						    </div>
						</div><!-- accordion -->

						<div class="accordion">
						    <div class="page_accordion_header active arrow_down">Text,Banner,borders color</div>
						    <div class="accordion_content block">
						    	<div class="theme_color btn_style color">
						    		<label class="layout_label">
											<div class="themes_select bg_white">
												<div class="setting_img bg_c1">
													<label class="custom_radio">
														<input type="radio" name="" class="layout_action colors <?=  html_escape(check_layouts('colors','49bcf7'))==1?'active':'';?> none" data-type="colors" value="49bcf7" <?=  html_escape(check_layouts('colors','49bcf7'))==1?'checked':'';?>>
														<span class="checkmark"></span>
													</label>
												</div>
												
											</div>
										</label>
							    		<label class="layout_label">
											<div class="themes_select bg_black">
												<div class="setting_img bg_c2" >
													<label class="custom_radio">
														<input type="radio" name="" class="layout_action colors <?=  html_escape(check_layouts('colors','29c7ac'))==1?'active':'';?> none" data-type="colors" value="29c7ac" <?=  html_escape(check_layouts('colors','29c7ac'))==1?'checked':'';?> >
														<span class="checkmark"></span>
													</label>
												</div>
											</div>
										</label>
							    		
										<label class="layout_label">
											<div class="themes_select bg_gradient_1">
												<div class="setting_img bg_c3">
													<label class="custom_radio">
														<input type="radio" name="" class="layout_action colors <?=  html_escape(check_layouts('colors','037fff'))==1?'active':'';?> none" data-type="colors" value="037fff" <?=  html_escape(check_layouts('colors','037fff'))==1?'checked':'';?> >
														<span class="checkmark"></span>
													</label>
												</div>
												
											</div>
										</label>


										<label class="layout_label">
											<div class="themes_select bg_gradient_1">
												<div class="setting_img bg_c4">
													<label class="custom_radio">
														<input type="radio" name="" class="layout_action colors <?=  html_escape(check_layouts('colors','00818a'))==1?'active':'';?> none" data-type="colors" value="00818a" <?=  html_escape(check_layouts('colors','00818a'))==1?'checked':'';?>>
														<span class="checkmark"></span>
													</label>
												</div>
												
											</div>
										</label>
										<label class="layout_label">
											<div class="themes_select bg_gradient_1">
												<div class="setting_img bg_c5">
													<label class="custom_radio">
														<input type="radio" name="" class="layout_action colors <?=  html_escape(check_layouts('colors','e14594'))==1?'active':'';?> none" data-type="colors" value="e14594" <?=  html_escape(check_layouts('colors','e14594'))==1?'checked':'';?> >
														<span class="checkmark"></span>
													</label>
												</div>
												
											</div>
										</label>
										<label class="layout_label">
											<div class="themes_select bg_gradient_1">
												<div class="setting_img bg_c6">
													<label class="custom_radio">
														<input type="radio" name="" class="layout_action colors <?=  html_escape(check_layouts('colors','ea0599'))==1?'active':'';?> none" data-type="colors" value="ea0599" <?=  html_escape(check_layouts('colors','ea0599'))==1?'checked':'';?>>
														<span class="checkmark"></span>
													</label>
												</div>
												
											</div>
										</label>

									<form action="<?php echo base_url('admin/profile/add_color'); ?>" method="post">
										<input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
										<div class="form-group">
											<label>Color picker:</label>

											<div class="color_picker">
												<div class="input-group my-colorpicker2 colorpicker-element">
									                  <input type="text" class="form-control" name="colors" value="<?= $this->my_info['colors'];?>">

									                  <div class="input-group-addon">
									                    <i style="background-color: rgb(0, 0, 0);"></i>
									                  </div>
									            </div>
													<!-- /.input group -->
													<button type="submit" class="btn btn-default btn-flat mt-10">Submit</button>
											</div>
										</div>
									</form>
									
						    	</div>
						    </div>
						</div><!-- accordion -->
					</div><!-- accordions -->
				</div>
</div>