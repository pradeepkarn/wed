<?php
$pv = $context->data->post_detail;
$comments = $context->data->comments;
$popular_posts = $context->data->popular_posts;
$trending_posts = $context->data->trending_posts;
$latest_posts = $context->data->latest_posts;
$post_categories = $context->data->post_categories ;
?>
<section class="single-post-content">
  <div class="container">
    <div class="row">
      <div class="col-md-9 post-content" data-aos="fade-up">

        <!-- ======= Single Post Content ======= -->
        <div class="single-post">
          <div class="post-meta"><span class="date"><?php echo $pv->category_name; ?></span>
            <span class="mx-1">&bullet;</span> <span><?php echo $pv->updated_at; ?>, View: <?php echo $pv->views; ?></span>
          </div>
          <h1 class="mb-5"><?php echo $pv->title; ?></h1>

          <?php echo $pv->content; ?>

        </div><!-- End Single Post Content -->

        <!-- ======= Comments ======= -->
        <div id="commentList" class="comments">
          <h5 class="comment-title py-4"><?php echo count($comments) ?> Comments</h5>
          <div style="max-height: 300px; overflow-y:scroll;">
            <?php foreach ($comments as $cmt) :
              $cmt = obj($cmt);
              $rplcnt = count($cmt->replies);
            ?>
              <div class="comment d-flex mb-4">
                <div class="flex-shrink-0">
                  <div class="avatar avatar-sm rounded-circle">
                    <img class="avatar-img" src="/<?php echo STATIC_URL; ?>/view/assets/img/person-5.jpg" alt="" class="img-fluid">
                  </div>
                </div>
                <div class="flex-grow-1 ms-2 ms-sm-3">
                  <div class="comment-meta d-flex align-items-baseline">
                    <h6 class="me-2"><?php echo $cmt->name; ?></h6>
                    <span class="text-muted">2d</span>
                  </div>
                  <div class="comment-body">
                    <?php echo $cmt->message; ?>
                  </div>

                  <div class="comment-replies bg-light p-3 mt-3 rounded">
                    <h6 class="comment-replies-title mb-4 text-muted text-uppercase"><?php echo $rplcnt; ?> Replies</h6>
                    <?php foreach ($cmt->replies as $rpl) :
                      $rpl = obj($rpl);
                    ?>
                      <div class="reply d-flex mb-4">
                        <div class="flex-shrink-0">
                          <div class="avatar avatar-sm rounded-circle">
                            <img class="avatar-img" src="/<?php echo STATIC_URL; ?>/view/assets/img/person-4.jpg" alt="" class="img-fluid">
                          </div>
                        </div>
                        <div class="flex-grow-1 ms-2 ms-sm-3">
                          <div class="reply-meta d-flex align-items-baseline">
                            <h6 class="mb-0 me-2"><?php echo $rpl->name; ?></h6>
                            <span class="text-muted">2d</span>
                          </div>
                          <div class="reply-body">
                            <?php echo $rpl->message; ?>
                          </div>
                        </div>
                      </div>
                    <?php endforeach; ?>
                    <a onclick="setCommentDetail(this)" data-comentId="<?php echo $cmt->id; ?>" data-reply-to="<?php echo $cmt->name; ?>" data-bs-toggle="modal" data-bs-target="#replyModal" id="reply-btn-<?php echo $cmt->id; ?>" class="ms-auto" href="#">Reply</a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div><!-- End scroll -->
        </div><!-- End Comments -->


        <!-- ======= Comments Form ======= -->
        <div class="row justify-content-center mt-5">

          <div class="col-lg-12">
            <form id="comment-form" action="">
              <h5 class="comment-title">Leave a Comment</h5>
              <div id="res"></div>
              <div class="row">
                <div class="col-lg-6 mb-3">
                  <label for="comment-name">Name</label>
                  <input type="text" name="name" class="form-control cmtdata" id="comment-name" placeholder="Enter your name">
                </div>
                <div class="col-lg-6 mb-3">
                  <label for="comment-email">Email</label>
                  <input type="text" name="email" class="form-control cmtdata" id="comment-email" placeholder="Enter your email">
                </div>
                <div class="col-12 mb-3">
                  <label for="comment-message">Message</label>

                  <textarea class="form-control cmtdata" name="message" id="comment-message" placeholder="Enter your name" rows="3"></textarea>
                </div>
                <div class="col-12">
                  <input type="hidden" class="cmtdata" name="post_id" value="<?php echo $pv->id; ?>">
                  <input id="comment-submit-btn" type="submit" class="btn btn-primary" value="Post comment">
                </div>
              </div>
            </form>
          </div>
          <!-- reply modal -->

          <div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="replyModalLabel">Comment</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="" id="reply-submit-form">
                    <h5 class="comment-title">Replying to <span id="set-reply-to-name"></span></h5>
                    <div id="res"></div>
                    <div class="row">
                      <div class="col-lg-6 mb-3">
                        <label for="comment-name">Name</label>
                        <input type="text" name="name" class="form-control cmtdata" id="comment-name" placeholder="Enter your name">
                      </div>
                      <div class="col-lg-6 mb-3">
                        <label for="comment-email">Email</label>
                        <input type="text" name="email" class="form-control cmtdata" id="comment-email" placeholder="Enter your email">
                      </div>
                      <div class="col-12 mb-3">
                        <label for="comment-message">Message</label>

                        <textarea class="form-control cmtdata" name="message" id="comment-message" placeholder="Enter your name" rows="2"></textarea>
                      </div>
                      <div class="col-12">
                        <input type="hidden" class="cmtdata" name="post_id" value="<?php echo $pv->id; ?>">
                        <input id="reply-submit-btn" type="submit" class="btn btn-primary" value="Reply">
                      </div>
                    </div>
                    <input type="hidden" name="reply_to" id="set-reply-to-id" value="0">
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                  <!-- <button type="button" class="btn btn-primary">Reply</button> -->
                </div>
              </div>
            </div>
          </div>
          <script>
            document.getElementById('aosCss').remove();

            function setCommentDetail(obj) {
              const cntid = obj.getAttribute("data-comentId");
              const replyTo = obj.getAttribute("data-reply-to");
              document.getElementById('set-reply-to-id').value = cntid;
              document.getElementById('set-reply-to-name').innerText = replyTo;
            }
          </script>
          <!-- reply modal end -->
        </div><!-- End Comments Form -->

        <?php
        $postCommnentUrl = "/" . home . route('postCommentAjax', ['slug' => $pv->slug]);
        pkAjax("#comment-submit-btn", $postCommnentUrl, "#comment-form", "#res");
        pkAjax("#reply-submit-btn", $postCommnentUrl, "#reply-submit-form", "#res");
        ?>

      </div>
      <div class="col-md-3 ps-5">
        <!-- ======= Sidebar ======= -->
        <div class="aside-block">

          <ul class="nav nav-pills custom-tab-nav mb-4" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pills-popular-tab" data-bs-toggle="pill" data-bs-target="#pills-popular" type="button" role="tab" aria-controls="pills-popular" aria-selected="true">Popular</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-trending-tab" data-bs-toggle="pill" data-bs-target="#pills-trending" type="button" role="tab" aria-controls="pills-trending" aria-selected="false">Trending</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="pills-latest-tab" data-bs-toggle="pill" data-bs-target="#pills-latest" type="button" role="tab" aria-controls="pills-latest" aria-selected="false">Latest</button>
            </li>
          </ul>

          <div class="tab-content" id="pills-tabContent">

            <!-- Popular -->
            <div class="tab-pane fade show active" id="pills-popular" role="tabpanel" aria-labelledby="pills-popular-tab">
              <?php foreach ($popular_posts as $ppv) : 
                $ppv = obj($ppv);
                ?>
                <div class="post-entry-1 border-bottom">
                  <div class="post-meta"><span class="date"><?php echo $ppv->category_name; ?></span> <span class="mx-1">&bullet;</span> <span><?php echo $ppv->updated_at; ?></span></div>
                  <h2 class="mb-2"><a href="/<?php echo home.route('readPost',['slug'=>$ppv->slug]) ?>"><?php echo $ppv->title; ?></a></h2>
                  <span class="author mb-3 d-block"><?php echo $ppv->author; ?></span>
                </div>
              <?php endforeach; ?>
          
            </div> <!-- End Popular -->

            <!-- Trending -->
            <div class="tab-pane fade" id="pills-trending" role="tabpanel" aria-labelledby="pills-trending-tab">
        

              <?php foreach ($trending_posts as $tpv) : 
                $tpv = obj($tpv);
                ?>
                <div class="post-entry-1 border-bottom">
                  <div class="post-meta"><span class="date"><?php echo $tpv->category_name; ?></span> <span class="mx-1">&bullet;</span> <span><?php echo $tpv->updated_at; ?></span></div>
                  <h2 class="mb-2"><a href="/<?php echo home.route('readPost',['slug'=>$tpv->slug]) ?>"><?php echo $tpv->title; ?></a></h2>
                  <span class="author mb-3 d-block"><?php echo $tpv->author; ?></span>
                </div>
              <?php endforeach; ?>
            </div> <!-- End Trending -->

            <!-- Latest -->
            <div class="tab-pane fade" id="pills-latest" role="tabpanel" aria-labelledby="pills-latest-tab">
              

              <?php foreach ($popular_posts as $lpv) : 
                $lpv = obj($lpv);
                ?>
                <div class="post-entry-1 border-bottom">
                  <div class="post-meta"><span class="date"><?php echo $lpv->category_name; ?></span> <span class="mx-1">&bullet;</span> <span><?php echo $lpv->updated_at; ?></span></div>
                  <h2 class="mb-2"><a href="/<?php echo home.route('readPost',['slug'=>$lpv->slug]) ?>"><?php echo $lpv->title; ?></a></h2>
                  <span class="author mb-3 d-block"><?php echo $lpv->author; ?></span>
                </div>
              <?php endforeach; ?>

            </div> <!-- End Latest -->

          </div>
        </div>

        <!-- <div class="aside-block">
          <h3 class="aside-title">Video</h3>
          <div class="video-post">
            <a href="https://www.youtube.com/watch?v=AiFfDjmd0jU" class="glightbox link-video">
              <span class="bi-play-fill"></span>
              <img src="/<?php // echo STATIC_URL; ?>/view/assets/img/post-landscape-5.jpg" alt="" class="img-fluid">
            </a>
          </div>
        </div> -->
        <!-- End Video -->

        <div class="aside-block">
          <h3 class="aside-title">Categories</h3>
          <ul class="aside-links list-unstyled">
            <?php foreach ($post_categories as $pct) { 
              $pct = obj($pct); ?>
              <li><a href="/<?php echo home.route('category',['slug'=>$pct->slug]) ?>"><i class="bi bi-chevron-right"></i> <?php echo $pct->title; ?></a></li>
           <?php } ?>
          </ul>
        </div>
        <!-- End Categories -->

        <!-- <div class="aside-block">
          <h3 class="aside-title">Tags</h3>
          <ul class="aside-tags list-unstyled">
            <li><a href="category.html">Business</a></li>
            <li><a href="category.html">Culture</a></li>
            <li><a href="category.html">Sport</a></li>
            <li><a href="category.html">Food</a></li>
            <li><a href="category.html">Politics</a></li>
            <li><a href="category.html">Celebrity</a></li>
            <li><a href="category.html">Startups</a></li>
            <li><a href="category.html">Travel</a></li>
          </ul>
        </div> -->
        <!-- End Tags -->

      </div>
    </div>
  </div>
</section>