<?php if (defined("direct_access") != 1) {
    echo "Silenece is awesome";
    return;
} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php");
$plugin_dir = "emails";
?>
<style>
    .list-none li {
        font-weight: bold;
    }

    .menu-col {
        min-height: 300px !important;
    }
</style>
<section>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div id="sidebar-col" class="col-md-2 <?php echo sidebar_bg; ?>">
                <?php import("apps/admin/inc/sidebar.php"); ?>
            </div>
            <!-- Main Area -->
            <div id="content-col" class="col-md-10">
                <?php // import("apps/admin/pages/page-nav.php"); 
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="my-4 d-flex justify-content-end">
                            <!-- <a class="btn btn-primary" href="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/add-new-item"> <i class="fas fa-plus"></i> Add New</a> -->
                        </div>
                    </div>
                    <div class="col-md-12" style="height:300px; overflow-y:scroll;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>City</th>
                                    <th>Country</th>
                                    <th>Attempt</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $emailsObj = new Model('emails');
                                $allEmails =  ($emailsObj->filter_index(array('attempt'=>0)));
                                ?>
                                <?php foreach ($allEmails as $key => $vl) { 
                                    $vl =   (object) $vl;
                                    ?>
                                    <tr>
                                        <td><?php echo $vl->name; ?></td>
                                        <td><?php echo $vl->email; ?></td>
                                        <td><?php echo $vl->mobile; ?></td>
                                        <td><?php echo $vl->city; ?></td>
                                        <td><?php echo $vl->country; ?></td>
                                        <td><?php echo $vl->attempt; ?></td>
                                        <td><?php echo $vl->status; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <div class="col-md-6">
                        <div class="progress">
                            <div class="progress-bar"></div>
                        </div>

                        <form action="/<?php echo home; ?>/admin/<?php echo $plugin_dir; ?>/csv-upload-ajax" id="csv-import-form">
                            <input type="file" name="csv_file" placeholder="CSV file only">
                            <button id="csv-import-btn" class="btn btn-primary">
                                Import
                            </button>
                        </form>
                        <style>
                            /* Hide scrollbar for all elements */
                            .hide-scroll::-webkit-scrollbar {
                                display: none;
                            }
                        </style>
                        <div class="hide-scroll my-3" style="height: 200px; overflow-y:scroll;">
                            <div id="res" style="background-color: lightgray;"></div>
                        </div>
                        <?php
                        pkAjax_form("#csv-import-btn", "#csv-import-form", "#res", "click", true);
                        ajaxActive(".progress");
                        ?>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>