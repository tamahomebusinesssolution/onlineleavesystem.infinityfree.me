
<!-- ////////////////////////////////////////// -->
<?php if($_settings->chk_flashdata('success')): ?>
<script>
  alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php 
$meta_qry=$conn->query("SELECT * FROM employee_meta where user_id = '{$_settings->userdata('id')}' and meta_field = 'approver' ");
$is_approver = $meta_qry->num_rows > 0 && $meta_qry->fetch_array()['meta_value'] == 'on' ? true : false;
?>
<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `users` where id = '{$_GET['id']}' ");    
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
if($_settings->userdata('type') == 3){
    $meta_qry = $conn->query("SELECT * FROM employee_meta where meta_field = 'leave_type_ids' and user_id = '{$_settings->userdata('id')}' ");
    $leave_type_ids = $meta_qry->num_rows > 0 ? $meta_qry->fetch_array()['meta_value'] : '';

?>
<?php 
$lt = $conn->query("SELECT * FROM `leave_types` where `status` = '1'  order by code asc ");

while($row=$lt->fetch_assoc()):
  if($row['id'] == 5): 

    // $opong = " and id = '{$_settings->userdata('id')}' ";
    
    // $opong = " and id = '{$_settings->userdata('id')}' ";
    
    $all_expired_used = $conn->query("SELECT SUM(`leave_days`) as total FROM `leave_applications` where leave_type_id = 5 and user_id = '{$_settings->userdata('id')}' and status = 1 and date_format(date_start,'%Y') < '".date('Y')."' and date_format(date_end,'%Y') < '".date('Y')."' ")->fetch_array()['total'];                    
    $all_expired_coc = $conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$_settings->userdata('id')}' and status = 1 and date_format(date_start,'%Y') < '".date('Y')."' and date_format(date_end,'%Y') < '".date('Y')."' and leave_type_id = 5 ")->fetch_array()['total'];

    $balance = $all_expired_coc - $all_expired_used;
   // echo $balance;

    ?>   
       
    <div class="card card-outline card-primary">
      <?php if($_settings->userdata('type') != 4): ?>
        <div class="card-header">

          <h3 class="card-title">List of Expired COC</h3>
          <!-- <?php if($_settings->userdata('type') != 5): ?>
          <div class="card-tools">
            <a href="?page=leave_credits/manage_credit" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>

          </div>
          <?php endif; ?> -->   
        </div>
        <?php endif; ?>
        <div class="card-body">
          <div class="container-fluid">
            <div class="container-fluid">
              <table class="table table-hover table-stripped">
                <?php if($_settings->userdata('type') != 3): ?>
                  <colgroup>
                    <col width="5%">
                    <col width="25%">
                    <col width="25%">
                    <col width="20%">
                    <col width="20%">
                    <col width="5%">

                  </colgroup>
                  <?php else: ?>
                    <colgroup>
                      <col width="5%">
                      <col width="25%">
                      <col width="20%">
                      <col width="20%">
                      <col width="20%">
                      <col width="10%">
                    </colgroup>
                  <?php endif; ?>
                  <thead>
                    <tr>
                      <th>#</th>
                      <?php if($_settings->userdata('type') != 3): ?>
                        <th>Employee</th>
                      <?php endif; ?>
                      <th>Leave Type</th>
                      <th>Expiry Date</th>
                      <th>Days Expired</th>
                      <th>Status</th>
                      <?php if($_settings->userdata('type') == 3): ?>
                        <th>Action</th>
                      <?php endif; ?>
                    </tr>
                  </thead>
                  <tbody>

                    <?php





                    $i = 1;
                    $where = '';
                    if($_settings->userdata('type') == 3)
                      $where = " and u.id = '{$_settings->userdata('id')}' ";
                    $total_expired_coc = $conn->query("
                      SELECT l.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as `name`,lt.code,lt.name as lname 
                      from `leave_credits` l 
                      inner join `users` u on l.user_id=u.id 
                      inner join `leave_types` lt on lt.id = l.leave_type_id 
                      where leave_type_id = 5 and (date_format(l.date_start,'%Y') < '".date("Y")."' && date_format(l.date_end,'%Y') < '".date("Y")."') {$where} order by FIELD(l.status,0,1,2,3), unix_timestamp(l.date_created) desc ");
                    while($row = $total_expired_coc->fetch_assoc()):

                      $creditDays = $row['credit_days']; 

                      ?>
                      <?php if ($all_expired_coc > $all_expired_used){ ?>
                        <tr>
                          <td class="text-center"><?php echo $i++; ?></td>
                          <?php if($_settings->userdata('type') != 3): ?>
                            <td><?php echo $row['name'] ?></td>
                          <?php endif; ?>
                          <td><?php echo $row['code'] . ' - '. $row['lname'] ?></td>
                          <td><?php echo isset($date_end) ? date("Y-m-d",strtotime($date_end)) : $row['date_end']  ?></td>
                          <!-- <td><?php echo $row['credit_days'] ?></td> -->


                          <?php 

                          $where = '';
                          if($_settings->userdata('type') == 3)
                            $where = " and u.id = '{$_settings->userdata('id')}' ";
                          $all_expired_used = $conn->query("SELECT l.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as `name`,lt.code,lt.name as lname from `leave_applications` l inner join `users` u on l.user_id=u.id inner join `leave_types` lt on lt.id = l.leave_type_id where leave_type_id = 5 and (date_format(l.date_start,'%Y') < '".date("Y")."' && date_format(l.date_end,'%Y') < '".date("Y")."') {$where} order by FIELD(l.status,0,1,2,3), unix_timestamp(l.date_created) desc ");
                          while($row = $all_expired_used->fetch_assoc()):
                            // $leaveDays = $row['leave_days'];

                            // $x_status = $row['status1'];

                            // if ($x_status == 0) {
                            //   $x_status == 'Expired';
                            // }elseif ($x_status = 1) {
                            //   $x_status == 'Confirmed';
                            // }
                            
                            ?>  
                          <?php endwhile; ?>
                          <!-- <?php 
                          $net = $creditDays - $leaveDays;
                          ?> -->
                          <td><?php echo $balance ?></td>
                          <td>
                            <!-- <?php echo $leaveDays?> -->
                            <!-- <p><?php echo 'Leave Days: '.$leaveDays?></p>
                              <p><?php echo 'credit Days: '.$creditDays?></p> -->

                              <?php if($balance > 0): ?>
                                <span class="badge badge-danger"> Expired </span>
                                <?php else: ?>
                                  <span class="badge badge-success">Confirmed</span>
                                <?php endif; ?>
                          </td>
                          <td>
                            <?php if($_settings->userdata('type') != 5): ?>
                            <?php if($_settings->userdata('type') == 3): ?>
                              <button a class="btn btn-sm btn-success edit_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"> Confirm</a></button>
                            <?php endif; ?>
                            <?php endif; ?>
                          </td>
                        </tr>
                      
                        <div class="row text-center">
                          <h3 class="text-center text-lightblue">Expired COC</h3>
                        </div>
                      <?php } ?>  
                          <!-- ////////////////////////////////// -->

                      <?php endwhile; ?> 
                    <?php endif; ?>
                  <?php endwhile; ?>
                </tbody>
              </table>


            </div>
          </div>
        </div>
      </div>
      <?php }else{ ?>
  <?php include '404.html'; ?>
<?php } ?>
<script>
    // Disable right-click
document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
});
  $(document).ready(function(){
    $('.edit_data').click(function(){
      uni_modal("",'expired_coc/manage_expired_coc1.php?id='+$(this).attr('data-id'))
    })
    $('#create_new').click(function(){
      uni_modal("<i class='fa fa-plus'></i> Create New Department",'expired_coc/manage_expired_coc.php')
    })
    $('.table').dataTable({
      columnDefs: [
        { orderable: false, targets: [3,4] }
      ]
    });
  })
  
</script>