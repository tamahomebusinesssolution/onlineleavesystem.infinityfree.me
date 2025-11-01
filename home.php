 <!-- Header-->
 <header class="bg-dark py-5 d-flex align-items-center" id="main-header">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder"><?php echo $_settings->info('name') ?></h1>
            <p class="lead fw-normal text-white-50 mb-0 mt-4"><a class="btn btn-default btn-lg bg-lightblue" href='<?php echo base_url.'admin' ?>'>Login</a></p>
        </div>
    </div>
</header>
<!-- Section-->
<style>
    .book-cover{
        object-fit:contain !important;
        height:auto !important;
    }
    a[class="btn btn-default btn-lg bg-lightblue"]:hover {
    color:#FFF;
    background-color:#4983b4;
    background-image:linear-gradient(#4983b4,#245B8A);
}
</style>
<section class="py-3">
    <div class="container px-4 px-lg-5 mt-5">
        <?php require_once('about.html') ?>
    </div>
</section>
<script>
              // Disable right-click
document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
}); 
</script>