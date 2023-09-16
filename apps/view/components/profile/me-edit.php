<?php
$prof = obj($context->data->my_profile);
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

    $centerX = $imageWidth - rand(1, 5);
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
); ?>


<div id="res"></div>
<section style="min-height: 100vh;">
    <div class="profile-section">
        <div class="grad-left"></div>
        <div class="grad-right"></div>
    </div>
    <div class="container pb-5">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow" style="border: transparent;">
                    <!-- <div id="cover-progress" class="progress">
                        <div class="progress-bar"></div>
                    </div> -->
                    <div id="user-profile-cover" class="col-md-12 profile-cover">
                        <form id="cover-img-form" action="/<?php echo home . route('uploadUserCoverImageAjax'); ?>" method="post">
                            <input accept="image/*" id="cover-img-fileInput" type="file" name="cover_img" style="display: none;">
                        </form>

                        <div id="cam-div-cover">
                            <i id="cover-img-camera-btn" class="bi bi-camera-fill"></i>
                        </div>
                    </div>
                    <div class="card-body" style="border: transparent;">
                        <div class="row">

                            <div class="img-details">
                                <div class="v-center">
                                    <div id="my-prof">
                                        <form id="profile-img-form" action="/<?php echo home . route('uploadUserProfileImageAjax'); ?>" method="post">
                                            <input accept="image/*" id="profile-img-fileInput" type="file" name="profile_img" style="display: none;">
                                        </form>

                                        <img id="user-profile-img" src="/<?php echo MEDIA_URL; ?>/images/profiles/<?php echo $prof->image; ?>" class="img-fluid profile-img" alt="<?php echo $prof->first_name; ?>">
                                        <div id="cam-div">
                                            <i id="profile-img-camera-btn" class="bi bi-camera-fill"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h3 id="profile-name">
                                            <?php echo $prof->first_name; ?> <?php echo $prof->last_name; ?>
                                        </h3>
                                        <b>
                                            <small>(Profile completed : <?php echo profile_completed($prof->id); ?>%)</small>
                                        </b>
                                    </div>


                                </div>

                                <form id="update-my-profile-form" action="/<?php echo home . route('updateMyProfileAjax'); ?>">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <h3><?php echo lang('global')->personal_details ?? "Personal details"; ?>:</h3>
                                            <input type="checkbox" name="is_public" value="1" <?php echo $prof->is_public ? 'checked' : null; ?>> <?php echo lang('global')->public ?? "Public"; ?>
                                            <b><?php echo lang('nav')->profile ?? "Profile"; ?> <?php echo lang('global')->id ?? "ID"; ?>: <?php echo $prof->id; ?></b>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="first_name" class="form-label"><?php echo lang('global')->first_name ?? "First name"; ?> :</label>
                                                <input type="text" class="form-control my-2" id="first_name" name="first_name" value="<?php echo $prof->first_name; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="first_name" class="form-label"><?php echo lang('global')->last_name ?? "Last name"; ?> :</label>
                                                <input type="text" class="form-control my-2" id="first_name" name="last_name" value="<?php echo $prof->last_name; ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="dob" class="form-label"><?php echo lang('global')->dob ?? "Date of birth"; ?>:</label>
                                                <input type="date" value="<?php echo $prof->dob; ?>" name="dob" class="form-control my-2" id="dob">
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mb-3">
                                                <label for="gender" class="form-label"><?php echo lang('global')->gender ?? "Gender"; ?>:</label>
                                                <select name="gender" id="gender" class="form-select my-2">
                                                    <option <?php echo $prof->gender == 'm' ? 'selected' : null; ?> value="m"><?php echo lang('global')->male ?? "Male"; ?></option>
                                                    <option <?php echo $prof->gender == 'f' ? 'selected' : null; ?> value="f"><?php echo lang('global')->female ?? "Female"; ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="caste" class="form-label"><?php echo lang('global')->caste ?? "Caste"; ?>:</label>
                                                <?php
                                                $jsncaste = json_decode(jsonData($file = "/caste/caste.json"));
                                                $allCastes =  ($jsncaste->religion[0]->castes); ?>
                                                <select name="caste" id="caste" class="form-select my-2">
                                                    <?php foreach ($allCastes as $key => $cst) { ?>
                                                        <option <?php echo $cst->name == $prof->caste ? 'selected' : null; ?> value="<?php echo $cst->name; ?>"><?php echo $cst->name; ?></option>
                                                    <?php  }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="occupation" class="form-label"><?php echo lang('global')->caste_details ?? "Caste details"; ?>:</label>
                                                <textarea class="form-control my-2" id="occupation" name="caste_detail"><?php echo $prof->caste_detail; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="occupation" class="form-label"><?php echo lang('global')->occupation ?? "Occupation"; ?>:</label>
                                                <textarea class="form-control my-2" id="occupation" name="occupation"><?php echo $prof->occupation; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="annual_income" class="form-label"><?php echo lang('global')->annual_income ?? "Annual Income"; ?>:</label>
                                                <select name="annual_income" id="annual_income" class="form-select my-2">
                                                    <option value="0-2 ">0-2 Lakhs</option>
                                                    <option value="2-5 ">2-5 Lakhs</option>
                                                    <option value="5-10">5-10 Lakhs</option>
                                                    <option value="10-15">10-15 Lakhs</option>
                                                    <option value="15-20">15-20 Lakhs</option>
                                                    <option value="20-25">20-25 Lakhs</option>
                                                    <option value="25-30">25-30 Lakhs</option>
                                                    <option value="30-35">30-35 Lakhs</option>
                                                    <option value="35-40">35-40 Lakhs</option>
                                                    <option value="40-45">40-45 Lakhs</option>
                                                    <option value="45-50">45-50 Lakhs</option>
                                                    <option value="50-55">50-55 Lakhs</option>
                                                    <option value="55-60">55-60 Lakhs</option>
                                                    <option value="60-65">60-65 Lakhs</option>
                                                    <option value="65-70">65-70 Lakhs</option>
                                                    <option value="70-75">70-75 Lakhs</option>
                                                    <option value="75-80">75-80 Lakhs</option>
                                                    <option value="80-85">80-85 Lakhs</option>
                                                    <option value="85-90">85-90 Lakhs</option>
                                                    <option value="90-95">90-95 Lakhs</option>
                                                    <option value="95-100">95-100 Lakhs</option>


                                                </select>
                                                <script>
                                                    var exists = false;
                                                    $('#annual_income option').each(function() {
                                                        if (this.value == '<?php echo  $prof->annual_income; ?>') {
                                                            $("#annual_income").val("<?php echo $prof->annual_income; ?>");
                                                        }
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="row" id="more-mobile-div">

                                                <div class="col-md-3">
                                                    <div class="mb-3">
                                                        <label for="mobile" class="form-label"><?php echo lang('global')->mobile ?? "Mobile"; ?>:</label>
                                                        <input type="text" name="mobile" value="<?php echo $prof->mobile; ?>" class="form-control my-2 custom-number-input" id="mobile">
                                                    </div>
                                                </div>
                                                <?php
                                                $jsn = json_decode($prof->jsn ?? "{}");
                                                if (isset($jsn->contacts)) {
                                                    foreach ($jsn->contacts as $key => $cnt) { ?>
                                                        <div class="col-md-3">
                                                            <div class="mb-3">
                                                                <label class="form-label">Mobile:</label>
                                                                <input type="text" name="contacts[]" value="<?php echo $cnt->contact; ?>" class="form-control my-2 custom-number-input">
                                                            </div>
                                                        </div>
                                                <?php }
                                                }
                                                ?>
                                            </div>
                                            <button id="add-more-mobiles" type="button" class="btn btn-primary"><?php echo lang('global')->add_more_number ?? "Add more number"; ?></button>
                                        </div>




                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="address" class="form-label"><?php echo lang('global')->address ?? "Address"; ?>:</label>
                                                <textarea class="form-control" name="address" id="address" rows="4"><?php echo $prof->address; ?></textarea>
                                            </div>
                                        </div>





                                        <div class="col-6 my-2">
                                            <div class="form-floating">
                                                <select class="form-select" name="state" id="state-select" aria-label="Floating label select example">
                                                    <?php
                                                    $data = json_decode(jsonData('/india/states-and-districts.json'));
                                                    foreach ($data->states as $key => $st) {
                                                        $st = obj($st);
                                                    ?>
                                                        <option <?php echo $prof->state == $st->state ? 'selected' : null; ?> data-districts='<?php echo json_encode($st->districts); ?>' value="<?php echo $st->state; ?>"><?php echo $st->state; ?></option>
                                                    <?php  } ?>
                                                </select>
                                                <label for="state-select"><?php echo lang('global')->state ?? "State"; ?></label>
                                            </div>
                                        </div>
                                        <div class="col-6 my-2">
                                            <div class="form-floating">
                                                <select class="form-select" name="city" id="district-select" aria-label="Floating label select example">

                                                </select>
                                                <label for="district-select"><?php echo lang('global')->city ?? "City"; ?></label>
                                            </div>
                                        </div>



                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="country" class="form-label"><?php echo lang('global')->country ?? "Country"; ?>:</label>
                                                <input type="text" class="form-control my-2" id="country" name="country" value="<?php echo $prof->country; ?>">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="bio" class="form-label"><?php echo lang('global')->about_me ?? "Aboute me"; ?>:</label>
                                                <textarea class="form-control" id="bio" name="about_me" rows="4"><?php echo $prof->bio; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label for="mool" class="form-label"><?php echo lang('global')->mool ?? "Mool"; ?>:</label>
                                                <textarea class="form-control" id="mool" name="mool" rows="4"><?php echo $prof->mool; ?></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="col-md-12">
                                            <h3><?php echo lang('global')->family_details ?? "Family details"; ?>:</h3>
                                            <div class="row" id="more-rel-div">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="country" class="form-label"><?php echo lang('global')->grand_father ?? "Grand father"; ?>:</label>
                                                        <input type="text" class="form-control my-2" id="gfather" name="grand_father" value="<?php echo $prof->grand_father; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="abtgf" class="form-label"><?php echo lang('global')->grand_father_details ?? "Grand father details"; ?> (<?php echo lang('global')->details ?? "Details"; ?>):</label>
                                                        <textarea class="form-control my-2" id="abtgf" name="about_grand_father" rows="4"><?php echo $prof->about_grand_father; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="country" class="form-label"><?php echo lang('global')->father ?? "Father"; ?>:</label>
                                                        <input type="text" class="form-control my-2" id="father" name="father" value="<?php echo $prof->father; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="abtfather" class="form-label"><?php echo lang('global')->father_details ?? "Father details"; ?> (<?php echo lang('global')->details ?? "Details"; ?>):</label>
                                                        <textarea class="form-control my-2" id="abtfather" name="about_father" rows="4"><?php echo $prof->about_father; ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="mother" class="form-label"><?php echo lang('global')->mother ?? "Mother"; ?>:</label>
                                                        <input type="text" class="form-control my-2" id="mother" name="mother" value="<?php echo $prof->mother; ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="abtmother" class="form-label"><?php echo lang('global')->mother_details ?? "Mother details"; ?> (<?php echo lang('global')->details ?? "Details"; ?>):</label>
                                                        <textarea class="form-control my-2" id="abtmother" name="about_mother" rows="4"><?php echo $prof->about_mother; ?></textarea>
                                                    </div>
                                                    <hr>
                                                </div>
                                                <h3><?php echo lang('global')->more_family_details ?? "More family details"; ?>:</h3>
                                                <?php
                                                $jsn = json_decode($prof->jsn ?? "{}");
                                                if (isset($jsn->family_members)) {
                                                    foreach ($jsn->family_members as $key => $rlv) { ?>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"><?php echo lang('global')->relation_type ?? "Relation type"; ?>:</label>
                                                                <input type="text" placeholder="Cousin brother, Uncle, etc.." class="form-control my-2" name="rel_type[]" value="<?php echo $rlv->relation; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="mb-3">
                                                                <label class="form-label"><?php echo lang('global')->relative_name ?? "Name"; ?>:</label>
                                                                <input type="text" placeholder="<?php echo lang('global')->relative_name ?? "Name"; ?>" class="form-control my-2" name="rel_name[]" value="<?php echo $rlv->name; ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="mb-3">
                                                                <label class="form-label"><?php echo lang('global')->details ?? "Details"; ?>:</label>
                                                                <textarea class="form-control my-2" placeholder="Work details or any other related information" name="about_rel[]" rows="4"><?php echo $rlv->about; ?></textarea>
                                                            </div>
                                                            <hr>
                                                        </div>
                                                <?php }
                                                }
                                                ?>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4 ms-auto text-end">
                                                    <button type="button" id="add-more-relations" class="btn btn-primary"><?php echo lang('global')->more_relations ?? "More relations"; ?> <i class="bi bi-plus"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="profile-update-spinner">
                                        <?php echo lang('contact')->please_wait ?? "Please wait"; ?> ... <img src="/<?php echo MEDIA_URL; ?>/site/loading.gif" alt="loading">
                                    </div>
                                    <button id="update-my-profile" class="btn btn-primary"><?php echo lang('global')->update ?? "Update"; ?></button>
                                </form>

                                <?php
                                pkAjax_form("#update-my-profile", "#update-my-profile-form", "#res", 'click', true);
                                ?>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
import("apps/view/components/profile/js/me-edit.js.php", obj(['prof' => $prof]));
ajaxActive('#profile-update-spinner');
pkAjax_form("#profile-img-fileInput", "#profile-img-form", "#res", "change", true);
pkAjax_form("#cover-img-fileInput", "#cover-img-form", "#res", "change", true);
?>