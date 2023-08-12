<?php
$post_detail = $context->post_detail;
$pd = obj($post_detail);
$catlist = $context->cat_list;
$meta_tags = null;
$meta_desc = null;
if ($pd->json_obj != "") {
    $jsn = json_decode($pd->json_obj);
    if (isset($jsn->meta->tags)) {
        $meta_tags = $jsn->meta->tags;
    }
    if (isset($jsn->meta->description)) {
        $meta_desc = $jsn->meta->description;
    }
}
?>

<form action="/<?php echo home . route('postUpdateAjax', ['id' => $pd->id]); ?>" id="update-new-post-form">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title">Edit Post</h5>
                </div>
                <div class="col text-end my-3">
                    <a class="btn btn-dark" href="/<?php echo home . route('postList'); ?>">Back</a>
                </div>
            </div>
            <div id="res"></div>
            <div class="row">
                <div class="col-md-8">
                    <h4>Title</h4>
                    <input type="text" name="title" value="<?php echo $pd->title; ?>" class="form-control my-3" placeholder="Title">
                    <h6>Slug</h6>
                    <input type="text" name="slug" value="<?php echo $pd->slug; ?>" class="form-control my-3" placeholder="slug">
                    <h4>Post category</h4>
                    <select name="parent_id" class="form-select my-3">
                        <option <?php echo $pd->parent_id == 0 ? "selected" : null; ?> value="0">Uncategorised</option>
                        <?php foreach ($catlist as  $cv) {
                            $cv = obj($cv);
                        ?>
                            <option <?php echo $pd->parent_id == $cv->id ? "selected" : null; ?> value="<?php echo $cv->id; ?>"><?php echo $cv->title; ?></option>
                        <?php } ?>
                        <?php ?>
                    </select>
                    <textarea class="tinymce-editor" name="content" id="mce_0" aria-hidden="true"><?php echo $pd->content; ?></textarea>
                    <h4>Tags</h4>
                    <textarea class="form-control" name="meta_tags" aria-hidden="true"><?php echo $meta_tags; ?></textarea>
                    <h4>Meta description</h4>
                    <textarea class="form-control" name="meta_description" aria-hidden="true"><?php echo $meta_desc; ?></textarea>
                </div>
                <div class="col-md-4">
                    <h4>Banner</h4>
                    <input accept="image/*" id="image-input" type="file" name="banner" class="form-control my-3">
                    <img style="width:100%; max-height:300px; object-fit:contain;" id="banner" src="/<?php echo MEDIA_URL; ?>/images/pages/<?php echo $pd->banner; ?>" alt="<?php echo $pd->banner; ?>">
                    <div class="d-grid">
                        <button id="update-post-btn" type="button" class="btn btn-primary my-3">Update</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</form>
<script>
    window.onload = () => {

        const imageInputPost = document.getElementById('image-input');
        const imagePost = document.getElementById('banner');

        imageInputPost.addEventListener('change', (event) => {
            const file = event.target.files[0];
            const fileReader = new FileReader();

            fileReader.onload = () => {
                imagePost.src = fileReader.result;
            };

            fileReader.readAsDataURL(file);
        });

        // for slug
        const titleInput = document.querySelector('input[name="slug"]');
        const slugInput = document.querySelector('input[name="slug"]');
        if (titleInput && slugInput) {
            titleInput.addEventListener('keyup', () => {
                const title = titleInput.value.trim();
                generateSlug(title, slugInput);
            });
        }
    }
</script>
<?php pkAjax_form("#update-post-btn", "#update-new-post-form", "#res"); ?>