<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `leave_applications` where leave_type_id = 5 and id = '{$_GET['id']}' ");
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
<div class="card card-outline card-info">
	<div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> Leave</h3>
	</div>
	<div class="card-body">
		<form action="" id="leave_application-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
			<div class="row">
				<div class="col-6">
					<?php if($_settings->userdata('type') != 3): ?>
					<div class="form-group">
						<label for="user_id" class="control-label">Employee</label>
						<select name="user_id" id="user_id" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Employee here" reqiured>
							<option value="" disabled <?php echo !isset($user_id) ? 'selected' : '' ?>></option>
							<?php 
							
							$emp_qry = $conn->query("SELECT u.*,concat(u.lastname,' ',u.firstname,' ',u.middlename) as `name`, m.meta_value FROM `users` u inner join `employee_meta` m on u.id = m.user_id where m.meta_field='employee_id'");
							while($row = $emp_qry->fetch_assoc()):

								
							?>
								<option value="<?php echo $row['id'] ?>" <?php echo (isset($user_id) && $user_id == $row['id']) ? 'selected' : '' ?>><?php echo "[".$row['meta_value']."] ".$row['name'] ?></option>
							<?php endwhile; ?>
						</select>
					</div>
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
							$lt = $conn->query("SELECT * FROM `leave_types` where status = 1 {$where} and id = 5 order by `code` asc");
							while($row = $lt->fetch_assoc()):
							?>
								<option value="<?php echo $row['id'] ?>" selected <?php echo (isset($leave_type_id) && $leave_type_id == $row['id']) ? 'selected' : '' ?> ><?php echo $row['code'] . ' - '. $row['name'] ?>
								</option>
							<?php endwhile; ?>
						</select>
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
					<?php $date_start = date("Y-12-31",strtotime("-1 year")); ?>
					<div class="form-group">
						<label for="date_start" class="control-label">Date Start</label>
						<input type="date" id="date_start" class="form-control form" required name="date_start" value="<?php echo isset($date_start) ? date("Y-m-d",strtotime($date_start)) : '' ?>">
					</div>
					<?php $date_end = date("Y-12-31",strtotime("-1 year")); ?>
					<div class="form-group">
								<label for="date_end" class="control-label">Date End</label>
								<input type="date" id="date_end" class="form-control form" required name="date_end" value="<?php echo isset($date_end) ? date("Y-m-d",strtotime($date_end)) : '' ?>">
					</div>
					
				</div>

				<div class="col-6">
					
					<div class="continer-fluid">
				    	<form action="" id="update-option1-form">
							<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
							<input type="hidden" name ="approved_by" value="<?php echo $_settings->userdata('id') ?>">
				            <div class="form-group">
				                <label for="option1" class="control-label">DETAILS OF LEAVE</label>
				                <select id="option1" name="option1" class="form-control rounded-0">
				                	<option value="0" <?php echo (isset($option1) && $option1 ==0)?'selected' : '' ?>>Please Select...</option>
				                    <option value="1" selected <?php echo (isset($option1) && $option1 ==1)?'selected' : '' ?>>Within the Philippines</option>
				                    <option value="2" <?php echo (isset($option1) && $option1 ==2)?'selected' : '' ?>>Abroad (Specify) </option>
				                    <option value="3" <?php echo (isset($option1) && $option1 ==3)?'selected' : '' ?>>In Hospital (Specify Illness)</option>
				                    <option value="4" <?php echo (isset($option1) && $option1 ==4)?'selected' : '' ?>>Out Patient (Specify Illness)</option>
				                    <option value="5" <?php echo (isset($option1) && $option1 ==5)?'selected' : '' ?>>In case of Special Leave Benefits for Women: (Specify Illness)</option>
				                    <option value="6" <?php echo (isset($option1) && $option1 ==6)?'selected' : '' ?>>Completion of Master's Degree</option>
				                    <option value="7" <?php echo (isset($option1) && $option1 ==7)?'selected' : '' ?>>BAR/Board Examination Review</option>
				                    <option value="8" <?php echo (isset($option1) && $option1 ==8)?'selected' : '' ?>>Monetization of Leave Credits</option>
				                    <option value="9" <?php echo (isset($option1) && $option1 ==9)?'selected' : '' ?>>Terminal Leave </option>
				                </select>
				            </div>
				            
				            <?php $reason = 'Expired COC'; ?>
				            <div class="form-group">
								<label for="reason">Reason</label>
								<textarea rows="1" name="reason" id="reason" class="form-control rounded-0" style="resize:none !important" required><?php echo isset($reason) ? $reason: '' ?></textarea>
							</div>
							<?php 

							$all_expired_coc = $conn->query("SELECT SUM(`credit_days`) as total FROM `leave_credits` where user_id = '{$_settings->userdata('id')}' and status = 1 and leave_type_id = 5 and date_format(date_start,'%Y') < '".date("Y")."' or date_format(date_end,'%Y') < '".date("Y")."' ")->fetch_array()['total'];

						    // $opong = " and id = '{$_settings->userdata('id')}' ";
						   
						    $all_expired_used = $conn->query("SELECT SUM(`leave_days`) as total FROM `leave_applications` where user_id = '{$_settings->userdata('id')}' and status = 1 and leave_type_id = 5 and date_format(date_start,'%Y') < '".date("Y")."' or date_format(date_end,'%Y') < '".date("Y")."' ")->fetch_array()['total'];

						    //$leave_days = $all_expired_coc - $all_expired_used;


							?>
							<p><?php echo $all_expired_coc; ?></p>
							<p><?php echo $all_expired_used; ?></p>


							<div class="form-group">
								<label for="leave_days" class="control-label">Days</label>
								<input type="number" id="leave_days" class="form-control form" name="leave_days" value="<?php echo isset($leave_days) ? $leave_days : 0 ?>" required ><?php echo $row['leave_days'] ?>
							</div>
							<?php $date_updated = date("Y-12-31",strtotime("-1 year")); ?>
							<div class="form-group">
								<label for="date_updated" class="control-label">Date Update</label>
								<input type="date" id="date_updated" class="form-control form" required name="date_updated" value="<?php echo isset($date_updated) ? date("Y-m-d",strtotime($date_updated)) : '' ?>">
					</div>
						</form>
					</div>

				</div>


				<?php $status = '1'; ?>
	            <div class="form-group">
					<label for="status">status</label>
					<textarea rows="1" name="status" id="status" class="form-control rounded-0" style="resize:none !important" required><?php echo isset($status) ? $status: '' ?></textarea>
				</div>

			</div>			
		</form>
	</div>
	<div class="card-footer">
		<button class="btn btn-flat btn-primary" form="leave_application-form">Save</button>
		<a class="btn btn-flat btn-default" href="?page=expired_coc">Cancel</a>
	</div>
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

// 	function calc_days( days, start, end ){
// 		var days = 0;
// 		if($('#date_start').val() != ''){
// 			var start = new Date($('#date_start').val());
// 			var end = new Date($('#date_end').val());
// 			var diffDate = (end - start) / (1000 * 60 * 60 * 24);
// 			days = Math.round(diffDate);
// 	}		
//     if ($('#type').val() == 2) {
//         $('#leave_days').val('.5');
//     } else {
//         $('#leave_days').val(days + 1);
//     }
// }
	$(document).ready(function(){
		$('.select2').select2();
		$('.select2-selection').addClass('form-control rounded-0')
		$('#type').change(function(){
			if($(this).val() == 2){
			console.log($(this).val())
				$('#leave_days').val('.5')
				$('#date_end').attr('required',false)
				$('#date_end').val($('#date_start').val())
				$('#date_end').closest('.form-group').hide('fast')
			}else{
				$('#date_end').attr('reqiured',true)
				$('#date_end').closest('.form-group').show('fast')
				$('#leave_days').val(1)
			}
			// calc_days()
		})
		$('#date_start, #date_end').change(function(){
			// calc_days()
		})
		$('#leave_application-form').submit(function(e){
			e.preventDefault();
            var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_expired_coc",
				data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json',
				error:err=>{
					console.log(err)
					alert_toast("An error occured1",'error');
					end_loader();
				},
				success:function(resp){
					if(typeof resp =='object' && resp.status == 'success'){
						location.href = "./?page=expired_coc";
					}else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: 0 }, "fast");
                            end_loader()
                    }else{
						alert_toast("An error occured2",'error');
						end_loader();
                        console.log(resp)
					}
				}
			})
		})
	})
</script>