<!-- slider -->
<!-- style="border-top-left-radius:50%; border-bottom-right-radius:50%;" -->
<section class="mobile-hide" style="position: relative;">
    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div id="carouselExampleFade" class="carousel slide carousel-slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php $slider = new Dbobjects();
                    $slider->tableName = "pk_user";
                    $sldrqry['user_group'] = "user";
                    $sldrqry['is_active'] = 1;
                    $slides = $slider->filter(assoc_arr: $sldrqry, limit: 20, ord: "RAND()");
                    // echo $slider->sql;
                    foreach ($slides as $key => $prof) :
                        // echo $key;
                        $prof = obj($prof);
                        // $age = getAgeFromDOB($prof->dob);
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
                        $prof->image = $prof->is_public == 1 ? $prof->image : 'default-user.png';
                        if ($prof->cover != '') {
                            $imagePath = MEDIA_ROOT . "images/profiles/" . $prof->cover;
                            if (!file_exists($imagePath)) {
                                $prof->cover = "default-cover.jpg";
                            }
                        } else {
                            $imagePath = MEDIA_ROOT . "images/profiles/default-cover.jpg";
                            if (file_exists($imagePath)) {
                                $prof->cover = "default-cover.jpg";
                            }
                        }

                        $prof->cover = $prof->is_public == 1 ? $prof->cover : 'default-cover.jpg';
                    ?>
                        <div class="text-center carousel-item bg-secondary <?php if ($key == 0) {
                                                                                echo "active";
                                                                            } ?>" style="height: 100%; background-image: url(/<?php echo MEDIA_URL; ?>/images/profiles/<?php echo $prof->cover; ?>); background-repeat: no-repeat; background-position: center; background-size: cover;">
                            <div style="position: relatve; height: 100%; background-color: rgba(0,0,0,0.3); ">
                                
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12">

                                                <div class="card shadow" style="margin: 5px 70px 5px 70px;">


                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <a class="text-decoration-none profile-link" href="/<?php echo home . route('showPublicProfile', ['profile_id' => $prof->id]); ?>">
                                                                    <img src="/<?php echo MEDIA_URL; ?>/images/profiles/<?php echo $prof->image; ?>" class="card-img-top profile-card-img" alt="<?php echo $prof->first_name; ?> <?php echo $prof->last_name; ?>">
                                                                </a>
                                                            </div>
                                                            <div class="col-8 text-start">
                                                                <h5 class="card-title"><?php echo $prof->first_name; ?> <?php echo $prof->last_name; ?>
                                                                    <small>
                                                                        (<?php echo bride_or_grom($prof->gender); ?>)
                                                                    </small>
                                                                </h5>
                                                                <?php echo $prof->is_public == 1 ? null : "<span class='badge text-bg-warning'>Private</span>"; ?>
                                                                <div class="row">
                                                                    <div class="col">Age:</div>
                                                                    <div class="col">
                                                                        <?php echo $prof->is_public == 1 ? $age : "**"; ?> Yrs
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">Religion:</div>
                                                                    <div class="col"><?php echo $prof->is_public == 1 ? $prof->religion : "****"; ?></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">Caste:</div>
                                                                    <div class="col"><?php echo $prof->is_public == 1 ? $prof->caste : "****"; ?></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">Caste details:</div>
                                                                    <div class="col"><?php echo $prof->is_public == 1 ? $prof->caste_detail : "****"; ?></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">Location:</div>
                                                                    <div class="col"><?php echo $prof->is_public == 1 ? $prof->address : "****"; ?></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">Education:</div>
                                                                    <div class="col"><?php echo $prof->is_public == 1 ? $prof->education : "****"; ?></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">Profession:</div>
                                                                    <div class="col"><?php echo $prof->is_public == 1 ? $prof->occupation : "****"; ?></div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col">Annual Income:</div>
                                                                    <div class="col"><?php echo $prof->is_public == 1 ? $prof->annual_income : "****"; ?> LPA</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>


                                                </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    endforeach; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</section>
<!-- slider end -->