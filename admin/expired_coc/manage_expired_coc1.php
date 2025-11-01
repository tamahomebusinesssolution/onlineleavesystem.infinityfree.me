
<?php require_once('../../config.php'); ?>
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
	<!-- <div class="card-header">
		<h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> Leave</h3>
	</div> -->
	<div class="card-body">
		<form action="" id="leave_application-form">
			<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
			<div class="row" hidden>
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
							// $where = '';
				              if($_settings->userdata('type') == 3)
				                // $where = " and u.id = '{$_settings->userdata('id')}' ";
				                // $total_expired_coc = $conn->query("SELECT l.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as `name`,lt.code,lt.name as lname from `leave_credits` l inner join `users` u on l.user_id=u.id inner join `leave_types` lt on lt.id = l.leave_type_id where leave_type_id = 5 and (date_format(l.date_end,'%Y') < '".date("Y")."') {$where} ");
				                // while($row = $total_expired_coc->fetch_assoc()):

				                // $creditDays = $row['credit_days']; 

				                // $total_expired_used = $conn->query("SELECT l.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as `name`,lt.code,lt.name as lname from `leave_applications` l inner join `users` u on l.user_id=u.id inner join `leave_types` lt on lt.id = l.leave_type_id where leave_type_id = 5 and (date_format(l.date_end,'%Y') < '".date("Y")."') {$where} ");
				                // while($row = $total_expired_used->fetch_assoc()):	

				                // $leaveDays = $row['leave_days']; 
				                // $leave_days = $creditDays - $leaveDays;

				               
				    //             $days_credit = $conn->query("
								// SELECT l.*,concat(u.credit_days) as 'daysCredit',
								// lt.code,lt.name as lname 
								// from `leave_applications` l 
								// inner join `leave_credits` u on l.user_id=u.user_id 
								// inner join `leave_types` lt on lt.id = l.leave_type_id 
								// where date_format(l.date_end,'%Y') = '".date("Y",strtotime("-1 year"))."' ")->fetch_array()['daysCredit'];

								// $days_leave = $conn->query("
								// SELECT l.*,concat(u.leave_days) as 'daysLeave',
								// lt.code,lt.name as lname 
								// from `leave_credits` l 
								// inner join `leave_applications` u on l.user_id=u.user_id 
								// inner join `leave_types` lt on lt.id = l.leave_type_id 
								//  where (date_format(l.date_end,'%Y') = '".date("Y")."') ")->fetch_array()['daysLeave']; 
				             //    $used_last_yr = $conn->query("SELECT COALESCE(sum(`leave_days`),0) as total FROM `leave_applications` where `leave_type_id` = 5 and user_id = '{$_settings->userdata('id')}' and status = 1 and date_format(date_end,'%Y') = '".date("Y",strtotime("-1 year"))."' ")->fetch_array()['total'];

				            	// $coc_last_yr = $conn->query("SELECT COALESCE(sum(`credit_days`),0) as total FROM `leave_credits` where user_id = '{$_settings->userdata('id')}' and status = 1 and `leave_type_id` = 5 and date_format(date_end,'%Y') = '".date("Y",strtotime("-1 year"))."' ")->fetch_array()['total'];

				            	$all_expired_used = $conn->query("SELECT COALESCE(sum(`leave_days`),0) as total FROM `leave_applications` where leave_type_id = 5 and user_id = '{$_settings->userdata('id')}' and status = 1 and date_format(date_start,'%Y') < '".date('Y')."' and date_format(date_end,'%Y') < '".date('Y')."' ")->fetch_array()['total'];                    
    							$all_expired_coc = $conn->query("SELECT COALESCE(sum(`credit_days`),0) as total FROM `leave_credits` where user_id = '{$_settings->userdata('id')}' and status = 1 and date_format(date_start,'%Y') < '".date('Y')."' and date_format(date_end,'%Y') < '".date('Y')."' and leave_type_id = 5 ")->fetch_array()['total'];

				            	$leave_days = $all_expired_coc - $all_expired_used;
				              ?>

							
						
							<div class="form-group">
								<label for="leave_days" class="control-label">Days</label>
								<input type="number" id="leave_days" class="form-control form" name="leave_days" value="<?php echo isset($leave_days) ? $leave_days : 0 ?>" required ><?php echo $row['leave_days'] ?>

								<!-- <p><?php echo $coc_last_yr; ?></p>
								<p><?php echo $used_last_yr; ?></p> -->
							</div>

						

							<?php $date_updated = date("Y-12-31",strtotime("-1 year")); ?>
							<div class="form-group">
								<label for="date_updated" class="control-label">Date Update</label>
								<input type="date" id="date_updated" class="form-control form" required name="date_updated" value="<?php echo isset($date_updated) ? date("Y-m-d",strtotime($date_updated)) : '' ?>">
							</div>
							<?php $date_created = date("Y-12-31",strtotime("-1 year")); ?>
							<div class="form-group">
								<label for="date_created" class="control-label">Date Created</label>
								<input type="date" id="date_created" class="form-control form" required name="date_created" value="<?php echo isset($date_created) ? date("Y-m-d",strtotime($date_created)) : '' ?>">
							</div>
						</form>
					</div>

				</div>


				<?php $status = '1'; ?>
	            <div class="form-group">
					<label for="status">status</label>
					<textarea rows="1" name="status" id="status" class="form-control rounded-0" style="resize:none !important" required><?php echo isset($status) ? $status: '' ?></textarea>
				</div>
				<?php $status1 = '1'; ?>
	            <div class="form-group">
					<label for="status1">confirmed</label>
					<textarea rows="1" name="status1" id="status1" class="form-control rounded-0" style="resize:none !important" required><?php echo isset($status1) ? $status1: '' ?></textarea>
				</div>

			</div>	
			<?php if ($all_expired_coc > $all_expired_used) { ?>
				
			
			<div>
				<?php 
					if ($leave_days > 1) {
						$d = 'days';
					}else{
						$d = 'day';
					}
				?>
				<p class="text-center" ><?php echo 'Please confirm the expired COC dated '.$date_updated ?></p>
				<p class="text-center" ><?php echo $leave_days.' ' .$d.'.'  ?> </p>
				
			</div>
			<?php }else{ ?>
				<div class="text-center" >
					<h1>Thank You</h1>
					<p>(Please click cancel)</p>
					<p><?php echo $status1?></p>
				</div>	
			<?php } ?>		
		</form>
	</div>

	                  

</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Confirm</button>
    <!-- <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button> -->
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