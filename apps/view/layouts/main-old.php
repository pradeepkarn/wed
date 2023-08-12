<?php
$default_meta = (object) array('title' => 'Home', 'description' => 'Welcome to our blog', 'keywords' => 'blog, article, education, news');
$meta = isset($GLOBALS['meta_seo']) ? $GLOBALS['meta_seo'] : $default_meta;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $meta->title; ?></title>
  <meta name="description" content="<?php echo $meta->description;  ?>">
  <meta name="keywords" content="<?php echo $meta->keywords;  ?>">

  <!-- Favicons -->
  <link href="/<?php echo STATIC_URL; ?>/view/assets/img/favicon.png" rel="icon">
  <link href="/<?php echo STATIC_URL; ?>/view/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=EB+Garamond:wght@400;500&family=Inter:wght@400;500&family=Playfair+Display:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="/<?php echo STATIC_URL; ?>/view/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="/<?php echo STATIC_URL; ?>/view/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="/<?php echo STATIC_URL; ?>/view/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="/<?php echo STATIC_URL; ?>/view/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link id="aosCss" href="/<?php echo STATIC_URL; ?>/view/assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS Files -->
  <link href="/<?php echo STATIC_URL; ?>/view/assets/css/variables.css" rel="stylesheet">
  <link href="/<?php echo STATIC_URL; ?>/view/assets/css/main.css" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <!-- Include Vue.js library -->
  <script src="/<?php echo STATIC_URL; ?>/view/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl d-flex align-items-center justify-content-between">

      <a href="/<?php echo home; ?>" class="logo d-flex align-items-center">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <!-- <img src="/<?php echo STATIC_URL; ?>/view/assets/img/logo.png" alt=""> -->
        <h1><?php echo SITE_NAME; ?></h1>
      </a>

      <nav id="navbar" class="navbar">
        <ul>
          <!-- <li><a href="/<?php // echo home; 
                              ?>">Blog</a></li>
          <li><a href="/<?php // echo home; 
                        ?>/read">Single Post</a></li> -->
          <!-- <li class="dropdown"><a href="/<?php // echo home; 
                                              ?>/category"><span>Categories</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
            <ul>
              <li><a href="/<?php // echo home; 
                            ?>/search">Search Result</a></li>
              <li><a href="#">Drop Down 1</a></li>
              <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                <ul>
                  <li><a href="#">Deep Drop Down 1</a></li>
                  <li><a href="#">Deep Drop Down 2</a></li>
                  <li><a href="#">Deep Drop Down 3</a></li>
                  <li><a href="#">Deep Drop Down 4</a></li>
                  <li><a href="#">Deep Drop Down 5</a></li>
                </ul>
              </li>
              <li><a href="#">Drop Down 2</a></li>
              <li><a href="#">Drop Down 3</a></li>
              <li><a href="#">Drop Down 4</a></li>
            </ul>
          </li> -->

          <li><a href="/<?php echo home; ?>/about">About</a></li>
          <li><a href="/<?php echo home.route('allPosts'); ?>">Blog</a></li>
          <li><a href="/<?php echo home; ?>/contact">Contact</a></li>
        </ul>
      </nav><!-- .navbar -->

      <div class="position-relative">
        <a href="https://fb.com/itsme.pkarn" class="mx-2"><span class="bi-facebook"></span></a>
        <a href="https://twitter.com/pradeepkarn" class="mx-2"><span class="bi-twitter"></span></a>
        <a href="https://instagram.com/pradeepkarn" class="mx-2"><span class="bi-instagram"></span></a>
        <a href="https://linkedin.com/in/pkarn" class="mx-2"><span class="bi-linkedin"></span></a>


        <a href="<?php echo "/" . home . route('search'); ?>" class="mx-2 js-search-open">
          <span class="bi-search"></span>
        </a>
        <i class="bi bi-list mobile-nav-toggle"></i>

        <!-- ======= Search Form ======= -->
        <div class="search-form-wrap js-search-form-wrap">
          <form action="/<?php echo home; ?>/search" class="search-form">
            <span class="icon bi-search"></span>
            <input type="text" name="q" placeholder="Search" class="form-control">
            <button type="button" class="btn js-search-close"><span class="bi-x"></span></button>
            <button style="position: absolute; top:5px; border:none;" type="submit"><span class="bi-search"></span></button>
          </form>
        </div>
        <!-- End Search Form -->

      </div>

    </div>

  </header><!-- End Header -->

  <!-- This is the section where your page will be rendered -->
  <?php
  // The $context variable defiend as parameteres of import function and its value is set on root level index.php 
  // $cat_list = $context->data->cat_list;
  $hmctrl = new HomeController;
  $cat_list = $hmctrl->cat_list($ord = "DESC", $limit = 10, $active = 1);
  $recent_posts = $hmctrl->recent_post_list($ord = "DESC", $limit = 5, $active = 1);
  import("apps/view/pages/{$context->page}", $context);
  ?>
  <!-- This is the section where your page will be rendered -->
  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">

    <div class="footer-content">
      <div class="container">

        <div class="row g-5">
          <div class="col-lg-4">
            <h3 class="footer-heading">About <?php echo SITE_NAME; ?></h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam ab, perspiciatis beatae autem deleniti voluptate nulla a dolores, exercitationem eveniet libero laudantium recusandae officiis qui aliquid blanditiis omnis quae. Explicabo?</p>
            <p><a href="/<?php echo home; ?>/about" class="footer-link-more">Learn More</a></p>
            <br>
            <p><a href="/<?php echo home.route('privacyPolicy'); ?>" class="footer-link-more">Privacy Policy</a></p>
          </div>
          <div class="col-6 col-lg-2">
            <h3 class="footer-heading">Navigation</h3>
            <ul class="footer-links list-unstyled">
              <li><a href="/<?php echo home; ?>"><i class="bi bi-chevron-right"></i> Home</a></li>
              <li><a href="/<?php echo home; ?>/about"><i class="bi bi-chevron-right"></i> About us</a></li>
              <li><a href="contact.html"><i class="bi bi-chevron-right"></i> Contact</a></li>
            </ul>
          </div>
          <div class="col-6 col-lg-2">
            <h3 class="footer-heading">Categories</h3>
            <ul class="footer-links list-unstyled">
              <?php
              foreach ($cat_list as $cl) {
                $cl = obj($cl);
              ?>
                <li><a href="<?php echo "/" . home . route('category', ['slug' => $cl->slug]); ?>"><i class="bi bi-chevron-right"></i> <?php echo $cl->title; ?></a></li>
              <?php  } ?>
            </ul>
          </div>

          <div class="col-lg-4">
            <h3 class="footer-heading">Recent Posts</h3>

            <ul class="footer-links footer-blog-entry list-unstyled">
              <?php
              foreach ($recent_posts as $pv) {
                $pv = obj($pv);
              ?>
                <li>
                  <a href="<?php echo "/" . home . route('readPost', ['slug' => $pv->slug]); ?>" class="d-flex align-items-center">
                    <img src="/<?php echo MEDIA_URL; ?>/images/pages/<?php echo $pv->banner; ?>" alt="" class="img-fluid me-3">
                    <div>
                      <div class="post-meta d-block"><span class="date"><?php echo $pv->category_name; ?></span> <span class="mx-1">&bullet;</span> <span><?php echo $pv->updated_at; ?></span></div>
                      <span><?php echo $pv->title; ?></span>
                    </div>
                  </a>
                </li>
              <?php  } ?>


            </ul>

          </div>
        </div>
      </div>
    </div>

    <div class="footer-legal">
      <div class="container">

        <div class="row justify-content-between">
          <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
            <div class="copyright">
              © Copyright <strong><span><?php echo SITE_NAME; ?></span></strong>. All Rights Reserved
            </div>

            <div class="credits">
              Designed by <a href="https://fb.com/itsme.pkarn">Pradeep Karn</a>
            </div>

          </div>

          <div class="col-md-6">
            <div class="social-links mb-3 mb-lg-0 text-center text-md-end">
              <a href="https://twitter.com/pradeepkarn" class="twitter"><i class="bi bi-twitter"></i></a>
              <a href="https://fb.com/itsme.pkarn" class="facebook"><i class="bi bi-facebook"></i></a>
              <a href="https://instagram.com/pradeepkarn" class="instagram"><i class="bi bi-instagram"></i></a>
              <a href="https://linkedin.com/in/pkarn" class="linkedin"><i class="bi bi-linkedin"></i></a>
            </div>

          </div>

        </div>

      </div>
    </div>

  </footer>

  <a href="#" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->

  <script src="/<?php echo STATIC_URL; ?>/view/assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="/<?php echo STATIC_URL; ?>/view/assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="/<?php echo STATIC_URL; ?>/view/assets/vendor/aos/aos.js"></script>
  <!-- <script src="/<?php // echo STATIC_URL; 
                      ?>/view/assets/vendor/php-email-form/validate.js"></script> -->

  <!-- Template Main JS File -->
  <script src="/<?php echo STATIC_URL; ?>/view/assets/js/main.js"></script>
  <script src="/<?php echo STATIC_URL; ?>/view/js/main.js"></script>

</body>

</html>