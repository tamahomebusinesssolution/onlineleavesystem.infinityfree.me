
<?php 
if(isset($_GET['id']) && $_GET['id'] > 0){
    $user = $conn->query("SELECT * FROM users where id ='{$_GET['id']}'");
    foreach($user->fetch_array() as $k =>$v){
        $meta[$k] = $v;
    }
}
$department_qry = $conn->query("SELECT id,name FROM department_list");
$dept_arr = array_column($department_qry->fetch_all(MYSQLI_ASSOC),'name','id');
?>
<?php if($_settings->chk_flashdata('success')): ?>

<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>
<style type="text/css">
	.hide {
 		 display: none;
	}
	.select2-container--default .select2-selection--single{
		height:calc(2.25rem + 2px) !important;
	}

</style>
<?php if($_settings->userdata('type') == 1){ ?>
<div class="card card-outline card-primary">
	<div class="card-body">
		<div class="container-fluid">
			<div id="msg"></div>
			<form action="" id="manage-user">	
				<input type="hidden" name="id" value="<?php echo isset($meta['id']) ? $meta['id']: '' ?>">
				<div class="form-group col-6">
					<label for="name">First Name</label>
					<input type="text" name="firstname" id="firstname" class="form-control" value="<?php echo isset($meta['firstname']) ? $meta['firstname']: '' ?>" required>
				</div>
				<div class="form-group col-6">
					<label for="name">Last Name</label>
					<input type="text" name="lastname" id="lastname" class="form-control" value="<?php echo isset($meta['lastname']) ? $meta['lastname']: '' ?>" required>
				</div>
				<div class="form-group col-6">
					<label for="username">Username</label>
					<input type="text" name="username" id="username" class="form-control" value="<?php echo isset($meta['username']) ? $meta['username']: '' ?>" required  autocomplete="off">
				</div>
				<div class="form-group col-6">
					<label for="password">Password</label>
					<input type="password" name="password" id="password" class="form-control" value="" autocomplete="off" <?php echo isset($meta['id']) ? "": 'required' ?>>
                    <?php if(isset($_GET['id'])): ?>
					<small><i>Leave this blank if you dont want to change the password.</i></small>
                    <?php endif; ?>
				</div>
				<div class="form-group col-6">
					<label for="type">Login Type</label>
					<select name="type" id="type" class="custom-select">
						<option value="1" <?php echo isset($meta['type']) && $meta['type'] == 1 ? 'selected' : '' ?>>Administrator
						</option>
						<option value="2" <?php echo isset($meta['type']) && $meta['type'] == 2 ? 'selected' : '' ?>>Leave Application Approver
						</option>
						<option value="4" <?php echo isset($meta['type']) && $meta['type'] == 4 ? 'selected' : '' ?>>Credit Leave Creator</option>
						<option value="5" <?php echo isset($meta['type']) && $meta['type'] == 5 ? 'selected' : '' ?>>Credit Leave Approver</option>
						<option value="6" <?php echo isset($meta['type']) && $meta['type'] == 6 ? 'selected' : '' ?>>Teaching Records
						</option>
						<option value="7" <?php echo isset($meta['type']) && $meta['type'] == 7 ? 'selected' : '' ?>>Non-Teaching Records</option>
						<option value="8" <?php echo isset($meta['type']) && $meta['type'] == 8 ? 'selected' : '' ?>>HRM
						</option>
						<option value="9" <?php echo isset($meta['type']) && $meta['type'] == 9 ? 'selected' : '' ?>>Department
						</option>
					</select>
				</div>
				<div id="nameFoo" class="form-group col-6 hide">
					<label for="department_id" class="text-danger" >Department</label>
					<select name="department_id" id="department_id" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Department here" required>
						<option value="" disabled <?php echo !isset($meta['department_id']) ? 'selected' : '' ?>></option>
						<?php foreach($dept_arr as $k=>$v): ?>
							<option value="<?php echo $k ?>" <?php echo (isset($meta['department_id']) && $meta['department_id'] == $k) ? 'selected' : '' ?>><?php echo $v ?></option>
						<?php endforeach; ?>
					</select>
				</div>
				<div class="form-group col-6">
					<label for="" class="control-label">Avatar</label>
					<div class="custom-file">
		              <input type="file" class="custom-file-input rounded-circle" id="customFile" name="img" onchange="displayImg(this,$(this))">
		              <label class="custom-file-label" for="customFile">Choose file</label>
		            </div>
				</div>
				<div class="form-group col-6 d-flex justify-content-center">
					<img src="<?php echo validate_image(isset($meta['avatar']) ? $meta['avatar'] :'') ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
				</div>
			</form>
		</div>
	</div>
	<div class="card-footer">
			<div class="col-md-12">
				<div class="row">
					<button class="btn btn-sm btn-primary mr-2" form="manage-user">Save</button>
					<a class="btn btn-sm btn-danger" href="./?page=user/list">Cancel</a>
				</div>
			</div>
		</div>
</div>
<?php }else{ ?>
	<?php include '404.html'; ?>
<?php } ?>
<style>
	img#cimg{
		height: 15vh;
		width: 15vh;
		object-fit: cover;
		border-radius: 100% 100%;
	}
</style>
<script>
	function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
	$('#manage-user').submit(function(e){
		e.preventDefault();
		var _this = $(this)
		start_loader()
		$.ajax({
			url:_base_url_+'classes/Users.php?f=save',
			data: new FormData($(this)[0]),
		    cache: false,
		    contentType: false,
		    processData: false,
		    method: 'POST',
		    type: 'POST',
			success:function(resp){
				if(resp ==1){
					 location.reload()
					// location.href = './?page=user/list';
					
				}else{
					$('#msg').html('<div class="alert alert-danger">Username already exist</div>')
					$("html, body").animate({ scrollTop: 0 }, "fast");
				}
                end_loader()
			}
		})
	})

	window.addEventListener("load", () => { // when the page loads
	  const sel = document.getElementById("type");
	  const input = document.getElementById("nameFoo");
	  const toggle = function() {
	    input.classList.toggle("hide", sel.value != "9")
	  }
	  sel.addEventListener("change", toggle)
	  toggle(); // initialise
	})
	$(function(){
		$('.select2').select2()
		$('.select2-selection').addClass('form-control rounded-0')
	})
</script>