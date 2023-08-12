<!-- slider -->
<!-- style="border-top-left-radius:50%; border-bottom-right-radius:50%;" -->
<section class="mobile-hide" style="position: relative;">
    <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div id="carouselExampleFade" class="carousel slide carousel-slide" data-bs-ride="carousel">
                <div class="carousel-inner" >
                    <?php $slider = new Dbobjects();
                    $slider->tableName = "content";
                    $sldrqry['content_group'] = "slider";
                    $sldrqry['is_active'] = true;
                    $slides = $slider->filter($sldrqry);
                    $i = 0;
                    foreach ($slides as $key => $sldval) : ?>
                        <div class="text-center carousel-item bg-secondary <?php if ($i == 0) {
                                                                                echo "active";
                                                                            } ?>" style="height: 70vh; background-image: url(/<?php echo MEDIA_URL; ?>/images/pages/<?php echo $sldval['banner']; ?>); background-repeat: no-repeat; background-position: center; background-size: cover;">
                            <div style="position: relatve; height: 100%; background-color: rgba(0,0,0,0.3); ">
                                <div style="position: relative; top: 30% !important;">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div>


                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php $i++;
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