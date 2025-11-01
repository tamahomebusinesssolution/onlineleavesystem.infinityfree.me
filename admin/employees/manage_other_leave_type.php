<?php require_once('../../config.php'); ?>
<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
    $qry = $conn->query("SELECT * from `users` where id = '{$_GET['id']}' ");    
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
        <form action="" id="other_leave_credit">

            <input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">
            
            <div class="row">
                <div class="col-4">
                    <?php if($_settings->userdata('type') != 3): ?>
                        <?php else: ?>
                            <input type="hidden" name="user_id" value="<?php echo $_settings->userdata('id') ?>">
                        <?php endif; ?>


                        <div class="form-group">
                            <label for="date_added" class="control-label">Date Created</label>
                            <input type="date" id="date_added" class="form-control form" required name="date_added" value="<?php echo isset($date_added) ? date("Y-m-d",strtotime($date_added)) : '' ?>" readonly >
                        </div>
                </div>  

                    <div class="col-4">
                        <form action="" id="update-option1-form">
                            <input type="hidden" name ="id" value="<?php echo isset($id) ? $id : '' ?>">

                            <div class="form-group">
                                <label for="vl_total" class="control-label"> Forward Balance</label>
                                <input type="" id="vl_total" class="form-control form" name="vl_total" value="<?php echo isset($vl_total) ? round($vl_total,3) : 0 ?>" readonly >
                            </div>
                            
                    </div>    
                        <div class="col-4">             
                            <div class="form-group">
                                <label for="sl_total" class="control-label">Forward Balance</label>
                                <input type="" id="sl_total" onchange = sum($x, $y); class="form-control form" name="sl_total" value="<?php echo isset($sl_total) ? round($sl_total,3) : 0 ?>" readonly >
                            </div>
                        </div>    
            </div>
            <?php
                $currentDateTime = date('Y-m-d H:i:s');
                $date_current = $currentDateTime;
                // $date_updated = $date_current; 
            ?> 
            <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="date_updated" class="control-label">Last UpDate</label>
                                <input type="date" id="date_updated"  class="form-control form" required name="date_updated" value="<?php echo isset($date_updated) ? date("Y-m-d",strtotime($date_updated)) : '' ?>"  >
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="vl_current" class="control-label"> Vacation Leave</label>
                                <input type="" id="vl_current" class="form-control form" name="vl_current" value="<?php echo isset($vl_current) ? round($vl_current,3) : 0 ?>" readonly >
                            </div>
                        </div>
                        <div class="col-4">             
                            <div class="form-group">
                                <label for="sl_current" class="control-label">Sick Leave</label>
                                <input type="" id="sl_current" onchange = sum($x, $y); class="form-control form" name="sl_current" value="<?php echo isset($sl_current) ? round($sl_current,3) : 0 ?>" readonly >
                            </div>
                        </div> 
                        <!-- <div class="col-4">
                            <div class="form-group">
                                <label for="vl_total" class="control-label"> Force Leave</label>
                                <?php $tl_vl_allow = $vl_total + $vl_current; ?>
                                <p><?php echo isset($tl_vl_allow) ? round($tl_vl_allow,3) : 0 ?></p>
                            </div>
                        </div> -->
            </div>
<!--                         <div class="col-4">
                            <div class="form-group">
                                <label for="vl_total" class="control-label"> Total Vacation</label>
                                <?php $tl_vl_allow = $vl_total + $vl_current; ?>
                                 <p><?php echo isset($tl_vl_allow) ? round($tl_vl_allow,3) : 0 ?></p> -->
                                <!-- <p><?php echo isset($tl_vl_allow) ? round($tl_vl_allow,3) : 0 ?></p> -->

            <!-- <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="date_current" class="control-label">Current Date</label>
                        <p type="date" id="date_current" onclick = sum($x, $y); class="form-control form" required name="date_current" value="<?php echo isset($date_current) ? date("Y-m-d",strtotime($date_current)) : '' ?>"  >Click me.</p>
                    </div>
                </div>
            </div>  -->                   
       
                        
                    
        </form>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-primary" id='submit' onclick="$('#uni_modal form').submit()">Update</button>
    <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
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

    function calc_days( days, start, end ){
        $days = 0;
        if($('#date_added').val() != ''){
            $start = new Date($('#date_added').val());
            $end = new Date($('#date_updated').val());
            $diffDate = (($end - $start) / (1000 * 60 * 60 * 24))+1;
            // $diffDate = (((($end - $start) / (1000 * 60 * 60 * 24 ))+1)/(365/12));
            $days = Math.round($diffDate);

            ///////////////////////////////////
            // ////////////////////////////////
            // $date1 = '2000-01-25';
            // $date2 = '2010-02-20';
            // $d1=new DateTime($date2); 
            // $d2=new DateTime($date1);                                  
            // $Months = $d2->diff($d1); 
            // $howeverManyMonths = (($Months->y) * 12) + ($Months->m);
 /////////////////////////////////
        }       

        // $('#vl_current').val($days * 0.0273972602739726);
        $('#sl_current').val($days * 0.0410958904109589);
        $('#vl_current').val($days * 0.0410958904109589);

    }


    $(document).ready(function(){

        $('.select2').select2();
        $('.select2-selection').addClass('form-control rounded-0')
        $('#type').change(function(){
            if($(this).val() == 2){
            console.log($(this).val())
                // $('#vlBeg').val('.5')
                $('#date_updated').attr('required',false)
                $('#date_updated').val($('#date_added').val())
                
                $('#date_updated').closest('.form-group').hide('fast')
            }else{
                $('#date_updated').attr('reqiured',true)
                $('#date_updated').closest('.form-group').show('fast')

                // $('#vlBeg').val(1)
                // $('#vl_current').val(0.833)
                // $('#sl_current').val(1.25)
            }
            calc_days()

        })
        $('#date_added, #date_updated, #tl_vl_allow').change(function(){
                calc_days();
                
        })



    })

<!-- /////  settings ///// -->



    function check_selected(){
        var count_item = $('input.check_item').length
        var checked_item = $('input.check_item:checked').length
        if(count_item == checked_item){
            $('#selectAll').attr('checked',true)
        }else{
            $('#selectAll').attr('checked',false)
        }
    }
    $(function(){
        $('input.check_item').each(function(){
            if($(this).is(':checked') == false){
                $(this).closest('tr').find('input[name="leave_credit[]"]').attr('disabled',true)
            }
            check_selected()
        })
        $('input.check_item').change(function(){
            if($(this).is(':checked') == true){
                $(this).closest('tr').find('input[name="leave_credit[]"]').attr('disabled',false)
            }else{
                $(this).closest('tr').find('input[name="leave_credit[]"]').attr('disabled',true)
            }
            check_selected()
        })
        $('#selectAll').change(function(){
            if($(this).is(':checked') == true){
                $('input.check_item').attr('checked',true).trigger('change')
            }else{
                $('input.check_item').attr('checked',false).trigger('change')
            }
        })

        $('#other_leave_credit').submit(function(e){
            e.preventDefault();
            var _this = $(this)
            start_loader()

            $.ajax({
                url:_base_url_+'classes/Master.php?f=save_other_credit',
                method:'POST',
                data:$(this).serialize(),
                dataType:'json',
                error:err=>{
                    console.log(err)
                    alert_taost(' An error occured while saving the data','error')
                    end_loader()
                },
                success:function(resp){
                    if(resp.status == 'success'){
                        location.reload()
                    }else if(resp.status == 'failed' && !!resp.msg){
                        var el = $('<div>')
                            el.addClass("alert alert-danger err-msg").text(resp.msg)
                            _this.prepend(el)
                            el.show('slow')
                            $("html, body").animate({ scrollTop: 0 }, "fast");
                    }else{
                        alert_toast("An error occured",'error');
                        console.log(resp)
                    }
                    end_loader()
                }
            })
        })
    })
</script>