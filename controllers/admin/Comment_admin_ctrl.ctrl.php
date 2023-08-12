<?php
class Comment_admin_ctrl
{
    // Comment list page
    public function list($req = null)
    {
        $req = obj($req);
        $current_page = 0;
        $data_limit = DB_ROW_LIMIT;
        $page_limit = "0,$data_limit";
        $cp = 0;
        if (isset($req->page) && intval($req->page)) {
            $cp = $req->page;
            $current_page = (abs($req->page) - 1) * $data_limit;
            $page_limit = "$current_page,$data_limit";
        }
        $total_comment = $this->comment_list(comment_group: $req->cg, ord: "DESC", limit: 10000, active: 1);
        $tc = count($total_comment);
        if ($tc %  $data_limit == 0) {
            $tc = $tc / $data_limit;
        } else {
            $tc = floor($tc / $data_limit) + 1;
        }
        if (isset($req->search)) {
            $comment_list = $this->comment_search_list(comment_group: $req->cg, keyword: $req->search, ord: "DESC", limit: $page_limit, active: 1);
        } else {
            $comment_list = $this->comment_list(comment_group: $req->cg, ord: "DESC", limit: $page_limit, active: 1);
        }
        $context = (object) array(
            'page' => 'comments/list.php',
            'data' => (object) array(
                'req' => obj($req),
                'comment_list' => $comment_list,
                'total_comment' => $tc,
                'current_page' => $cp,
                'is_active' => true
            )
        );
        $this->render_main($context);
    }

    // comment trash list page
    public function trash_list($req = null)
    {
        $req = obj($req);

        $current_page = 0;
        $data_limit = DB_ROW_LIMIT;
        $page_limit = "0,$data_limit";
        $cp = 0;
        if (isset($req->page) && intval($req->page)) {
            $cp = $req->page;
            $current_page = (abs($req->page) - 1) * $data_limit;
            $page_limit = "$current_page,$data_limit";
        }
        $total_comment = $this->comment_list(comment_group: $req->cg, ord: "DESC", limit: 10000, active: 0);
        $tc = count($total_comment);
        if ($tc %  $data_limit == 0) {
            $tc = $tc / $data_limit;
        } else {
            $tp = floor($tc / $data_limit) + 1;
        }
        if (isset($req->search)) {
            $comment_list = $this->comment_search_list($comment_group = $req->cg, $keyword = $req->search, $ord = "DESC", $limit = $page_limit, $active = 0);
        } else {
            $comment_list = $this->comment_list(comment_group: $req->cg, ord: "DESC", limit: $page_limit, active: 0);
        }
        $context = (object) array(
            'page' => 'comments/list.php',
            'data' => (object) array(
                'req' => obj($req),
                'comment_list' => $comment_list,
                'total_comment' => $tc,
                'current_page' => $cp,
                'is_active' => false
            )
        );
        $this->render_main($context);
    }
    public function toggle_spam($req = null)
    {

        $request = json_decode(file_get_contents('php://input'));
        if (isset($request->comment_id) && isset($request->action) && ($request->action == 'comment_group')) {
            $id = $request->comment_id;
            $tobj = new Model('comments');
            $arr['id'] = $id;
            $arr[$request->action] = 'spam';
            $comment = $tobj->filter_index($arr);
            if (count($comment) > 0) {
                $tobj->update($id, [$request->action => 'post']);
                $res['msg'] = 'success';
                $res['data'] = "Comment moved to inbox";
            } else {
                $tobj->update($id, [$request->action => 'spam']);
                $res['msg'] = 'success';
                $res['data'] = "Comment moved as spam";
            }
            echo json_encode($res);
            exit;
        } else {
            $res['msg'] = 'Something went wrong';
            $res['data'] = null;
            echo json_encode($res);
            exit;
        }
    }
    public function toggle_approve($req = null)
    {

        $request = json_decode(file_get_contents('php://input'));
        if (isset($request->comment_id) && isset($request->action) && ($request->action == 'is_approved' || $request->action == 'toggle_spam')) {
            $id = $request->comment_id;
            $tobj = new Model('comments');
            $arr['id'] = $id;
            $arr[$request->action] = 1;
            $comment = $tobj->filter_index($arr);
            if (count($comment) > 0) {
                $tobj->update($id, [$request->action => 0]);
                $res['msg'] = 'success';
                $res['data'] = "Comment removed from $request->action";
            } else {
                $tobj->update($id, [$request->action => 1]);
                $res['msg'] = 'success';
                $res['data'] = "Comment marked as $request->action";
            }
            echo json_encode($res);
            exit;
        } else {
            $res['msg'] = 'Something went wrong';
            $res['data'] = null;
            echo json_encode($res);
            exit;
        }
    }
    // Edit page
    public function edit($req = null)
    {
        $req = obj($req);
        $context = (object) array(
            'page' => 'comments/edit.php',
            'data' => (object) array(
                'req' => obj($req),
                'comment_detail' => $this->comment_detail(id: $req->id, comment_group: $req->cg)
            )
        );
        $this->render_main($context);
    }
    // Update
    public function update($req = null)
    {
        $req = obj($req);
        $comment_exists = (new Model('comments'))->exists(['id' => $req->id, 'comment_group' => $req->cg]);
        if ($comment_exists == false) {
            $_SESSION['msg'][] = "Object not found";
            echo js_alert(msg_ssn("msg", true));
            exit;
        }
        $request = null;
        $data = null;
        $data = $_POST;
        $data['id'] = $req->id;
        $rules = [
            'id' => 'required|integer',
            'email' => 'required|email',
            'name' => 'required|string',
            'message' => 'required|string'
        ];
        $pass = validateData(data: $data, rules: $rules);
        if (!$pass) {
            echo js_alert(msg_ssn("msg", true));
            exit;
        }
        $request = obj($data);
        $comment_exists = (new Model('comments'))->exists(['id' => $request->id]);
        if (!$comment_exists) {
            $_SESSION['msg'][] = 'Comment not availble';
            echo js_alert(msg_ssn("msg", true));
            exit;
        }
        if (isset($request->email)) {
            $arr = null;
            $arr['comment_group'] = $req->cg;
            $arr['email'] = $request->email;
            $arr['name'] = sanitize_remove_tags($request->name);
            $arr['message'] = sanitize_remove_tags($request->message);
            $arr['updated_at'] = date('Y-m-d H:i:s');
            try {
                (new Model('comments'))->update($request->id, $arr);
                $_SESSION['msg'][] = "Updated";
                echo js_alert(msg_ssn(return: true));
                echo go_to(route('commentEdit', ['cg' => $req->cg, 'id' => $request->id]));
                exit;
            } catch (PDOException $e) {
                echo js_alert('Comment not updated');
                exit;
            }
        }
    }
    public function move_to_trash($req = null)
    {
        $req = obj($req);
        $comment_exists = (new Model('comments'))->exists(['id' => $req->id, 'comment_group' => $req->cg]);
        if ($comment_exists == false) {
            $_SESSION['msg'][] = "Object not found";
            echo js_alert(msg_ssn("msg", true));
            echo go_to(route('commentList', ['cg' => $req->cg]));
            exit;
        }
        $data = null;
        $data['id'] = $req->id;
        $rules = [
            'id' => 'required|integer'
        ];
        $pass = validateData(data: $data, rules: $rules);
        if (!$pass) {
            echo js_alert(msg_ssn("msg", true));
            echo go_to(route('commentList', ['cg' => $req->cg]));
            exit;
        }
        try {
            (new Model('comments'))->update($req->id, array('is_active' => 0));
            echo js_alert('comment moved to trash');
            echo go_to(route('commentList', ['cg' => $req->cg]));
            exit;
        } catch (PDOException $e) {
            echo js_alert('comment not moved to trash');
            exit;
        }
    }
    public function restore($req = null)
    {
        $req = obj($req);
        $comment_exists = (new Model('comments'))->exists(['id' => $req->id, 'comment_group' => $req->cg]);
        if ($comment_exists == false) {
            $_SESSION['msg'][] = "Object not found";
            echo js_alert(msg_ssn("msg", true));
            echo go_to(route('commentTrashList', ['cg' => $req->cg]));
            exit;
        }
        // $comment = obj(getData(table: 'comments', id: $req->id));
        $data = null;
        $data['id'] = $req->id;
        $rules = [
            'id' => 'required|integer'
        ];
        $pass = validateData(data: $data, rules: $rules);
        if (!$pass) {
            echo js_alert(msg_ssn("msg", true));
            echo go_to(route('commentTrashList', ['cg' => $req->cg]));
            exit;
        }
        try {
            (new Model('comments'))->update($req->id, array('is_active' => 1));
            echo js_alert('comment restored');
            echo go_to(route('commentTrashList', ['cg' => $req->cg]));
            exit;
        } catch (PDOException $e) {
            echo js_alert('comment can not be restored');
            exit;
        }
    }
    public function delete_trash($req = null)
    {
        $req = obj($req);
        $comment_exists = (new Model('comments'))->exists(['id' => $req->id, 'comment_group' => $req->cg]);
        if ($comment_exists == false) {
            $_SESSION['msg'][] = "Object not found";
            echo js_alert(msg_ssn("msg", true));
            echo go_to(route('commentTrashList', ['cg' => $req->cg]));
            exit;
        }
        // $comment = obj(getData(table: 'comments', id: $req->id));
        $data = null;
        $data['id'] = $req->id;
        $rules = [
            'id' => 'required|integer'
        ];
        $pass = validateData(data: $data, rules: $rules);
        if (!$pass) {
            echo js_alert(msg_ssn("msg", true));
            echo go_to(route('commentTrashList', ['cg' => $req->cg]));
            exit;
        }
        try {
            $comment_exists = (new Model('comments'))->exists(['id' => $req->id, 'is_active' => 0, 'comment_group' => $req->cg]);
            if ($comment_exists) {
                if ((new Model('comments'))->destroy($req->id)) {
                    echo js_alert('Comment deleted permanatly');
                    echo go_to(route('commentTrashList', ['cg' => $req->cg]));
                    exit;
                }
            }
            echo js_alert('comment does not exist');
            echo go_to(route('commentTrashList', ['cg' => $req->cg]));
            exit;
        } catch (PDOException $e) {
            echo js_alert('comment not deleted');
            exit;
        }
    }
    public function comment_search_list($comment_group = 'post', $keyword, $ord = "DESC", $limit = 5, $active = 1)
    {
        $cntobj = new Model('comments');
        $search_arr['name'] = $keyword;
        $search_arr['email'] = $keyword;
        $search_arr['message'] = $keyword;
        $search_arr['content_id'] = $keyword;
        return $cntobj->search(
            assoc_arr: $search_arr,
            ord: $ord,
            limit: $limit,
            whr_arr: array('comment_group' => $comment_group, 'is_active' => $active)
        );
    }
    public function comment_list($comment_group = "post", $ord = "DESC", $limit = 5, $active = 1)
    {
        $cntobj = new Model('comments');
        return $cntobj->filter_index(array('comment_group' => $comment_group, 'is_active' => $active), $ord, $limit);
    }
    // comment detail
    public function comment_detail($id, $comment_group = 'post')
    {
        $cntobj = new Model('comments');
        $exists = $cntobj->exists(array('comment_group' => $comment_group, 'id' => $id));
        if ($exists) {
            return $cntobj->show($id);
        } else {
            return false;
        }
    }
    public function render_main($context = null)
    {
        import("apps/admin/layouts/admin-main.php", $context);
    }
}
