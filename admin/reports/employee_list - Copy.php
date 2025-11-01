<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Employee</h3>
    </div>
    <div class="card-body">
        <div class="container-fluid">
            <table class="table table-hover table-stripped">
                <colgroup>
                    <col width="10%">
                    <col width="10%">
                    <col width="30%">
                    <col width="25%">
                    <col width="25%">
                    <!-- <col width="5%"> -->
                </colgroup>
                <thead>
                    <tr>
                        <th>#</th>
                        
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <!-- <th>Action</th> -->
                    </tr>
                </thead>
                <tbody>
<?php 
    $i = 1;
    $department_qry = $conn->query("SELECT id,name FROM department_list");
    $dept_arr = array_column($department_qry->fetch_all(MYSQLI_ASSOC),'name','id');

    $designation_qry = $conn->query("SELECT id,name FROM designation_list");
    $desg_arr = array_column($designation_qry->fetch_all(MYSQLI_ASSOC),'name','id');

    // $position_qry = $conn->query("SELECT id,name FROM position_list");
    // $pos_arr = array_column($position_qry->fetch_all(MYSQLI_ASSOC),'name','id');

    $position_id = isset($_GET['position_id']) ? $_GET['position_id'] : 0;

    ?>

    <div class="row">
        <div class="col-3">
            <div class="form-group">
                <!-- <label for="position_id" class="control-label ml-1">Position</label> -->
                <select name="position_id" id="position_id" class="custom-select">
                    <option value="1" <?php echo $position_id == 1 ? 'selected' : '' ?>>Teaching</option>
                    <option value="2" <?php echo $position_id == 2 ? 'selected' : '' ?>>Non-Teaching</option>

                </select>
            </div>
        </div>
        <div class="col-2 row align-items-end pb-1">      
            <div class="form-group d-flex justify-content-between align-middle">
                <button class="btn btn-sm btn-default bg-lightblue" type="button" id="filter"><i class="fa fa-filter"></i> Filter</button>
            </div>
        </div>
    </div>        
    <?php

        // and `position_id` =  $position_id ;
        $qry = $conn->query("SELECT * from `users` where `position_id` =  $position_id and `type` = 3 ");
        while($row = $qry->fetch_assoc()):
        
        // $meta_qry = $conn->query("SELECT * FROM employee_meta where user_id = '{$row['id']}' and '{$row['position_id']}' ");
        // while($mrow = $meta_qry->fetch_assoc()){
        //     $row[$mrow['meta_field']] = $mrow['meta_value'];
        // };
        
    
?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo ($row['employee_id']) ?></td>
                            <td><?php echo ucwords($row['lastname']).', '. ucwords($row['firstname']).' '. ucwords($row['middlename']) ?></td>
                            <td ><?php echo isset($dept_arr[$row['department_id']]) ? $dept_arr[$row['department_id']] : 'N/A' ?></td>
                            <td><?php echo isset($desg_arr[$row['designation_id']]) ? $desg_arr[$row['designation_id']] : 'N/A' ?></td>
                            
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
        $('#filter').click(function(){
            location.replace("./?page=reports/employee_list&position_id="+($('#position_id').val()));
        })
        $('.table').dataTable();
    })
    

</script>