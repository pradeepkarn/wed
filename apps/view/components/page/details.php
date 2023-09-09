<style>
    .post-cover {
        height: 50vh;
        background-image: url('/<?php echo MEDIA_URL; ?>/images/pages/<?php echo $context->data->banner; ?>');
        background-size: cover;
        background-repeat: no-repeat;
    }
    .page-title{
        margin-top: 100px;
        color: white;
    }
</style>
<section class="post-cover">
    <div style="position: relatve; height: 50vh; background-color: rgba(0,0,0,0.3); ">

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center page-title"><?php echo $context->data->title; ?></h1>
                </div>

            </div>

        </div>
    </div>
</section>


<section>
    <div class="container" data-aos="fade-up">


        <div class="row mb-5">
            <div class="col-md-10 mx-auto">

                <div class="ps-md-5 mt-4 mt-md-0">
                    <!-- <div class="post-meta mt-4">Privacy Policy</div> -->
                    <h2 class="mb-4 display-4">Details</h2>
                    <?php
                    echo ($context->data->content); ?>
                </div>
            </div>



        </div>

    </div>
</section>