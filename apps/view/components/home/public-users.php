<?php
$users = $context->user_list;
$tu = $context->total_users;
$cp = $context->current_page;
import(
    "apps/view/components/home/css/users.css.php",
    obj([])
);
?>
<?php if (USER) : ?>
    <div id="send-req-response-users-component"></div>
    <section>
        <div class="container py-5">
            <div class="row row-cols-1 row-cols-md-3 g-4" id="append">
                <?php
                foreach ($users as $uk => $prof) :
                    $prof = obj($prof);
                    $age = getAgeFromDOB($prof->dob);
                    $prof->image = $prof->is_public == 1 ? $prof->image:'default-user.png';
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
                                            <div class="col"><?php echo $prof->is_public == 1 ? $prof->caste_detail:"****"; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col">Location:</div>
                                            <div class="col"><?php echo $prof->is_public == 1 ? $prof->address:"****"; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col">Education:</div>
                                            <div class="col"><?php echo $prof->is_public == 1 ? $prof->education:"****"; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col">Profession:</div>
                                            <div class="col"><?php echo $prof->is_public == 1 ? $prof->occupation:"****"; ?></div>
                                        </div>
                                        <div class="row">
                                            <div class="col">Annual Income:</div>
                                            <div class="col"><?php echo $prof->is_public == 1 ? $prof->annual_income:"****"; ?> LPA</div>
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
                                            <i data-request="cancel" data-user-id="<?php echo $prof->id; ?>" class="my-icons person-icon bi bi-person-dash" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" data-bs-title="<b>Interest</b>"></i>
                                        <?php else : ?>
                                            <i data-request="send" data-user-id="<?php echo $prof->id; ?>" class="my-icons person-icon bi bi-person-plus" data-bs-toggle="tooltip" data-bs-html="true" data-bs-placement="top" data-bs-title="<b>Interest</b>"></i>
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
            <div class="row">
                <div class="col-md-4 mx-auto my-5 text-center">
                    <div class="custom-pagination">
                        <?php
                        $pg = isset($_GET['page']) ? $_GET['page'] : 1;
                        $tu = $tu; // Total pages
                        $current_page = $cp; // Assuming first page is the current page
                        $link = route('home'); // Set your link here

                        // Calculate start and end page numbers to display
                        $start_page = max(1, $current_page - 2);
                        $end_page = min($start_page + 4, $tu);

                        // Show first page button if not on the first page
                        if ($current_page > 1) {
                            echo '<a class="first-button" href="/' . home . $link . '?page=1">&laquo;</a>';
                        }

                        // Show ellipsis if there are more pages before the start page
                        if ($start_page > 1) {
                            echo '<span>...</span>';
                        }

                        // Display page links within the range
                        for ($i = $start_page; $i <= $end_page; $i++) {
                            $active_class = ($pg == $i) ? "active" : null;
                            echo '<a class="' . $active_class . '" href="/' . home . $link . '?page=' . $i . '">' . $i . '</a>';
                        }

                        // Show ellipsis if there are more pages after the end page
                        if ($end_page < $tu) {
                            echo '<span>...</span>';
                        }

                        // Show last page button if not on the last page
                        if ($current_page < $tu) {
                            echo '<a class="last-button" href="/' . home . $link . '?page=' . $tu . '">&raquo;</a>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>


    <?php
    $users = $context->user_list;
    import(
        "apps/view/components/home/js/users.js.php",
        obj([])
    );
    ?>
<?php endif; ?>