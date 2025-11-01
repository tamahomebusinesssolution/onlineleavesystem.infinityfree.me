<?php
//require_once('../../config.php');
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT l.*,concat(u.lastname) as `name3`,concat(u.firstname) as `name1`,concat(u.middlename) as `name2`,lt.code as lname from `leave_applications` l inner join `users` u on l.user_id=u.id inner join `leave_types` lt on lt.id = l.leave_type_id  where l.id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
    $lt_qry = $conn->query("SELECT meta_value FROM `employee_meta` where user_id = '{$user_id}' and meta_field = 'employee_id' ");
    $employee_id = ($lt_qry->num_rows > 0) ? $lt_qry->fetch_array()['meta_value'] : "N/A";
    
    $lt_qry1 = $conn->query("SELECT meta_value FROM `employee_meta` where user_id = '{$user_id}' and meta_field = 'department_id' ");
    $department_id = ($lt_qry1->num_rows > 0) ? $lt_qry1->fetch_array()['meta_value'] : "N/A";

    $lt_qry2 = $conn->query("SELECT meta_value FROM `employee_meta` where user_id = '{$user_id}' and meta_field = 'designation_id' ");
    $designation_id = ($lt_qry2->num_rows > 0) ? $lt_qry2->fetch_array()['meta_value'] : "N/A";

    $lt_qry3 = $conn->query("SELECT meta_value FROM `employee_meta` where user_id = '{$user_id}' and meta_field = 'salary' ");
    $salary = ($lt_qry3->num_rows > 0) ? $lt_qry3->fetch_array()['meta_value'] : "N/A";

    $lt_qry4 = $conn->query("SELECT meta_value FROM `employee_meta` where user_id = '{$user_id}' and meta_field = 'firstname' ");
    $firstname = ($lt_qry4->num_rows > 0) ? $lt_qry4->fetch_array()['meta_value'] : "N/A";

    $lt_qry5 = $conn->query("SELECT meta_value FROM `employee_meta` where user_id = '{$user_id}' and meta_field = 'middlename' ");
    $middlename = ($lt_qry5->num_rows > 0) ? $lt_qry5->fetch_array()['meta_value'] : "N/A";

    $lt_qry6 = $conn->query("SELECT meta_value FROM `employee_meta` where user_id = '{$user_id}' and meta_field = 'lastname' ");
    $lastname = ($lt_qry6->num_rows > 0) ? $lt_qry6->fetch_array()['meta_value'] : "N/A";
}
$department_qry = $conn->query("SELECT id,name FROM department_list");
$dept_arr = array_column($department_qry->fetch_all(MYSQLI_ASSOC),'name','id');
///// school head
$department_qry1 = $conn->query("SELECT id,manager FROM department_list");
$dept_mgr_arr = array_column($department_qry1->fetch_all(MYSQLI_ASSOC),'manager','id');
////psds
$department_qry2 = $conn->query("SELECT id,supervisor FROM department_list");
$dept_psds_arr = array_column($department_qry2->fetch_all(MYSQLI_ASSOC),'supervisor','id');

$designation_qry = $conn->query("SELECT id,name FROM designation_list");
$desg_arr = array_column($designation_qry->fetch_all(MYSQLI_ASSOC),'name','id');

$department_qry3 = $conn->query("SELECT id,manager FROM department_list");
$mgr_arr = array_column($department_qry3->fetch_all(MYSQLI_ASSOC),'manager','id');

// $manager_qry = $conn->query("SELECT id,concat(lastname,', ',firstname,' ',middlename) as lfname from `users`");
// $manage_arr = array_column($manager_qry->fetch_all(MYSQLI_ASSOC),'lfname','id');
?>
<style>
    p,label{
        margin-bottom:5px;
    }
    #uni_modal .modal-footer{
        display:none !important;
    }
    
</style>
<tbody>
<div class="container-fluid" id="print_out" style="border: 5px">
    <div class="w-100 d-flex justify-content-end my-2">
        <a type="button" class="btn btn-sm btn-danger" href="?page=leave_applications">Cancel</a>
        <a href="javascript:void(0)" type="button" class="btn btn-sm btn-success ml-3"  id="print"><span class="fas fa-print"></span>  Print</a>
    </div>
    <div class="row" style="border: 1px solid #000">
        <div class="col-sm-4">
            <p class="m-0 p-0">1. OFFICE/DEPARTMENT</p>
            <p class="ml-4 p-0"><b><?php echo $dept_arr[$department_id] ?></b></p>
        </div>
        <div class="col-sm-2 ">
            <p class="m-0 p-0">2. NAME:</p>

        </div>
        <div class="col-sm-2 ">
            <p class="m-0 p-0"> (Last)</small></p>
            <p class="m-0 p-0"><b><?php echo ucwords($lastname) ?></b></p>
        </div>
        <div class="col-sm-2 ">
            <p class="m-0 p-0"> (First)</small></p>
            <p class="m-0 p-0"><b><?php echo ucwords($firstname) ?></b></p>
        </div>
        <div class="col-sm-2 ">
            <p class="m-0 p-0"> (Middle)</small></p>
            <p class="m-0 p-0"><b><?php echo ucwords($middlename) ?></b></p>
        </div>
    </div>
    <div class="row border-top-0 border-bottom-0 border-left-1 border-right-1" style="border: 1px solid #000">
        <div class="col-sm-4 mb-1">
            <p class="mt-1 ml-0 mr-0 mb-0 p-0">3. DATE OF FILING: <span><input disabled="" type="text" class=" border-top-0 border-left-0 border-right-0 text-center" style="width: 50%; font-weight: bold;" value="<?php echo date("m-d-Y", strtotime($date_created));?>"></span></p>
<!--             <p class="m-0 p-0">3. DATE OF FILING:</p>
            <p class="m-0 p-0"><b><?php echo date("m-d-Y", strtotime($date_created));?></b></p> -->
        </div>
        <div class="col-sm-5 ">
            <p class="m-1 p-0">4. POSITION: <span><input disabled=""type="text" class=" border-top-0 border-left-0 border-right-0 text-center" style="width: 65%; font-weight: bold;" value="<?php echo $desg_arr[$designation_id] ?>"></span></p>
        </div>
        <div class="col-sm-3 ">
            <p class="m-1 p-0">5. SALARY: <span><input disabled=""type="text" class=" border-top-0 border-left-0 border-right-0 text-center" style="width: 50%; font-weight: bold;" value="<?php echo $salary ?>"></span></p>
        </div>
    </div>

    <div class="row ">
        <div class="col-sm-6 border-top-1 border-left-1 border-bottom-0 border-right-0" style="border: 1px solid #000">
            <p class="m-0 p-0">6.A TYPE OF LEAVE TO BE AVAILED OF</p>
            <div class="ml-2 px-1" style="text-align: justify-all;">
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" <?php if($lname == 'VL') { echo 'checked'; }?> value="">Vacation Leave <small>(Sec. 51, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</small></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name=""  value="" <?php if($lname == 'MFL') { echo 'checked'; }?>>Mandatory/Forced Leave <small>(Sec. 25, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</small></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" <?php if($lname == 'SL' || $lname == 'SC') { echo 'checked'; }?> value="">Sick Leave <small>(Sec. 43, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</small></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" <?php if($lname == 'ML') { echo 'checked'; }?> value="">Maternity Leave <small>(R.A. No. 11210 / IRR issued by CSC, DOLE and SSS)</small></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" <?php if($lname == 'PL') { echo 'checked'; }?> value="">Paternity Leave <small>(R.A. No. 8187 / CSC MC No. 71, s. 1998, as amended)</small></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" <?php if($lname == 'SPL') { echo 'checked'; }?> value="">Special Privilege Leave <small>(Sec. 21, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</small></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" <?php if($lname == 'SOLO') { echo 'checked'; }?> value="">Solo Parent Leave <small>(RA No. 8972 / CSC MC No. 8, s. 2004)</small></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" <?php if($lname == 'STUDY') { echo 'checked'; }?> value="">Study Leave <small>(Sec. 68, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</small></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" <?php if($lname == 'VAWC') { echo 'checked'; }?> value="">10-Day VAWC Leave <small>(RA No. 9262 / CSC MC No. 15, s. 2005)</small></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" <?php if($lname == 'RL') { echo 'checked'; }?> value="">Rehabilitation Privilege <small>(Sec. 55, Rule XVI, Omnibus Rules Implementing E.O. No. 292)</small></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" <?php if($lname == 'SLB') { echo 'checked'; }?> value="">Special Leave Benefits for Women <small>(RA No. 9710 / CSC MC No. 25, s. 2010)</small></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" <?php if($lname == 'SECL') { echo 'checked'; }?> value="">Special Emergency (Calamity) Leave <small>(CSC MC No. 2, s. 2012, as amended)</small></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" <?php if($lname == 'AL') { echo 'checked'; }?> value="">Adoption Leave <small>(R.A. No. 8552)</small></p><br>
                <p><i>Others:</i></p>
                <input disabled=""type="text" class="border-top-0 border-left-0 border-right-0 text-center" style="width: 80%; font-weight: bold;" value="<?php 
                    if($lname == 'COC' || $lname == 'MLC' ) 
                        {
                            echo isset($reason) ? $reason: ''; 
                        }
                    elseif($lname == 'LWOP') 
                        {
                            echo 'Leave without Pay'; 
                        } ?>" >
                <p></p>
            </div>                           
        </div>
            <?php
        $qry1 = $conn->query("SELECT * from `leave_applications` where id = '{$_GET['id']}' ");
    ?>
        <div class="col-sm-6 border-top-1 border-left-1 border-bottom-0" style="border: 1px solid #000">
            <p class="m-0 p-0">6.B DETAILS OF LEAVE</p>
            <div class="ml-2 px-1" style="text-align: justify-all;">
                <p class="m-0 p-0"><i>In case of Vacation/Special Privilege Leave:</i></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" value="" <?php if($option1 == '1') { echo 'checked'; }?>>Within the Philippines<input type="text" class=" border-top-0 border-left-0 border-right-0 mr-1" style="width: 60%; font-weight: bold;" disabled value="  <?php if($option1 == '1') {echo isset($reason) ? $reason: ''; }?>" ></p>
                <p>
                <input type="checkbox"  class="check_item mr-1" id="" name="" value="" <?php if($option1 == '2') { echo 'checked'; }?> >Abroad (Specify)<input type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 70%; font-weight: bold;" disabled value="  <?php if($option1 == '2') {echo isset($reason) ? $reason: ''; }?>" ></p>
                <p class="m-0 p-0"><i>In case of Sick Leave:</i></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" value="" <?php if($option1 == '3') { echo 'checked'; }?>>In Hospital (Specify Illness)<input disabled=""type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 55%; font-weight: bold;" value="  <?php if($option1 == '3') {echo isset($reason) ? $reason: ''; }?>"></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" value="" <?php if($option1 == '4') { echo 'checked'; }?> >Out Patient (Specify Illness)<input type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 55%; font-weight: bold;" value="  <?php if($option1 == '4') {echo isset($reason) ? $reason: ''; }?>" disabled ></p>
                <P class=" text-center"><input disabled=""type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 95%;"></p>
                <p class="m-0 p-0">  
                <i>In case of Special Leave Benefits for Women:</i></p>
                <p class="m-0 p-0">
                (Specify Illness)<input type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 80%; font-weight: bold;" value="  <?php if($option1 == '5') {echo isset($reason) ? $reason: ''; }?>" disabled ></p>
                <P class="text-center"><input disabled=""type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 100%;"></p>
                <p class="m-0 p-0"><i>In case of Study Leave:</i></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" value="" <?php if($option1 == '6') { echo 'checked'; }?>>Completion of Master's Degree</p>
                <p>
                <input type="checkbox"  class="check_item mr-1" id="" name="" value="" <?php if($option1 == '7') { echo 'checked'; }?>>BAR/Board Examination Review</p>
                <p class="m-0 p-0"><i>Other purpose:</i></p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" value="" <?php if($lname == 'MLC') { echo 'checked'; }?>>Monetization of Leave Credits</p>
                <p class="m-0 p-0">
                <input type="checkbox"  class="check_item mr-1" id="" name="" value="" <?php if($lname == 'TL') { echo 'checked'; }?>>Terminal Leave </p>
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-sm-6 border-top-1 border-left-1 border-bottom-0 border-right-0" style="border: 1px solid #000">         
            <p class="m-0 p-0">6.C. NUMBER OF WORKING DAYS APPLIED FOR</p>
             <div class="ml-2 px-1" style="text-align: justify-all;">
                <p class="m-0 p-0">
                <?php 
                if ($leave_days > 1):
                    { 
                        $day = 'days';
                    }
                else:
                    { 
                        $day = 'day';
                    }  
                endif; 
                 
                if ($leave_days == 0):
                    { 
                        $day = '';
                        $leave_days = '';
                    }
                endif;


                ?>    
                <b><input disabled=""type="text" class="border-top-0 border-left-0 border-right-0" style="width: 60%; text-align: center; font-weight: bold;" value="<?php echo $leave_days.' '.$day ?>  "></b></p>
                <p class="m-0 p-0">INCLUSIVE DATES</p>
                <p class="m-0 p-0"><input disabled=""type="text" class="border-top-0 border-left-0 border-right-0" style="width: 60%; text-align: center; font-weight: bold;" value="<?php
                 if($date_start == $date_end){
                    echo date("m-d-Y", strtotime($date_start));
                    }else{
                    echo date("m-d-Y", strtotime($date_start)).' - '.date("m-d-Y", strtotime($date_end));
                    }
                ?>"></p>
             </div>
        </div>
        <div class="col-sm-6 border-top-1 border-left-1 border-bottom-0 border-right-1" style="border: 1px solid #000">
            <p class="m-0 p-0">6.D COMMUTATION</p>
            <div class="ml-2 px-1" style="text-align: justify-all;">
                <p class="m-0 p-0">
                <input disabled=""type="checkbox"  class="check_item mr-1" id="" name="" value="">Not Requested</p>
                <p class="m-0 p-0">
                <input disabled=""type="checkbox"  class="check_item mr-1" id="" name="" value="">Requested</p>
                <p class="m-0 p-0 text-center">
                <input disabled=""type="text" class="border-top-0 border-left-0 border-right-0" style="width: 70%;"></P>
                <p class="m-0 p-0 text-center">(Signature of Applicant)</p>    
            </div>    
        </div>    
    </div>   
    <div class="row">
        <div class="col-sm-12 border-top-1 border-left-1 border-bottom-0 border-right-1" style="border: 1px solid #000">  
            <h6 class="text-center m-0 p-0">7. DETAILS OF ACTION ON APPLICATION</h6>
        </div>
    </div>           
    <div class="row">
        <div class="col-sm-6 border-top-1 border-left-1 border-bottom-0 border-right-0" style="border: 1px solid #000">         
            <p class="m-0 p-0">7.A CERTIFICATION OF LEAVE CREDITS</p>
            <p class="text-center  p-0">As of<input disabled=""type="text" class="border-top-0 border-left-0 border-right-0" style="width: 50%;"></p>
  
                <table class="table-responsive">
                  <thead>
                    <tr>
                      <td scope="col" class="col-sm-2 my-0 py-0"style="border: 1px solid #000"></td>
                      <td scope="col" class="col-sm-2 text-center my-0 py-0 "style="border: 1px solid #000">Vacation Leave</td>
                      <td scope="col" class="col-sm-2 text-center my-0 py-0 "style="border: 1px solid #000">Sick Leave</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td scope="row"  class="my-0 py-0"style="border: 1px solid #000">Total Earned</td>
                      <td class="text-center my-0 py-0"style="border: 1px solid #000"></td>
                      <td class="text-center my-0 py-0"style="border: 1px solid #000"></td>
                    </tr>
                    <tr>
                      <td scope="row"  class="my-0 py-0"style="border: 1px solid #000">Less this application</td>
                      <td class="text-center my-0 py-0"style="border: 1px solid #000"></td>
                      <td class="text-center my-0 py-0"style="border: 1px solid #000"></td>  
                    </tr>
                    <tr>
                      <td scope="row"  class="my-0 py-0"style="border: 1px solid #000">Balance</td>
                      <td class="text-center my-0 py-0"style="border: 1px solid #000"></td>
                      <td class="text-center my-0 py-0"style="border: 1px solid #000"></td>                              
                    </tr>
                  </tbody>
                </table><br>
            <p class="text-center m-0 p-0"><input disabled=""type="text" class="text-center border-top-0 border-left-0 border-right-0" style="width: 50%; font-weight: bold;" value="<?php echo $_settings->info('hrmo') ?>" ></p>
            <p class="text-center m-0 p-0"><input disabled=""type="text" class="text-center border-0" style="width: 50%;" value="Administrative Officer IV" ></p>
            <p class="text-center m-0 p-0">(Authorized Officer)</p>
           


 
        </div>
        <div class="col-sm-6 border-top-1 border-left-1 border-bottom-0 border-right-1" style="border: 1px solid #000">
            <p class="m-0 p-0">7.B RECOMMENDATION</p>
            <div class="ml-2 px-1" style="text-align: justify-all;">
                <p class="m-0 p-0">
                <input disabled=""type="checkbox" class="check_item mr-1" id="" name="" value="">For approval</p>
                <p class="m-0 p-0">
                <input disabled=""type="checkbox" class="check_item mr-1" name="" value="">For disapproval due to
                <span><input disabled=""type="text" class="border-top-0 border-left-0 border-right-0" style="width: 60%;"></span></P>
                <p class="text-center m-0 p-0"><input disabled=""type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 85%;"></p>
                <p class="text-center m-0 p-0"><input disabled=""type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 85%;"></p>
                <p class="text-center"><input disabled=""type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 85%;"></p><br>
                <p class="text-center m-0 p-0"><input disabled=""type="text" class="text-center border-top-0 border-left-0 border-right-0" style="width: 60%; font-weight: bold;" value="<?php if($designation_id == '6') { 
                        echo $dept_psds_arr[$department_id];
                    }else{
                        echo $dept_mgr_arr[$department_id];
                        //echo $manage_arr[$department_id];
                        // echo isset($manage_arr['manager']) ? $manage_arr['manager'] : 'N/A';

                    }
                    ?>"
                ></p>

                <p class="text-center m-0 p-0"><input disabled=""type="text" class="text-center border-0" style="width: 60%;" value="<?php if($designation_id == '6') { 
                        echo "Public Schools District Supervisor";
                    }else{
                        echo "School Head";
                    }
                    ?>" ></p>
                <p class="text-center">(Authorized Officer)</p>   
            </div>    
        </div>    
    </div>   
    <div class="row" style="border: 1px solid #000">
        <div class="col-sm-6" >         
            <p class="m-0 p-0">7.C APPROVED FOR:</p>
            <div class="ml-2 px-1" style="text-align: justify-all;">
                <p class="m-0 p-0">
                <input disabled=""type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 25%;">days with pay</p>
                <p class=" m-0 p-0"><input disabled=""type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 25%;">days without pay</p>
                <p class=" m-0 p-0"><input disabled=""type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 25%;">others (Specify)</small></p>
            </div>    
        </div>
        <div class="col-sm-6" >
            <p class=" m-0 p-0">7.D DISAPPROVED DUE TO:</p>
            <p class="text-center m-0 p-0"><input disabled=""type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 85%;"></p>
            <p class="text-center m-0 p-0"><input disabled=""type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 85%;"></p>
            <p class="text-center"><input disabled=""type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 85%;"></p>    
        </div>

        <div class="col-sm-12 mt-4" >         
            <p class="text-center m-0 p-0">
                <input disabled=""type="text" class="text-center border-top-0 border-left-0 border-right-0" style="width: 30%; font-weight: bold;" 
                value="<?php if($leave_days > 30) { 
                    echo $_settings->info('sds');
                }else{
                    echo $_settings->info('asds');
                }
                ?>"
                ></p>
                

            <p class="text-center m-0 p-0">
                <input disabled=""type="text" class="text-center border-0" style="width: 60%;" value="<?php if($leave_days > 30) { 
                    echo "Schools Division Superintendent";
                }else{
                    echo "Assistant Schools Division Superintendent";
                }
                ?>" ></p>
            <p class="text-center">(Authorized Officer)</p>

        </div> 

    </div>

<!-- ////////////end of page 1////////////////// -->
<div class="container-fluid mt-2 border-0" style="font-size: 14px">
    <div class="row">
        <div class="col-sm-12 mt-4" style="border: 1px solid #000">  
            <h6 class="text-center m-0 p-0">INSTRUCTIONS AND REQUIREMENTS</h6>
        </div>
    </div> 
    <div class="row">
        <div class="col-sm-6 mt-3" >
            <div>
                <ol class="list-group list-group-numbered">
                  <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <p class="m-0 p-0" style="text-align: justify;">Application for any type of leave shall be made on this Form and <u><b>to be
                        accomplished at least in duplicate</b></u> with documentary requirements, as
                        follows</p>
                      <div class="fw-bold mt-1"><b>1. Vacation leave*</b></div>
                        <p class="m-0 p-0 ml-3" style="text-align: justify;">It shall be filed five (5) days in advance, whenever possible, of the
                        effective date of such leave. Vacation leave within in the Philippines or
                        abroad shall be indicated in the form for purposes of securing travel
                        authority and completing clearance from money and work
                        accountabilities.</p> 
                      <div class="fw-bold mt-1"><b>2. Mandatory/Forced leave*</b></div>
                        <p class="m-0 p-0 ml-3" style="text-align: justify;">Annual five-day vacation leave shall be forfeited if not taken during the year. In case the scheduled leave has been cancelled in the exigency of the service by the head of agency, it shall no longer be deducted from the accumulated vacation leave. Availment of one (1) day or more Vacation Leave (VL) shall be considered for complying the mandatory/forced leave subject to the conditions under Section 25, Rule XVI of the Omnibus Rules Implementing E.O. No. 292.</p>  
                      <div class="fw-bold mt-1"><b>3. Sick leave*</b></div>
                        <ul>
                            <li class="m-0 p-0" style="text-align: justify;">It shall be filed immediately upon employee's return from such leave.</li>
                            <li class="m-0 p-0" style="text-align: justify";>If filed in advance or exceeding five (5) days, application shall be accompanied by a <u>medical certificate</u>. In case medical consultation was not availed of, an <u>affidavit</u> should be executed by an applicant.</li>
                        </ul>
                      <div class="fw-bold mt-1"><b>4. Maternity leave* – 105 days</b></div>
                        <ul>
                            <li class="m-0 p-0" style="text-align: justify";>Proof of pregnancy e.g. ultrasound, doctor’s certificate on the
                            expected date of delivery</li>
                            <li class="m-0 p-0" style="text-align: justify";>Accomplished Notice of Allocation of Maternity Leave Credits (CS
                            Form No. 6a), if needed</li>
                            <li class="m-0 p-0" style="text-align: justify";>Seconded female employees shall enjoy maternity leave with full pay in the recipient agency.</li>
                        </ul>
                      <div class="fw-bold mt-1"><b>5. Paternity leave – 7 days</b></div>
                        <p class="ml-3 m-0 p-0" style="text-align: justify;">Proof of child’s delivery e.g. birth certificate, medical certificate and marriage contract</p> 
                      <div class="fw-bold mt-1"><b>6. Special Privilege leave – 3 days</b></div>
                        <p class="ml-3 m-0 p-0" style="text-align: justify;">It shall be filed/approved for at least one (1) week prior to availment, except on emergency cases. Special privilege leave within the Philippines or abroad shall be indicated in the form for purposes of securing travel authority and completing clearance from money and work accountabilities.</p>  
                      <div class="fw-bold mt-1"><b>7. Solo Parent leave – 7 days</b></div>
                        <p class="ml-3 m-0 p-0" style="text-align: justify;">It shall be filed in advance or whenever possible five (5) days before going on such leave with updated Solo Parent Identification Card.</p> 
                      <div class="fw-bold mt-1"><b>8. Study leave* – up to 6 months</b></div>
                        <ul>
                            <li class="m-0 p-0" style="text-align: justify;">Shall meet the agency’s internal requirements, if any;</li>
                            <li class="m-0 p-0" style="text-align: justify";>Contract between the agency head or authorized representative and the employee concerned.</li>
                        </ul> 
                      <div class="fw-bold mt-1"><b>9. VAWC leave – 10 days</b></div>
                        <ul >
                            <li class="m-0 p-0" style="text-align: justify;">It shall be filed in advance or immediately upon the woman employee’s return from such leave.</li>
                            <li class="m-0 p-0" style="text-align: justify";>Contract between the agency head or authorized representative and the employee concerned.</li>
                            <ol start="a" type="a">
                                <li class="m-0 p-0" style="text-align: justify";>Barangay Protection Order (BPO) obtained from the barangay;</li>
                                <li class="m-0 p-0" style="text-align: justify";>Temporary/Permanent Protection Order (TPO/PPO) obtained from the court;</li>
                                <li class="m-0 p-0" style="text-align: justify";>If the protection order is not yet issued by the barangay or the court, a certification issued by the Punong Barangay/Kagawad or Prosecutor or the Clerk of Court that the application for the BPO, TPO or PPO has been filed with the said office shall be sufficient to support the application for the ten-day leave; or</li>
                            </ol>
                        </ul>  
                    </div>  
                  </li>
                </ol>
            </div>  
        </div>
        <div class="col-sm-6 mt-3" >
            <div>
                <ol class="list-group list-group-numbered">
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div class="ms-2 me-auto">
                            <div class="row">
                                <div class="col-sm-2 text-right m-0 p-0" >  
                                    <p>d. </p>
                                </div>
                                <div class="col-sm-10" >  
                                    <p class="ml-1" style="text-align: justify;">In the absence of the BPO/TPO/PPO or the certification, a police report specifying the details of the occurrence of violence on the victim and a medical certificate may be considered, at the discretion of the immediate supervisor of the woman employee concerned.</p>
                                </div>
                            </div> 
                            <div class="fw-bold"><b>10. Rehabilitation leave* – up to 6 months</b></div>
                            <ul>
                                <li style="text-align: justify;">Application shall be made within one (1) week from the time of the accident except when a longer period is warranted.</li>
                                <li style="text-align: justify;">Letter request supported by relevant reports such as the police report, if any</li>
                                <li style="text-align: justify;">Medical certificate on the nature of the injuries, the course of treatment involved, and the need to undergo rest, recuperation, and rehabilitation, as the case may be.</li>
                                <li style="text-align: justify;">Written concurrence of a government physician should be obtained relative to the recommendation for rehabilitation if the attending physician is a private practitioner, particularly on the duration of the period of rehabilitation</li>
                            </ul> 
                            <div class="fw-bold mt-1"><b>11. Special leave benefits for women* – up to 2 months</b></div>
                            <ul>
                                <li style="text-align: justify;">The application may be filed in advance, that is, at least five (5) days prior to the scheduled date of the gynecological surgery that will be undergone by the employee. In case of emergency, the application for special leave shall be filed immediately upon employee’s return but during confinement the agency shall be notified of said surgery.</li>
                                <li style="text-align: justify;">The application shall be accompanied by a medical certificate filled out by the proper medical authorities, e.g. the attending surgeon accompanied by a clinical summary reflecting the gynecological disorder which shall be addressed or was addressed by the said surgery; the histopathological report; the operative technique used for the surgery; the duration of the surgery including the perioperative period (period of confinement around surgery); as well as the employees estimated period of recuperation for the same.</li>
                            </ul> 
                            <div class="fw-bold mt-1"><b>12. Special Emergency (Calamity) leave – up to 5 days</b></div>
                            <ul>
                                <li style="text-align: justify;">The special emergency leave can be applied for a maximum of five (5) straight working days or staggered basis within thirty (30) days from the actual occurrence of the natural calamity/disaster. Said privilege shall be enjoyed once a year, not in every instance of calamity or disaster.</li>
                                <li style="text-align: justify;">The head of office shall take full responsibility for the grant of special emergency leave and verification of the employee’s eligibility to be granted thereof. Said verification shall include: validation of place of residence based on latest available records of the affected employee; verification that the place of residence is covered in the declaration of calamity area by the proper government agency; and such other proofs as may be necessary.</li>
                            </ul> 
                            <div class="fw-bold mt-1"><b>13. Monetization of leave credits</b></div>
                                <p class="ml-3" style="text-align: justify;">Application for monetization of fifty percent (50%) or more of the accumulated leave credits shall be accompanied by letter request to the head of the agency stating the valid and justifiable reasons</p> 
                            <div class="fw-bold"><b>14. Terminal leave*</b></div>
                                <p class="ml-3" style="text-align: justify;">Proof of employee’s resignation or retirement or separation from the service.</p>
                            <div class="fw-bold"><b>15. Adoption Leave</b></div>
                            <ul>
                                <li style="text-align: justify;">Application for adoption leave shall be filed with an authenticated copy of the Pre-Adoptive Placement Authority issued by the Department of Social Welfare and Development (DSWD).</li>
                            </ul>             
                        </div>    
                    </li>      
                </ol>        
            </div>            
        </div>
        <div class="row">
        <div class="col-sm-12" >  
            <P class="text-left mx-4 px-4"><input disabled=""type="text" class=" border-top-0 border-left-0 border-right-0" style="width: 30%;"></p>
            <small></small><p class="mx-4 px-4">* For leave of absence for thirty (30) calendar days or more and terminal leave, application shall be accompanied by a <u>clearance from money, property and work-related accountabilities</u> (pursuant to CSC Memorandum Circular No. 2, s. 1985).</p></small>
        </div>
    </div> 
</div>
</div>
    <!-- <div class="w-100 d-flex justify-content-end my-2">
        <a type="button" class="btn btn-danger" href="?page=leave_applications">Cancel</a>
        <a href="javascript:void(0)" type="button" class="btn btn-success ml-3"  id="print"><span class="fas fa-print"></span>  Print</a>
    </div> -->
</tbody>
<script>
    $(function(){
        $('#print').click(function(){
            start_loader()
            var _h = $('head').clone()
            var _p = $('#print_out').clone();
            var _el = $('<div>')
            _el.append(_h)
            _el.append('<style>html, body, .wrapper {min-height: unset !important;}.btn{display:none !important}</style>')
            _p.prepend('<div class="d-flex mb-3 w-100 align-items-center justify-content-center">'+
            '<div class="col-sm-3 text-center">'+ 
            `<p class="text-left m-0 p-0"><small><i>Civil Service Form No. 6<i></small></p>`+   
            `<p class="text-left m-0 p-0"><small><i>Revised 2020<i></small></p>`+  
            '<img class="text-right mx-5" src="<?php echo validate_image($_settings->info('logo')) ?>" width="100px" height="100px"/>'+
            '</div>'+
            '<div class="col-sm-6">'+
            `<br>`+
            '<h6 class="text-center m-0 p-0">Republic of the Philippines</h>'+
            '<h5 class="text-center m-0 p-0"><?php echo $_settings->info('name') ?></h5>'+
            '<h5 class="text-center m-0 p-0">SCHOOLS DIVISION OF SORSOGON CITY</h5>'+
            '<h6 class="text-center m-0 p-0">City Hall Compound, Cabid-an, Sorsogon City</h6>'+
            '<h5 class="text-center m-0 p-0">APPLICATION FOR LEAVE</h5>'+
            '</div>'+
            '<div class="col-sm-3">'+
            `<p class="text-center border m-1 p-1"><small><i>Stamp of Date of Receipt
                <i></small></p>`+ 
            '</div>'+
            '</div><hr/>');
            _el.append(_p)
            var nw = window.open("","_blank","width=1200,height=1200")
                nw.document.write(_el.html())
                nw.document.close()
                setTimeout(() => {
                    nw.print()
                    setTimeout(() => {
                        nw.close()
                        end_loader()
                    }, 300);
                }, 500);
        })
    });
</script>