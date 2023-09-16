  <?php
  $hero =  $context;
  ?>
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="hero d-flex align-items-center">

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
          <?php
          $slider = new Dbobjects();
          $slider->tableName = "pk_user";
          $sldrqry['user_group'] = "user";
          $sldrqry['is_active'] = 1;
          if (!is_superuser()) {
            if (USER && USER['gender'] == 'f') {
              $sldrqry['gender'] = 'm';
            } else if (USER && USER['gender'] == 'm') {
              $sldrqry['gender'] = 'f';
            }
          }
          $slides = $slider->filter(assoc_arr: $sldrqry, limit: 20, ord: "RAND()");
          if (count($slides) > 0) {
            $context = new stdClass;
            $context->sliders = $slides;
            import('apps/view/components/common/sliders/slider-home-users.php',$context);
          } else {
            import('apps/view/components/common/sliders/slider-home.php');
          }
          ?>
          <?php  ?>
          <!-- <img src="/<?php echo STATIC_URL; ?>/view/assets/img/hero-img.png" class="img-fluid" alt=""> -->
        </div>
        <div class="col-lg-6 d-flex flex-column justify-content-center">
          <h1 data-aos="fade-up"><?php echo lang('home')->search_title; ?></h1>
          <h2 data-aos="fade-up" data-aos-delay="400">
            <!-- Forget everything that others told you. Find the perfect life partner that you know you deserve -->
            <?php echo lang('home')->search_desc; ?>
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