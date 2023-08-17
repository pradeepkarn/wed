<?php

class Users_api extends Main_ctrl
{

    function load_users($req)
    {
        $this->user_list(ord: 'desc', page: $this->get->page, limit: $this->get->limit);
    }

    public function user_list($ord = "DESC", $page = 1, $limit = 10, $active = 1)
    {
        header('Content-Type: application/json');
        $data_limit = "{$page},{$limit}";
        $cntobj = new Model('pk_user');
        $users = $cntobj->filter_index(array('user_group' => 'user', 'is_active' => $active), $ord, $limit = $data_limit);
        $user_list = array();
        foreach ($users as $u) {
            $myreq = obj(check_request($myid = USER['id'], $req_to = $u['id']));
            // myprint($myreq);
            $is_liked = is_liked($myid = USER['id'], $obj_id = $u['id'], $obj_group = 'profile');

            $user_list[]  = array(
                'id' => $u['id'],
                'first_name' => $u['first_name'],
                'last_name' => $u['last_name'],
                'image' => dp_or_null($u['image']),
                'dob' => $u['dob'],
                'age' => getAgeFromDOB($u['dob']),
                'caste' => $u['caste'],
                'caste_detail' => $u['caste_detail'],
                'gender' => $u['gender'],
                'religion' => $u['religion'],
                'occupation' => $u['occupation'],
                'education' => $u['education'],
                'address' => $u['address'],
                'email' => $u['email'],
                'annual_income' => $u['annual_income'],
                'bride_or_groom' => bride_or_grom($u['gender']),
                'profile_link'=> "/".home.route('showPublicProfile', ['profile_id' => $u['id']]),
                'is_liked'=>$is_liked,
                'myreq'=>$myreq
            );
        }
        if (count($users) > 0) {
            $data['success'] = true;
            $data['data'] = $user_list;
            $data['msg'] = null;
            echo json_encode($data);
            exit;
        } else {
            $data['success'] = false;
            $data['data'] = null;
            $data['msg'] = 'No data found';
            echo json_encode($data);
            exit;
        }
    }
}
