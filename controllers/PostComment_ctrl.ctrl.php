<?php

class PostComment_ctrl
{
    public function comment($req = null)
    {
        $request = obj($_POST);
        if (isset($request->email) && isset($request->name) && isset($request->post_id)) {
            $rules = [
                'name' => 'required|string',
                'email' => 'required|email',
                'post_id' => 'required|integer',
                'message' => 'required|string|max:1000|min:1'
            ];
            $pass = validateData(data: $_POST, rules: $rules);
            if (!$pass) {
                echo js_alert(msg_ssn("msg", true));
                exit;
            }
            $reply_to = (isset($request->reply_to) && $request->reply_to>0)?$request->reply_to:0;
            $is_spam = detectSpam($request->message);
            $lastId = (new Model('comments'))->store(
                [
                    'name' => sanitize_remove_tags($request->name),
                    'email' => sanitize_remove_tags($request->email),
                    'content_id' => $request->post_id,
                    'is_active' => 1,
                    'is_approved' => 0,
                    'message'=>sanitize_remove_tags($request->message),
                    'replied_to'=>$reply_to,
                    'comment_group' => $is_spam?"spam":"post"
                ]
            );
            if ($lastId) {
                $_SESSION['msg'][] = "Your comment has been sent now, please wait for approval";
                echo js_alert(msg_ssn("msg", true));
                echo RELOAD;
                exit;
            }
        } else {
            return js_alert("Comment not submitted");
        }
    }
}
