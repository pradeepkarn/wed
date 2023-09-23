<?php
$album = $context->data->my_album;
$album_groups = $context->data->album_groups;
?>
<style>
  #portfolio {
    margin-top: 100px;
  }

  .tabs {
    list-style: none;
    display: flex;
  }

  .tab {
    cursor: pointer;
    padding: 10px;
    border: 1px solid #ccc;
    margin-right: 10px;
  }

  .edit-tool {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 10px 0 10px 0;
  }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.9/cropper.min.js"></script>

<!-- ======= Portfolio Section ======= -->
<section id="portfolio" class="portfolio">

  <div class="container" data-aos="fade-up">

    <header class="section-header">
      <h2>Album</h2>
      <p>Explore my world</p>
    </header>

    <div class="row" data-aos="fade-up" data-aos-delay="100">
      <div class="col-md-12 text-end mb-3">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addMediaId">
          <i class="fas fa-plus"></i>
          Upload Images
        </button>



      </div>
      <!-- Modal -->
      <div class="modal fade" id="addMediaId" tabindex="-1" role="dialog" data-bs-backdrop='static' aria-labelledby="mediaModalId" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="mediaModalId">Add Image</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5">
              <div class="container-fluid">
                <div class="btn-group my-3" role="group" aria-label="Aspect Ratio Options">
                  <input type="radio" class="btn-check tab" name="aspect-ratio" id="aspectKeepOriginal" autocomplete="off" data-aspect-ratio="keepOriginal" checked>
                  <label class="btn btn-outline-primary" for="aspectKeepOriginal">Keep Original</label>

                  <input type="radio" class="btn-check tab" name="aspect-ratio" id="aspectNoCrop" autocomplete="off" data-aspect-ratio="noCrop">
                  <label class="btn btn-outline-primary" for="aspectNoCrop">Free <i class="bi bi-crop"></i></label>

                  <input type="radio" class="btn-check tab" name="aspect-ratio" id="aspect1x1" autocomplete="off" data-aspect-ratio="ratio1x1">
                  <label class="btn btn-outline-primary" for="aspect1x1">1:1 (Profile Image)<i class="bi bi-crop"></i></label>

                  <input type="radio" class="btn-check tab" name="aspect-ratio" id="aspect16x9" autocomplete="off" data-aspect-ratio="ratio16x9">
                  <label class="btn btn-outline-primary" for="aspect16x9">16:9 (Cover Image)<i class="bi bi-crop"></i></label>


                </div>



                <form id="upload-album" action="/<?php echo home . route('uploadGalleryFile'); ?>" enctype="multipart/form-data">
                  <input name="croppedImage" accept=".jpeg,.jpg,.png,.webp" type="file" id="imageInput" class="form-control">
                  <label for="albumDropdown">Select an album or add a new one:</label>
                  <select name="album_group" id="albumDropdown" class="form-select my-2" onchange="handleDropdownChange()">
                    <option value="CREATE_NEW_ALBUM">Add New Album</option>
                    <?php foreach ($album_groups as $ag) {
                      $ag = obj($ag);
                    ?>
                      <option value="<?php echo $ag->album_group; ?>"><?php echo ucfirst($ag->album_group); ?></option>
                    <?php  } ?>
                  </select>
                  <div id="newAlbumInput">
                    <label for="newAlbumName">Enter the new album name:</label>
                    <input type="text" name="new_album_name" class="form-control my-2" id="newAlbumName">
                  </div>

                  <script>
                    function handleDropdownChange() {
                      const dropdown = document.getElementById("albumDropdown");
                      const newAlbumInput = document.getElementById("newAlbumInput");
                      const newAlbumNameInput = document.getElementById("newAlbumName");

                      if (dropdown.value === "CREATE_NEW_ALBUM") {
                        newAlbumInput.style.display = "block";
                        newAlbumNameInput.setAttribute("required", "true");
                      } else {
                        newAlbumInput.style.display = "none";
                        newAlbumNameInput.removeAttribute("required");
                      }
                    }
                  </script>
                  <div id="imageContainer"></div>
                  <div class="d-grid gap-2 my-3">
                    <button type="button" id="cropButton" class="btn btn-primary">Upload</button>
                  </div>
                </form>

              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            <?php
            import("apps/view/components/profile/gallery/js/cropper.js.php", obj([]));
            ?>
          </div>
        </div>
      </div>
      <div class="col-lg-12 d-flex justify-content-center">
        <ul id="portfolio-flters">
          <li data-filter="*" class="filter-active">All</li>
          <?php foreach ($album_groups as $ag) {
            $alb = obj($ag);
            $grp = ucfirst($alb->album_group);
            $alb->album_group = str_replace(" ", "-", $alb->album_group);
          ?>
            <li data-filter=".filter-<?php echo $alb->album_group; ?>"><?php echo $grp; ?></li>
          <?php  } ?>
        </ul>
      </div>
    </div>

    <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">
      <?php
      foreach ($album as $alb) :
        $alb = obj($alb);
        $grp = ucfirst($alb->album_group);
        $alb->album_group = str_replace(" ", "-", $alb->album_group);
      ?>
        <div class="col-lg-3 col-md-6 portfolio-item filter-<?php echo $alb->album_group; ?>">
          <div class="edit-tool">
            <button data-setting-imgsrc="<?php echo $alb->image; ?>" data-setting-userid="<?php echo $alb->user_id; ?>" data-setting-as="<?php echo 'cover'; ?>" data-setting-albumid="<?php echo $alb->id; ?>" type="button" class="setting-album-img button btn btn-primary btn-sm">Set as cover</button> 
            <button data-setting-imgsrc="<?php echo $alb->image; ?>" data-setting-userid="<?php echo $alb->user_id; ?>" data-setting-as="<?php echo 'profile'; ?>" data-setting-albumid="<?php echo $alb->id; ?>" type="button" class="setting-album-img button btn btn-primary btn-sm">Set as profile</button> 
            <i data-remove-imgsrc="<?php echo $alb->image; ?>" data-remove-userid="<?php echo $alb->user_id; ?>" data-edit-albumid="<?php echo $alb->id; ?>" data-remove-albumid="<?php echo $alb->id; ?>" class="fas fa-trash remove-album-img pk-pointer text-danger"></i>
          </div>
          <div class="portfolio-wrap">
            <img style="height: 300px; width:100%; object-fit:cover;" src="<?php echo SERVER_DOMAIN; ?>/media/images/profiles/<?php echo $alb->image; ?>" class="img-fluid" alt="<?php echo $alb->title; ?>">
            <div class="portfolio-info">
              <h4><?php echo $grp; ?></h4>
              <p><?php echo $grp; ?></p>

              <div class="portfolio-links">
                <a href="<?php echo SERVER_DOMAIN; ?>/media/images/profiles/<?php echo $alb->image; ?>" data-gallery="portfolioGallery" class="portfokio-lightbox" title="<?php echo $alb->title; ?>"><i class="bi bi-plus"></i></a>
                <a href="#" title="<?php echo $alb->title; ?>"><i class="bi bi-link"></i></a>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </div>

  </div>

</section><!-- End Portfolio Section -->