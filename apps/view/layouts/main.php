<?php
$default_meta = (object) array('title' => 'Wed', 'description' => 'Welcome to our blog', 'keywords' => 'Weding site, weding, social, culture');
$meta = isset($GLOBALS['meta_seo']) ? $GLOBALS['meta_seo'] : $default_meta;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?php echo $meta->title; ?></title>
    <meta content="<?php echo $meta->description; ?>" name="description">
    <meta content="<?php echo $meta->keywords; ?>" name="keywords">

    <!-- Favicons -->
    <link href="/<?php echo MEDIA_URL; ?>/logo/logo.png" rel="icon">
    <link href="/<?php echo STATIC_URL; ?>/view/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="/<?php echo STATIC_URL; ?>/view/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="/<?php echo STATIC_URL; ?>/view/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/<?php echo STATIC_URL; ?>/view/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="/<?php echo STATIC_URL; ?>/view/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="/<?php echo STATIC_URL; ?>/view/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="/<?php echo STATIC_URL; ?>/view/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Template Main CSS File -->
    <link href="/<?php echo STATIC_URL; ?>/view/assets/css/style.css" rel="stylesheet">
    <link href="/<?php echo STATIC_URL; ?>/view/css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/splitting/dist/splitting.css" />
    <link rel="stylesheet" href="https://unpkg.com/splitting/dist/splitting-cells.css" />
    <script src="https://unpkg.com/splitting/dist/splitting.min.js"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

    <script src="/<?php echo STATIC_URL; ?>/view/js/jq.3.5.js"></script>
    <script src="/<?php echo STATIC_URL; ?>/view/js/main.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.min.js"></script> -->
    <script>
        function swalert(obj) {
            Swal.fire(
                obj.title,
                obj.msg,
                obj.icon
            ).then(() => {
                if (obj.gotoLink) {
                    window.location.href = obj.gotoLink;
                }
            })
        }
    </script>
</head>

<body>

    <div id="global-progress-bar" style="height: 5px;" class="progress bg-primary fixed-top">
        <div class="progress-bar"></div>
    </div>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top">
        <div class="nav-div container-fluid container-xl d-flex align-items-center justify-content-between">

            <a href="/<?php echo home . route('home'); ?>" class="logo d-flex align-items-center">
                <img src="/<?php echo MEDIA_URL; ?>/logo/logo.png" alt="Logo">
            </a>

            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto" href="/<?php echo home . route('home'); ?>"><?php echo lang("nav")->home; ?></a></li>
                    <li><a class="nav-link scrollto" href="/<?php echo home . route('home'); ?>/about"><?php echo lang("nav")->about; ?></a></li>
                    <!-- <li><a class="nav-link scrollto" href="/<?php //echo home . route('home'); 
                                                                    ?>/#services">Services</a></li> -->
                    <!-- <li><a class="nav-link scrollto" href="/<?php //echo home . route('home'); 
                                                                    ?>/#portfolio">Portfolio</a></li> -->
                    <!-- <li><a class="nav-link scrollto" href="/<?php //echo home . route('home'); 
                                                                    ?>/#team">Team</a></li> -->
                    <!-- <li><a href="#">Blog</a></li> -->


                    <!-- <li class="dropdown megamenu"><a href="#"><span>Mega Menu</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li>
                                <a href="#">Column 1 link 1</a>
                                <a href="#">Column 1 link 2</a>
                                <a href="#">Column 1 link 3</a>
                            </li>
                            <li>
                                <a href="#">Column 2 link 1</a>
                                <a href="#">Column 2 link 2</a>
                                <a href="#">Column 3 link 3</a>
                            </li>
                            <li>
                                <a href="#">Column 3 link 1</a>
                                <a href="#">Column 3 link 2</a>
                                <a href="#">Column 3 link 3</a>
                            </li>
                            <li>
                                <a href="#">Column 4 link 1</a>
                                <a href="#">Column 4 link 2</a>
                                <a href="#">Column 4 link 3</a>
                            </li>
                        </ul>
                    </li> -->

                    <li><a class="nav-link scrollto" href="/<?php echo home . route('home'); ?>/#contact"><?php echo lang("nav")->contact; ?></a></li>
                    <!-- <li><a class="getstarted scrollto" href="#about">Get Started</a></li> -->
                    <li class="dropdown"><a href="#"><span><?php echo lang("nav")->account; ?></span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <!-- <li><a href="#">Drop Down 1</a></li>
                            <li class="dropdown"><a href="#"><span>Deep Drop Down</span> <i class="bi bi-chevron-right"></i></a>
                                <ul>
                                    <li><a href="#">Deep Drop Down 1</a></li>
                                    <li><a href="#">Deep Drop Down 2</a></li>
                                    <li><a href="#">Deep Drop Down 3</a></li>
                                    <li><a href="#">Deep Drop Down 4</a></li>
                                    <li><a href="#">Deep Drop Down 5</a></li>
                                </ul>
                            </li> -->
                            <li>

                                <?php if (USER) : ?>
                                    <a href="/<?php echo home . route('showPublicProfile',['profile_id'=>USER['id']]); ?>"><?php echo lang("nav")->public_profile ?? "Public Profile"; ?></a>
                                    <!-- <a href="/<?php //echo home . route('userProfile'); ?>"><?php //echo lang("nav")->profile ?? "Profile"; ?></a> -->
                                    <a href="/<?php echo home . route('userProfileEdit'); ?>"><?php echo lang("nav")->profile_edit ?? "Profile Edit"; ?></a>
                                    <a href="/<?php echo home . route('userProfileGallery'); ?>"><?php echo lang("global")->my_album ?? "My Album"; ?></a>
                                    <a href="/<?php echo home . route('logout'); ?>"><?php echo lang("nav")->logout ?? "Logout"; ?></a>
                                <?php else : ?>
                                    <a href="/<?php echo home . route('userLogin'); ?>"><?php echo lang("nav")->login ?? "Login"; ?></a>
                                    <a href="/<?php echo home . route('register'); ?>"><?php echo lang("nav")->register ?? "Register"; ?></a>
                                <?php endif; ?>
                            </li>
                        </ul>
                    </li>
                    <li><?php if (isset($_COOKIE['lang']) && $_COOKIE['lang'] == 'en') : ?>
                            <a id="set-lang-hi" class="nav-link scrollto pk-pointer"><?php echo lang("nav")->hi ?? "Hi"; ?></a>
                        <?php else : ?>
                            <a id="set-lang-en" class="nav-link scrollto pk-pointer"><?php echo lang("nav")->en ?? "En"; ?></a>
                        <?php endif; ?>
                    </li>
                    <input type="hidden" class="lang" name="lang" value="">
                    <div id="res-lang"></div>
                    <?php
                    pkAjax("#set-lang-en", route('setLang', ['lang' => 'en']), ".lang", "#res-lang");
                    pkAjax("#set-lang-hi", route('setLang', ['lang' => 'hi']), ".lang", "#res-lang");
                    ?>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav><!-- .navbar -->

        </div>
    </header><!-- End Header -->


    <?php
    // if (USER == false) {
    //     import("apps/view/components/common/fb/pop-up.php");
    // }
    import("apps/view/pages/{$context->page}", $context);
    ?>

    <!-- ======= Footer ======= -->
    <footer id="footer" class="footer">

        <!-- <div class="footer-newsletter">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-12 text-center">
                        <h4>Our Newsletter</h4>
                        <p>Tamen quem nulla quae legam multos aute sint culpa legam noster magna</p>
                    </div>
                    <div class="col-lg-6">
                        <form action="" method="post">
                            <input type="email" name="email"><input type="submit" value="Subscribe">
                        </form>
                    </div>
                </div>
            </div>
        </div> -->

        <div class="footer-top">
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-5 col-md-12 footer-info">
                        <a href="/<?php echo home.route('home'); ?>" class="footer-logo d-flex align-items-center">
                            <img src="/<?php echo MEDIA_URL; ?>/logo/logo.png" alt="logo">
                        </a>
                        <p><?php echo lang('global')->welcome_to_site ?? "Welcome to " . SITE_NAME; ?></p>
                        <div class="social-links mt-3">
                            <a href="https://fb.com/pradeepkarn" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="https://fb.com/itsme.pkarn" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="https://fb.com/pradeepkarn" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="https://fb.com/pradeepkarn" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-4 col-12 footer-links">
                        <h4><?php echo lang('global')->useful_links ?? "Useful_links"; ?></h4>
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="/<?php echo home . route('home'); ?>"><?php echo lang('nav')->home ?? "Home"; ?></a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="/<?php echo home . route('pageBySlug', ['slug' => 'about']); ?>"><?php echo lang('nav')->about ?? "About"; ?></a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="/<?php echo home . route('pageBySlug', ['slug' => 'terms-of-use']); ?>"><?php echo lang('global')->terms_of_use ?? "Terms of use"; ?></a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="/<?php echo home . route('pageBySlug', ['slug' => 'privacy-policy']); ?>"><?php echo lang('global')->privacy_policy ?? "Privacy Policy"; ?></a></li>
                        </ul>
                    </div>

                    <!-- <div class="col-lg-2 col-6 footer-links">
                        <h4>Our Services</h4>
                        <ul>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Design</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Web Development</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Product Management</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Marketing</a></li>
                            <li><i class="bi bi-chevron-right"></i> <a href="#">Graphic Design</a></li>
                        </ul>
                    </div> -->

                    <div class="col-lg-3 col-md-12 footer-contact text-center text-md-start">
                        <h4><?php echo lang('global')->contact_us ?? "Contact us"; ?></h4>
                        <p>
                            <?php echo lang('global')->darbhanga ?? "Darbhanga"; ?><br>
                            <?php echo lang('global')->bihar ?? "Bharat"; ?><br>
                            <?php echo lang('global')->bharat ?? "Bharat"; ?><br><br>
                        </p>

                    </div>

                </div>
            </div>
        </div>

        <div class="container">
            <div class="copyright">
                &copy; <?php echo lang('global')->copy_right ?? "Copyright"; ?> <strong><span><?php echo lang('global')->me ?? "Pradeep Karn"; ?></span></strong>. <?php echo lang('global')->all_rights_reserved . " " . date("Y") ?? "All rights reserved"; ?>
            </div>
            <div class="credits">
                <?php echo lang('global')->developed_by ?? "Developed by"; ?> <a href="https://fb.com/itsme.pkarn"><?php echo lang('global')->me ?? "Pradeep Karn"; ?></a>
            </div>
        </div>
    </footer><!-- End Footer -->

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <?php  //import("apps/view/components/common/chat/chat.php"); 
    ?>
    <!-- Vendor JS Files -->
    <script src="/<?php echo STATIC_URL; ?>/view/assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="/<?php echo STATIC_URL; ?>/view/assets/vendor/aos/aos.js"></script>
    <script src="/<?php echo STATIC_URL; ?>/view/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="/<?php echo STATIC_URL; ?>/view/assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="/<?php echo STATIC_URL; ?>/view/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="/<?php echo STATIC_URL; ?>/view/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="/<?php echo STATIC_URL; ?>/view/assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="/<?php echo STATIC_URL; ?>/view/assets/js/main.js"></script>

    <script>
        <?php
        $gctrl = new Fb_auth_ctlr;
        $authUrl = $gctrl->login_url();
        ?>
        // fb
        function openFacebookLoginPopup() {
            // Set your Facebook app ID and redirect URI
            const facebookLoginUrl = `<?php echo $authUrl; ?>`;
            // Open the popup window with the Facebook login URL
            const popupWindow = window.open(facebookLoginUrl, 'FacebookLogin', 'width=600,height=400');

            // Check the popup window status at regular intervals
            const intervalId = setInterval(function() {
                if (popupWindow.closed) {
                    // Popup window closed, so check if login was successful and reload the page
                    checkLoginStatusAndReload();
                    clearInterval(intervalId);
                }
            }, 1000);

            // Listen for messages from the popup window
            window.addEventListener('message', function(event) {
                if (event.data === 'loginSuccess') {
                    // Close the popup when a successful login message is received
                    popupWindow.close();
                }
            });
        }

        function checkLoginStatusAndReload() {
            location.reload();
        }
    </script>
    <script>
        $(document).ready(function() {
            $(".custom-number-input").on("input", function() {
                this.value = this.value.replace(/[^0-9]/g, ''); // Remove non-numeric characters
            });
        });
    </script>
    <?php
    ajaxActive("#global-progress-bar");
    ?>
</body>

</html>