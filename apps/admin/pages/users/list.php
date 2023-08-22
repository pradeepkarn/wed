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
                    <div class="table-responsive">

                    
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Image</th>
                                <th scope="col">First name</th>
                                <th scope="col">Gender</th>
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
                                    <td><?php echo gender_view($pv->gender); ?></td>
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
                    </div>
                    <div class="custom-pagination">
                        <?php
                        $pg = isset($_GET['page']) ? $_GET['page'] : 1;
                        $tu = $tp; // Total pages
                        $current_page = $cp; // Assuming first page is the current page
                        if ($active == true) {
                            $link =  route('userList',['ug'=>$req->ug]);
                        } else {
                            $link =  route('userTrashList',['ug'=>$req->ug]);
                        }
                        // Calculate start and end page numbers to display
                        $start_page = max(1, $current_page - 2);
                        $end_page = min($start_page + 4, $tu);

                        // Show first page button if not on the first page
                        if ($current_page > 1) {
                            echo '<a class="first-button" href="/' . home . $link . '?page=1">&laquo;</a>';
                        }

                        // Show ellipsis if there are more pages before the start page
                        if ($start_page > 1) {
                            echo '<span>...</span>';
                        }

                        // Display page links within the range
                        for ($i = $start_page; $i <= $end_page; $i++) {
                            $active_class = ($pg == $i) ? "active" : null;
                            echo '<a class="' . $active_class . '" href="/' . home . $link . '?page=' . $i . '">' . $i . '</a>';
                        }

                        // Show ellipsis if there are more pages after the end page
                        if ($end_page < $tu) {
                            echo '<span>...</span>';
                        }

                        // Show last page button if not on the last page
                        if ($current_page < $tu) {
                            echo '<a class="last-button" href="/' . home . $link . '?page=' . $tu . '">&raquo;</a>';
                        }
                        ?>
                    </div>
                
                    <!-- End Table with stripped rows -->
                </div>

            </div>

        </div>
    </div>
</section>