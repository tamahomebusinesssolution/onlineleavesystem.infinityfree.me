<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `leave_credits` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}

	$meta_qry = $conn->query("SELECT * FROM employee_meta where meta_field = 'leave_type_ids' and user_id = '{$_settings->userdata('id')}' ");
	$leave_type_ids = $meta_qry->num_rows > 0 ? $meta_qry->fetch_array()['meta_value'] : '';

?>

<style>
	.hide {
  		display: none;
	}
	img#cimg{
		height: 25vh;
		width: 15vw;
		object-fit: scale-down;
		object-position: center center;
	}
/*	.select2-container--default .select2-selection--single{
		height:calc(2.25rem + 2px) !important;
	}*/
</style>
<?php if($_settings->userdata('type') == 4 || $_settings->userdata('type') == 1){  ?>
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> Credit Leave</h3>
	</div>
	<div class="card-body">
		<form action="" id="leave_credit-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
			<div class="row">
				<div class="col-3">
					<?php if($_settings->userdata('type') != 3): ?>
					<div class="form-group">
						<label for="user_id" class="control-label">Employee</label>
						<select name="user_id" id="user_id" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Employee here" reqiured>
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

				
				<div class="col-3">	
					<?php else: ?>
					<input type="hidden" name="user_id" value="<?php echo $_settings->userdata('id') ?>">
					<?php endif; ?>
					<div class="form-group">
						<label for="leave_type_id" class="control-label">Leave Type</label>
						<select name="leave_type_id" id="leave_type_id" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Leave  Type here" reqiured>
							<option value="" disabled <?php echo !isset($leave_type_id) ? 'selected' : '' ?>></option>
							<?php 
							$where = '';
							if(isset($leave_type_ids) && !empty($leave_type_ids))
							$where = " and id in ({$leave_type_ids}) ";
							$lt = $conn->query("SELECT * FROM `leave_types` where status = 1 {$where} order by `code` asc");
							while($row = $lt->fetch_assoc()):
							?>
								<option  value="<?php echo $row['id'] ?>" <?php echo (isset($leave_type_id) && $leave_type_id == $row['id']) ? 'selected' : '' ?>><?php echo $row['code'] . ' - '. $row['name'] ?>
								</option>
							<?php endwhile; ?>
						</select>
					</div>
				</div>	
<!-- 					<div class="form-group">
						<label for="type" class="control-label">Day Type</label>
						<select id="type" name="type" class="form-control rounded-0">
							<option value="1" <?php echo (isset($type) && $type ==1)?'selected' : '' ?>>Whole Day</option>
							<option value="2" <?php echo (isset($type) && $type ==2)?'selected' : '' ?>>Half Day</option>
						</select>
					</div> -->
 					<!-- <div class="form-group">
						<label for="date_start" class="control-label">Date of File</label>
						<input type="date" id="date_created" class="form-control form" required name="date_created" value="<?php echo isset($date_created) ? date("Y-m-d",strtotime($date_created)) : '' ?>">
					</div> -->
 <!-- 					<?php 

 						 if(isset($date_start) ? date("Y-01-01",strtotime($date_start)) : 'date_start'); 
 						// $date_start = 'date_start';
 						if ($row['id'] == 5) {
 							$date_start = date('Y-01-01');
 						}
 					?> -->
<!-- 					<div class="form-group">
						<label for="date_start" class="control-label">Date Start</label>

						<input type="date" id="date_start" class="form-control form"  name="date_start" value="<?php echo isset($date_start) ? date("Y-m-d",strtotime($date_start)) : '' ?>">
					</div> -->
					<div class="col-2">
					<div id="nameFoo" class="form-group">
						<label for="date_end" class="control-label">Date Expire</label>
						<input type="date" id="date_end" class="form-control form"  name="date_end" value="<?php echo isset($date_end) ? date("Y-m-d",strtotime($date_end)) : '' ?>">
					</div>
					</div>


				<div class="col-3">
					<div class="continer-fluid">
				    	<div class="form-group">
							<label for="reason">Reason</label>
							<textarea rows="1" name="reason" id="reason" class="form-control rounded-0" placeholder="Put the reason here" style="resize:none !important" required><?php echo isset($reason) ? $reason: '' ?></textarea>
						</div>
					</div>
				</div>		
						<?php 
						
						$leaveDays=(isset($credit_days)) ? $credit_days : 0;
						?>
				<div class="col-1">
					<div class="continer-fluid">		
						<div class="form-group">
							<label for="credit_days" class="control-label">Days</label>
							<input type="text" id="credit_days" class="form-control form" name="credit_days" value="<?php echo number_format($leaveDays,3) ?>" >
						</div>
					</div>
				</div>
			</div>			
		</form>
		<div class="card-footer">
			<button class="btn btn-sm btn-primary" form="leave_credit-form">Save</button>
			<a class="btn btn-sm btn-danger" href="?page=leave_credits">Cancel</a>
		</div>	
	</div>

</div>
<?php }else{ ?>
	
<?php } ?>

<script>
window.addEventListener("load", () => { // when the page loads
  const sel = document.getElementById("leave_type_id");
  const input = document.getElementById("nameFoo");
  const toggle = function() {
    input.classList.toggle("hide", sel.value === "5")
  }
  sel.addEventListener("change", toggle)
  toggle(); // initialise
})

// window.addEventListener("load", () => { // when the page loads
//   document.getElementById("leave_type_id").addEventListener("change", function() {
//     document.getElementById("nameFoo").classList.toggle("hide", this.value === "5")
//   })
// })
//////////////////////////////////////////////
// function myFunction() {
//   var x = document.getElementById("myDIV");
//   if ($row['code'] == 'COC') {
// 	  if (x.style.display === "none") {
// 	    x.style.display = "block";
// 	  } else {
// 	    x.style.display = "none";
// 	  }
// 	}  
// }
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

// 	function calc_days( days, start, end ){
// 		var days = 0;
// 		if($('#date_start').val() != ''){
// 			var start = new Date($('#date_start').val());
// 			var end = new Date($('#date_end').val());
// 			var diffDate = (end - start) / (1000 * 60 * 60 * 24);
// 			days = Math.round(diffDate);
// 	}		
//     if ($('#type').val() == 2) {
//         $('#credit_days').val('.5');
//     } else {
//         $('#credit_days').val(days + 1);
//     }
// }
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
			// calc_days()
		})
		$('#date_start, #date_end').change(function(){
			// calc_days()
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
						location.href = "./?page=leave_credits";
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

<?php if($_settings->userdata('type') == 4 || $_settings->userdata('type') == 1 || $_settings->userdata('type') == 5){  ?>
	

<div class="card card-outline card-primary">
	<?php if($_settings->userdata('type') != 4): ?>
	<div class="card-header">
		
		<h3 class="card-title">List of Leave Credits</h3>
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
					<col width="10%">
					<col width="25%">
					<col width="25%">
					<col width="10%">
					<col width="5%">
					<col width="10%">
					<col width="10%">
				</colgroup>
				<?php else: ?>
					<colgroup>
						<col width="20%">
						<col width="20%">
						<col width="20%">
						<col width="20%">
						<col width="20%">
					</colgroup>
				<?php endif; ?>
				<thead>
					<tr>
						<th>#</th>
						<th>ID</th>
						<th>Employee</th>
						<th>Leave Type</th>
						<th>Date</th>
						<th>Days</th>
						<th>Status</th>
						<th>Action</th>
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
							<th><?php echo $row['employee_id'] ?></th>
							<td><?php echo $row['name'] ?></th>
							<?php endif; ?>
							<td><?php echo $row['code'] . ' - '. $row['lname'] ?></td>
							<td>
                            <?php
                                if($row['date_start'] == $row['date_end']){
                                    echo date("Y-m-d", strtotime($row['date_start']));
                                }else{
                                    echo date("Y-m-d", strtotime($row['date_start'])).' - '.date("Y-m-d", strtotime($row['date_end']));
                                }
                            ?>
                            </td>
							<td><?php echo $row['credit_days'] ?></td>
							<td>
								<?php if($row['status'] == 1): ?>
									<span class="badge badge-success">Approved</span>
								<?php elseif($row['status'] == 2): ?>
									<span class="badge badge-danger">Denied</span>
								<?php elseif($row['status'] == 3): ?>
									<span class="badge badge-warning">Cancelled</span>
								<?php else: ?>
									<span class="badge badge-primary">Pending</span>
								<?php endif; ?>
							</td>
							<?php if($_settings->userdata('type') != 5 || ($row['status'] == '0')): ?>
							<?php if($_settings->userdata('type') != 4 || ($row['status'] == '0')): ?>

							<td>
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon text-primary" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">

								  	<!-- <a class="dropdown-item" href="?page=leave_applications/view_application&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-secodary"></span> View</a> -->

				                    <div class="dropdown-divider"></div>

									<?php if($_settings->userdata('type') != 3): ?>
									<?php if($_settings->userdata('type') != 4): ?>
				                    <a class="dropdown-item update_status_cr" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-check-square"></span> Update Status</a>
				                    <div class="dropdown-divider"></div>
									<?php endif; ?>
									<?php endif; ?>
									
									<?php if($_settings->userdata('type') != 5): ?>
				                    <a class="dropdown-item" href="?page=leave_credits/manage_credit&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
									<?php endif; ?><?php endif; ?><?php endif; ?>
									
				                  </div>
							</td>
						</tr>
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
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Leave Credit permanently?","delete_leave_credit",[$(this).attr('data-id')])
		})		
		$('.update_status_cr').click(function(){
			uni_modal("<i class='fa fa-check-square'></i> Update Leave Credit Status","leave_credits/update_status_cr.php?id="+$(this).attr('data-id'))
		})
		$('.table').dataTable({
			columnDefs: [
				{ orderable: false, targets: [3,4] }
			]
		});
	})
	function delete_leave_credit($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=delete_leave_credit",
			method:"POST",
			data:{id: $id},
			dataType:"json",
			error:err=>{
				console.log(err)
				alert_toast("An error occured.",'error');
				end_loader();
			},
			success:function(resp){
				if(typeof resp== 'object' && resp.status == 'success'){
					location.reload();
				}else{
					alert_toast("An error occured.",'error');
					end_loader();
				}
			}
		})
	}
</script>