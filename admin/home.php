<style>
  #blink {
      font-size: 16px;
      font-weight: bold;
      color: #2d38be;
      transition: 0.5s;
  }
  #blink1 {
      font-size: 14px;
      font-weight: bold;
      color: #2d38be;
      transition: 0.5s;
  }
  #pendingApp {
      font-size: 16px;
      font-weight: bold;
      color: #2d38ke;
      transition: 0.5s;
  }
  #pendingAppClient {
      font-size: 20px;
      font-weight: bold;
      color: #2d38ke;
      transition: 0.5s;
  }
    #pendingLeaveCr {
      font-size: 16px;
      font-weight: bold;
      color: #2d38ke;
      transition: 0.5s;
  }
</style>
<h2><?php echo $_settings->userdata('firstname') ?>, <i>Welcome to <?php echo $_settings->info('name') ?></i></h2>
<hr class="bg-light">
<?php if($_settings->userdata('type') != 3): ?>
  <div class="row">
    <?php 
      $pending = $conn->query("SELECT * FROM `leave_applications` where date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y') = '".date('Y')."' and status = 0 ")->num_rows;
    ?>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box bg-danger">
        <span class="info-box-icon bg-danger elevation-1" ><i class="fas fa-file-alt "></i></span>

        <div class="info-box-content">
          <span class="info-box-text" >Pending Applications</span>
          <?php if ($pending > 0) { ?>
            <span class="info-box-number text-right" id="pendingApp">
          <?php }else{ ?>
            <span class="info-box-number text-right font-weight" style="font-size: 20px" >
          <?php } ?>
          
            <?php echo number_format($pending);?>
 
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3 bg-primary">
        <span class="info-box-icon bg-primary elevation-1"><i class="fa fa-building"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Departments</span>
          <span class="info-box-number text-right" style="font-size: 20px">
            <?php 
            $department = $conn->query("SELECT id FROM `department_list` ")->num_rows;
            echo number_format($department);
            ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3 bg-secondary">
        <span class="info-box-icon bg-secondary elevation-1"><i class="fa fa-sitemap"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Designations</span>
          <span class="info-box-number text-right" style="font-size: 20px">
            <?php 
            $designation = $conn->query("SELECT id FROM `designation_list`")->num_rows;
            echo number_format($designation);
            ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3 bg-purple">
        <span class="info-box-icon bg-purple elevation-1"><i class="fas fa-list"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Type of Leave</span>
          <span class="info-box-number text-right" style="font-size: 20px">
            <?php 
            $leave_types = $conn->query("SELECT id FROM `leave_types` where status = 1 ")->num_rows;
            echo number_format($leave_types);
            ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  </div>

  
  <?php else: ?>
    <div class="row">
    <?php 
      $pending = $conn->query("SELECT * FROM `leave_applications` where date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y') = '".date('Y')."' and status = 0 and user_id = '{$_settings->userdata('id')}' ")->num_rows;
    ?>
   
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box bg-danger">
          <span class="info-box-icon bg-danger elevation-1"><i class="far fa-file"></i></span>

          <div class="info-box-content">
            <span class="info-box-text" >Pending Applications</span>
            <?php if ($pending > 0) { ?>
              <span class="info-box-number text-right" id="pendingAppClient" >
            <?php }else{ ?>
              <span class="info-box-number text-right" style="font-size: 20px">
            <?php } ?>
            
              <?php 
              
              echo number_format($pending);
              ?>
              
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box bg-success">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-th-list"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Upcoming Leave</span>
            <span class="info-box-number text-right" style="font-size: 20px">
              <?php 
              $upcoming = $conn->query("SELECT * FROM `leave_applications` where date(date_start) > '".date('Y-m-d')."' and status = 1 and user_id = '{$_settings->userdata('id')}' ")->num_rows;
              echo number_format($upcoming);
              ?>
              <?php ?>
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>

      <?php

        // $used_last_yr = $conn->query("SELECT COALESCE(sum(`leave_days`),0) as total FROM `leave_applications` where `leave_type_id` = 5 and user_id = '{$_settings->userdata('id')}' and status = 1 and date_format(date_end,'%Y') = '".date("Y",strtotime("-1 year"))."' ")->fetch_array()['total'];  

        // $coc_last_yr = $conn->query("SELECT COALESCE(sum(`credit_days`),0) as total FROM `leave_credits` where user_id = '{$_settings->userdata('id')}' and status = 1 and `leave_type_id` = 5 and date_format(date_end,'%Y') = '".date("Y",strtotime("-1 year"))."' ")->fetch_array()['total'];

        $all_expired_used = $conn->query("SELECT COALESCE(sum(`leave_days`),0) as total FROM `leave_applications` where leave_type_id = 5 and user_id = '{$_settings->userdata('id')}' and status = 1 and date_format(date_start,'%Y') < '".date('Y')."' and date_format(date_end,'%Y') < '".date('Y')."' ")->fetch_array()['total'];

        $all_expired_coc = $conn->query("SELECT COALESCE(sum(`credit_days`),0) as total FROM `leave_credits` where user_id = '{$_settings->userdata('id')}' and status = 1 and date_format(date_start,'%Y') < '".date('Y')."' and date_format(date_end,'%Y') < '".date('Y')."' and leave_type_id = 5 ")->fetch_array()['total']; 

        $expired_last_yr = $all_expired_coc - $all_expired_used;

      ?>
      <?php if ($all_expired_coc > $all_expired_used) { ?>
      
      <div class="col-12 col-sm-6 col-md-3" id="blink1">
        <div class="info-box bg-warning"  >
          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-file-alt"></i></span>

          <div class="info-box-content text-danger">
            <span class="info-box-text ">Expired COC</span>
            <span class="info-box-number text-right" style="font-size: 20px">
              <?php 
              // $pendingCr = $conn->query("SELECT * FROM `leave_credits` where date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y') = '".date('Y')."' and status = 0 and user_id = '{$_settings->userdata('id')}' ")->num_rows;
              echo number_format($expired_last_yr);
              ?>
              <?php ?>
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>

    <?php }else{} ?>
      <?php 
        // $expire_coc = $conn->query("SELECT * FROM `leave_credits` where leave_type_id = 5 and date_format(date_end,'%Y') = '".date('Y')."' and status = 1 and user_id = '{$_settings->userdata('id')}' ")->num_rows;echo number_format($expire_coc);
        $current_date = date('Y-m-d');
        $expire_date = date('Y-12-31');
        $notice_date = date('Y-09-30');
        $all_expired_used = $conn->query("SELECT SUM(`leave_days`) as total FROM `leave_applications` where leave_type_id = 5 and user_id = '{$_settings->userdata('id')}' and status = 1 and date_format(date_start,'%Y') < '".date('Y')."' and date_format(date_end,'%Y') < '".date('Y')."' ")->fetch_array()['total'];

        $all_expired_coc = $conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$_settings->userdata('id')}' and status = 1 and date_format(date_start,'%Y') < '".date('Y')."' and date_format(date_end,'%Y') < '".date('Y')."' and leave_type_id = 5 ")->fetch_array()['total'];
        
        $current_coc = $conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$_settings->userdata('id')}' and status = 1 and date_format(date_end,'%Y') = '".date('Y')."' and leave_type_id = 5 ")->fetch_array()['total'];

        $current_use = $conn->query("SELECT SUM(`leave_days`) as total FROM `leave_applications` where leave_type_id = 5  and user_id = '{$_settings->userdata('id')}' and status = 1 and date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y') = '".date('Y')."' ")->fetch_array()['total'];

        $balance = $all_expired_coc - $all_expired_used;
        $total_coc = $all_expired_coc + $current_coc;
        $total_used = $all_expired_used + $current_use;
        
        $total_available = $total_coc - $total_used; 

      ?>
      <?php if($_settings->userdata('position_id') == 2): ?>
      <?php 
        if ($current_coc > $current_use && $current_date > $notice_date && $expire_date = date('Y-12-31')) { ?>
          <div class="col-12 col-sm-6 col-md-3" >
        <div class="info-box bg-primary border-0 "  >
          <span class="info-box-icon bg-primary elevation-1" id="blink"><i class="fas fa-file-alt"></i></span>

          <div class="info-box-content" >
            <span class="info-box-text"><?php echo 'COC Expire '.$expire_date ?></span>
            <span class="info-box-number text-right" style="font-size: 20px">

              <?php 
              if ($total_available > 1):
                {
                  $day = 'days';

                }else:{
                  $day = 'day';
                } 
              endif;  
              ?>
              <?php echo $total_available.' '.$day; ?>
            </span>
          </div>
          <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
      </div>
      <?php  }else{}  ?>  
      
        <?php endif; ?>
  <?php endif; ?>

<!-- start of second row -->

<hr class="bg-light">
<?php if($_settings->userdata('type') != 3): ?>
  <div class="row">
    <?php 
      $pendingCr = $conn->query("SELECT * FROM `leave_credits` where date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y') = '".date('Y')."' and status = 0 ")->num_rows;
    ?>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box bg-green">
        <span class="info-box-icon bg-green elevation-1"><i class="fas fa-credit-card"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Pending Leave Credits</span>
          <?php if ($pendingCr > 0) { ?>
            <span class="info-box-number text-right" id="pendingLeaveCr">
          <?php }else{ ?>
            <span class="info-box-number text-right" style="font-size: 20px" >
          <?php } ?>
            <?php echo number_format($pendingCr); ?>
            
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3 bg-warning">
        <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Employees</span>
          <span class="info-box-number text-right" style="font-size: 20px">
            <?php 
            $employee = $conn->query("SELECT id FROM `users` where type = 3 ")->num_rows;
            echo number_format($employee);
            ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->

    <!-- fix for small devices only -->
    <div class="clearfix hidden-md-up"></div>

    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3 bg-lightblue">
        <span class="info-box-icon bg-lightblue elevation-1"><i class="fas fa-chalkboard-teacher"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Teachers</span>
          <span class="info-box-number text-right" style="font-size: 20px">
            <?php 
            $teacher = $conn->query("SELECT id FROM `users` where position_id = 1 and type = 3")->num_rows;
            echo number_format($teacher);
            ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-6 col-md-3">
      <div class="info-box mb-3 bg-maroon">
        <span class="info-box-icon bg-maroon elevation-1"><i class="fas fa-users-cog"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Total Non-Teaching</span>
          <span class="info-box-number text-right" style="font-size: 20px">
            <?php 
            $nonteaching = $conn->query("SELECT id FROM `users` where position_id = 2 and type = 3 ")->num_rows;
            echo number_format($nonteaching);
            ?>
          </span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  </div>

      
<?php endif; ?>
<script>
  var blink = document.getElementById('blink');
  setInterval(function() {
    blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
  }, 1000);
  var blink1 = document.getElementById('blink1');
  setInterval(function() {
    blink1.style.opacity = (blink1.style.opacity == 0 ? 1 : 0);
  }, 1000);
  var pendingApp = document.getElementById('pendingApp');
  setInterval(function() {
    pendingApp.style.opacity = (pendingApp.style.opacity == 0 ? 1 : 0);
  }, 1000);
  var pendingAppClient = document.getElementById('pendingAppClient');
  setInterval(function() {
    pendingAppClient.style.opacity = (pendingAppClient.style.opacity == 0 ? 1 : 0);
  }, 1000);
  var pendingLeaveCr = document.getElementById('pendingLeaveCr');
  setInterval(function() {
    pendingLeaveCr.style.opacity = (pendingLeaveCr.style.opacity == 0 ? 1 : 0);
  }, 1000);
</script>
