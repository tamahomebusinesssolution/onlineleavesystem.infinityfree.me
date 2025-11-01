<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
	require_once('../../config.php');
    $qry = $conn->query("SELECT * from `department_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
 
?>
<style>
	.select2-container--default .select2-selection--single{
		height:calc(2.25rem + 2px) !important;
	}
</style>

<div class="container-fluid">
	<form action="" id="department-form">
		<input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
		<div class="form-group">
			<label for="name" class="control-label">Name</label>
			<input name="name" id="name" type="text" class="form-control form  rounded-0" value="<?php echo isset($name) ? $name : ''; ?>" required/>
		</div>

		<div class="form-group">
			<label for="description" class="control-label">Description</label>
			<textarea name="description" id="description" cols="30" rows="3" style="resize:none !important" class="form-control form no-resize rounded-0" required><?php echo isset($description) ? $description : ''; ?></textarea>
		</div>
		<div class="form-group">
			<label for="manager" class="control-label">Employee</label>
			<select name="manager" id="manager" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Employee here" reqiured>
				<option value="" disabled <?php echo !isset($manager) ? 'selected' : '' ?>></option>
				<?php 

				$emp_qry = $conn->query("SELECT u.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as `lfname`,m.meta_value FROM `users` u inner join `employee_meta` m on u.id = m.user_id where m.meta_field='employee_id' order by `lfname` asc");
				while($row = $emp_qry->fetch_assoc()):
					?>
					<option value="<?php echo $row['id'] ?>" <?php echo (isset($manager) && $manager == $row['id']) ? 'selected' : '' ?>><?php echo "[".$row['meta_value']."] ".$row['lfname'] ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<!-- <div class="form-group">
			<label for="manager" class="control-label">School Head</label>
			<input name="manager" id="manager" type="text" class="form-control form  rounded-0" value="<?php echo isset($manager) ? $manager : ''; ?>" required/>
		</div> -->
		<div class="form-group">
			<label for="supervisor" class="control-label">Public Schools Division Supervisor</label>
			<input name="supervisor" id="supervisor" type="text" class="form-control form  rounded-0" value="<?php echo isset($supervisor) ? $supervisor : ''; ?>" required/>
		</div>
	</form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Save</button>
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
</div>
<script>

	$(document).ready(function(){
		$('.select2').select2();
		$('.select2-selection').addClass('form-control rounded-0')
		$('#type').change(function(){
			if($(this).val() == 2){
			console.log($(this).val())
			}

		})
		$('#department-form').submit(function(e){
			e.preventDefault();
			var _this = $(this)
			 $('.err-msg').remove();
			start_loader();
			$.ajax({
				url:_base_url_+"classes/Master.php?f=save_department",
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