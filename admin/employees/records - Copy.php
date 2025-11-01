<?php if($_settings->chk_flashdata('success')): ?>
    <script>
        alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
    </script>
<?php endif;?>
<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){
    $user = $conn->query("SELECT * FROM users where id ='{$_GET['id']}'");
    foreach($user->fetch_array() as $k =>$v){
        $$k = $v;
    }
    $name = ucwords($lastname.', '.$firstname.' '.$middlename);
    $meta_qry = $conn->query("SELECT * FROM employee_meta where user_id = '{$_GET['id']}' ");
    while($row = $meta_qry->fetch_assoc()){
        ${$row['meta_field']} = $row['meta_value'];
    }

}
$department_qry = $conn->query("SELECT id,name FROM department_list");
$dept_arr = array_column($department_qry->fetch_all(MYSQLI_ASSOC),'name','id');
$designation_qry = $conn->query("SELECT id,name FROM designation_list");
$desg_arr = array_column($designation_qry->fetch_all(MYSQLI_ASSOC),'name','id');
$position_qry = $conn->query("SELECT id,name FROM position_list");
$post_arr = array_column($position_qry->fetch_all(MYSQLI_ASSOC),'name','id');
?>
<?php 
if(isMobileDevice()):
?>
<style>
    .info-table td{
        display:block !important;
        width:100% !important;
    }
</style>
<?php endif; ?>
<div class="card">
    <div class="card-body">
        <div class="w-100 d-flex justify-content-end mb-3">
            <?php if($_settings->userdata('type') != 3): ?>
            <a href="?page=employees/manage_employee&id=<?php echo $id ?>" class="btn btn-sm btn-primary"><span class="fas fa-edit"></span>  Edit Employee</a>
            <?php endif; ?>
            <a href="javascript:void(0)" class="btn btn-sm btn-success ml-3" id="print"><span class="fas fa-print"></span>  Print</a>
        </div>
        <div id="print_out">
        <table class="table info-table">
            <tr class='boder-0'>
                <td width="20%">
                    <div class="w-100 d-flex align-items-center justify-content-center">
                        <img src="<?php echo validate_image($avatar) ?>" alt="Employee Avatar" class="img-thumbnail" id="cimg">
                    </div>
                </td>
                <td width="80%" class='boder-0 align-bottom'>
                    <div class="row">
                        <div class="col-12">
                            <div class="row justify-content-between  w-max-100 mr-0">
                                <div class="col-md-6 col-sm-12 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Employee ID:</label>
                                    <p class="col-md-auto border-bottom border-dark w-100"><?php echo $employee_id ?></p>
                                </div>
                                <div class="col-md-6 col-sm-12 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Position:</label>
                                    <p class="col-md-auto border-bottom border-dark w-100"><?php echo $post_arr[$position_id] ?></p>
                                </div>
                            </div>    
                            <div class="row justify-content-between  w-max-100 mr-0">
                                <div class="col-sm-4 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Firstname:</label>
                                    <p class="col-md-auto border-bottom border-dark w-100"><?php echo $firstname ?></p>
                                </div>
                                <div class="col-sm-4 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Middlename:</label>
                                    <p class="col-md-auto border-bottom border-dark w-100"><?php echo $middlename ?></p>
                                </div>
                                <div class="col-sm-4 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Lastname:</label>
                                    <p class="col-md-auto border-bottom border-dark w-100"><?php echo $lastname ?></p>
                                </div>
                            </div>
                            <div class="row justify-content-between  w-max-100 mr-0">
                                <div class="col-4 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">DOB: </label>
                                    <p class="col-md-auto border-bottom px-2 border-dark w-100"><?php echo date("M d, Y",strtotime($dob)) ?></p>
                                </div>
                                <div class="col-4 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Contact No.: </label>
                                    <p class="col-md-auto border-bottom px-2 border-dark w-100"><?php echo $contact ?></p>
                                </div>
                                <div class="col-4 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Basic Salary: </label>
                                    <p class="col-md-auto border-bottom px-2 border-dark w-100"><?php echo $salary ?></p>
                                </div>
                            </div>
                            <div class="row justify-content-between w-max-100 mr-0">
                                <div class="col-sm-12 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Address:</label>
                                    <p class="col-md-auto border-bottom px-2 border-dark w-100"><?php echo $address ?></p>
                                </div>
                            </div>    
                            <div class="row justify-content-between  w-max-100  mr-0">
                                <div class="col-sm-6 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Department: </label>
                                    <p class="col-md-auto border-bottom px-2 border-dark w-100"><?php echo $dept_arr[$department_id] ?></p>
                                </div>
                                <div class="col-6 d-flex w-max-100">
                                    <label class="float-left w-auto whitespace-nowrap">Designation: </label>
                                    <p class="col-md-auto border-bottom px-2 border-dark w-100"><?php echo $desg_arr[$designation_id] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <hr class="border-dark">
        <div class="row">
            
            <div class="col-md-4 col-sm-12">
                <?php if($position_id == 2): ?>
                    <div class="float-left">
                        <button class="btn btn-sm btn-default bg-warning rounded-circle text-center" type="button" id="manage_other">
                        <span class="fa fa-cog"></span></button><span><b> Update Sick/Vacation Leave Credits</b></span> 
                    </div>   
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="float-left">
                    <button class="btn btn-sm btn-default bg-red rounded-circle text-center" type="button" id="manage_coc"><span class="fa fa-cog"></span></button><span><b>  COC Records</b></span>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-md-4 col-sm-12">
                <?php if($_settings->userdata('type') == 1 || ($_settings->userdata('type') == 8)): ?>
                <div class="float-left">
                    <button class="btn btn-sm btn-blue bg-primary rounded-circle text-center" type="button" id="manage_leave"><span class="fa fa-cog"></span></button><span><b> Type of Privilege Leave granted</b></span> 
                </div>
                <?php endif; ?>
            </div>
        </div>    
        <?php if($_settings->userdata('position_id') != 1): ?>
        <hr class="border-dark">
        <?php endif; ?>
        <div class="row">
            <div class="col-md-4 col-sm-12">
                <div class="callout border-0">
                    <h5 class="mb-2">Records</h5>
                    <table class="table table-hover ">
                        <colgroup>
                            <col width="15%">
                            <col width="35%">
                            <col width="25%">
                            <col width="25%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="p-1">Type</th>
                                <th class="p-1">Allowable</th>
                                <th class="p-1">Used</th>
                                <th class="p-1">Available</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            if(isset($leave_type_ids) && !empty($leave_type_ids)):
                                $leave_type_credits = isset($leave_type_credits) ? json_decode($leave_type_credits) : array();
                            $ltc = array();
                            foreach($leave_type_credits as $k=> $v){
                                $ltc[$k] = $v;
                            }
                            $lt = $conn->query("SELECT * FROM `leave_types` where `id` in ({$leave_type_ids}) order by code asc ");
                            while($row=$lt->fetch_assoc()):
                            $used = $conn->query("SELECT SUM(`leave_days`) as total FROM `leave_applications` where user_id = '{$id}' and status = 1 and leave_type_id = '{$row['id']}' ")->fetch_array()['total'];

                            $allowed = $conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$id}' and status = 1 and leave_type_id = '{$row['id']}' ")->fetch_array()['total'];

                            $current_used = $conn->query("SELECT SUM(`leave_days`) as total FROM `leave_applications` where user_id = '{$id}' and status = 1 and date_format(date_start,'%Y') = '".date('Y')."' and date_format(date_end,'%Y') = '".date('Y')."' and leave_type_id = '{$row['id']}' ")->fetch_array()['total'];
                            $all_expired_used = $conn->query("SELECT SUM(`leave_days`) as total FROM `leave_applications` where leave_type_id = '{$row['id']}' and user_id = '{$id}' and status = 1 and date_format(date_start,'%Y') < '".date('Y')."' and date_format(date_end,'%Y') < '".date('Y')."' ")->fetch_array()['total'];                    
                            $all_expired_coc = $conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$id}' and status = 1 and date_format(date_start,'%Y') < '".date('Y')."' and date_format(date_end,'%Y') < '".date('Y')."' and leave_type_id = '{$row['id']}' ")->fetch_array()['total'];
                            $used_last_yr = $conn->query("SELECT SUM(`leave_days`) as total FROM `leave_applications` where leave_type_id = '{$row['id']}' and user_id = '{$id}' and status = 1 and date_format(date_end,'%Y') = '".date("Y",strtotime("-1 year"))."' ")->fetch_array()['total'];  

                            $coc_last_yr = $conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$id}' and status = 1 and leave_type_id = '{$row['id']}' and date_format(date_end,'%Y') = '".date("Y",strtotime("-1 year"))."' ")->fetch_array()['total'];
                            $active = $conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$id}' and status = 1 and date_format(date_end,'%Y-%m-%d') > '".date('Y-m-d')."' and leave_type_id = '{$row['id']}' ")->fetch_array()['total'];

                            $allowed_spl = (isset($ltc[$row['id']])) ? $ltc[$row['id']] : 0;
                            $available_spl =  $allowed_spl - $current_used;
                            $available_solo =  $allowed - $current_used;
                            $available =  $allowed - $used;
                        /// coc ///
                            $coc_reserve = 0;
                            if ($used_last_yr > $coc_last_yr) {
                                $active = $active - ($all_expired_used - $all_expired_coc);
                            }elseif ($all_expired_used > $all_expired_coc) {
                                $active = $active - ($all_expired_used - $all_expired_coc);
                            }
                            $current_available =  $active - $current_used;
                            if ($current_available <= 15) 
                            {
                                $current_available =  $active - $current_used;
                            }
                            elseif ($current_available > 15)  
                            {
                                $current_available = 15;
                                $coc_reserve = (floatval($active) - floatval($current_used)) - 15;
                            }
                            // sl //
                            $current_sl = floatval($sl_current);
                            $total_sl = floatval($sl_total);
                            $allowed_sl = floatval($total_sl) + floatval($current_sl);
                            $available_sl = $allowed_sl - $used;
                            // vl & mfl
                            $tl_vl_allow = floatval($vl_total) + floatval($vl_current);
                            if ($tl_vl_allow <= 10)
                            {
                                $tl_vl_allow = $vl_total + $vl_current;
                                $mfl_current = 0;
                            }
                            elseif ($tl_vl_allow > 10 and $tl_vl_allow <= 15)
                            {
                                $mfl_current = $tl_vl_allow -10;
                                $tl_vl_allow = $tl_vl_allow - $mfl_current;
                            }
                            elseif ($tl_vl_allow > 15)
                            {
                                $tl_vl_allow = $tl_vl_allow - 5;
                                $mfl_current = 5;
                            }
                                $available_vl = $tl_vl_allow - $used;
                                $available_mfl = $mfl_current - $current_used;
                        ?>
                        <tr>
                            <td class="p-1"><?php echo $row['code'] ?></td>

                            <?php if($row['id'] == 1){?>     
                               <td class="p-1"><?php echo number_format($tl_vl_allow,3) ?></td>
                               <td class="p-1"><?php echo number_format($used,3) ?></td>
                               <td class="p-1"><?php echo number_format($available_vl,3) ?></td>
                            <?php }elseif($row['id'] == 2){?>     
                               <td class="p-1"><?php echo number_format($allowed_sl,3) ?></td>
                               <td class="p-1"><?php echo number_format($used,3) ?></td>
                               <td class="p-1"><?php echo number_format($available_sl,3) ?></td>
                            <?php }elseif($row['id'] == 5 ){?> 
                            <td class="p-1"><?php echo number_format($active,3).'<i class="text-danger">('.number_format($coc_reserve,3).')</i>' ?></td>
                            <td class="p-1"><?php echo number_format($current_used,3) ?></td> 
                            <td class="p-1"><?php echo number_format($current_available,3) ?></td>

                            <?php }elseif($row['id'] == 6) {?>
                            <td class="p-1"><?php echo number_format($allowed_spl,3) ?></td>
                            <td class="p-1"><?php echo number_format($current_used,3) ?></td>
                            <td class="p-1"><?php echo number_format($available_spl,3) ?></td>

                            <?php }elseif($row['id'] == 7 ){?>  
                            <td class="p-1"><?php echo number_format($mfl_current,3) ?></td>
                            <td class="p-1"><?php echo number_format($current_used,3) ?></td>
                            <td class="p-1"><?php echo number_format($available_mfl,3) ?></td>
                        <?php }elseif($row['id'] == 10 ){?>  
                            <td class="p-1"><?php echo number_format($allowed,3) ?></td>
                            <td class="p-1"><?php echo number_format($current_used,3) ?></td>
                            <td class="p-1"><?php echo number_format($available_solo,3) ?></td>
                            <?php }else{?>
                            <td class="p-1"><?php echo number_format($allowed,3) ?></td>
                            <td class="p-1"><?php echo number_format($used,3) ?></td>
                            <td class="p-1"><?php echo number_format($available,3) ?></td>
                            <?php } ?>
                            
                            
                        </tr>
                        <?php endwhile; ?>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="callout border-0">
                    
                    <h5>Leave Credits</h5>
                    <table class="table-stripped table">
                        <colgroup>
                                <col width="15%">
                                <col width="40%">
                                <col width="10%">
                                <col width="35%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="p-1">Type</th>
                                <th class="p-1">Date</th>
                                <th class="p-1">Days</th>
                                <th class="p-1">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $la = $conn->query("SELECT l.*,lt.code, lt.name FROM `leave_credits` l inner join `leave_types` lt on l.leave_type_id = lt.id where l.status = 1 and l.user_id = '{$id}' and (date_format(l.date_start,'%Y') = '".date("Y")."' or date_format(l.date_end,'%Y') = '".date("Y")."')  order by unix_timestamp(l.date_start) asc,unix_timestamp(l.date_end) asc ");
                            while($row = $la->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="p-1"><?php echo $row['code'] ?></td>
                                <td class="p-1">
                                    <?php
                                    if($row['date_start'] == $row['date_end']){
                                        echo date("Y-m-d", strtotime($row['date_start']));
                                    }else{
                                        echo date("Y-m-d", strtotime($row['date_start'])).' - '.date("Y-m-d", strtotime($row['date_end']));
                                    }
                                    ?>
                                </td>
                                <td class="p-1"><?php echo $row['credit_days'] ?></td>
                                <td class="p-1"><small><i><?php echo $row['reason'] ?></i></small></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="callout border-0">
                    
                    <h5>Applied Leaves</h5>
                    <table class="table-stripped table">
                        <colgroup>
                                <col width="15%">
                                <col width="40%">
                                <col width="10%">
                                <col width="35%">
                        </colgroup>
                        <thead>
                            <tr>
                                <th class="p-1">Type</th>
                                <th class="p-1">Date</th>
                                <th class="p-1">Days</th>
                                <th class="p-1">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $la = $conn->query("SELECT l.*,lt.code, lt.name FROM `leave_applications` l inner join `leave_types` lt on l.leave_type_id = lt.id where l.status = 1 and l.user_id = '{$id}' and (date_format(l.date_start,'%Y') = '".date("Y")."' or date_format(l.date_end,'%Y') = '".date("Y")."')  order by unix_timestamp(l.date_start) asc,unix_timestamp(l.date_end) asc ");
                            while($row = $la->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="p-1"><?php echo $row['code'] ?></td>
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
                                <td class="p-1"><small><i><?php echo $row['reason'] ?></i></small></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>

<script>
        // Disable right-click
document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
});
    $(function(){
        $('#manage_other').click(function(){
            uni_modal('<i><?php echo $name ?>','employees/manage_other_leave_type.php?id=<?php echo $id ?>');
        })
        $('#manage_leave').click(function(){
            uni_modal('<i class="fa fa-cog"></i> Manage Leave Credits of <?php echo $name ?>','employees/manage_leave_type.php?id=<?php echo $id ?>');
        })
         $('#manage_coc').click(function(){
            uni_modal('<i class="fa fa-cog"></i> Manage COC of <?php echo $name ?>','employees/manage_coc_type.php?id=<?php echo $id ?>');
        })
        $('#print').click(function(){
            start_loader()
            var _h = $('head').clone()
            var _p = $('#print_out').clone();
            var _el = $('<div>')
            _el.append(_h)
            _el.append('<style>html, body, .wrapper {min-height: unset !important;}.btn{display:none !important}</style>')
            _p.prepend('<div class="d-flex mb-3 w-100 align-items-center justify-content-center">'+
            '<img class="mx-4" src="<?php echo validate_image($_settings->info('logo')) ?>" width="50px" height="50px"/>'+
            '<div class="px-2">'+
            '<h3 class="text-center"><?php echo $_settings->info('name') ?></h3>'+
            '<h3 class="text-center">Employee\'s Leave Information Year(<?php echo date("Y") ?>)</h3>'+
            '</div>'+
            '</div><hr/>');
            _el.append(_p)
            var nw = window.open("","_blank","width=1200,height=1200")
                nw.document.write(_el.html())
                nw.document.close()
                setTimeout(() => {
                    nw.print()
                    setTimeout(() => {
                        nw.close()
                        end_loader()
                    }, 300);
                }, 500);
        })
    })
</script>