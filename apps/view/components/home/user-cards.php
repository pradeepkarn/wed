<?php
$users = $context->user_list;
import(
"apps/view/components/home/css/users.css.php",
obj([])
);
?>
<?php if (USER) : ?>
  <!-- ======= Team Section ======= -->
  <section id="team" class="team">

    <div class="container" data-aos="fade-up">

      <header class="section-header">
        <h2>Team</h2>
        <p>Our hard working team</p>
      </header>

      <div class="row gy-4">
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
        <div class="col-md-3" data-aos="fade-up" data-aos-delay="100">
        <div class="card h-100">
          <div class="member">
            <div class="member-img">
              <img src="/<?php echo MEDIA_URL; ?>/images/profiles/<?php echo $prof->image; ?>" class="img-fluid" alt="">
              <div class="social">
                <a href=""><i class="bi bi-twitter"></i></a>
                <a href=""><i class="bi bi-facebook"></i></a>
                <a href=""><i class="bi bi-instagram"></i></a>
                <a href=""><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
               <!-- like request open -->
          <div class="icon-footer">
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


              <a class="text-decoration-none" href="/<?php echo home . route('showPublicProfile', ['profile_id' => $prof->id]); ?>">
                <i class="my-icons door-icon bi-door-closed-fill"></i>
              </a>
            </div>
            <?php

            ?>
          </div>
          <!-- like request open -->
            <div class="member-info">
              <h4><?php echo $prof->first_name; ?></h4>
              <span><?php echo $prof->occupation; ?></span>
              <?php echo pk_excerpt($prof->bio,15); ?>
            </div>
          
          </div>
         
        </div>
        </div>
        <?php endforeach ?>


      </div>

    </div>

  </section><!-- End Team Section -->
<?php endif; ?>