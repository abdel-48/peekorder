<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12 pl-5">
	<div class="box box-solid ">
		<div class="box-header">
			<i class="fa fa-th"></i>

			<h3 class="box-title"><?= lang('sales_graph'); ?></h3>

			<div class="box-tools pull-right">
				<button type="button" class="btn bg-white btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
				</button>
				<button type="button" class="btn bg-white btn-sm" data-widget="remove"><i class="fa fa-times"></i>
				</button>
			</div>
		</div>
		<div class="box-body border-radius-none p-r">
			<div id="chartContainers" style="height: 370px; width: 100%;"></div>
			<span class="removeText"></span>
		</div>
		<!-- /.box-body -->
		<div class="box-footer no-border">
			<div class="row">
				<div class="col-xs-4 text-center revenue_text">
					<h4><?= $this->admin_m->user_total_income_in_year(0);?> <?= restaurant()->icon;?></h4>
					<p><?= lang('total_revenue'); ?></p>
				</div>

				<div class="col-xs-4 text-center revenue_text">
					<h4><?= $this->admin_m->user_total_income_in_year('year');?> <?= restaurant()->icon;?></h4>
					<p><?= lang('total_revenue'); ?> (<?= date('Y');?>)</p>
				</div>

				<div class="col-xs-4 text-center revenue_text">
					<h4><?= $this->admin_m->user_total_income_in_year('month');?> <?= restaurant()->icon;?></h4>
					<p><?= lang('total_revenue'); ?> (<?= date('M');?>)</p>
				</div>
				<!-- ./col -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.box-footer -->
	</div>  
	<!-- sales graph -->

</div>