  <?php 
  $hero =  $context;
  ?>
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center">

    <div class="container-fluid">
      <div class="row">
      <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
        <?php import('apps/view/components/common/sliders/slider-home.php'); ?>
          <!-- <img src="/<?php echo STATIC_URL; ?>/view/assets/img/hero-img.png" class="img-fluid" alt=""> -->
        </div>
        <div class="col-lg-6 d-flex flex-column justify-content-center">
          <h1 data-aos="fade-up">Find your life partners</h1>
          <h2 data-aos="fade-up" data-aos-delay="400">
          <!-- Forget everything that others told you. Find the perfect life partner that you know you deserve -->
          Our advanced matching algorithms use a combination of preferences and personality traits to suggest potential matches that are truly compatible with you
          </h2>
          <div data-aos="fade-up" data-aos-delay="600">
            <div class="text-center text-lg-start mt-2">
              <?php import('apps/view/components/common/forms/search-partner.php'); ?>
            </div>
          </div>
        </div>
        
      </div>
    </div>

  </section>
  <!-- End Hero -->