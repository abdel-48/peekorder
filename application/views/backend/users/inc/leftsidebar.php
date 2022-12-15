<div class="col-md-3">
	<div class="card">
		<div class="card-body">
			<div class="leftSidebar">
				<ul class="flex-column">
					<li><a href="<?= base_url('admin/auth/settings'); ?>" class="<?= isset($page_title) && $page_title == "Settings"?"active":"" ;?>"><i class="icofont-at"></i> <?= !empty(lang('email_settings'))?lang('email_settings'):"Email Settings"; ?></a></li>
					<li><a href="<?= base_url('admin/auth/order_config'); ?>" class="<?= isset($page_title) && $page_title == "Order Configuration"?"active":"" ;?>"> <i class="icofont-badge"></i> <?= !empty(lang('order_config'))?lang('order_config'):"Order Configuration"; ?></a></li>

					<li><a href="<?= base_url('admin/auth/order_type_config'); ?>" class="<?= isset($page_title) && $page_title == "Order Types Configuration"?"active":"" ;?>"> <i class="icofont-badge"></i> <?= !empty(lang('order_types_config'))?lang('order_types_config'):"Order Types Configuration"; ?></a></li>

					 <?php if(is_feature(auth('id'),'online-payment')==1): ?>
						<?php if(check()==1 && $this->security->online_payment()==1): ?>
							<li><a href="<?= base_url('admin/auth/payment_config'); ?>" class="<?= isset($page_title) && $page_title == "Payment Configuration"?"active":"" ;?> <?= is_package;?>"> <i class="icofont-pay"></i> <?= !empty(lang('payment_configuration'))?lang('payment_configuration'):"Payment Configuration"; ?></a></li>

						<?php endif;?>
					<?php endif;?>
					
					<li><a href="<?= base_url('admin/auth/twillo_sms_settings') ?>" class="<?= isset($page_title) && $page_title == "Twillo SMS Settings"?"active":"" ;?>"><i class="icofont-bullhorn"></i> <?= !empty(lang('twillo_sms_settings'))?lang('twillo_sms_settings'):"Twillo SMS settings";?></a></li>


					<li><a href="<?= base_url('admin/auth/seo_settings') ?>" class="<?= isset($page_title) && $page_title == "Seo Settings"?"active":"" ;?>"><i class="icofont-search-2"></i> <?= !empty(lang('seo_settings'))?lang('seo_settings'):"Seo settings";?></a> </li>

					<li><a href="<?= base_url('admin/auth/icon_settings') ?>" class="<?= isset($page_title) && $page_title == "Icon Settings"?"active":"" ;?>"><i class="icofont-brand-icofont"></i> <?= !empty(lang('icon_settings'))?lang('icon_settings'):"Icon Settings";?></a> </li>

					
					<li><a href="<?= base_url('admin/auth/whatsapp_message') ?>" class="<?= isset($page_title) && $page_title == "Whatsapp Message"?"active":"" ;?> hidden"><i class="fa fa-whatsapp"></i> <?= lang('whatsapp_message');?></a></li>

					<li><a href="<?= base_url('admin/auth/delivery_settings') ?>" class="<?= isset($page_title) && $page_title == "Delivery Settings"?"active":"" ;?>"><i class="fa fa-truck"></i> <?= lang('delivery_settings');?></a></li>

					<?php if(check()==1): ?>
						<?php if(is_feature(auth('id'),'pwa-push')==1 && is_active(auth('id'),'pwa-push')): ?>
							<li><a href="<?= base_url('admin/auth/pwa_config') ?>" class="<?= isset($page_title) && $page_title == "PWA Config"?"active":"" ;?> d-active"><i class="icofont-share-alt"></i> <?= lang('pwa_config');?></a> </li>

							<li><a href="<?= base_url('admin/onesignal') ?>" class="<?= isset($page_title) && $page_title == "Onesignal"?"active":"" ;?>"><i class="icofont-megaphone"></i> <?= lang('onesignal_configuration');?></a> <span class="ab-position custom_badge danger-light-active"><?= lang('new') ;?></span></li>
						<?php endif; ?>
					<?php endif; ?>



					<li><a href="<?= base_url('admin/auth/extras'); ?>" class="<?= isset($page_title) && $page_title == "Extras"?"active":"" ;?>" ><i class="icofont-ui-next"></i> <?= !empty(lang('extras'))?lang('extras'):"Extras";?> </a> <span class="ab-position custom_badge danger-light-active"><?= lang('new') ;?></span></li>
					
					
				</ul>
			</div>
		</div>
	</div>
</div><!-- col-md-3 -->