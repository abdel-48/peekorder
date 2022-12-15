<?php if(USER_ROLE==0): ?>
  <?php if(isset($page_title) && $page_title=="Dashboard"): ?>
      <?php $check = $this->admin_m->get_last_unseen_notification(restaurant()->id); ?>

      <?php if(isset($check['check']) && $check['check']==1): ?>
      <div class="custom_notification">
        <div class="alert alert-danger alert-dismissible">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            <a href="<?= base_url("admin/notify/my_notifications");?>">
              <div class="customNotify">
                <strong><i class="fa fa-bell"></i></strong>
                <div class="notifyBody">
                  <h4><?= $check['result']->title;?></h4>
                  <p><?= full_date($check['result']->send_at);?></p>
                </div>
              </div>
            </a>
        </div>
      </div>
    <?php endif; ?>
  <?php endif; ?>
<?php endif; ?>


 <?php $setting = settings(); ?>
 <?php $auth_info = get_user_info(); ?>
 <header class="main-header">
    <!-- Logo -->
    <?php if($auth_info['user_role']==1): ?>
      <a href="<?php echo base_url() ?>" class="logo shopLogo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b></b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
          <?php if(!empty($setting['logo'])): ?>
            <img src="<?= base_url($setting['logo']) ;?>" alt="">
          <?php else: ?>
          <img src="<?= base_url("assets/frontend/images/logo-example.png"); ?>" alt=""></span>
        <?php endif;?>
      </a>
    <?php else: ?>
      <a href="<?php echo base_url() ?>" class="logo shopLogo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b><?=  !empty(restaurant()->short_name)?restaurant()->short_name:"QR";?></b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">
          <?php if(!empty($setting['logo'])): ?>
            <img src="<?= base_url($setting['logo']) ;?>" alt="">
          <?php else: ?>
             <img src="<?= base_url("assets/frontend/images/logo-example.png"); ?>" alt=""></span>
          <?php endif;?>

          
      </a>
    <?php endif;?>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <?php if(USER_ROLE==0): ?>
            <?php $pages = ['Dashboard','Auth Profile','Settings'] ?>
              <?php if(isset($page_title) && in_array($page_title, $pages)==1): ?>
                  <?php $total_notify = $this->admin_m->get_last_total_unseen_notification(restaurant()->id); ?>
                    <li class="p-r">
                      <a href="<?= base_url("admin/notify/my_notifications");?>" class="fz-18"><i class="icofont-bell-alt"></i> 
                        <?php if($total_notify > 0): ?>
                          <span class="notifyBadge"><?= $total_notify;?></span>
                        <?php endif ?>
                      </a>
                      <!-- notification -->
                    </li>
                <?php endif; ?>
            <?php endif; ?>

          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
              <i class="icofont-globe"></i>
              <?= !empty(auth('site_lang'))?auth('site_lang'):$settings['language'] ;?> &nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <?php $languages = $this->common_m->select_with_status('languages'); ?>
                <?php foreach ($languages as $key => $language): ?>
                  <li>
                   <a class="dropdown-item" href="<?= base_url('home/lang_switch/'.$language['slug']) ;?>"><?= $language['lang_name'] ;?></a>
                 </li>
               <?php endforeach ?>
              </ul>
            </li>
          
          
          <?php if(!auth('is_staff')): ?>
            <li class="hidden-xs hidden-sm">
              <a><?php 
                if ($this->agent->is_browser())
                {
                  $agent = $this->agent->browser().' '.$this->agent->version();
                }
                elseif ($this->agent->is_robot())
                {
                  $agent = $this->agent->robot();
                }
                elseif ($this->agent->is_mobile())
                {
                  $agent = $this->agent->mobile();
                }
                else
                {
                  $agent = 'Unidentified User Agent';
                }

                echo "<i class='fa fa-laptop'></i> ".$agent."&nbsp; &nbsp;"; 

                echo $this->agent->platform();
                ?></a>
            </li>
          <?php endif;?>
          <?php if(auth('is_staff')==TRUE): ?>
          <li class="bg-success-soft">
            <a class="bg-success-soft"><i class="icofont-users-social fz-19"></i> &nbsp;<?= !empty(lang('staff_login'))?lang('staff_login'):"Staff Login"; ?></a>
          </li>

          <li class="">
            <a><?= staff_info()->name ;?></a>
          </li>
        <?php endif;?>

          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu hidden">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?= base_url()?>assets/frontend/images/avatar.png" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?= base_url()?>assets/frontend/images/avatar.png" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?= base_url()?>assets/frontend/images/avatar.png" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?= base_url()?>assets/frontend/images/avatar.png" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="<?= base_url()?>assets/frontend/images/avatar.png" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>

          <?php if(auth('user_role')==0): ?>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu ajax-notification">
            <?php include "ajax_notification.php"; ?>
            <!-- notification -->
          </li>
        <?php endif;?>

          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu hidden">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Make beautiful transitions
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?= base_url(!empty($auth_info['thumb'])?$auth_info['thumb']:'assets/frontend/images/avatar.png')?>" class="user-image uploaded_img" alt="User Image">
              <span class="hidden-xs"><?= isset($auth_info['name']) && !empty($auth_info['name'])?$auth_info['name']:$auth_info['username']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?= base_url(!empty($auth_info['thumb'])?$auth_info['thumb']:'assets/frontend/images/avatar.png')?>" class="img-circle uploaded_img" alt="User Image">

                <p>
                  <?= !empty($auth_info['name'])?$auth_info['name']:$auth_info['username']; ?>
                  <?php if(!empty($auth_info['designation'])){ ?>
                    <span><?= "- ".$auth_info['designation']; ?></span>
                  <?php } ?>
                  <small><?= lang('member_since'); ?> - <?= cl_format($auth_info['created_at']); ?></small>
                  
                  <!-- <small id="time"></small> -->
                </p>
              </li>
              <div class="text-center">
                <small><?= lang('last_login'); ?> - <?= cl_format($auth_info['last_login']); ?></small>
              </div>
              <!-- Menu Body -->
              
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <?php if(auth('is_staff')==TRUE): ?>
                    <a href="<?= base_url('admin/restaurant/staff_profile') ?>" class="btn btn-default btn-flat"><?= !empty(lang('profile'))?lang('profile'):"Profile";?></a>
                  <?php else: ?>
                    <a href="<?= base_url('admin/auth/') ?>" class="btn btn-default btn-flat"><?= !empty(lang('profile'))?lang('profile'):"Profile";?></a>
                  <?php endif;?>
                </div>
                <div class="pull-right">
                  <a href="<?= base_url('logout') ?>" class="btn btn-default btn-flat"><?= !empty(lang('logout'))?lang('logout'):"Logout";?></a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
    </nav>
  </header>


  <?php if(LICENSE!=MY_LICENSE): ?>
  <script>
    $(document).ready(function(){
      $(".card.stripe_fpx, .mercado, .flutterwave, .paystack, .paytm").html('')
    })
  </script>
  <?php endif ?>

