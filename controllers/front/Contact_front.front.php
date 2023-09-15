<?php
class Contact_front extends Main_ctrl
{
    public function send_message($req = null)
    {
        if (isset($_SESSION['msg'])) {
            unset($_SESSION['msg']);
        }
        // if (isset($_SESSION['message_at'])) {
        //     if (time() - $_SESSION['message_at'] < 900) {
        //         $data['msg'] = "You already have sent your message, please wait at least 15 minutes";
        //         $data['success'] = false;
        //         $data['data'] = null;
        //         echo json_encode($data);
        //         exit;
        //     }
        // }
        // $_SESSION['message_at'] = time();
        header('Content-Type: application/json');
        $post = obj($_POST);
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email',
            'subject' => 'required|string|min:2|max:100',
            'message' => 'required|string|min:10|max:500',
            'name' => 'required|string'
        ];
        $is_spam = detectSpam($post->message);
        if ($is_spam) {
            $data['msg'] = "Spam detected in your message";
            $data['success'] = false;
            $data['data'] = null;
            echo json_encode($data);
            exit;
        }
        $pass = validateData(data: $_POST, rules: $rules);
        if (!$pass) {
            $data['msg'] = msg_ssn(return: true, lnbrk: "<br>");
            $data['success'] = false;
            $data['data'] = null;
            echo json_encode($data);
            exit;
        }
        $notSpam = isNotSpamEmail($post->email);
        $validEmail = email_has_valid_dns($post->email);
        if (!$validEmail || !$notSpam) {
            msg_set("Email is not valid");
            $data['msg'] = msg_ssn(return: true, lnbrk: "<br>");
            $data['success'] = false;
            $data['data'] = null;
            echo json_encode($data);
            exit;
        }
        $userIP = $_SERVER['REMOTE_ADDR'];

        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $userIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        $obj = new stdClass;
        $obj->col = 'email';
        $obj->val = $post->email;
        $auth = new Auth;
        $ourmenber = $auth->check_dup($obj);
        if (!$ourmenber) {
            msg_set("Currently our member can send message.");
            $data['msg'] = msg_ssn(return: true, lnbrk: "<br>");
            $data['success'] = false;
            $data['data'] = null;
            echo json_encode($data);
            exit;
        }
        $db = new Dbobjects;
        $db->tableName = 'contact';

        $db->insertData['name'] = sanitize_remove_tags($post->name);
        $db->insertData['email'] = sanitize_remove_tags($post->email);
        $db->insertData['subject'] = sanitize_remove_tags($post->subject);
        $db->insertData['message'] = sanitize_remove_tags($post->message);
        $db->insertData['client_ip'] = $userIP;
        try {
            $id = $db->create();
            if (intval($id)) {
                $data['msg'] = "Message sent successfully";
                $data['success'] = true;
                $data['data'] = null;
                echo json_encode($data);
                exit;
            } else {
                $data['msg'] = "Message not sent";
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
}
