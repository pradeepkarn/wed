<?php
// $cat = $context->data->category;
$req = $context->data->req;
$cp = $context->data->current_page;
$tp = $context->data->total_post;
$posts_by_cat = $context->data->posts_by_cat;
$popular_posts = $context->data->popular_posts;
$trending_posts = $context->data->trending_posts;
$latest_posts = $context->data->latest_posts;
$post_categories = $context->data->post_categories;
// $catslug = $context->data->slug;
?>
<style>
  #loading-spinner {
    display: none;
  }
</style>
<section>
  <div class="container">
    <div class="row">

      <div class="col-md-9" data-aos="fade-up">
        <h3 class="category-title">All Posts</h3>
        <div class="my-4">
        <div class="custom-pagination">
            <?php
            $pg = isset($req->page)?$req->page:1;
            $tp = $tp; // Total pages
            $current_page = $cp; // Assuming first page is the current page
            $link = route('allPosts'); // Set your link here

            // Calculate start and end page numbers to display
            $start_page = max(1, $current_page - 2);
            $end_page = min($start_page + 4, $tp);

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
            if ($end_page < $tp) {
              echo '<span>...</span>';
            }

            // Show last page button if not on the last page
            if ($current_page < $tp) {
              echo '<a class="last-button" href="/' . home . $link . '?page=' . $tp . '">&raquo;</a>';
            }
            ?>
          </div>
        </div>
        <div id="blog-posts">
          <?php

          foreach ($posts_by_cat as $pv) :
            $pv = obj($pv);
          ?>
            <div class="d-md-flex post-entry-2 half">
              <a href="/<?php echo home . route('readPost', ['slug' => $pv->slug]) ?>" class="me-4 thumbnail">
                <img src="/<?php echo MEDIA_URL; ?>/images/pages/<?php echo $pv->banner; ?>" alt="<?php echo $pv->title; ?>" class="img-fluid">
              </a>
              <div>
                <div class="post-meta"><span class="date"><?php echo $pv->category_name; ?></span> <span class="mx-1">&bullet;</span> <span><?php echo $pv->updated_at; ?></span></div>
                <h3><a href="/<?php echo home . route('readPost', ['slug' => $pv->slug]) ?>"><?php echo $pv->title; ?></a></h3>
                <?php echo pk_excerpt($pv->content, 200); ?>
                <div class="d-flex align-items-center author">
                  <div class="photo"><img src="/<?php echo MEDIA_URL; ?>/images/profiles/<?php echo $pv->author_image; ?>" alt="" class="img-fluid"></div>
                  <div class="name">
                    <h3 class="m-0 p-0"><?php echo $pv->author; ?></h3>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach;

          ?>
        </div>

        <!-- <div>
          <button type="button" class="btn btn-primary" onclick="loadMorePosts()">
            <span>Load More </span> 
            <span id="loading-spinner"> please wait...</span>
          </button>
        </div> -->
        <div class="text-start py-4">
          <div class="custom-pagination">
            <?php
            $pg = isset($req->page)?$req->page:1;
            $tp = $tp; // Total pages
            $current_page = $cp; // Assuming first page is the current page
            $link = route('allPosts'); // Set your link here

            // Calculate start and end page numbers to display
            $start_page = max(1, $current_page - 2);
            $end_page = min($start_page + 4, $tp);

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
            if ($end_page < $tp) {
              echo '<span>...</span>';
            }

            // Show last page button if not on the last page
            if ($current_page < $tp) {
              echo '<a class="last-button" href="/' . home . $link . '?page=' . $tp . '">&raquo;</a>';
            }
            ?>
          </div>

        </div>
      </div>

      <div class="col-md-3">
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
              <?php
              foreach ($popular_posts as $ppv) :
                $ppv = obj($ppv);
              ?>
                <div class="post-entry-1 border-bottom">
                  <div class="post-meta"><span class="date"><?php echo $ppv->category_name; ?></span> <span class="mx-1">&bullet;</span> <span><?php echo $ppv->updated_at; ?></span></div>
                  <h2 class="mb-2"><a href="/<?php echo home . route('readPost', ['slug' => $ppv->slug]) ?>"><?php echo $ppv->title; ?></a></h2>
                  <span class="author mb-3 d-block"><?php echo $ppv->author; ?></span>
                </div>
              <?php endforeach;

              ?>

            </div> <!-- End Popular -->

            <!-- Trending -->
            <div class="tab-pane fade" id="pills-trending" role="tabpanel" aria-labelledby="pills-trending-tab">


              <?php foreach ($trending_posts as $tpv) :
                $tpv = obj($tpv);
              ?>
                <div class="post-entry-1 border-bottom">
                  <div class="post-meta"><span class="date"><?php echo $tpv->category_name; ?></span> <span class="mx-1">&bullet;</span> <span><?php echo $tpv->updated_at; ?></span></div>
                  <h2 class="mb-2"><a href="/<?php echo home . route('readPost', ['slug' => $tpv->slug]) ?>"><?php echo $tpv->title; ?></a></h2>
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
                  <h2 class="mb-2"><a href="/<?php echo home . route('readPost', ['slug' => $lpv->slug]) ?>"><?php echo $lpv->title; ?></a></h2>
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
              <img src="/<?php // echo STATIC_URL; 
                          ?>/view/assets/img/post-landscape-5.jpg" alt="" class="img-fluid">
            </a>
          </div>
        </div> -->
        <!-- End Video -->

        <div class="aside-block">
          <h3 class="aside-title">Categories</h3>
          <ul class="aside-links list-unstyled">
            <?php foreach ($post_categories as $pct) {
              $pct = obj($pct); ?>
              <li><a href="/<?php echo home . route('category', ['slug' => $pct->slug]) ?>"><i class="bi bi-chevron-right"></i> <?php echo $pct->title; ?></a></li>
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