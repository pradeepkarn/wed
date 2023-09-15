<?php
$default_meta = (object) array('title' => 'Wed', 'description' => 'Welcome to our blog', 'keywords' => 'Weding site, weding, social, culture');
$meta = isset($GLOBALS['meta_seo']) ? $GLOBALS['meta_seo'] : $default_meta;
?>
<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <?php echo $GLOBALS['ogdata'] ?? null; ?>
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


    <?php
    // if (USER == false) {
    //     import("apps/view/components/common/fb/pop-up.php");
    // }
    import("apps/view/pages/{$context->page}", $context);
    ?>

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