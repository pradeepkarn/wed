<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php $GLOBALS["title"] = "Home"; ?>
<?php import("apps/admin/inc/header.php"); ?>
<?php import("apps/admin/inc/nav.php"); ?>
<style>
.list-none li{
    font-weight: bold;
}
.menu-col{
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
            <?php import("apps/admin/pages/page-nav.php"); ?>
            <div class="row">
        <div class="col-md-12">
            <!-- <form action="" method="post">
            <div class="row">
                <div class="col-md-8">
                    <input type="text" onkeyup="createSlug('page_title', 'page_slug');" id="page_title" required name="page_title" placeholder="Title" class="form-control mb-2">
                    <input type="text" placeholder="url-slug" onblur="createSlug(this.id, this.id);" id="page_slug" required  name="slug" class="form-control">
                    <input type="hidden" name="add_new_content" value="add_new_content">
                </div>
                <div class="col-md-4">
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Add New <span class="text-capt"> Item </span>  <i class="fas fa-level-down-alt"></i></button>
                    </div>
                </div>
            </div>
            </form> -->
            <div class="my-4 d-flex justify-content-end">
                    <a class="btn btn-primary" href="/<?php echo home; ?>/admin/contents/add-new-item"> <i class="fas fa-plus"></i> Add New Page</a>
            </div>
            <table id="datatablesSimple" class="table-sm table table-bordered">
                <thead>
                    <th>Content ID</th>
                    <th>Status</th>
                    <th>Thumbnail</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th class="text-center">Status</th>
                    <th>Category</th>
                    <th>Type</th>
                    <th class="hide">View</th>
                    <th>Edit</th>
                    <th>Trash</th>
                </thead>
                <tbody>
            <?php 
               
                $db = new Model('content');
                $pgqry['content_group'] = "content";
                $pgqry['content_type'] = "page";
                $prods = $db->filter_index($pgqry,$ord = "DESC",$limit = 500);
                if ($prods!=false) {
                foreach ($prods as $pk => $pv) { ?>
                <tr>
                    <td><?php echo $pv['id']; ?></td> 
                    <td <?php matchData($pv['status'],'published','class="bg-success text-white"'); 
                                matchData($pv['status'],'trash','class="bg-secondary text-white"');
                                matchData($pv['status'],'draft','class="bg-warning"');
                    ?>><?php echo $pv['status']; ?></td> 
                    <td><img style="height: 50px;" src="/<?php echo media_root; ?>/images/pages/<?php echo $pv['banner']; ?>"></td> 
                    <td><?php echo $pv['title']; ?></td> 
                    <td><?php echo $pv['slug']; ?></td> 
                    <td><p class="text-center  text-capt px-1 pb-1 pk-round <?php echo ($pv['status']!="listed")?"text-dark bg-warning":"text-white bg-success"; ?>"><?php echo $pv['status']; ?></p></td> 
                    <td><?php echo (getData("content",$pv['parent_id'])!=false)?getData("content",$pv['parent_id'])['title']:"NA"; ?></td> 
                    <td><span class="<?php echo ($pv['post_category']=="featured")?"p-1 bg-primary text-white":""; echo ($pv['post_category']=="trending")?"p-1 bg-success text-white":""; ?>"><?php echo $pv['post_category']; ?></span></td> 
                    <td class="hide"><a target="_blank" href='<?php echo "/".home."/item/?lid={$pv['id']}"; ?>'>View</a></td> 
                    <td><a href="/<?php echo home; ?>/admin/contents/edit/<?php echo $pv['id']; ?>">Edit</a></td>
                    <td><a data-bs-toggle="modal" data-bs-target="#deltModal<?php echo $pv['id']; ?>" href="javascript:void(0);" class="text-danger">Delete</a></td>
                    <div class="modal" id="deltModal<?php echo $pv['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel<?php echo $pv['id']; ?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">
                            
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h3 class="bg-danger p-3 text-white">Be careful, this action can not be un done!</h3>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                        <div class="modal-footer">
                        <a class="btn btn-danger" href="/<?php echo home; ?>/admin/contents/delete/<?php echo $pv['id']; ?>">Delete</a>
                        </div>
                        </div>
                    </div>
                    </div>
                </tr>
            <?php } }
                ?>
                </tbody>
            </table>
        </div>
    </div>
            </div>
        </div>
    </div>
</section>
<?php import("apps/admin/inc/footer.php"); ?>