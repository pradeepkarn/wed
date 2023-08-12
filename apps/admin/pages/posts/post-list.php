<?php
$pl = $context->post_list;
$tp = $context->total_post;
$cp = $context->current_page;
$active = $context->is_active;
// myprint($pl)
?>
<style>
    .featured-post,
    .trending-post {
        font-size: 30px;
    }
</style>
<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col my-3">
                            <h5 class="card-title">All Post</h5>
                            <nav class="nav">
                                <a class="nav-link <?php echo $active ? "btn btn-sm btn-primary text-white" : ""; ?>" href="/<?php echo home . route('postList'); ?>">Active List</a>
                                <a class="nav-link <?php echo $active ? "" : "btn btn-sm btn-danger text-white"; ?>" href="/<?php echo home . route('postTrashList'); ?>">Trash List</a>
                            </nav>

                        </div>
                        <div class="col my-3">
                            <form action="">
                                <div class="row">
                                    <div class="col-8">
                                        <input value="<?php echo isset($_GET['search']) ? $_GET['search'] : null; ?>" type="search" class="form-control" name="search" placeholder="Search...">
                                    </div>
                                    <div class="col-4">
                                        <button type="submit" class="btn btn-primary ">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col text-end my-3">
                            <a class="btn btn-dark" href="/<?php echo home . route('postCreate'); ?>">Add New</a>
                        </div>
                    </div>

                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">
                                    <div class="text-center">
                                        Trending
                                    </div>
                                </th>
                                <th scope="col">
                                    <div class="text-center">
                                        Featured
                                    </div>
                                </th>
                                <th scope="col">Banner</th>
                                <th scope="col">Title</th>
                                <th scope="col">category</th>
                                <th scope="col">Hits</th>
                                <th scope="col">Status</th>
                                <th scope="col">Publish Date</th>
                                <?php
                                if ($active == true) { ?>

                                    <th scope="col">Edit</th>

                                <?php    }
                                ?>
                                <th scope="col">Action</th>
                                <?php
                                if ($active == false) { ?>
                                    <th scope="col">Restore</th>
                                <?php    }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($pl as $key => $pv) :
                                $pv = obj($pv);
                                $cat = getData(table: "content", id: $pv->parent_id);
                                $cat_title =  $cat ? $cat['title'] : "Uncategorised";
                                if ($pv->is_active == true) {
                                    $move_to_text = "Trash";
                                    $move_to_link = route('postTrash', ['id' => $pv->id]);
                                } else {
                                    $move_to_link = route('postDelete', ['id' => $pv->id]);
                                    $move_to_text = "Delete";
                                    $restore_text = "Restore";
                                    $restore_link = route('postRestore', ['id' => $pv->id]);
                                }
                            ?>

                                <tr>
                                    <th scope="row"><?php echo $pv->id; ?></th>
                                    <th scope="row">
                                        <div class="text-center">
                                            <?php echo $pv->is_trending ? "<i data-trending='{$pv->id}' class='trending-post pk-pointer text-primary bx bxs-star'></i>" : "<i data-trending='{$pv->id}' class='trending-post pk-pointer bx bx-star'></i>"; ?>
                                        </div>
                                    </th>
                                    <th scope="row">
                                        <div class="text-center">
                                            <?php echo $pv->is_featured ? "<i data-featured='{$pv->id}' class='featured-post pk-pointer text-success bx bxs-star'></i>" : "<i data-featured='{$pv->id}' class='featured-post pk-pointer bx bx-star'></i>"; ?>
                                        </div>
                                    </th>
                                    <th>
                                        <img style="width:100%; max-height:30px; object-fit:cover;" id="banner" src="/<?php echo MEDIA_URL; ?>/images/pages/<?php echo $pv->banner; ?>" alt="">
                                    </th>
                                    <td><?php echo $pv->title; ?></td>
                                    <td><?php echo $cat_title; ?></td>
                                    <td><?php echo $pv->views; ?></td>
                                    <td><?php echo $pv->status; ?></td>
                                    <td><?php echo $pv->created_at; ?></td>
                                    <?php
                                    if ($active == true) { ?>
                                        <td>
                                            <a class="btn-primary btn btn-sm" href="/<?php echo home . route('postEdit', ['id' => $pv->id]); ?>">Edit</a>
                                        </td>
                                    <?php    }
                                    ?>

                                    <td>
                                        <a class="btn-danger btn btn-sm" href="/<?php echo home . $move_to_link; ?>"><?php echo $move_to_text; ?></a>
                                    </td>
                                    <?php
                                    if ($active == false) { ?>
                                        <td>
                                            <a class="btn-success btn btn-sm" href="/<?php echo home . $restore_link; ?>"><?php echo $restore_text; ?></a>
                                        </td>
                                    <?php    }
                                    ?>

                                </tr>

                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <!-- End Table with stripped rows -->
                    <!-- Pagination -->
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">

                            <?php
                            $tp = $tp;
                            $current_page = $cp; // Assuming first page is the current page
                            if ($active == true) {
                                $link =  route('postList');
                            } else {
                                $link =  route('postTrashList');
                            }
                            // Show first two pages
                            for ($i = 1; $i <= $tp; $i++) {
                            ?>
                                <li class="page-item"><a class="page-link" href="/<?php echo home . $link . "?page=$i"; ?>"><?php echo $i; ?></a></li>
                            <?php
                            } ?>




                        </ul>
                    </nav>

                    <!-- Pagination -->
                </div>

            </div>

        </div>
    </div>
</section>
<script>
    window.onload = () => {
        const trendingPost = document.querySelectorAll(".trending-post");
        const featuredPost = document.querySelectorAll(".featured-post");
        for (const tp of trendingPost) {
            tp.addEventListener('click', () => {
                const content_id = tp.getAttribute('data-trending');
                sendData({
                        content_id: content_id,
                        action: 'is_trending'
                    },
                    `/<?php echo home . route('postToggleMarked') ?>`,
                    (err, response) => {
                        if (err) {
                            // console.error('Error:', err);
                        } else {

                            res = JSON.parse(response)
                            // console.log('Response:', res);
                            if (res.msg == "success") {
                                // console.log('Response:', response);
                                alert(res.data)
                                location.reload();
                            } else {
                                alert(res.msg);
                            }
                            // do something with the response data
                        }
                    });
            });

        }
        for (const fp of featuredPost) {
            fp.addEventListener('click', () => {
                const content_id = fp.getAttribute('data-featured');
                sendData({
                        content_id: content_id,
                        action: 'is_featured'
                    },
                    `/<?php echo home . route('postToggleMarked') ?>`,
                    (err, response) => {
                        if (err) {
                            // console.error('Error:', err);
                        } else {

                            res = JSON.parse(response)
                            // console.log('Response:', res);
                            if (res.msg == "success") {
                                // console.log('Response:', response);
                                alert(res.data)
                                location.reload();
                            } else {
                                alert(res.data);
                            }
                            // do something with the response data
                        }
                    });
            });

        }
    };

    function sendData(data, url, callback) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', url);
        xhr.setRequestHeader('Content-Type', 'application/json');
        xhr.onload = () => {
            if (xhr.status === 200) {
                // console.log('Data successfully sent.');
                callback(null, xhr.responseText);
            } else {
                console.log('Request failed. Status:', xhr.status);
                callback(xhr.status);
            }
        };
        xhr.send(JSON.stringify(data));
    }
</script>