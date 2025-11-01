
<?php 

$date_start = isset($_GET['date_start']) ? $_GET['date_start'] : date("Y-m-d",strtotime(date('Y-m-d').' -30 days'));
$date_end = isset($_GET['date_end']) ? $_GET['date_end'] : date("Y-m-d");

$department_id = isset($_GET['department_id']) ? $_GET['department_id'] : 0;
$department_qry = $conn->query("SELECT id,name FROM department_list order by name asc");
$dept_arr = array_column($department_qry->fetch_all(MYSQLI_ASSOC),'name','id');
?>
<style>
    .select2-container--default .select2-selection--single{
        height:calc(2.25rem + 2px) !important;
    }
</style>
<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">Leave Application Report</h3>
		<!-- <div class="card-tools">
			<a href="?page=offenses/manage_record" class="btn btn-flat btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div> -->
	</div>
	<div class="card-body">
		<div class="">
        <div class="row">
            <div class="col-2">
                <div class="form-group">
                    <label for="date_start" class="control-label">Date Start</label>
                    <input type="date" class="form-control" id="date_start" value="<?php echo date("Y-m-d",strtotime($date_start)) ?>">
                </div>
            </div>
            <div class="col-2">
            <div class="form-group">
                    <label for="date_end" class="control-label">Date End</label>
                    <input type="date" class="form-control" id="date_end" value="<?php echo date("Y-m-d",strtotime($date_end)) ?>">
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="department_id" class="control-label">Department</label>
                    <select name="department_id" id="department_id" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Department here">
                        <option value="" disabled <?php echo !isset($meta['department_id']) ? 'selected' : '' ?>></option>
                        <?php foreach($dept_arr as $k=>$v): ?>
                            <option value="<?php echo $k ?>" <?php echo (isset($meta['department_id']) && $meta['department_id'] == $k) ? 'selected' : '' ?>><?php echo $v ?></option>
                        <?php endforeach; ?>
                    </select>
                    <!-- <select name="manager" id="manager" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Employee here" reqiured>
                        <option value="" disabled <?php echo !isset($manager) ? 'selected' : '' ?>></option>
                        <?php 

                        $emp_qry = $conn->query("SELECT u.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as `lfname`,m.meta_value FROM `users` u inner join `employee_meta` m on u.id = m.user_id where m.meta_field='employee_id' order by `lfname` asc");
                        while($row = $emp_qry->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['lfname'] ?>" <?php echo (isset($manager) && $manager == $row['lfname']) ? 'selected' : '' ?>><?php echo "[".$row['meta_value']."] ".$row['lfname'] ?></option>
                        <?php endwhile; ?>
                    </select> -->

                </div>
            </div>
            <div class="col-2 row align-items-end pb-1">
                <div class="w-100">
                    <div class="form-group d-flex justify-content-between align-middle">
                        <button class="btn btn-sm btn-default bg-lightblue" type="button" id="filter"><i class="fa fa-filter"></i> Search</button>
                        <button class="btn btn-sm btn-success" type="button" id="print"><i class="fa fa-print"></i> Print</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid" id="print_out">
			<table class="table table-hover table-stripped">
				<colgroup>
					<col width="5%">
					<col width="5%">
					<col width="25%">
					<col width="15%">
                    <col width="10%">
					<col width="12%">
					<col width="5%">
                    <col width="5%">
                    <col width="18%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>ID</th>
                        <th>Employee</th>
                        <th>Department</th>
						<th>Leave Type</th>
						<th>Date</th>
                        <th>Day/s</th>
						<th>Status</th>
						<th>Reason</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
                    $sql = "
                    SELECT l.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as `name`,
                    u.employee_id as emp_id,
                    d.id,d.name as dname ,
                    lt.code,lt.name as lname 
                    from `leave_applications` l 
                    inner join `users` u on l.user_id=u.id 
                    inner join `leave_types` lt on lt.id = l.leave_type_id 
                    inner join `department_list` d on d.id = u.department_id 
                    where u.department_id = '$department_id' and ((date(l.date_start) BETWEEN '$date_start'  and '$date_end') OR (date(l.date_end) BETWEEN '$date_start'  and '$date_end') ) order by unix_timestamp(l.date_start) asc,unix_timestamp(l.date_end) asc";
						$qry = $conn->query($sql);
						while($row = $qry->fetch_assoc()):
                            $lt_qry = $conn->query("SELECT meta_value FROM `employee_meta` where user_id = '{$row['user_id']}' and meta_field = 'employee_id'  ");
							$row['employee_id'] = ($lt_qry->num_rows > 0) ? $lt_qry->fetch_array()['meta_value'] : "N/A";
                            
					?>
						<tr>
							<td><?php echo $i++; ?></td>
							<td><?php echo $row['emp_id'] ?></td>
                            <td><?php echo $row['name'] ?></td>
                            <td><?php echo $row['dname'] ?></td>
							<td><?php echo $row['code'] ?></td>
                            
							<td>
                            <?php
                                if($row['date_start'] == $row['date_end']){
                                    echo date("Y-m-d", strtotime($row['date_start']));
                                }else{
                                    echo date("Y-m-d", strtotime($row['date_start'])).' - '.date("Y-m-d", strtotime($row['date_end']));
                                }
                            ?>
                            </td>
                            <td><?php echo $row['leave_days'] ?></td>
							<td>
                            <?php if($row['status'] == 1): ?>
                                <span class="badge badge-success mx-2">Approved</span>
                            <?php elseif($row['status'] == 2): ?>
                                <span class="badge badge-danger mx-2">Denied</span>
                            <?php elseif($row['status'] == 3): ?>
                                <span class="badge badge-danger mx-2">Cancelled</span>
                            <?php else: ?>
                                <span class="badge badge-primary mx-2">Pending</span>
                            <?php endif; ?>
                            </td>
							<td><small><?php echo $row['reason'] ?></small></td>
						</tr>
					<?php endwhile; ?>
					<?php if($qry->num_rows <=0 ): ?>
                        <tr>
                            <th class="text-center" colspan='6'> No Records.</th>
                        </tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
        $('#filter').click(function(){
            location.replace("./?page=reports/application_leave_report&date_start="+($('#date_start').val())+"&date_end="+($('#date_end').val())+"&department_id="+($('#department_id').val()));
        })
        $(function(){
            $('.select2').select2()
            $('.select2-selection').addClass('form-control rounded-0')
        })
        $('#print').click(function(){
            start_loader()
            var _h = $('head').clone()
            var _p = $('#print_out').clone();
            var _el = $('<div>')
            _el.append(_h)
            _el.append('<style>html, body, .wrapper {min-height: unset !important;}</style>')
            var rdate = "";
            if('<?php echo $date_start ?>' == '<?php echo $date_end ?>')
                rdate = "<?php echo date("M d, Y",strtotime($date_start)) ?>";
            else
                rdate = "<?php echo date("M d, Y",strtotime($date_start)) ?> - <?php echo date("M d, Y",strtotime($date_end)) ?>";
            _p.prepend('<div class="d-flex mb-3 w-100 align-items-center justify-content-center">'+
            '<img class="mx-4" src="<?php echo validate_image($_settings->info('logo')) ?>" width="50px" height="50px"/>'+
            '<div class="px-2">'+
            '<h3 class="text-center"><?php echo $_settings->info('name') ?></h3>'+
            '<h3 class="text-center">Leave Application Reports</h3>'+
            '<h4 class="text-center">as of</h4>'+
            '<h4 class="text-center">'+rdate+'</h4>'+
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