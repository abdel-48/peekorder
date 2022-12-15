
<?php if(!auth('is_staff')): ?>
  <li class="<?= isset($page_title) && $page_title =="Subscriptions"?"active":""; ?>">
    <a href="<?= base_url('admin/auth/subscriptions') ?>">
      <i class="icofont-repair fz-20"></i> <span><?= !empty(lang('subscriptions'))?lang('subscriptions'):"Subscriptions";?></span>
    </a>
  </li>
  <li class="<?= $page_title =="Profiles"?"active":"";?>">
    <a href="<?= base_url(html_escape($this->my_info['username'])); ?>">
      <i class="fa fa-eye"></i> <span><?= !empty(lang('view_shop'))?lang('view_shop'):"View Shop";?></span>
    </a>
  </li>

<?php endif;?>

<?php if($this->auth['is_payment']==1 && $this->auth['is_expired']==0 && shop_id() > 0): ?>
    <?php if(is_access('order-control')==1): ?>

          <li class="nav-drawer-header"><?= lang('order'); ?></li>

            <li class="<?= isset($page_title) && $page_title =="Order List"?"active":""; ?>">
            <?php $today_order = $this->admin_m->get_todays_notify(restaurant()->id); ?>
              <a href="<?= base_url('admin/restaurant/order_list') ?>" class="flex_between liveOrder">
                <i class="icofont-live-support fz-20"></i> 
                <span class="flex_between">
                  <span><?= !empty(lang('live_order'))?lang('live_order'):"Live Orders";?> </span><span class="blob <?= isset($today_order) && $today_order >0?"red":"green" ;?>"></span>
                </span> 
              </a>
            </li>

            <li class="<?= isset($page) && $page =="Reservation List"?"active":""; ?>">

              <?php $todays_reservation = $this->admin_m->get_todays_reservations_notify(restaurant()->id); ?>
              <a href="<?= base_url('admin/restaurant/todays_reservation') ?>" class="flex_between liveOrder">
                <i class="icofont-delivery-time fz-20"></i>
                <span class="flex_between">
                  <span><?= !empty(lang('reservation'))?lang('reservation'):"Reservation";?> </span><span class="blob <?= isset($todays_reservation) && $todays_reservation > 0?"red":"green" ;?>"></span>
                </span> 
              </a>
            </li>

          <?php if(restaurant()->is_call_waiter==1): ?>
            <li class="<?= isset($page) && $page =="Call Waiter"?"active":""; ?> hidden">
              <a href="<?= base_url('admin/restaurant/call_waiter') ?>" class="flex_between liveOrder">
                <i class="icofont-waiter fz-20"></i>
                <span class="flex_between">
                  <span><?= lang('call_waiter');?> </span>
                </span> 
              </a>
            </li>
          <?php endif;?>

          <!-- kds -->
        <?php if(restaurant()->is_kds==1): ?>
          </li><li class="<?= isset($page) && $page =="KDS"?"active":""; ?>">
            <a href="<?= base_url('admin/kds/live/'.md5(restaurant()->id)) ?>" class="flex_between liveOrder" target="_blank">
              <i class="icofont-prestashop fz-20"></i>
              <span class="flex_between">
                <span><?= !empty(lang('kds'))?lang('kds'):"KDS";?> 
              </span> 
            </a>
          </li>
        <?php endif;?>
        <!-- kds -->

        <li class="<?= isset($page_title) && $page_title =="Statistics"?"active":""; ?>">
          <a href="<?= base_url('admin/restaurant/statistics?status=2') ?>">
            <i class="icofont-sound-wave fz-20"></i> <span><?= !empty(lang('statistics'))?lang('statistics'):"Statistics";?></span>
          </a>
        </li>

        <li class="<?= isset($page_title) && $page_title =="Payment History"?"active":""; ?>">
          <a href="<?= base_url('admin/restaurant/payment_history') ?>">
            <i class="fa fa-credit-card-alt"></i> <span><?= !empty(lang('payment_history'))?lang('payment_history'):"Payment History";?></span>
          </a>
        </li>

      <?php if(!empty(restaurant()->phone) && restaurant()->country_id !=0): ?>
        <li class="nav-drawer-header"><?= lang('menu'); ?></li>
          <li class="treeview <?= isset($page) && $page=="Menu"?"active":"";?>">
            <a href="#">
              <i class="icofont-tasks fz-20"></i>
              <span><?= !empty(lang('menu'))?lang('menu'):"menu";?></span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

                <li class="<?= $page_title =="Category"?"active":"";?>"><a href="<?= base_url('admin/menu/category') ?>"><i class="fa fa-angle-double-right"></i> <?= !empty(lang('menu_categories'))?lang('menu_categories'):"Menu Categories";?></a></li>
                
              <?php if(is_feature(auth('id'),'menu')==1): ?>
                <li class="<?= $page_title =="Items"?"active":"";?>"><a href="<?= base_url('admin/menu/item') ?>"><i class="fa fa-angle-double-right"></i> <?= !empty(lang('items'))?lang('items'):"Items";?></a></li>
              <?php endif; ?>

              <?php if(is_feature(auth('id'),'packages')==1): ?>
               <li class="<?= $page_title =="Packages"?"active":"";?>"><a href="<?= base_url('admin/menu/packages') ?>"><i class="fa fa-angle-double-right"></i> <?= !empty(lang('packages'))?lang('packages'):"Packages";?></a></li>
             <?php endif; ?>

               <?php if(is_feature(auth('id'),'specialities')==1): ?>

                 <li class="<?= $page_title =="Specialties"?"active":"";?>"><a href="<?= base_url('admin/menu/specialties') ?>"><i class="fa fa-angle-double-right"></i> <?= !empty(lang('specialties'))?lang('specialties'):"Specialties";?></a></li>
               <?php endif; ?>

              <?php if(is_feature(auth('id'),'qr-code')==1): ?>
                  <li class="<?= $page_title =="QR Builder"?"active":"";?>"><a href="<?= base_url('admin/menu/dine_in') ?>"><i class="fa fa-angle-double-right"></i> <?= !empty(lang('pacage_qr_builder'))?lang('pacage_qr_builder'):"Package QR builder";?></a></li>
              <?php endif ?>

                <li class="<?= $page_title =="Allergens"?"active":"";?>"><a href="<?= base_url('admin/menu/allergens') ?>"><i class="fa fa-angle-double-right"></i> <?= !empty(lang('allergens'))?lang('allergens'):"allergens";?></a></li>


                <li class="<?= $page_title =="Extras"?"active":"";?>"><a href="<?= base_url('admin/menu/extras') ?>"><i class="fa fa-angle-double-right"></i> <?= lang('extras');?> <span class="ab-position custom_badge danger-light-active"><?= lang('new') ;?></span></a></li>

            </ul>
          </li>
          
      <?php endif; ?><!-- !empty(restaurant()->phone) && restaurant()->country_id !=0 -->
    <?php endif; ?><!-- order-control -->


      <!-- settings -->
        <?php if(is_access('setting-control')==1): ?>
            <li class="nav-drawer-header"><?= lang('settings'); ?></li>
            <li class="<?= isset($page) && $page =="Profile"?"active":"";?>"><a href="<?= base_url('admin/restaurant/general') ?>"><i class="fa fa-user-circle"></i> <?= !empty(lang('shop_configuration'))?lang('shop_configuration'):"shop configuration";?></a></li>
           
             <!-- settings --> 
                
             <li class="<?= isset($page) && $page=="Settings"?"active":"";?>">
                  <a href="<?= base_url('admin/auth/settings') ?>">
                    <i class="fa fa-cogs"></i> <span><?= !empty(lang('settings'))?lang('settings'):"Settings";?></span>
                  </a>
              </li>
              <!-- settings -->
          
              <?php if(is_feature(auth('id'),'whatsapp')==1): ?>
                <li class="<?= isset($page_title) && $page_title =="Whatsapp Config"?"active":""; ?>">
                  <a href="<?= base_url('admin/auth/whatsapp_config') ?>">
                    <i class="fa fa-whatsapp fz-20"></i> <span><?= !empty(lang('whatsapp_config'))?lang('whatsapp_config'):"whatsapp config";?></span> 
                  </a>
                </li>
              <?php endif; ?>

              <?php if(auth('account_type') !=0 && !auth('is_staff')): ?>
                <li class="<?= isset($page_title) && $page_title =="Manage Features"?"active":""; ?>">
                  <a href="<?= base_url('admin/auth/manage_features') ?>">
                    <i class="fa fa-toggle-on"></i> <span><?= !empty(lang('manage_features'))?lang('manage_features'):"Manage Features";?></span>
                  </a>
                </li>
          <?php endif; ?>

        <?php endif; ?><!-- is access setting-control-->

        <li class="<?= isset($page_title) && $page_title =="Customer List"?"active":""; ?>">
          <a href="<?= base_url('admin/restaurant/customer_list') ?>">
           <i class="icofont-learn"></i> <?= lang('customer_list');?></span>
          </a>
        </li> 

        <li class="<?= isset($page_title) && $page_title =="Coupon List"?"active":""; ?>">
          <a href="<?= base_url('admin/coupon/') ?>">
            <i class="fa fa-gift"></i> <span><?= lang('coupon_list');?></span>
          </a>
        </li>
      <!-- settings -->

      <?php if(auth('account_type') !=0 && !auth('is_staff')): ?>

      <li class="treeview <?= isset($page) && $page=="Staff"?"active":"";?>">
        <a href="#">
          <i class="icofont-users-social fz-20"></i>
          <span><?= !empty(lang('staffs'))?lang('staffs'):"Staffs";?></span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">

          <li class="<?= isset($page_title) && $page_title =="Staff"?"active":""; ?>">
            <a href="<?= base_url('admin/restaurant/staff_list') ?>">
             <i class="fa fa-angle-double-right"></i> <?= !empty(lang('staff'))?lang('staff'):"staff";?></span>
           </a>
         </li>  
         <?php if(check()==1): ?>
          <li class="<?= isset($page_title) && $page_title =="Delivery Staff"?"active":""; ?>">
            <a href="<?= base_url('admin/restaurant/dboy_list') ?>">
              <i class="fa fa-angle-double-right"></i> <span><?= !empty(lang('delivery_staff'))?lang('delivery_staff'):"Delivery staff";?></span>
            </a>
          </li>
        <?php endif;?>

      </ul>
    </li>
  <?php endif; ?>



<?php endif; ?><!-- is_expired && is_payment -->