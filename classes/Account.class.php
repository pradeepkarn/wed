<?php if(defined("direct_access") != 1){echo "Silenece is awesome"; return;} ?>
<?php
/**
 * 
 */
class Account
{
    public function login($email="",$pass="")
    {
          $db = new Dbobjects();
          $db->tableName = "pk_user";
          $qry = null;
          $qry['email'] = $email;
          $qry['password'] = md5($pass);
          $user = count($db->filter($qry));
          if ($user==1) {
            $user = $db->get($qry);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            // $_SESSION[$csrf_token] = $user['email'];
            $qry = null;
            return $user;
          }
          else if($user==0){
            $qry = null;
            $qry['username'] = $email;
            $qry['password'] = md5($pass);
            $user_with_username = count($db->filter($qry));
            if ($user_with_username===1) {
                $user_with_username = $db->get($qry);
                $_SESSION['user_id'] = $user_with_username['id'];
                $_SESSION['email'] = $user_with_username['email'];
                $qry = null;
                return $user_with_username;
              }
              else{
                  return false;
              }
          }
          else{
              return false;
          }
    }
    public function login_viaApp($email="",$pass="")
    {
          $db = new Dbobjects();
          $db->tableName = "pk_user";
          $qry = null;
          $qry['email'] = $email;
          $qry['password'] = md5($pass);
          $userCnt = count($db->filter($qry));
          if ($userCnt===1) {
            $user = $db->get($qry);
            $app_arr['app_login_token'] = uniqid().bin2hex(random_bytes(16))."_uid_".$user['id'];
            $db->insertData = $app_arr;
            $db->update();
            $qry = null;
            $app_arr_retrun['id'] = $user['id'];
            $app_arr_retrun['name'] = $user['name'];
            $app_arr_retrun['email'] = $user['email'];
            $app_arr_retrun['username'] = $user['username'];
            $app_arr_retrun['image'] = $user['image'];
            $app_arr_retrun['isd_code'] = $user['isd_code'];
            $app_arr_retrun['mobile'] = $user['mobile'];
            $app_arr_retrun['city'] = $user['city'];
            $app_arr_retrun['area'] = $user['address'];
            $app_arr_retrun['company'] = $user['company'];
            $app_arr_retrun['national_id'] = $user['national_id'];
            $app_arr_retrun['role'] = $user['role'];
            $app_arr_retrun['user_group'] = $user['user_group'];
            $app_arr_retrun['status'] = $user['status'];
            $app_arr_retrun['app_login_token'] = $app_arr['app_login_token'];
            return $app_arr_retrun;
          }
          else if($userCnt===0){
            $qry = null;
            $qry['username'] = $email;
            $qry['password'] = md5($pass);
            $user_with_usernameCnt = count($db->filter($qry));
            if ($user_with_usernameCnt===1) {
                $user_with_username = $db->get($qry);
                $app_arr['app_login_token'] = uniqid().bin2hex(random_bytes(16))."_uid_".$user_with_username['id'];
                $db->insertData = $app_arr;
                $db->update();
                $qry = null;
                $app_arr_retrun['id'] = $user_with_username['id'];
                $app_arr_retrun['name'] = $user_with_username['name'];
                $app_arr_retrun['email'] = $user_with_username['email'];
                $app_arr_retrun['username'] = $user_with_username['username'];
                $app_arr_retrun['image'] = $user_with_username['image'];
                $app_arr_retrun['isd_code'] = $user_with_username['isd_code'];
                $app_arr_retrun['mobile'] = $user_with_username['mobile'];
                $app_arr_retrun['city'] = $user_with_username['city'];
                $app_arr_retrun['area'] = $user_with_username['address'];
                $app_arr_retrun['company'] = $user_with_username['company'];
                $app_arr_retrun['national_id'] = $user_with_username['national_id'];
                $app_arr_retrun['role'] = $user_with_username['role'];
                $app_arr_retrun['user_group'] = $user_with_username['user_group'];
                $app_arr_retrun['status'] = $user_with_username['status'];
                $app_arr_retrun['app_login_token'] = $app_arr['app_login_token'] ;
                return $app_arr_retrun;
              }
              else if ($user_with_usernameCnt===0) {
                $qry = null;
                $qry['mobile'] = $email;
                $qry['password'] = md5($pass);
                $user_with_mobileCnt = count($db->filter($qry));
                if ($user_with_mobileCnt===1) {
                $user_with_mobile = $db->get($qry);
                $app_arr['app_login_token'] = uniqid().bin2hex(random_bytes(16))."_uid_".$user_with_mobile['id'];
                $db->insertData = $app_arr;
                $db->update();
                $qry = null;
                $app_arr_retrun['id'] = $user_with_mobile['id'];
                $app_arr_retrun['name'] = $user_with_mobile['name'];
                $app_arr_retrun['email'] = $user_with_mobile['email'];
                $app_arr_retrun['username'] = $user_with_mobile['username'];
                $app_arr_retrun['image'] = $user_with_mobile['image'];
                $app_arr_retrun['isd_code'] = $user_with_mobile['isd_code'];
                $app_arr_retrun['mobile'] = $user_with_mobile['mobile'];
                $app_arr_retrun['city'] = $user_with_mobile['city'];
                $app_arr_retrun['area'] = $user_with_mobile['address'];
                $app_arr_retrun['company'] = $user_with_mobile['company'];
                $app_arr_retrun['national_id'] = $user_with_mobile['national_id'];
                $app_arr_retrun['role'] = $user_with_mobile['role'];
                $app_arr_retrun['user_group'] = $user_with_mobile['user_group'];
                $app_arr_retrun['status'] = $user_with_mobile['status'];
                $app_arr_retrun['app_login_token'] = $app_arr['app_login_token'] ;
                return $app_arr_retrun;
                }
              }
              else{
                  return false;
              }
          }
          else{
              return false;
          }
    }
    public function loginWithToken_viaApp($login_token)
    {
        $token = explode("_uid_",$login_token);
        $uid = end($token);
          $db = new Dbobjects();
          $db->tableName = "pk_user";
          $qry = null;
          $qry['id'] = $uid;
          $qry['app_login_token'] = $login_token;
          $userCnt = count($db->filter($qry));
          if ($userCnt===1) {
            $user = $db->get($qry);
            $app_arr['id'] = $user['id'];
            $app_arr['email'] = $user['email'];
            $app_arr['name'] = $user['name'];
            $app_arr['username'] = $user['username'];
            $app_arr['image'] = $user['image'];
            $app_arr['isd_code'] = $user['isd_code'];
            $app_arr['mobile'] = $user['mobile'];
            $app_arr['city'] = $user['city'];
            $app_arr['area'] = $user['address'];
            $app_arr['company'] = $user['company'];
            $app_arr['national_id'] = $user['national_id'];
            $app_arr['role'] = $user['role'];
            $app_arr['user_group'] = $user['user_group'];
            $app_arr['status'] = $user['status'];
            $app_arr['app_login_token'] = $user['app_login_token'];
            return $app_arr;
          }
          else{
              return false;
          }
    }
    public function loginWithCookie($cookie)
    {
        $token = explode("_uid_",$cookie);
        $uid = end($token);
          $db = new Dbobjects();
          $db->tableName = "pk_user";
          $qry = null;
          $qry['id'] = $uid;
          $qry['remember_token'] = $cookie;
          $user = count($db->filter($qry));
          if ($user===1) {
            $user = $db->get($qry);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $qry = null;
            return $user;
          }
          else{
              return false;
          }
    }

    public function register($email="",$pass="",$mobile="")
    {
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $GLOBALS['msg_signup'][] = "Check your email";
                return false;
            }
          $db = new Dbobjects();
          $db->tableName = "pk_user";
          $qry = null;
          $qry['email'] = $email;
          $user = count($db->filter($qry));
          if ($user===0) {
              try{
                    $qry = null;
                    $qry['email'] = $email;
                    $qry['password'] = md5($pass);
                    $qry['username'] = generate_username_by_email($email,1000);
                    // $qry['username'] = explode("@",$email)[0].rand(0,100);
                    $db->insertData = $qry;
                    $id = $db->create();
                    $newuser = $db->pk($id);
                    $_SESSION['user_id'] = $id;
                    $_SESSION['email'] = $newuser['email'];
                    $_SESSION['msg'][] = "Congratulations, you have successfully registered";
                    $GLOBALS['msg_signup'][] = "Congratulations, you have successfully registered";
                    return $newuser;
                }
            catch(PDOException $e) {
                return false;
            }
          }
          else{
              $_SESSION['msg'][] = "This email is already registered";
              $GLOBALS['msg_signup'][] = "This email is already registered";
              return false;
          }
    }

    public function authenticate()
    {
           if (isset($_SESSION['user_id'])) {
               return true;
           }
           else{
               return false;
           }
    }
    public function getLoggedInAccount()
    {
        if (isset($_SESSION['user_id'])) {
                $db = new Dbobjects();
                $db->tableName = "pk_user";
                $qry['id'] = $_SESSION['user_id'];
                $db->insertData = $qry;
                if (count($db->filter($qry)) != 0) {
                return $db->pk($_SESSION['user_id']);
                }
                else{
                    return false;
                }
            }   
            else{
                return false;
            }
           
    }
    public function is_superuser()
    {
           if (isset($_SESSION['user_id'])) {
                $db = new Dbobjects();
                $db->tableName = "pk_user";
                $qry = null;
                $qry['id'] = $_SESSION['user_id'];
                $qry['role'] = "superuser";
                $user = count($db->filter($qry));
                $qry = null;
                if ($user===1) {
                    return true;
                }
                else{
                    return false;
                }
           }
           else{
               return false;
           }
    }
  
}