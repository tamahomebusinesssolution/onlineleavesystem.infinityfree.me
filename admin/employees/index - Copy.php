<?php if($_settings->chk_flashdata('success')): ?>
<script>
	alert_toast("<?php echo $_settings->flashdata('success') ?>",'success')
</script>
<?php endif;?>

<style>
    .img-avatar{
        width:45px;
        height:45px;
        object-fit:cover;
        object-position:center center;
        border-radius:100%;
    }
</style>

<div class="card card-outline card-primary">
	<div class="card-header">
		<h3 class="card-title">List of Employees</h3>
		<?php if($_settings->userdata('type') != 5): ?>
		<div class="card-tools">
			<a href="?page=employees/manage_employee" class="btn btn-sm btn-primary"><span class="fas fa-plus"></span>  Create New</a>
		</div>
		<?php endif; ?>

	</div>
	<div class="card-body">
		<div class="container-fluid">
			<table class="table table-hover table-stripped">
				<colgroup>
					<col width="10%">
					<col width="15%">
					<col width="15%">
					<col width="20%">
					<col width="30%">
					<col width="10%">
				</colgroup>
				<thead>
					<tr>
						<th>#</th>
						<th>Avatar</th>
						<th>Employee ID</th>
						<th>Name</th>
						<th>Details</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
<?php 
	$i = 1;
	$department_qry = $conn->query("SELECT id,name FROM department_list");
	$dept_arr = array_column($department_qry->fetch_all(MYSQLI_ASSOC),'name','id');

	$designation_qry = $conn->query("SELECT id,name FROM designation_list");
	$desg_arr = array_column($designation_qry->fetch_all(MYSQLI_ASSOC),'name','id');

	$position_qry = $conn->query("SELECT id,name FROM position_list");
	$pos_arr = array_column($position_qry->fetch_all(MYSQLI_ASSOC),'name','id');

	$position = 0;
	
	if($_settings->userdata('type') == 6) {
		$position = 1;
	}elseif($_settings->userdata('type') == 7){
		$position = 2;
	}
	?>
<!-- 	<button onclick="myFunction($position)">Click me</button>

	<select name="$position" id="$position" class="custom-select">
		<option value="1" <?php echo $position == 1 ? 'selected' : '' ?>>Teaching</option>
		<option value="2" <?php echo $position == 2 ? 'selected' : '' ?>>Non-Teaching</option>

	</select> -->
	<?php
		// and `position_id` =  $position 
		$qry = $conn->query("SELECT *,concat(lastname,' ',firstname) as name from `users` where `type` = '3'   order by concat(lastname,' ',firstname) asc ");
		while($row = $qry->fetch_assoc()):
		
		$meta_qry = $conn->query("SELECT * FROM employee_meta where user_id = '{$row['id']}' and '{$row['position_id']}' ");
		while($mrow = $meta_qry->fetch_assoc()){
			$row[$mrow['meta_field']] = $mrow['meta_value'];
		};
		
	
?>
						<tr>
							<!-- <?php if($_settings->userdata('position_id') != 1): ?> -->
							<td><?php echo $i++; ?></td>
							<td><img src="<?php echo validate_image($row['avatar']) ?>" class="img-avatar img-thumbnail p-0 border-2" alt="user_avatar"></td>
							<td><?php echo ($row['employee_id']) ?></td>
							<td><?php echo ucwords($row['lastname']).', '. ucwords($row['firstname']).' '. ucwords($row['middlename']) ?></td>
							<td >
								<p class="m-0 ">
									<b>Department: </b><?php echo isset($dept_arr[$row['department_id']]) ? $dept_arr[$row['department_id']] : 'N/A' ?><br>
									<b>Designation: </b><?php echo isset($desg_arr[$row['designation_id']]) ? $desg_arr[$row['designation_id']] : 'N/A' ?>
									<?php echo ($row['position_id']) ?>

									<!-- <?php echo isset($pos_arr[$row['position_id']]) ? $pos_arr[$row['position_id']] : 'N/A' ?> --><br>
								</p>
							</td>

							<td>
								 <button type="button" class="btn btn-flat btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown">
				                  		Action
				                    <span class="sr-only">Toggle Dropdown</span>
				                  </button>
				                  <div class="dropdown-menu" role="menu">
								  	<a class="dropdown-item" href="?page=employees/records&id=<?php echo $row['id'] ?>"><span class="fa fa-eye text-secodary"></span> View Profile</a>
								  	<?php if($_settings->userdata('type') != 5): ?>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item" href="?page=employees/manage_employee&id=<?php echo $row['id'] ?>"><span class="fa fa-edit text-primary"></span> Edit</a>
				                    <div class="dropdown-divider"></div>
									<a class="dropdown-item reset_password" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-key text-primary"></span> Reset Passwowrd</a>
				                    <div class="dropdown-divider"></div>
				                    <a class="dropdown-item delete_data" href="javascript:void(0)" data-id="<?php echo $row['id'] ?>"><span class="fa fa-trash text-danger"></span> Delete</a>
				                    <?php endif; ?>
				                  </div>
				                  <?php endif; ?>
							</td>
						</tr>
					<?php endwhile; ?>
				</tbody>
			</table>
		</div>
		</div>
	</div>
</div>

<script>
	// Disable right-click
document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
});
	$(document).ready(function(){
		$('.delete_data').click(function(){
			_conf("Are you sure to delete this Employee permanently?","delete_user",[$(this).attr('data-id')])
		})
		$('.reset_password').click(function(){
			_conf("You're about to reset the password of the user. Are you sure to continue this action?","reset_password",[$(this).attr('data-id')])
		})
		$('.table').dataTable();
	})
	function delete_user($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Users.php?f=delete",
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
	function reset_password($id){
		start_loader();
		$.ajax({
			url:_base_url_+"classes/Master.php?f=reset_password",
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

function myFunction($position) {
	// var foo = 'bar';
	// var $position = 2;
	var baz = '<?php echo $position ?>';
	alert(baz);
}
</script>