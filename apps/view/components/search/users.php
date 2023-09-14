<?php
$users = $context->data->user_list;
// myprint($users);
import(
    "apps/view/components/home/css/users.css.php",
    obj([])
);
?>
<?php if (USER) : ?>
    <div id="send-req-response-users-component"></div>
    <section class="mt-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-12">
                    <?php 
                    import("apps/view/components/search/search-partner.php");
                    ?>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                foreach ($users as $uk => $prof) :
                    $prof = obj($prof);
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
                    $myreq = obj(check_request($myid = USER['id'], $req_to = $prof->id));
                    // myprint($myreq);
                    $is_liked = is_liked($myid = USER['id'], $obj_id = $prof->id, $obj_group = 'profile');
                ?>
                    <div class="col-md-6">
                        <div class="card shadow h-100">


                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <a class="text-decoration-none profile-link" href="/<?php echo home . route('showPublicProfile', ['profile_id' => $prof->id]); ?>">
                                            <img src="/<?php echo MEDIA_URL; ?>/images/profiles/<?php echo $prof->image; ?>" class="card-img-top profile-card-img" alt="<?php echo $prof->first_name; ?> <?php echo $prof->last_name; ?>">
                                        </a>
                                    </div>
                                    <div class="col-8">
                                        <h5 class="card-title"><?php echo $prof->first_name; ?> <?php echo $prof->last_name; ?>
                                            <small>
                                                (<?php echo bride_or_grom($prof->gender); ?>)
                                            </small>
                                        </h5>
                                        <?php
                                        $locked = lang('global')->locked??'Locked';
                                        echo $prof->is_public == 1 ? null : "<span class='badge text-bg-warning'>{$locked}</span>"; ?>
                                        <div class="row">
                                            <div class="col"><?php echo lang('global')->age??"Age"; ?>:</div>
                                            <div class="col">
                                                <?php echo $prof->is_public == 1 ? getAgeFromDOB($prof->dob) : "**"; ?> <?php echo lang('global')->yrs??"Yrs"; ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col"><?php echo lang('global')->religion??"Religion"; ?>:</div>
                                            <div class="col"><?php echo $prof->is_public == 1 ? $prof->religion : "****"; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col"><?php echo lang('global')->caste??"Caste"; ?>:</div>
                                            <div class="col"><?php echo $prof->is_public == 1 ? $prof->caste : "****"; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col"><?php echo lang('global')->caste_details??"Caste details"; ?>:</div>
                                            <div class="col"><?php echo $prof->is_public == 1 ? $prof->caste_detail:"****"; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col"><?php echo lang('global')->location??"Location"; ?>:</div>
                                            <div class="col"><?php echo $prof->is_public == 1 ? $prof->address:"****"; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col"><?php echo lang('global')->education??"Education"; ?>:</div>
                                            <div class="col"><?php echo $prof->is_public == 1 ? $prof->education:"****"; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col"><?php echo lang('global')->profession??"Profession"; ?>:</div>
                                            <div class="col"><?php echo $prof->is_public == 1 ? $prof->occupation:"****"; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col"><?php echo lang('global')->annual_income??"Annual income"; ?>:</div>
                                            <div class="col"><?php echo $prof->is_public == 1 ? $prof->annual_income:"****"; ?> <?php echo lang('global')->lpa??"LPA"; ?></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="icon-footer card-footer">
                                <div class="frnd-icons">
                                    <?php if ($myreq->is_accepted == true) : ?>
                                        <i class="bi bi-person-check-fill"></i>
                                    <?php else : ?>
                                        <?php if ($myreq->success == true) : ?>
                                            <i data-request="cancel" data-user-id="<?php echo $prof->id; ?>" class="my-icons person-icon bi bi-person-dash" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" data-bs-title="<b><?php echo lang('global')->request??"Request"; ?></b>"></i>
                                        <?php else : ?>
                                            <i data-request="send" data-user-id="<?php echo $prof->id; ?>" class="my-icons person-icon bi bi-person-plus" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" data-bs-title="<b><?php echo lang('global')->request??"Request"; ?></b>"></i>
                                        <?php endif; ?>
                                    <?php endif; ?>


                                    <?php if ($is_liked == true) : ?>
                                        <i data-request="unlike" data-user-id="<?php echo $prof->id; ?>" class="my-icons heart-icon bi bi-heart-fill"></i>
                                    <?php else : ?>
                                        <i data-request="like" data-user-id="<?php echo $prof->id; ?>" class="my-icons heart-icon bi bi-heart"></i>
                                    <?php endif; ?>


                                    <!-- <a class="text-decoration-none" href="/<?php //echo home . route('showPublicProfile', ['profile_id' => $prof->id]); 
                                                                                ?>">
                                        <i class="my-icons door-icon bi-door-closed-fill"></i>
                                    </a> -->
                                </div>
                                <?php

                                ?>
                            </div>

                        </div>
                    </div>
                   <?php endforeach ?>
                <!-- Add more user cards here as needed -->
            </div>
        </div>
    </section>
<?php endif; ?>

<?php
$users = $context->data->user_list;
import(
    "apps/view/components/home/js/users.js.php",
    obj([])
);
?>