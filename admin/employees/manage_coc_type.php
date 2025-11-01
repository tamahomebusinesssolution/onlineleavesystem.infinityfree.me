<?php require_once('../../config.php'); ?>

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
}
?>

<style>
    .select2-container--default .select2-selection--single{
        height:calc(2.25rem + 2px) !important;
    }
    #blink {
        font-size: 16px;
        font-weight: bold;
        color: #2d38be;
        transition: 0.5s;
    }
</style>
<div class="card card-outline card-info">
    <!-- <p><?php echo $currentDateTime = date('Y-m-d H:i:s a'); ?></p> -->
    <div class="card-header">
        <h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> 

    Compensatory Overtime Credit (COC)</h3>
</div>
<div class="card-body">
    <form action="" id="other_leave_credit">
        <input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
        <?php if($_settings->userdata('type') != 3): ?>
            <?php else: ?>
                <input type="hidden" name="user_id" value="<?php echo $_settings->userdata('id') ?>">
            <?php endif; ?>
        <div class="row">
            <!-- <div class="col-md-7 card border-dark "> -->
            <div class="col-md-7 col-sm-12">
                <h6 class="text-center" >Credited COC</h6>
                <table class="table-stripped table">
                    <colgroup>
                        <col width="50%">
                        <col width="20%">
                        <col width="30%">

                    </colgroup>
                    <thead>
                        <tr>
                            <th class="p-1">Date</th>
                            <th class="p-1">Days</th>
                            <th class="p-1">Status</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php 

                        $la = $conn->query("SELECT l.*,lt.code, lt.name FROM `leave_credits` l inner join `leave_types` lt on l.leave_type_id = lt.id where l.leave_type_id = 5 and l.status = 1 and l.user_id = '{$id}' order by unix_timestamp(l.date_created) asc");
                        while($row = $la->fetch_assoc()):
                            ?>
                        <tr>
                            <!-- <td class="p-1"><?php echo $row['code'].' - '.$row['name'] ?></td> -->

                            <td class="p-1">
                                <?php
                                if($row['date_start'] == $row['date_end']){
                                    echo date("Y-m-d", strtotime($row['date_start'])).' - '.date("Y-m-d", strtotime($row['date_end']));
                                }else{
                                    echo date("Y-m-d", strtotime($row['date_start'])).' - '.date("Y-m-d", strtotime($row['date_end']));
                                }
                                ?>
                            </td>
                            <td class="p-1"><?php echo $row['credit_days'] ?></td>
                            <!-- <td class="p-1"><?php echo $row['reason'] ?></td> -->

                            <td class="text-center">
                                <?php if($currentDateTime > $row['date_end']): ?>
                                    <span class="badge badge-danger">Expired</span>
                                    <?php else: ?>
                                        <span class="badge badge-success">Active</span>
                                    <?php endif; ?>
                            </td>
                        </tr>
                            <?php endwhile; ?>
                    </tbody>
                </table>
            </div>              
            <div class="col-md-5 col-sm-12">
            <!-- <div class="col-md-5 card border-dark"> -->
                <h6 class="text-center" >Used COC</h6>
                <table class="table-stripped table">
                    <colgroup>
                        <col width="70%">
                        <col width="30%">
                    </colgroup>
                    <thead>
                        <tr>
                            <th class="p-1">Date</th>
                            <th class="p-1">Days</th>
                        </tr>
                    </thead>
                    <tbody class="">
                        <?php 
                        $la_used = $conn->query("SELECT l.*,lt.code, lt.name FROM `leave_applications` l inner join `leave_types` lt on l.leave_type_id = lt.id where l.status = 1 and l.user_id = '{$id}' and leave_type_id = 5 order by unix_timestamp(l.date_created) asc");
                        while($row = $la_used->fetch_assoc()):
                            ?>
                        <?php if($row['reason'] == 'Expired COC') { ?>
                            <tr class="text-danger">;
                        <?php }else{ ?>
                            <tr>
                        <?php } ?>    
                        
                            <!-- <td class="p-1"><?php echo $row['code'] ?></td> -->
                            <td class="p-1">
                                <?php
                                if($row['date_start'] == $row['date_end']){
                                    echo date("Y-m-d", strtotime($row['date_start']));
                                }else{
                                    echo date("Y-m-d", strtotime($row['date_start'])).' - '.date("Y-m-d", strtotime($row['date_end']));
                                }
                                ?>
                            </td>
                            <td class="p-1"><?php echo $row['leave_days'] ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div> 
        <?php 
            $lt = $conn->query("SELECT * FROM `leave_types` where `status` = '1'  order by code asc ");

            while($row=$lt->fetch_assoc()):
                if($row['id'] == 5): 

                    $coc_2_yr = $conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$id}' and status = 1 and leave_type_id = 5 and date_format(date_start,'%Y') = '".date("Y",strtotime("-3 year"))."' or date_format(date_end,'%Y') = '".date("Y",strtotime("-1 year"))."' ")->fetch_array()['total'];

                    $used_2_yr = $conn->query("SELECT SUM(`leave_days`) as total FROM `leave_applications` where leave_type_id = 5 and user_id = '{$id}' and status = 1 and date_format(date_start,'%Y') = '".date("Y",strtotime("-2 year"))."' or date_format(date_end,'%Y') = '".date("Y",strtotime("-1 year"))."' ")->fetch_array()['total'];

                    $used_last_yr = $conn->query("SELECT SUM(`leave_days`) as total FROM `leave_applications` where leave_type_id = 5 and user_id = '{$id}' and status = 1 and date_format(date_end,'%Y') = '".date("Y",strtotime("-1 year"))."' ")->fetch_array()['total'];  

                    $coc_last_yr = $conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$id}' and status = 1 and leave_type_id = 5 and date_format(date_end,'%Y') = '".date("Y",strtotime("-1 year"))."' ")->fetch_array()['total'];

                    $all_used = $conn->query("SELECT SUM(`leave_days`) as total FROM `leave_applications` where leave_type_id = 5 and user_id = '{$id}' and status = 1  ")->fetch_array()['total'];

                    $all_coc = $conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$id}' and status = 1 and leave_type_id = 5 ")->fetch_array()['total'];

                    $all_expired_used = $conn->query("SELECT SUM(`leave_days`) as total FROM `leave_applications` where leave_type_id = 5 and user_id = '{$id}' and status = 1 and date_format(date_start,'%Y') < '".date('Y')."' and date_format(date_end,'%Y') < '".date('Y')."' ")->fetch_array()['total'];                    
                    $all_expired_coc = $conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$id}' and status = 1 and date_format(date_start,'%Y') < '".date('Y')."' and date_format(date_end,'%Y') < '".date('Y')."' and leave_type_id = 5 ")->fetch_array()['total']; 
                    $current_coc = $conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$id}' and status = 1 and date_format(date_end,'%Y') = '".date('Y')."' and leave_type_id = 5 ")->fetch_array()['total'];   
                    $active = $conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$id}' and status = 1 and date_format(date_end,'%Y-%m-%d') > '".date('Y-m-d')."' and leave_type_id = 5 ")->fetch_array()['total'];
                    $current_use = $conn->query("SELECT SUM(`leave_days`) as total FROM `leave_applications` where leave_type_id = 5  and user_id = '{$id}' and status = 1 and date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y') = '".date('Y')."' ")->fetch_array()['total'];                    
                    $coc_reserve = 0;

                    if ($used_last_yr > $coc_last_yr) {
                        $active = $active - ($all_expired_used - $all_expired_coc);

                    }elseif ($all_expired_used > $all_expired_coc) {
                        $active = $active - ($all_expired_used - $all_expired_coc);

                    }


///////////////////AVAILABLE.////////////
                    $current_available =  $active - $current_use;

                // $unexpire_coc_reserve = 0;

                    if ($current_available <= 15) 
                    {
                        $current_available =  $active - $current_use;
                    }
                    elseif ($current_available > 15)  
                    {
                        $current_available = 15;
                        $coc_reserve = (floatval($active) - floatval($current_use)) - 15;
                    }

                    ?>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="callout border-0">
                    <table class="table table-hover ">
                        <colgroup>
                            <col width="25%">
                            <col width="25%">
                            <col width="25%">
                            <col width="25%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="py-1 px-2">COC</th>
                                <th class="py-1 px-2">Used</th>
                                <th class="py-1 px-2">Available</th>
                                <th class="py-1 px-2">Reserve</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><?php echo number_format($active,3) ?></td>
                                <td><?php echo number_format($current_use,3) ?></td>
                                <td><?php echo number_format($current_available,3) ?></td>
                                <td><?php echo number_format($coc_reserve,3)?></td>
                            </tr>
                            <!-- <tr>
                                <td><?php echo number_format($coc_last_yr,3) ?></td>
                                <td><?php echo number_format($used_last_yr,3) ?></td>
                                <td><?php echo 'last year' ?></td>
                            </tr>
                            <tr>
                                <td><?php echo number_format($coc_2_yr,3) ?></td>
                                <td><?php echo number_format($used_2_yr,3) ?></td>
                                <td><?php echo 'last 2 year' ?></td>
                            </tr> 
                            <tr>
                                <td><?php echo number_format($all_expired_coc,3) ?></td>
                                <td><?php echo number_format($all_expired_used,3) ?></td>
                                <td><?php echo 'all expired' ?></td>
                            </tr>
                            <tr>
                                <td><?php echo number_format($all_coc,3) ?></td>
                                <td><?php echo number_format($all_used,3) ?></td>
                                <td><?php echo 'all' ?></td>
                            </tr> -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
                <?php
                $total_coc = $all_expired_coc + $current_coc;
                $total_used = $all_expired_used + $current_use;
                $total_available = $total_coc - $total_used;
                $current_date = date('Y');
                ?>
<!--             </div>    
                <div class="row container-fluid ">
                    <div class="col-md-6 col-sm-12">
                        <p><?php echo 'TOTAL COC as of '.$current_date.': '.$total_coc ?></p> 
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <p><?php echo 'TOTAL used as of '.$current_date.': '.$total_used ?></p> 
                    </div>
                </div>   -->
                <!-- <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <?php 
                        $no_day = 0;
                        if ($total_available > 1) {
                         $no_day = 'days';
                     }else{
                        $no_day = 'day';
                    }
                    if ($total_coc > $total_used) { ?>
                        <label class="text-danger" id="blink"><?php echo 'Your COC is about to expire. You need to file atleast '.$total_available.' '.$no_day.' before the expiration date '.$current_date = date('Y-12-31') ?></label>
                    <?php } ?> 
                </div> -->
            </div>      
    <?php endif;?>
<?php endwhile;?> 
    </form>
</div>
<div class="modal-footer">
    <!-- <button type="button" class="btn btn-float btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Confirm</button> -->
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
</div>
<script>
        // Disable right-click
document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
});
    function displayImg(input,_this) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#cimg').attr('src', e.target.result);
                _this.siblings('.custom-file-label').html(input.files[0].name)
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
<?php 
    $current_date = date('Y-m-d');
    $notice_date = date('Y-06-31');
    if ($current_date > $notice_date) {?>

<script>
     var blink = document.getElementById('blink');
     setInterval(function() {
         blink.style.opacity = (blink.style.opacity == 0 ? 1 : 0);
    }, 1500);

</script>
<?php } ?>