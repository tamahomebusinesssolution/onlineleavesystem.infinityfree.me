<style>
  body 
  {
    cursor: url('https://ionicframework.com/img/finger.png'), auto;    
  }
</style>

<!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary text-white bg-lightblue disabled elevation-4 sidebar-no-expand">
        <!-- Brand Logo -->
        <a href="<?php echo base_url ?>admin" class="brand-link bg-lightblue text-sm">
        <img src="<?php echo validate_image($_settings->info('logo'))?>" alt="Store Logo" class="brand-image img-circle elevation-3" style="opacity: .8;width: 1.7rem;height: 1.7rem;max-height: unset">
        <span class="brand-text font-weight-light"><?php echo $_settings->info('short_name') ?></span>
        </a>
        <!-- Sidebar -->
        <div class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">
          <div class="os-resize-observer-host observed">
            <div class="os-resize-observer" style="left: 0px; right: auto;"></div>
          </div>
          <div class="os-size-auto-observer observed" style="height: calc(100% + 1px); float: left;">
            <div class="os-resize-observer"></div>
          </div>
          <div class="os-content-glue" style="margin: 0px -8px; width: 249px; height: 646px;"></div>
          <div class="os-padding">
            <div class="os-viewport os-viewport-native-scrollbars-invisible" style="overflow-y: scroll;">
              <div class="os-content" style="padding: 0px 8px; height: 100%; width: 100%;">
                <!-- Sidebar user panel (optional) -->
                <div class="clearfix"></div>
                <!-- Sidebar Menu -->
                <nav class="mt-4">
                   <ul class="nav nav-pills nav-sidebar flex-column text-sm nav-compact nav-flat nav-child-indent nav-collapse-hide-child" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item dropdown">
                      <a href="./" class="nav-link nav-home">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                          Dashboard
                        </p>
                      </a>
                    </li> 
                    <?php if($_settings->userdata('type') == 3): ?>

                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=employees/records&id=<?php echo $_settings->userdata('id') ?>" class="nav-link nav-records">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>
                          My Records
                        </p>
                      </a>
                    </li>
                    <?php if($_settings->userdata('position_id') == 2): ?>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=expired_coc" class="nav-link nav-expired_coc">
                        <i class="nav-icon fa fa-times-circle"></i>
                        <p>
                          Expired COC List
                        </p>
                      </a>
                    </li>
                    <?php endif; ?>
                    <?php else: ?>
                      <!-- Creator -->
                    <?php if($_settings->userdata('type') != 4): ?> 
                      <!-- Approver -->
                    <?php if($_settings->userdata('type') != 2): ?> 
                    <?php if($_settings->userdata('type') != 5): ?>   

                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=employees" class="nav-link nav-employees">
                        <i class="nav-icon fas fa-user-friends"></i>
                        <p>
                          Employees List
                        </p>
                      </a>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if($_settings->userdata('type') != 4): ?> 
                      <?php if($_settings->userdata('type') != 5): ?> 
                    <?php if($_settings->userdata('type') != 8): ?>     
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=leave_applications" class="nav-link nav-leave_applications">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>
                          Application List
                        </p>
                      </a>
                    </li>
                    
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php if($_settings->userdata('type') != 3): ?>
                      <!-- Creator -->
                    <?php if($_settings->userdata('type') == 4 || ($_settings->userdata('type') == 1) || ($_settings->userdata('type') == 5)): ?>

                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=leave_credits" class="nav-link nav-leave_credits">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p>
                          Leave Credit List
                        </p>
                      </a>
                    </li>
                    <?php endif; ?>

                    <?php if($_settings->userdata('type') == 1): ?>

                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=maintenance/department" class="nav-link nav-maintenance_department">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                          Department List
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=maintenance/designation" class="nav-link nav-maintenance_designation">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                          Designation List
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=maintenance/position" class="nav-link nav-maintenance_position">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                          Position List
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=maintenance/leave_type" class="nav-link nav-maintenance_leave_type">
                        <i class="nav-icon fas fa-list"></i>
                        <p>
                          Leave Type List
                        </p>
                      </a>
                    </li>
                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=user/list" class="nav-link nav-user_list">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                          User List
                        </p>
                      </a>
                    </li>

                    <li class="nav-item dropdown">
                      <a href="<?php echo base_url ?>admin/?page=system_info" class="nav-link nav-system_info">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                          Settings
                        </p>
                      </a>
                    </li>
                    
                    <li class="nav-item dropdown">
                     <label class="ml-3" > REPORT</label>
                    </li>

                    <ul class="ml-2" >
                      <li class="nav-item dropdown">
                        <a href="<?php echo base_url ?>admin/?page=reports" class="nav-link nav-reports">
                          <p>Leave Application Report</p>
                        </a>
                      </li>
                    </ul>

                    <ul class="ml-2" >
                      <li class="nav-item dropdown">
                        <a href="<?php echo base_url ?>admin/?page=reports/credit_leave_report" class="nav-link nav-reports_credit_leave_report" >
                          <p>Credit Leave Report</p>
                        </a>
                      </li>
                    </ul>
                    <ul class="ml-2" >
                      <li class="nav-item dropdown">
                        <a href="<?php echo base_url ?>admin/?page=reports/employee_list" class="nav-link nav-reports_employee_list">
                          <p>List of Employee</p>
                        </a>
                      </li>
                    </ul>
                    <ul class="ml-2" >
                      <li class="nav-item dropdown">
                        <a href="<?php echo base_url ?>admin/?page=reports/employee_department" class="nav-link nav-reports_employee_department">
                          <p>Employee per Department</p>
                        </a>
                      </li>
                    </ul>
                    <ul class="ml-2" >
                      <li class="nav-item dropdown">
                        <a href="<?php echo base_url ?>admin/?page=reports/employee_designation" class="nav-link nav-reports_employee_designation">
                          <p>Employee per Designation</p>
                        </a>
                      </li>
                    </ul>
          

                    
                    <?php endif; ?>
                    <?php endif; ?>
                    
                  </ul>
                </nav>
                <!-- /.sidebar-menu -->
              </div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-horizontal os-scrollbar-unusable os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="width: 100%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar os-scrollbar-vertical os-scrollbar-auto-hidden">
            <div class="os-scrollbar-track">
              <div class="os-scrollbar-handle" style="height: 55.017%; transform: translate(0px, 0px);"></div>
            </div>
          </div>
          <div class="os-scrollbar-corner"></div>
        </div>
        <!-- /.sidebar -->
      </aside>
      <script>
          // Disable right-click
document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
});  
    $(document).ready(function(){
      var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
      var s = '<?php echo isset($_GET['s']) ? $_GET['s'] : '' ?>';
      page = page.split('/');
      page = page.join('_');

      if($('.nav-link.nav-'+page).length > 0){
             $('.nav-link.nav-'+page).addClass('active')
        if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
          $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
        }
        if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
          $('.nav-link.nav-'+page).parent().addClass('menu-open')
        }

      }
     
    })
  </script>