<?php
$createData = $context;
?>

<form action="/<?php echo home; ?>/admin/post-category/create/save-by-ajax" id="save-new-post-form">
    <div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col">
                <h5 class="card-title">Add Post category</h5>
            </div>
            <div class="col text-end my-3">
                <a class="btn btn-dark" href="/<?php echo home.route('postCatList'); ?>">Back</a>
            </div>
        </div>
        <div id="res"></div>
        <div class="row">
            <div class="col-md-8">
                <h4>Title</h4>
            <input type="text" name="title" class="form-control my-3" placeholder="Title">
                <textarea class="tinymce-editor" name="content" id="mce_0" aria-hidden="true"></textarea>
            </div>
            <div class="col-md-4">
                <h4>Banner</h4>
                <input accept="image/*" id="image-input" type="file" name="banner" class="form-control my-3">
                <img style="width:100%; max-height:300px; object-fit:contain;" id="banner" src="" alt="">
                
                <div class="d-grid">
                    <button id="save-post-btn" type="button" class="btn btn-primary my-3">Save</button>
                </div>
            </div>
        </div>
        
    </div>
    </div>
    
</form>
<script>
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

</script>
 <?php pkAjax_form("#save-post-btn","#save-new-post-form","#res"); ?>