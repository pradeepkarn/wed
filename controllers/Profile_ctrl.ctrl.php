<?php
class Profile_ctrl
{
    public function index($req = null)
    {
        $req = obj($req);
        $prof = null;
        if (USER) {
            $prof = $this->profile_detail($id = USER['id']);
            if ($prof == null) {
                header("Location:/" . home . route('home'));
                return;
            }
            $myfrnds = $this->my_friend_list($my_id = USER['id']);
        }
        $context = (object) array(
            'page' => 'profile.php',
            'data' => (object) array(
                'req' => obj($req),
                'my_profile' => $prof,
                'my_friends' => $myfrnds
            )
        );
        $this->render_main($context);
    }
    public function edit($req = null)
    {
        $req = obj($req);
        $prof = null;
        if (USER) {
            $prof = $this->profile_detail($id = USER['id']);
            if ($prof == null) {
                header("Location:/" . home . route('home'));
                return;
            }
            $myfrnds = $this->my_friend_list($my_id = USER['id']);
        }
        $context = (object) array(
            'page' => 'profile-edit.php',
            'data' => (object) array(
                'req' => obj($req),
                'my_profile' => $prof,
                'my_friends' => $myfrnds
            )
        );
        $this->render_main($context);
    }
    public function show_public_profile($req = null)
    {
        $req = obj($req);
        $prof = null;
        $myfrnds = null;



        if (isset($req->profile_id) && intval($req->profile_id)) {
            $prof = $this->profile_detail($id = $req->profile_id);
            $is_public = $prof['is_public'];
            if (USER) {
                if ($prof == null) {
                    header("Location:/" . home . route('home'));
                    return;
                }
                $myfrnds = $this->my_friend_list($my_id = USER['id']);
            }
        }
        $prof = obj($prof);
        $prof->bio=$is_public?$prof->bio:'User info is hidden by user';
        $prof->image=$is_public?$prof->image:'default-user.png';
        $prof->cover=$is_public?$prof->cover:'default-cover.jpg';

        $profileLink = SERVER_DOMAIN . route('showPublicProfile', ['profile_id' => $prof->id]);
        $profileImageLink = SERVER_DOMAIN  . "/media/images/profiles/$prof->image";
        $oghtml = <<<OGHTML
                    <meta property="og:title" content="$prof->first_name">
                    <meta property="og:description" content="$prof->bio">
                    <meta property="og:image" content="$profileImageLink">
                    <meta property="og:url" content="$profileLink">
                    <meta property="og:type" content="profile">
                    OGHTML;
        $GLOBALS['ogdata'] = $oghtml;
        $GLOBALS['meta_seo'] = (object) array('title' => "$prof->first_name", 'description' => 'Welcome to shubhavivaah', 'keywords' => 'matrimonial');
        $context = (object) array(
            'page' => $is_public == 1 ? 'public-profile.php' : 'mask-public-profile.php',
            'data' => (object) array(
                'req' => obj($req),
                'my_profile' => $prof,
                'my_friends' => $myfrnds
            )
        );
        $this->render_main($context, 'public-main.php');
    }
    public function upload_cover_image_ajax($req = null)
    {
        $req = obj($req);
        if (isset($_FILES)) {
            $req->files = obj($_FILES);
        }
        $req->post = $_POST;
        $prof = null;
        if (USER) {
            $u = obj(USER);
            if (isset($req->files->cover_img)) {
                $imgfl = obj($req->files->cover_img);
                if ($imgfl->error == 0) {
                    $ext = pathinfo($imgfl->name, PATHINFO_EXTENSION);
                    $imgname = uniqid('cover_') . "_" . $u->id . "." . $ext;
                    if (move_uploaded_file($imgfl->tmp_name, MEDIA_ROOT . "images/profiles/$imgname")) {
                        if ($u->cover != '') {
                            if (file_exists(MEDIA_ROOT . "images/profiles/$u->cover")) {
                                unlink(MEDIA_ROOT . "images/profiles/$u->cover");
                            }
                        }
                    }
                    try {
                        (new Model('pk_user'))->update($u->id, ['cover' => $imgname]);
                        echo RELOAD;
                        exit;
                    } catch (PDOException $th) {
                        msg_set('Something went wrong');
                        echo js_alert(msg_ssn(return: true));
                        exit;
                    }
                }
            }
        }
    }
    public function upload_profile_image_ajax($req = null)
    {
        $req = obj($req);
        if (isset($_FILES)) {
            $req->files = obj($_FILES);
        }
        $req->post = $_POST;
        if (USER) {
            $u = obj(USER);
            if (isset($req->files->profile_img)) {
                $imgfl = obj($req->files->profile_img);
                if ($imgfl->error == 0) {
                    $ext = pathinfo($imgfl->name, PATHINFO_EXTENSION);
                    $imgname = uniqid('profile_') . "_" . $u->id . "." . $ext;
                    $maxFileSize = 1024 * 1024 * 5.5;
                    if ($imgfl->size > $maxFileSize) {
                        msg_set('Image should not be more than 5 mb');
                        echo js_alert(msg_ssn(return: true));
                        exit;
                    }
                    if (move_uploaded_file($imgfl->tmp_name, MEDIA_ROOT . "images/profiles/$imgname")) {
                        if ($u->image != '') {
                            if (file_exists(MEDIA_ROOT . "images/profiles/$u->image")) {
                                unlink(MEDIA_ROOT . "images/profiles/$u->image");
                            }
                        }
                    }
                    try {
                        (new Model('pk_user'))->update($u->id, ['image' => $imgname]);
                        echo RELOAD;
                        exit;
                    } catch (PDOException $th) {
                        msg_set('Something went wrong');
                        echo js_alert(msg_ssn(return: true));
                        exit;
                    }
                }
            }
        } else {
            msg_set('Please login first');
            echo js_alert(msg_ssn(return: true));
            exit;
        }
    }
    function send_request_ajax($req = null)
    {
        header('Content-Type: application/json');
        $req = obj($req);
        if (USER) {
            $post = obj($_POST);
            if (isset($post->request_to)) {
                $req_to = intval($post->request_to);
                $db = new Dbobjects;
                $db->tableName = 'pk_user';
                if (count($db->filter(['id' => $req_to, 'is_active' => 1])) > 0) {
                    $db->tableName = 'requests';
                    $arr['request_by'] = USER['id'];
                    $arr['request_to'] = $req_to;
                    $filter = $db->filter(['request_by' => USER['id'], 'request_to' => $req_to]);
                    $filter_alternate = $db->filter(['request_to' => USER['id'], 'request_by' => $req_to]);
                    if (count($filter) > 0) {
                        $delid = $filter[0]['id'];
                        $db->tableName = 'requests';
                        $db->pk($delid);
                        $db->delete();
                        $data['msg'] = "Request cancelled by you";
                        $data['success'] = true;
                        $data['data'] = null;
                        echo json_encode($data);
                        exit;
                    }
                    if (count($filter_alternate) > 0) {
                        $delid = $filter_alternate[0]['id'];
                        $db->tableName = 'requests';
                        $db->pk($delid);
                        $db->delete();
                        $data['msg'] = "Request rejected by you";
                        $data['success'] = true;
                        $data['data'] = null;
                        echo json_encode($data);
                        exit;
                    } else {

                        try {
                            $db->insertData = $arr;
                            $id = $db->create();
                            if (intval($id)) {
                                $data['msg'] = "Request sent";
                                $data['success'] = true;
                                $data['data'] = null;
                                echo json_encode($data);
                                exit;
                            } else {
                                $data['msg'] = "Request not sent";
                                $data['success'] = false;
                                $data['data'] = null;
                                echo json_encode($data);
                                exit;
                            }
                        } catch (PDOException $th) {
                            $data['msg'] = "Something went wrong";
                            $data['success'] = false;
                            $data['data'] = null;
                            echo json_encode($data);
                            exit;
                        }
                    }
                } else {
                    $data['msg'] = "request to id not found";
                    $data['success'] = false;
                    $data['data'] = null;
                    echo json_encode($data);
                    exit;
                }
            }
            $data['msg'] = "request to id not found";
            $data['success'] = false;
            $data['data'] = null;
            echo json_encode($data);
            exit;
        } else {
            $data['msg'] = "You need to log in";
            $data['success'] = false;
            $data['data'] = null;
            echo json_encode($data);
            exit;
        }
    }
    function like_unlike_ajax($req = null)
    {
        header('Content-Type: application/json');
        $req = obj($req);

        if (USER) {
            $post = obj($_POST);
            if (isset($post->obj_id)) {
                $obj_id = intval($post->obj_id);
                $db = new Dbobjects;
                $db->tableName = 'pk_user';
                if (count($db->filter(['id' => $obj_id, 'is_active' => 1])) > 0) {
                    $db->tableName = 'likes';
                    $arr['like_by'] = USER['id'];
                    $arr['obj_id'] = $obj_id;
                    $arr['obj_group'] = 'profile';
                    $filter = $db->filter(['like_by' => USER['id'], 'obj_id' => $obj_id, 'obj_group' => 'profile']);
                    if (count($filter) > 0) {
                        $delid = $filter[0]['id'];
                        $db->tableName = 'likes';
                        $db->pk($delid);
                        $db->delete();
                        $data['msg'] = "Unliked";
                        $data['success'] = true;
                        $data['data'] = null;
                        echo json_encode($data);
                        exit;
                    } else {
                        try {
                            $db->insertData = $arr;
                            $id = $db->create();
                            if (intval($id)) {
                                $data['msg'] = "Liked";
                                $data['success'] = true;
                                $data['data'] = null;
                                echo json_encode($data);
                                exit;
                            } else {
                                $data['msg'] = "Not liked, something went wrong";
                                $data['success'] = false;
                                $data['data'] = null;
                                echo json_encode($data);
                                exit;
                            }
                        } catch (PDOException $th) {
                            $data['msg'] = "Something went wrong";
                            $data['success'] = false;
                            $data['data'] = null;
                            echo json_encode($data);
                            exit;
                        }
                    }
                } else {
                    $data['msg'] = "User not found";
                    $data['success'] = false;
                    $data['data'] = null;
                    echo json_encode($data);
                    exit;
                }
            }
            $data['msg'] = "Invalid request";
            $data['success'] = false;
            $data['data'] = null;
            echo json_encode($data);
            exit;
        } else {
            $data['msg'] = "You need to log in";
            $data['success'] = false;
            $data['data'] = null;
            echo json_encode($data);
            exit;
        }
    }
    function update_my_profile_ajax($req = null)
    {
        $req = obj($req);
        if (isset($_FILES)) {
            $req->files = obj($_FILES);
        }
        $data = $_POST;
        $req->post = obj($_POST);
        $post = $req->post;
        $rules = [
            'first_name' => 'required|string',
            'dob' => 'required|date',
            'caste' => 'required|string',
            'caste_detail' => 'required|string',
            'occupation' => 'required|string',
            'annual_income' => 'required|string',
            'mobile' => 'required|integer',
            'gender' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'country' => 'required|string',
            'about_me' => 'required|string',
            'grand_father' => 'required|string',
            'father' => 'required|string',
            'mother' => 'required|string',
        ];
        $pass = validateData(data: $data, rules: $rules);
        if (!$pass) {
            echo js_alert(msg_ssn("msg", true));
            exit;
        }
        // myprint($req);
        if (USER) {

            $db = new Dbobjects;
            $db->tableName = 'pk_user';
            $db->insertData['first_name'] = sanitize_remove_tags($post->first_name);
            $db->insertData['last_name'] = sanitize_remove_tags($post->last_name);
            $db->insertData['occupation'] = sanitize_remove_tags($post->occupation);
            $db->insertData['annual_income'] = sanitize_remove_tags($post->annual_income);
            $db->insertData['mobile'] = sanitize_remove_tags($post->mobile);
            $db->insertData['gender'] = sanitize_remove_tags($post->gender);
            $db->insertData['address'] = sanitize_remove_tags($post->address);
            $db->insertData['dob'] = sanitize_remove_tags($post->dob);
            $db->insertData['caste'] = sanitize_remove_tags($post->caste);
            $db->insertData['caste_detail'] = sanitize_remove_tags($post->caste_detail);
            $db->insertData['city'] = sanitize_remove_tags($post->city);
            $db->insertData['state'] = sanitize_remove_tags($post->state);
            $db->insertData['country'] = sanitize_remove_tags($post->country);
            $db->insertData['bio'] = sanitize_remove_tags($post->about_me);
            $db->insertData['is_public']  = isset($post->is_public) ? 1 : 0;

            if (isset($post->mool)) {
                $db->insertData['mool'] = sanitize_remove_tags($post->mool);
            }
            if (isset($post->about_mother)) {
                $db->insertData['about_mother'] = sanitize_remove_tags($post->about_mother);
            }
            if (isset($post->about_grand_father)) {
                $db->insertData['about_grand_father'] = sanitize_remove_tags($post->about_grand_father);
            }
            if (isset($post->about_father)) {
                $db->insertData['about_father'] = sanitize_remove_tags($post->about_father);
            }
            $db->insertData['grand_father'] = sanitize_remove_tags($post->grand_father);
            $db->insertData['father'] = sanitize_remove_tags($post->father);
            $db->insertData['mother'] = sanitize_remove_tags($post->mother);
            $jsnarr = [];
            if (isset($post->rel_type) && isset($post->rel_name) && isset($post->about_rel)) {
                if (!((count($post->rel_type) == count($post->rel_name)) && (count($post->rel_name) == count($post->about_rel)))) {
                    msg_set('Invalid activity');
                    echo js_alert(msg_ssn(return: true));
                    exit;
                }
                for ($i = 0; $i < count($post->rel_type); $i++) {
                    if ($post->rel_type[$i] != '') {
                        $jsnarr['family_members'][] = array(
                            "relation" => $post->rel_type[$i],
                            "name" => $post->rel_name[$i],
                            "about" => $post->about_rel[$i]
                        );
                    }
                }
            }
            if (isset($post->contacts)) {
                for ($i = 0; $i < count($post->contacts); $i++) {
                    if ($post->contacts[$i] != '' && intval($post->contacts[$i])) {
                        $jsnarr['contacts'][] = array(
                            "contact" => $post->contacts[$i]
                        );
                    }
                }
            }
            $db->insertData['jsn'] = json_encode($jsnarr);
            $db->pk(USER['id']);
            try {
                $db->update();
                $completed_percentage = profile_completed($id = USER['id']);
                if ($completed_percentage == 0) {
                    msg_set("check your date of birth and gender");
                    msg_set("Your age must be grater than or equals to 18");
                }
                msg_set("Profile $completed_percentage % completed");
                echo js_alert(msg_ssn(return: true));
                echo RELOAD;
            } catch (PDOException $th) {
                msg_set('Please login first');
                echo js_alert(msg_ssn(return: true));
                exit;
            }
        } else {
            msg_set('Please login first');
            echo js_alert(msg_ssn(return: true));
            exit;
        }
    }
    public function render_main($context = null, $layout = 'main.php')
    {
        import("apps/view/layouts/$layout", $context);
    }
    public function profile_detail($id)
    {
        $db = new Dbobjects;
        $db->tableName = 'pk_user';
        try {
            $user = $db->pk($id);
            if ($user['user_group'] == 'user') {
                return $user;
            } else {
                return null;
            }
        } catch (PDOException $th) {
            return null;
        }
    }
    function message_history()
    {
        // $req = json_decode(file_get_contents('php://input'));
        $req = obj($_POST);
        $my_id = $req->sender_id;
        $friend_id = $req->receiver_id;
        $db = new Dbobjects;
        $hisarr = [];
        $hisarr['profile_link'] = home . route('showPublicProfile', ['profile_id' => $req->receiver_id]);
        try {
            $sql = "SELECT * FROM chat_history
            WHERE (JSON_UNQUOTE(JSON_EXTRACT(users, '$[0]')) = '$my_id'
              AND JSON_UNQUOTE(JSON_EXTRACT(users, '$[1]')) = '$friend_id') 
              OR 
              (JSON_UNQUOTE(JSON_EXTRACT(users, '$[0]')) = '$friend_id'
              AND JSON_UNQUOTE(JSON_EXTRACT(users, '$[1]')) = '$my_id') 
              AND JSON_LENGTH(users) = 2;";
            $hist = $db->show($sql);

            foreach ($hist as $key => $his) {
                $members = [];
                foreach (json_decode($his['users']) as $mbr) {
                    if ($mbr != $my_id) {
                        $sqlm = "select id, first_name, last_name, image from pk_user where id = $mbr";
                        $m = $db->show($sqlm)[0];
                        $members[] = array(
                            'id' => $m['id'],
                            'first_name' => $m['first_name'],
                            'last_name' => $m['last_name'],
                            'image' => dp_or_null($m['image'])
                        );
                    }
                };
                $hisarr['data'][] = array(
                    'id' => $his['id'],
                    'created_at' => $his['created_at'],
                    'sender_id' => $his['sender_id'],
                    'members' => $members,
                    'users' => json_decode($his['users']),
                    'message' => $his['message'],
                    'jsn' => json_decode($his['jsn'])
                );
            }
            echo json_encode($hisarr);
            exit;
        } catch (PDOException $th) {
            echo json_encode($hisarr);
            exit;
        }
    }
    public function my_friend_list($my_id)
    {
        $my_frnd = [];
        $db = new Dbobjects;
        try {
            $sql = "select * from requests where (request_by = $my_id OR request_to = $my_id) AND is_accepted = 1";
            $frnds = $db->show($sql);
            // myprint($frnds);
            if (count($frnds) > 0) {
                foreach ($frnds as $key => $fid) {
                    if ($fid['request_by'] != $my_id) {
                        $sql_my_frnd = "select id, username, first_name, last_name, image, dob from pk_user where id = {$fid['request_by']} AND is_active = 1";
                        $my_frnd[] = $db->show($sql_my_frnd)[0];
                    }
                    if ($fid['request_to'] != $my_id) {
                        $sql_im_frnd = "select id, username, first_name, last_name, image, dob from pk_user where id = {$fid['request_to']} AND is_active = 1";
                        $my_frnd[] = $db->show($sql_im_frnd)[0];
                    }
                }
            }
            return $my_frnd;
        } catch (PDOException $th) {
            return [];
        }
    }
}
