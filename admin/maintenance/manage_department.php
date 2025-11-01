<?php
if(isset($_GET['id']) && $_GET['id'] > 0){
  // require_once('../../config.php');
    $qry = $conn->query("SELECT * from `department_list` where id = '{$_GET['id']}' ");
    if($qry->num_rows > 0){
        foreach($qry->fetch_assoc() as $k => $v){
            $$k=$v;
        }
    }
}
 
?>
<link href='//fonts.googleapis.com/css?family=Lato:400,300,100,700,900' rel='stylesheet' type='text/css'>
<style>
    .select2-container--default .select2-selection--single{
    height:calc(2.25rem + 2px) !important;
  }
    html {
    /*background: #22324a;*/
}

body {
    /*background: #22324a;*/
    position: relative;
    /*cursor: url('https://ionicframework.com/img/finger.png'), auto; */   
    font-family: 'Lato', sans-serif;
    display: none;
}

h1, h2, h3, h4, h5, p, a, div, span, small {
    font-family: 'Lato', sans-serif;
}

#container {
    overflow: hidden;
    width: 375px;
    height: 600px;
    /*background: -webkit-linear-gradient(345deg, #2b4488, #a7b5cb);*/
    background: linear-gradient(345deg, #2b4488, #a7b5cb);    
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    -webkit-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    border-radius: 2%;
}

.card {
    height: 450px;
    margin: 0 auto;
    margin-left: 2.5%;
    margin-right: 2.5%;
    width: calc(100% - 5%);
    border-radius: 9px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.3);
    margin-top: 90px;
    overflow: hidden;
    z-index: 5;
    position: relative;
}

.card_top, .info .right small, .info .left .wrapper {
    position: absolute;
    top: 5%;
    left: 50%;
    transform: translate(-50%,-50%);
    -webkit-transform: translate(-50%,-50%);
    -ms-transform: translate(-50%,-50%);
    width: 100%;
    text-align: center;
}

span.text {
    color: #fff;
    font-weight: 100;
    font-size: 12px;
}

@-webkit-keyframes fadeOut {
  0% {
    opacity: 1;
  }

  100% {
    opacity: 0;
  }
}
@keyframes fadeOut {
  0% {
    opacity: 1;
  }

  100% {
    opacity: 0;
  }
}



</style>
<?php if($_settings->userdata('type') == 8 || $_settings->userdata('type') == 1){ ?>

<body>
    <div id="container">
        <div id="cards">
            <div class="cards_container">
                <div class="card_top">
                      <!-- <h3 class="card-title"><?php echo isset($id) ? "Update ": "Create New " ?> Leave</h3> -->
                    <h3 class="title"><?php echo isset($id) ? "Update ": "Create New " ?>Department</h3> 
                    <div class="border"></div>
                  </div>
                  <div class="card">
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
                            <label for="manager" class="control-label">Department Head</label>
                            <select name="manager" id="manager" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Employee here" reqiured>
                                <option value="" disabled <?php echo !isset($manager) ? 'selected' : '' ?>></option>
                            <?php 

                            $emp_qry = $conn->query("SELECT u.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as `lfname`,m.meta_value FROM `users` u inner join `employee_meta` m on u.id = m.user_id where m.meta_field='employee_id' order by `lfname` asc");
                            while($row = $emp_qry->fetch_assoc()):
                            ?>
                            <option value="<?php echo $row['lfname'] ?>" <?php echo (isset($manager) && $manager == $row['lfname']) ? 'selected' : '' ?>><?php echo "[".$row['meta_value']."] ".$row['lfname'] ?></option>
                        <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="supervisor" class="control-label">Supervisor</label>
                            <select name="supervisor" id="supervisor" class="form-control select2bs4 select2 rounded-0" data-placeholder="Please Select Supervisor here" reqiured>
                            <option value="" disabled <?php echo !isset($supervisor) ? 'selected' : '' ?>></option>
                        <?php 

                        $emp_qry = $conn->query("SELECT u.*,concat(u.lastname,', ',u.firstname,' ',u.middlename) as `lfname`,m.meta_value FROM `users` u inner join `employee_meta` m on u.id = m.user_id where m.meta_field='employee_id' order by `lfname` asc");
                        while($row = $emp_qry->fetch_assoc()):
                        ?>
                            <option value="<?php echo $row['lfname'] ?>" <?php echo (isset($supervisor) && $supervisor == $row['lfname']) ? 'selected' : '' ?>><?php echo "[".$row['meta_value']."] ".$row['lfname'] ?></option>
                        <?php endwhile; ?>
                            </select>
                        </div>

                        </form>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-sm btn-primary" form="department-form">Save</button>
                        <a class="btn btn-sm btn-danger" href="?page=maintenance/department">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php }else{ ?>
    <?php include '404.html'; ?>
<?php } ?>
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
            // location.reload();
            location.href = "./?page=maintenance/department";
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
    var $window = $(window);

$('body').fadeIn('fast');

function getWidth() {
    $('body').css({
        height: $window.height(),
        width: $window.width(),
    });   
}

function go(){
    $('#cards').owlCarousel({
        loop:false,
        items:1,
        margin:10,
        nav:false
    });
    
    (function($) {
        $.fn.clickToggle = function(func1, func2) {
            var funcs = [func1, func2];
            this.data('toggleclicked', 0);
            this.click(function() {
                var data = $(this).data();
                var tc = data.toggleclicked;
                $.proxy(funcs[tc], this)();
                data.toggleclicked = (tc + 1) % 2;
            });
            return this;
        };
    }(jQuery));    
    
    $('.card').each(function(){
        var that = $(this);
        var b = that.find('.bg-img');
        var o = that.find('.overlay');
        
        var r = that.find('.info .right');
        var l = that.find('.info .left');
        var tl = new TimelineMax();        
        
        
        var tween1 = TweenMax.to(that, 0.35, {height:600, margin:0, width:'100%', background:'#fff', borderRadius:0, ease: Expo.easeInOut, y: 0 });
        var tween2 = TweenMax.to(b, 0.35, {borderRadius:0, ease: Expo.easeInOut, y: 0 });
        var tween3 = TweenMax.to(o, 0.35, {borderRadius:0, ease: Expo.easeInOut, y: 0 });
        
        var tween4 = TweenMax.to(r, 0.35, {width:'100%', height:'100px', ease: Expo.easeInOut });
        var tween5 = TweenMax.to(l, 0.35, {width:'100%', height:'100px', ease: Expo.easeInOut });
        
        tween1.pause();
        tween2.pause();
        tween3.pause();    
        tween4.pause();
        tween5.pause();
        
        $(that).clickToggle(function() {   
            tween1.play();
            tween2.play();
            tween3.play();
            tween4.play();
            tween5.play();
        },
        function() {
            tween1.reverse();
            tween2.reverse();
            tween3.reverse();
            TweenMax.to(r, 0.35, {width:'30%', height:'132px', ease: Expo.easeInOut });
            TweenMax.to(l, 0.35, {width:'70%', height:'132px', ease: Expo.easeInOut });
            
        });        
    });
    
    $('body').on('swipe',function(){
        $('.card').click(false);
        tween1.reverse();
        tween2.reverse();
        tween3.reverse(); 
    });      
};

go();
getWidth();
$window.resize(getWidth);



</script>