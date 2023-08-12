 <?php
  $abt  = obj($context->about);
  $content = isset($abt->content)?$abt->content:null; 
        $banner = isset($abt->banner)?$abt->banner:null;
  ?>
 <!-- ======= About Section ======= -->
 <section id="about" class="about">

   <div class="container" data-aos="fade-up">
     <div class="row gx-0">

       <div class="col-lg-6 align-items-center d-flex" data-aos="fade-up" data-aos-delay="200">
       <img src="/<?php echo home.img_or_null($banner); ?>" class="img-fluid" alt="">
       </div>
       <div class="col-lg-6 align-items-center d-flex" data-aos="fade-up" data-aos-delay="200">
        <?php echo $content; ?>
       </div>

       <!-- <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
         <img src="/<?php echo home.img_or_null($banner); ?>" class="img-fluid" alt="">
       </div> -->

     </div>
   </div>

 </section>
 <!-- End About Section -->