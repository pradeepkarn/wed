<?php
$prof = obj($context->data->my_profile);
$frnds = $context->data->my_friends ? obj($context->data->my_friends) : [];
$me = null;
if (authenticate()) {
    $me = USER ? obj(USER) : null;
    $myreq = obj(check_request($myid = USER['id'], $req_to = $prof->id));
    $is_liked = is_liked($myid = USER['id'], $obj_id = $prof->id, $obj_group = 'profile');
    $frnd = (object)check_request($myid = USER['id'], $req_to = $prof->id);
}

// myprint($frnds);

if ($prof->cover != '') {
    $prof->cover = $prof->is_public==1?$prof->cover:"default-cover.jpg";
    $imagePath = MEDIA_ROOT . "images/profiles/" . $prof->cover;
    if (file_exists($imagePath)) {
        $imageType = exif_imagetype($imagePath);
    } else {
        $imagePath = MEDIA_ROOT . "images/profiles/default-cover.jpg";
        if (file_exists($imagePath)) {
            $imageType = exif_imagetype($imagePath);
            $prof->cover = "default-cover.jpg";
        } else {
            $imageType = null;
        }
    }
} else {
    $imagePath = MEDIA_ROOT . "images/profiles/default-cover.jpg";
    if (file_exists($imagePath)) {
        $prof->cover = "default-cover.jpg";
        $imageType = exif_imagetype($imagePath);
    } else {
        $imageType = null;
    }
}

// Load the image based on its type
switch ($imageType) {
    case IMAGETYPE_JPEG:
        $image = imagecreatefromjpeg($imagePath);
        break;
    case IMAGETYPE_PNG:
        $image = imagecreatefrompng($imagePath);
        break;
    case IMAGETYPE_GIF:
        $image = imagecreatefromgif($imagePath);
        break;
        // Add more cases for other image types if needed
    default:
        $imageType = null;
}
if ($imageType) {
    // Get the image dimensions
    $imageWidth = imagesx($image);
    $imageHeight = imagesy($image);

    // Calculate the center coordinates
    // $centerX = floor($imageWidth / 2);
    $centerX = rand(1, 5);
    $centerY = rand(1, 5);

    // Get the RGB color of the pixel at the center
    $colorIndex = imagecolorat($image, $centerX, $centerY);
    $colorRGB = imagecolorsforindex($image, $colorIndex);

    // Extract RGB components
    $red = $colorRGB['red'];
    $green = $colorRGB['green'];
    $blue = $colorRGB['blue'];

    // Free up memory by destroying the image resource


    // Output the RGB color values
    $rgb_left = "rgb($red,$green,$blue)";

    $centerX = $imageWidth - rand(1, 10);
    $centerY = rand(1, 5);

    // Get the RGB color of the pixel at the center
    $colorIndex = imagecolorat($image, $centerX, $centerY);
    $colorRGB = imagecolorsforindex($image, $colorIndex);

    // Extract RGB components
    $red = $colorRGB['red'];
    $green = $colorRGB['green'];
    $blue = $colorRGB['blue'];
    $rgb_right = "rgb($red,$green,$blue)";

    imagedestroy($image);
} else {
    $rgb_left = "rgb(255,255,255)";
    $rgb_right = "rgb(255,255,255)";
}

##################################################################
if ($prof->image != '') {
    if (!file_exists(MEDIA_ROOT . "images/profiles/" . $prof->image)) {
        if (file_exists(MEDIA_ROOT . "images/profiles/default-user.png")) {
            $prof->image = "default-user.png";
        }
    }
} else {
    if (file_exists(MEDIA_ROOT . "images/profiles/default-user.png")) {
        $prof->image = "default-user.png";
    }
}
####################################################################
import(
    "apps/view/components/profile/css/me-edit.css.php",
    obj([
        'prof' => $prof,
        'rgb_left' => $rgb_left,
        'rgb_right' => $rgb_right
    ])
);
import(
    "apps/view/components/profile/css/public-profile.css.php",
    obj([
        'prof' => $prof,
        'rgb_left' => $rgb_left,
        'rgb_right' => $rgb_right
    ])
);


?>


<div id="res"></div>
<section>
    <div class="profile-section">
        <div class="grad-left"></div>
        <div class="grad-right"></div>
    </div>
    <div class="container-fluid pb-5">
        <div class="row justify-content-center">
            <div class="col-md-10 mx-auto">
                <div class="card shadow" style="border: transparent;">

                    <div id="user-profile-cover" class="col-md-12 profile-cover">
                    </div>
                    <div class="card-body" style="border: transparent;">
                        <div class="row">

                            <div class="img-details">
                                <div class="v-center">
                                    <div id="my-prof">

                                        <img id="user-profile-img" src="/<?php echo MEDIA_URL; ?>/images/profiles/default-user.png" class="img-fluid profile-img" alt="<?php echo $prof->first_name; ?>">

                                    </div>
                                    <h3 id="profile-name">
                                        <?php echo $prof->first_name; ?> <?php echo $prof->last_name; ?>
                                    </h3>
                                    <b> <?php echo $prof->gender == 'm' ? '(Male)' : '(Female)'; ?> <?php echo "**-**-****"; ?></b>

                                </div>

                                <div class="row">
                                    <div class="col-md-2 ms-auto">

                                        <?php if (authenticate()) : ?>
                                            <?php if (USER['id'] != $prof->id) : ?>

                                                <div class="frnd-icons">
                                                    <?php if ($myreq->is_accepted == true) : ?>
                                                        <i class="bi bi-person-check-fill"></i>
                                                    <?php else : ?>
                                                        <?php if ($myreq->success == true) : ?>
                                                            <i data-request="cancel" data-user-id="<?php echo $prof->id; ?>" class="my-icons person-icon bi bi-person-dash"></i>
                                                        <?php else : ?>
                                                            <i data-request="send" data-user-id="<?php echo $prof->id; ?>" class="my-icons person-icon bi bi-person-plus"></i>
                                                        <?php endif; ?>
                                                    <?php endif; ?>


                                                    <?php if ($is_liked == true) : ?>
                                                        <i data-request="unlike" data-user-id="<?php echo $prof->id; ?>" class="my-icons heart-icon bi bi-heart-fill"></i>
                                                    <?php else : ?>
                                                        <i data-request="like" data-user-id="<?php echo $prof->id; ?>" class="my-icons heart-icon bi bi-heart"></i>
                                                    <?php endif; ?>

                                                </div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>



                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h1 class="text-center">Profile is locked by user</h1>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mx-auto text-center">
                                <button type="button" onclick="backOrHomepage();" class="btn btn-light">Back</button>
                            </div>
                            <script>
                                function backOrHomepage() {
                                    if (window.history.length > 1) {
                                        window.history.back();
                                    } else {
                                        window.location.href = "/<?php echo home; ?>";
                                    }
                                }
                            </script>

                        </div>
                    </div>
                </div>


            </div>

        </div>
    </div>
   
  



</section>

<?php
import("apps/view/components/profile/js/public-profile.js.php");

?>