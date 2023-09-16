<?php
$prof = obj($context->data->my_profile);
$frnds = obj($context->data->my_friends);
// myprint($frnds);
$frnd = (object)check_request($myid = USER['id'], $req_to = $prof->id);
if ($prof->cover != '') {
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
    "apps/view/components/profile/css/chat.css.php",
    obj([])
);
?>


<div id="res"></div>
<section style="min-height: 100vh;">
    <div class="profile-section">
        <div class="grad-left"></div>
        <div class="grad-right"></div>
    </div>
    <div class="container-fluid pb-5">
        <div class="row justify-content-center">
            <div class="col-md-10" style="height: 100vh; overflow-y:scroll;">
                <div class="card shadow" style="border: transparent;">

                    <div id="user-profile-cover" class="col-md-12 profile-cover">
                    </div>
                    <div class="card-body" style="border: transparent;">
                        <div class="row">

                            <div class="img-details">
                                <div class="v-center">
                                    <div id="my-prof">

                                        <img id="user-profile-img" src="/<?php echo MEDIA_URL; ?>/images/profiles/<?php echo $prof->image; ?>" class="img-fluid profile-img" alt="<?php echo $prof->first_name; ?>">

                                    </div>
                                    <h3 id="profile-name">
                                        <?php echo $prof->first_name; ?> <?php echo $prof->last_name; ?>
                                    </h3>
                                    <b> <?php echo $prof->gender == 'm' ? '(Male)' : '(Female)'; ?> <?php echo $prof->dob; ?></b>

                                </div>

                                <div class="row">
                                    <div class="col-md-12">

                                        <h3>Personal details:</h3>
                                        <b>Profile ID: <?php echo $prof->id; ?></b>
                                    </div>
                                    <div class="row">
                                        <div class="col my-2">
                                            <b>Caste:</b>
                                        </div>
                                        <div class="col my-2">
                                            <?php echo $prof->caste; ?>
                                            <?php echo $prof->caste_detail != "" ? "({$prof->caste_detail})" : null; ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <b>Occupation: </b>
                                            <?php echo $prof->occupation; ?> LPA
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <b>Annual Income: </b>
                                            <?php echo $prof->annual_income; ?> 
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row" id="more-mobile-div">

                                            <div class="col-md-3">
                                                <div class="mb-3">
                                                    <b>Mobile 1: </b>

                                                    <a href="tel:<?php echo $prof->mobile; ?>">
                                                        <?php echo $prof->mobile; ?> <i class="bi bi-telephone-fill"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <?php
                                            $jsn = json_decode($prof->jsn);
                                            if (isset($jsn->contacts)) {
                                                foreach ($jsn->contacts as $key => $cnt) { ?>
                                                    <div class="col-md-3">
                                                        <div class="mb-3">
                                                            <b>Mobile <?php echo $key + 2; ?>: </b>

                                                            <a href="tel:<?php echo $cnt->contact; ?>">
                                                                <?php echo $cnt->contact; ?> <i class="bi bi-telephone-fill"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                            <?php }
                                            }
                                            ?>
                                        </div>

                                    </div>

                                    <div class="col-md-6 my-2">
                                        <b>Gender:</b>
                                        <?php echo $prof->gender == 'm' ? 'Male' : 'Female'; ?>
                                    </div>


                                    <div class="col-md-12 my-2">
                                        <b>Address:</b>
                                        <?php echo $prof->address; ?>
                                    </div>

                                    <div class="col-md-4 my-2">
                                        <b>City:</b>
                                        <?php echo $prof->city; ?>
                                    </div>
                                    <div class="col-md-4 my-2">
                                        <b>State:</b>
                                        <?php echo $prof->state; ?>
                                    </div>
                                </div>
                                <div class="col-md-4 my-2">
                                    <b>Country:</b>
                                    <?php echo $prof->country; ?>
                                </div>
                                <div class="col-md-12 my-2">
                                    <b>About me:</b>
                                    <?php echo $prof->bio; ?>
                                </div>
                                <hr>
                                <div class="col-md-12">
                                    <h3>Family details:</h3>
                                    <div class="row">
                                        <div class="col my-2">
                                            <b>Grand Father:</b>
                                        </div>
                                        <div class="col my-2">
                                            <?php echo $prof->grand_father; ?>
                                            <?php echo $prof->about_grand_father != "" ? "({$prof->about_grand_father})" : null; ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col my-2">
                                            <b>Father:</b>
                                        </div>
                                        <div class="col my-2">
                                            <?php echo $prof->father; ?>
                                            <?php echo $prof->about_father != "" ? "({$prof->about_father})" : null; ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col my-2">
                                            <b>Mother:</b>
                                        </div>
                                        <div class="col my-2">
                                            <?php echo $prof->mother; ?>
                                            <?php echo $prof->about_mother != "" ? "({$prof->about_mother})" : null; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $jsn = json_decode($prof->jsn);
                                if (isset($jsn->family_members)) {
                                    foreach ($jsn->family_members as $key => $rlv) { ?>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col my-2">
                                                    <b><?php echo $rlv->relation; ?>:</b>
                                                </div>
                                                <div class="col my-2">
                                                    <?php echo $rlv->name; ?>
                                                    <?php echo $rlv->about != "" ? "({$rlv->about})" : null; ?>
                                                </div>
                                            </div>
                                        </div>

                                <?php }
                                }
                                ?>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <!-- Contact List -->
                <img id="user-icon" src="/<?php echo MEDIA_URL; ?>/images/profiles/default-user.png" alt="">
                <div class="row">

                    <div class="col-md-12">
                        <h3>Contact List</h3>
                        <ul class="list-group user-list">
                            <?php
                            foreach ($frnds as $key => $frnd) :
                                $frnd = obj($frnd);
                            ?>
                                <li data-chat-friendName="<?php echo $frnd->first_name; ?>" data-chat-myId="<?php echo $prof->id; ?>" data-chat-friendId="<?php echo $frnd->id; ?>" data-chat-friendDp="/<?php echo MEDIA_URL; ?>/images/profiles/<?php echo $frnd->image; ?>" class="list-group-item friends">
                                    <div>
                                        <span id="friend-div-id-<?php echo $frnd->id; ?>"></span>
                                        <img class="friend-user-img" src="/<?php echo MEDIA_URL; ?>/images/profiles/<?php echo $frnd->image; ?>" alt="<?php echo $frnd->first_name; ?>">
                                        <?php echo $frnd->first_name; ?>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                            <!-- Add more users here -->
                        </ul>

                    </div>
                </div>

                <div class="chat-box" id="chatBox">

                    <div class="show-hide-icons">
                        <div>
                            <a id="profile-link" href="">
                                <img id="current-user-img" src="/<?php echo MEDIA_URL; ?>/images/profiles/default-user.png" alt="">
                                <b id="chatUserName" class="ps-1"></b>
                            </a>

                        </div>
                        <div id="min-close-icon">
                            <i id="minimize-chat" class="bi bi-dash"></i>
                            <i id="hide-chat" class="bi bi-x"></i>
                        </div>
                    </div>


                    <div class="messages" id="message-box">
                        <!-- <div class="its-me chat-bubble">
                            HI there adkjhdk hkjsdh hksdh
                        </div>
                        <div class="other chat-bubble">
                            hello jkgkdsg hkjdsh kjh kjhds
                        </div> -->

                    </div>
                    <div id="write-msg">

                        <div id="writing-box">
                            <textarea id="write-msg-input" placeholder="Type your message..." class="form-control" name="message" rows="1"></textarea>
                        </div>
                        <div data-chat-myId="" data-chat-friendId="" id="send-msg-icon">
                            <i class="bi bi-send"></i>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
    </div>
    </div>

    <?php
    import(
        "apps/view/components/profile/js/chatbox.js.php",
        obj([
            'prof' => obj(USER)
        ])
    );
    import(
        "apps/view/components/profile/js/ws.p2p.js.php",
        obj([
            'prof' => obj(USER)
        ])
    );
    ?>



</section>