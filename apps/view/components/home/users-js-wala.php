<?php
$users = $context->user_list;
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
                <!-- Add more user cards here as needed -->
                
            </div>
            <div class="row">
            <div class="col-md-4 mx-auto my-5 text-center">
                    <button style="display: block;" id="load_more_btn" class="btn btn-primary">Load More</button>
                </div>
            </div>
        </div>
    </section>


    <?php
    $users = $context->user_list;
   
    import(
        "apps/view/components/home/js/fetch-users.js.php",
        obj([])
    );
    import(
        "apps/view/components/home/js/users.js.php",
        obj([])
    );
    ?>
<?php endif; ?>