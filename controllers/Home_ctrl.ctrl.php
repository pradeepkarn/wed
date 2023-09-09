<?php
class Home_ctrl extends Main_ctrl
{
    public function redirect_to_lang($req = null)
    {
        header("Location:/".home.route('home'));
        return;
    }
    public function index($req = null)
    {
        $req = obj($req);
        
        $data_limit = FRONT_ROW_LIMIT;
        $row_limit = "0,$data_limit";
        $cp = 0;
        if (isset($req->page) && intval($req->page)) {
            $cp = $req->page;
            $load_page = (abs($req->page) - 1) * $data_limit;
            $row_limit = "$load_page,$data_limit";
        }
        $total_users = $this->user_list(ord: "DESC", limit: 10000, active: 1);
        $tu = count($total_users);
        if ($tu %  $data_limit == 0) {
            $tu = $tu / $data_limit;
        } else {
            $tu = floor($tu / $data_limit) + 1;
        }
        
        $user_list = $this->user_list($ord = "DESC", $limit = $row_limit, $active = 1);
        
        $GLOBALS['meta_seo'] = (object) array('title' => 'Home', 'description' => 'Welcome to our blog', 'keywords' => 'blog, article, education, news');
        $context = (object) array(
            'page' => 'home.php',
            'data' => (object) array(
                'req' => obj($req),
                'user_list' => $user_list,
                'current_page' => $cp,
                'total_users' => $tu,
                'about' => $this->about_content(),
                "hero"=>null
            )
        );
        if (isset($_COOKIE['remember_token'])) {
            $acc = new Account;
            $acc->loginWithCookie($_COOKIE['remember_token']);
        }
        $this->render_main($context);
    }
    public function render_main($context = null)
    {
        import("apps/view/layouts/main.php", $context);
    }

    
    public function user_list($ord = "DESC", $limit = 1, $active = 1)
    {
        $cntobj = new Model('pk_user');
        if (is_superuser()) {
            return $cntobj->filter_index(array('user_group' => 'user', 'is_active' => $active), $ord, $limit);
        }
        if (USER) {
            if (USER['gender']=='m') {
                return $cntobj->filter_index(array('user_group' => 'user', 'gender'=>'f', 'is_active' => $active), $ord, $limit);
            }
            elseif (USER['gender']=='f') {
                return $cntobj->filter_index(array('user_group' => 'user', 'gender'=>'m', 'is_active' => $active), $ord, $limit);
            }else{
                return $cntobj->filter_index(array('user_group' => 'user', 'is_active' => $active), $ord, $limit);
            }
            
        }else{
            return array();
        }
    }
    public function user_list_privacy($ord = "DESC", $limit = 1, $active = 1, $is_public=1)
    {
        $cntobj = new Model('pk_user');
        if (is_superuser()) {
            return $cntobj->filter_index(array('user_group' => 'user', 'is_active' => $active,'is_public'=>$is_public), $ord, $limit);
        }
        if (USER) {
            if (USER['gender']=='m') {
                return $cntobj->filter_index(array('user_group' => 'user', 'gender'=>'f', 'is_active' => $active,'is_public'=>$is_public), $ord, $limit);
            }
            elseif (USER['gender']=='f') {
                return $cntobj->filter_index(array('user_group' => 'user', 'gender'=>'m', 'is_active' => $active,'is_public'=>$is_public), $ord, $limit);
            }else{
                return $cntobj->filter_index(array('user_group' => 'user', 'is_active' => $active,'is_public'=>$is_public), $ord, $limit);
            }
            
        }else{
            return array();
        }
    }
    function about_content()  {
        $db = new Model('content');
        $abt = $db->filter_index(['slug'=>'about','content_group'=>'page','is_active'=>1]);
        if (count($abt)>0) {
            return $abt[0];
        }
        return null;
    }
}
