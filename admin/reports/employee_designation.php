<style>
    .select2-container--default .select2-selection--single{
        height:calc(2.25rem + 2px) !important;
    }
</style>
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">List of Employee per Designation</h3>
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
                    $designation_id = isset($_GET['designation_id']) ? $_GET['designation_id'] : 0;
                    // $position_id = isset($_GET['position_id']) ? $_GET['position_id'] : 0;
                    
                    
                    // $position_qry = $conn->query("SELECT id,name FROM position_list");
                    // $pos_arr = array_column($position_qry->fetch_all(MYSQLI_ASSOC),'name','id');
                    $designation_qry = $conn->query("SELECT id,name FROM designation_list");
                    $desg_arr = array_column($designation_qry->fetch_all(MYSQLI_ASSOC),'name','id');
                    $department_qry = $conn->query("SELECT id,name FROM department_list");
                    $dept_arr = array_column($department_qry->fetch_all(MYSQLI_ASSOC),'name','id');
                    ?>

                    <div class="row">
                        <div class="col-3">
                            <div class="form-group">
                                <select name="designation_id" id="designation_id" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Designation here">
                                    <option value="" disabled <?php echo !isset($meta['designation_id']) ? 'selected' : '' ?>></option>
                                    <?php foreach($desg_arr as $k=>$v): ?>
                                        <option value="<?php echo $k ?>" <?php echo (isset($meta['designation_id']) && $meta['designation_id'] == $k) ? 'selected' : '' ?>><?php echo $v ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>

                        <!-- <div class="col-3">
                            <div class="form-group">
                                <select name="position_id" id="position_id" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Position here">
                                    <option value="" disabled <?php echo !isset($meta['position_id']) ? 'selected' : '' ?>></option>
                                    <?php foreach($pos_arr as $k=>$v): ?>
                                        <option value="<?php echo $k ?>" <?php echo (isset($meta['position_id']) && $meta['position_id'] == $k) ? 'selected' : '' ?>><?php echo $v ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div> -->
                        <div class="col-2 row align-items-end pb-1">      
                            <div class="form-group d-flex justify-content-between align-middle">
                                <button class="btn btn-sm btn-default bg-lightblue" type="button" id="filter"><i class="fa fa-filter"></i> Designation</button>
                            </div>
                        </div>  
                    </div>          
                        <?php

        // and `position_id` =  $position_id ;
                    $qry = $conn->query("SELECT * from `users` where `designation_id` =  $designation_id  and `type` = 3 order by 'lastname','firstname','middlename' asc ");
                    while($row = $qry->fetch_assoc()):
                    ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo ($row['employee_id']) ?></td>
                            <td><?php echo ucwords($row['lastname']).', '. ucwords($row['firstname']).' '. ucwords($row['middlename']) ?></td>
                            <td><?php echo isset($dept_arr[$row['department_id']]) ? $dept_arr[$row['department_id']] : 'N/A' ?></td>
                            <td><?php echo isset($desg_arr[$row['designation_id']]) ? $desg_arr[$row['designation_id']] : 'N/A' ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<script>
    $(document).ready(function(){
        $('#filter').click(function(){
            location.replace("./?page=reports/employee_designation&designation_id="+($('#designation_id').val()));
        })
        $('.table').dataTable();
    })
    $(function(){
        $('.select2').select2()
        $('.select2-selection').addClass('form-control rounded-0')
    })

</script>