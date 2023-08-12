<?php
$comment_detail = $context->comment_detail;
$cd = obj($comment_detail);
$cg =  explode("/",REQUEST_URI);
$cg = $cg[3];
$req = new stdClass;
$req->cg = $cg;
?>

<form action="/<?php echo home.route('commentUpdateAjax',['id'=>$cd->id,'cg'=>$req->cg]); ?>" id="update-comment-form">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="card-title">Add user</h5>
                </div>
                <div class="col text-end my-3">
                    <a class="btn btn-dark" href="/<?php echo home . route('commentList',['cg'=>$req->cg]); ?>">Back</a>
                </div>
            </div>
            <div id="res"></div>
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-8">
                            <h4>Email</h4>
                            <input type="email" value="<?php echo $cd->email; ?>" name="email" class="form-control my-3" placeholder="Eemail">
                        </div>
                        <div class="col-md-4">
                            <h4>Name</h4>
                            <input type="text" name="name" value="<?php echo $cd->name; ?>" class="form-control my-3" placeholder="username">
                        </div>
                 
                        <div class="col-md-12">
                            <h4>Message</h4>
                            <textarea class="form-control" name="message" aria-hidden="true"><?php echo $cd->message; ?></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="d-grid">
                        <button id="update-comment-btn" type="button" class="btn btn-primary my-3">Update</button>
                    </div>
                </div>
            </div>

        </div>
    </div>

</form>
<script>
    const imageInputPost = document.getElementById('image-input');
    const imagePost = document.getElementById('image');

    imageInputPost.addEventListener('change', (event) => {
        const file = event.target.files[0];
        const fileReader = new FileReader();

        fileReader.onload = () => {
            imagePost.src = fileReader.result;
        };

        fileReader.readAsDataURL(file);
    });
</script>
<?php pkAjax_form("#update-comment-btn", "#update-comment-form", "#res"); ?>