<?php
$pl = $context->user_list;
$tp = $context->total_user;
$cp = $context->current_page;
$active = $context->is_active;

$ug =  explode("/",REQUEST_URI);
$ug = $ug[3];
$req = new stdClass;
$req->ug = $ug;
?>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col my-3">
                            <h5 class="card-title">All users</h5>
                            <nav class="nav">
                                <a class="nav-link <?php echo $active ? "btn btn-sm btn-primary text-white" : ""; ?>" href="/<?php echo home . route('userList',['ug'=>$req->ug]); ?>">Active List</a>
                                <a class="nav-link <?php echo $active ? "" : "btn btn-sm btn-danger text-white"; ?>" href="/<?php echo home . route('userTrashList',['ug'=>$req->ug]); ?>">Trash List</a>
                            </nav>

                        </div>
                        <div class="col my-3">
                           <form action="">
                           <div class="row">
                                <div class="col-8"> 
                                    <input value="<?php echo isset($_GET['search'])?$_GET['search']:null; ?>" type="search" class="form-control" name="search" placeholder="Search...">
                                </div>
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary ">Search</button>
                                </div>
                            </div>
                           </form>
                        </div>
                        <div class="col text-end my-3">
                            <a class="btn btn-dark" href="/<?php echo home . route('userCreate',['ug'=>$req->ug]); ?>">Add New</a>
                        </div>
                    </div>

                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Image</th>
                                <th scope="col">First name</th>
                                <th scope="col">Username</th>
                                <th scope="col">Email</th>
                                <th scope="col">Role</th>
                                <th scope="col">Register Date</th>
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
                                if ($pv->is_active == true) {
                                    $move_to_text = "Trash";
                                    $move_to_link = route('userTrash', ['id' => $pv->id,'ug'=>$req->ug]);
                                } else {
                                    $move_to_link = route('userDelete', ['id' => $pv->id,'ug'=>$req->ug]);
                                    $move_to_text = "Delete";
                                    $restore_text = "Restore";
                                    $restore_link = route('userRestore', ['id' => $pv->id,'ug'=>$req->ug]);
                                }
                            ?>

                                <tr>
                                    <th scope="row"><?php echo $pv->id; ?></th>
                                    <th>
                                        <img style="width:40px; height:40px; object-fit:cover; border-radius:50%;" src="/<?php echo MEDIA_URL; ?>/images/profiles/<?php echo $pv->image; ?>" alt="<?php echo $pv->image; ?>">
                                    </th>
                                    <td><?php echo $pv->first_name; ?></td>
                                    <td><?php echo $pv->username; ?></td>
                                    <td><?php echo $pv->email; ?></td>
                                    <td><?php echo $pv->role; ?></td>
                                    <td><?php echo $pv->created_at; ?></td>
                                    <?php
                                    if ($active == true) { ?>
                                        <td>
                                            <a class="btn-primary btn btn-sm" href="/<?php echo home . route('userEdit', ['id' => $pv->id,'ug'=>$req->ug]); ?>">Edit</a>
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
                                $link =  route('userList',['ug'=>$req->ug]);
                            } else {
                                $link =  route('userTrashList',['ug'=>$req->ug]);
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