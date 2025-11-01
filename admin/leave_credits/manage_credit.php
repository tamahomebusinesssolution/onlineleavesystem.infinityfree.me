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
<?php if($_settings->userdata('type') == 4 || $_settings->userdata('type') == 1){ ?>
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
								<option value="<?php echo $row['id'] ?>" <?php echo (isset($leave_type_id) && $leave_type_id == $row['id']) ? 'selected' : '' ?>><?php echo $row['code'] . ' - '. $row['name'] ?>
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
					<div class="form-group">
						<label for="date_start" class="control-label">Date Start</label>
						<input type="date" id="date_start" class="form-control form"  name="date_start" value="<?php echo isset($date_start) ? date("Y-m-d",strtotime($date_start)) : '' ?>">
					</div>
					<div class="form-group">
						<label for="date_end" class="control-label">Date End</label>
						<input type="date" id="date_end" class="form-control form"  name="date_end" value="<?php echo isset($date_end) ? date("Y-m-d",strtotime($date_end)) : '' ?>">
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
						
						$leaveDays=(isset($credit_days)) ? $credit_days : 0;
						?>
				<div class="col-3">
					<div class="continer-fluid">		
						<div class="form-group">
							<label for="credit_days" class="control-label">Days</label>
							<input type="text" id="credit_days" class="form-control form" name="credit_days" value="<?php echo number_format($leaveDays,3) ?>" >
						</div>
					</div>
				</div>

			</div>			
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-sm btn-primary" form="leave_credit-form">Save</button>
		<a class="btn btn-sm btn-danger" href="?page=leave_credits">Cancel</a>
	</div>
</div>
<?php }else{ ?>
	<?php include '404.html'; ?>
<?php } ?>
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