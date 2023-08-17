<?php
class Search_users_ctrl
{
    public function index($req = null)
    {
        
        
        $GLOBALS['meta_seo'] = (object) array('title' => 'Search', 'description' => 'Search blogs', 'keywords' => 'blogs, news, articles');
     
        $rules = [
            'city' => 'required|string',
            'state' => 'required|string',
            'age_from' => 'required|numeric',
            'age_to' => 'required|numeric'
        ];
        $pass = validateData(data: $req, rules: $rules);
        if (!$pass) {
            echo js_alert(msg_ssn("msg", true));
            exit;
        }
        $req = obj($req);
        $filter = new stdClass;
        $filter->city = $req->city;
        $filter->state = $req->state;
        $filter->age_from = $req->age_from;
        $filter->age_to = $req->age_to;
        $users = $this->user_list($filter = $filter, $ord = "DESC", $limit = 5, $active = 1);
        // myprint($users);
        $context = (object) array(
            'page' => 'search.php',
            'data' => (object) array(
                'req' => obj($req),
                'user_list' => $users,
            )
        );
        $this->render_main($context);
    }
    public function user_list($filter, $ord = "DESC", $limit = 100, $active = 1)
    {
        $cntobj = new Dbobjects;
        $cntobj->tableName="pk_user";

        $dobfrom = getDOBFromAge($filter->age_from);
        $dobto = getDOBFromAge($filter->age_to);
        $search_gender = null;
        if (USER) {
            $s_gender = USER['gender']=='m'?'f':'m';
            $search_gender = "AND gender = '$s_gender'";
        }
        $city = sanitize_remove_tags($filter->city);
        $state = sanitize_remove_tags($filter->state);
        $sql = "SELECT * FROM pk_user WHERE `is_active`= $active $search_gender 
        AND dob IS NOT NULL 
        AND dob >= '$dobto' 
        AND dob <= '$dobfrom'
        AND city = '$city'
        AND state = '$state'
        ORDER BY id $ord LIMIT $limit;
        ;";
        // echo $sql;
        return $cntobj->show($sql);
    }
    public function render_main($context = null)
    {
        import("apps/view/layouts/main.php", $context);
    }
}
