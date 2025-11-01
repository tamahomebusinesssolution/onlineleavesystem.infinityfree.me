<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `leave_credits` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
if($_settings->userdata('type') == 3){
	$meta_qry = $conn->query("SELECT * FROM employee_meta where meta_field = 'leave_type_ids' and user_id = '{$_settings->userdata('id')}' ");
	$leave_type_ids = $meta_qry->num_rows > 0 ? $meta_qry->fetch_array()['meta_value'] : '';
	$meta_qry = $conn->query("SELECT * FROM employee_meta where user_id = '{$_GET['id']}' ");
while($row = $meta_qry->fetch_assoc()){
    ${$row['meta_field']} = $row['meta_value'];
}
$leave_type_credits = isset($leave_type_credits) ? json_decode($leave_type_credits) : array();
$ltc = array();
foreach($leave_type_credits as $k=> $v){
    $ltc[$k] = $v;
}
$leave_type_ids = isset($leave_type_ids) ? explode(',',$leave_type_ids) : array();
}
?>

<style>
	img#cimg{
		height: 25vh;
		width: 15vw;
		object-fit: scale-down;
		object-position: center center;
	}
	.select2-container--default .select2-selection--single{
		height:calc(2.25rem + 2px) !important;
	}
</style>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> Credit Leave</h3>
	</div>
	<div class="card-body">
		<form action="" id="leave_credit-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
			<div class="row">
				<div class="col-3">
					<div class="continer-fluid">
					<?php if($_settings->userdata('type') != 3): ?>
						<div class="form-group">
							<label for="user_id" class="control-label">Employee</label>
							<select name="user_id" id="user_id" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Employee here" required>
								<option value="" disabled <?php echo !isset($user_id) ? 'selected' : '' ?>></option>
								<?php 

								$emp_qry = $conn->query("SELECT u.*,concat(u.lastname,' ',u.firstname,' ',u.middlename) as `name`,m.meta_value FROM `users` u inner join `employee_meta` m on u.id = m.user_id where m.meta_field='employee_id'");
								while($row = $emp_qry->fetch_assoc()):
									?>
									<option value="<?php echo $row['id'] ?>" <?php echo (isset($user_id) && $user_id == $row['id']) ? 'selected' : '' ?>><?php echo "[".$row['meta_value']."] ".$row['name'] ?></option>
								<?php endwhile; ?>
							</select>
						</div>
					</div>	
				</div>		
						<?php else: ?>
							<input type="hidden" name="user_id" value="<?php echo $_settings->userdata('id') ?>">
						<?php endif; ?>
				<div class="col-3">
					<div class="continer-fluid">		
						<div class="form-group">
							<label for="leave_type_id" class="control-label">Leave Type</label>
							<select name="leave_type_id" id="leave_type_id" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Leave  Type here" required>
								<option value="" disabled <?php echo !isset($leave_type_id) ? 'selected' : '' ?>></option>
								<?php 
								$where = '';
								if(isset($leave_type_ids) && !empty($leave_type_ids))
									$where = " and id in ({$leave_type_ids}) ";
								$lt = $conn->query("SELECT * FROM `leave_types` where status = 1 {$where} order by `code` asc");
								while($row = $lt->fetch_assoc()):
									?>
									<option value="<?php echo $row['id'] ?>" <?php echo (isset($leave_type_id) && $leave_type_id == $row['id']) ? 'selected' : '' ?>><?php echo $row['code'] . ' - '. $row['name'] ?>
								</option>
							<?php endwhile; ?>
							</select>
						</div>
					</div>
				</div>	
				<div class="col-3">
					<div class="continer-fluid">
						<div class="form-group">
							<label for="reason">Reason</label>
							<textarea rows="1" name="reason" id="reason" class="form-control rounded-0" style="resize:none !important" required><?php echo isset($reason) ? $reason: '' ?></textarea>
						</div>
					</div>
				</div>
				<?php 
						
						$leaveDays=(isset($credit_days)) ? $credit_days : '';
						?>
				<div class="col-3">
					<div class="continer-fluid">		
						<div class="form-group">
							<label for="credit_days" class="control-label">Days</label>
							<input type="text" id="credit_days" class="form-control form" name="credit_days" value="<?php echo (isset($ltc[$row['id']])) ? $lt[$row['id']] : $leaveDays; ?>" required>


						</div>
					</div>

				</div>

			</div>			
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-sm-end btn-primary" form="leave_credit-form">Save</button>
		<a class="btn btn-sm-end btn-danger" href="?page=leave_credits">Cancel</a>
	</div>
</div>
<script>
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

	$(document).ready(function(){
		$('.select2').select2();
		$('.select2-selection').addClass('form-control rounded-0')
		$('#type').change(function(){
			if($(this).val() == 1){
			console.log($(this).val())
				$('#credit_days').val()
				$('#date_end').attr('required',false)
				$('#date_end').val($('#date_start').val())
				$('#date_end').closest('.form-group').hide('fast')
			}else{
				$('#date_end').attr('reqiured',true)
				$('#date_end').closest('.form-group').show('fast')
				$('#credit_days').val()
			}
			calc_days()
		})
		$('#date_start, #date_end').change(function(){
			calc_days()
		})
		$('#leave_credit-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			$('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_credit",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.reload();
						// location.href = "./?page=leave_credits";
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: 0 }, "fast");
                            end_loader()
                    }else{
						alert_toast("An error occured",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})
	})
</script>
<?php if($_settings->chk_flashdata('success')): ?>
	<!-- ///////////////////////////////////////////////////////////// -->
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<?php 
$meta_qry=$conn->query("SELECT * FROM employee_meta where user_id = '{$_settings->userdata('id')}' and meta_field = 'approver' ");
$is_approver = $meta_qry->num_rows > 0 && $meta_qry->fetch_array()['meta_value'] == 'on' ? true : false;
?>
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">

			<table class="table table-hover table-stripped">
				<?php if($_settings->userdata('type') != 3): ?>
				<colgroup>
					<col width="5%">
					<col width="30%">
					<col width="35%">
					<col width="10%">
					<col width="10%">
					<col width="20%">
				</colgroup>
				<?php else: ?>
					<colgroup>
						<col width="5%">
						<col width="30%">
						<col width="35%">
						<col width="10%">
						<col width="10%">
						<col width="20%">
					</colgroup>
				<?php endif; ?>
				<thead>
					<tr>
						<th>#</th>
						<?php if($_settings->userdata('type') != 3): ?>
						<th>Employee</th>
						<?php endif; ?>
						<th>Leave Type</th>
						<th>Days</th>
						<th>Status</th>
						<th>Date Created</th> 
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
						$where = '';
						if($_settings->userdata('type') == 3)
						$where = " and u.id = '{$_settings->userdata('id')}' ";
						$qry = $conn->query("SELECT l.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as `name`,lt.code,lt.name as lname from `leave_credits` l inner join `users` u on l.user_id=u.id inner join `leave_types` lt on lt.id = l.leave_type_id where (date_format(l.date_start,'%Y') = '".date("Y")."' or date_format(l.date_end,'%Y') = '".date("Y")."') {$where} order by FIELD(l.status,0,1,2,3), unix_timestamp(l.date_created) desc ");
						while($row = $qry->fetch_assoc()):
							$lt_qry = $conn->query("SELECT meta_value FROM `employee_meta` where user_id = '{$row['user_id']}' and meta_field = 'employee_id' ");
							$row['employee_id'] = ($lt_qry->num_rows > 0) ? $lt_qry->fetch_array()['meta_value'] : "N/A";
					?>
						<tr>
							<td><?php echo $i++; ?></td>
							<?php if($_settings->userdata('type') != 3): ?>
							<th>
								<small><b>ID: </b><?php echo $row['employee_id'] ?></small><br>
								<?php echo $row['name'] ?>
							</th>
							<?php endif; ?>
							<td><?php echo $row['code'] . ' - '. $row['lname'] ?></td>
							<td><?php echo $row['credit_days'] ?></td>
							<td>
								<?php if($row['status'] == 1): ?>
									<span class="badge badge-success">Approved</span>
								<?php elseif($row['status'] == 2): ?>
									<span class="badge badge-danger">Denied</span>
								<?php elseif($row['status'] == 3): ?>
									<span class="badge badge-danger">Cancelled</span>
								<?php else: ?>
									<span class="badge badge-primary">Pending</span>
								<?php endif; ?>
							</td>
							<td><?php echo $row['date_created'] ?></td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){

		$('.table').dataTable({
			columnDefs: [
				{ orderable: false, targets: [3,4] }
			]
		});
	})
	
</script>