<?php
class Auth
{
    public function register()
    {
        $data = null;
        $data = $_POST;
        $rules = [
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:20',
            'confirm_password' => 'required|string|min:8|max:20'
        ];
        $pass = validateData(data: $_POST, rules: $rules);
        if ($pass) {
            $data = obj($data);
            if ($data->password != $data->confirm_password) {
                $_SESSION['msg'][] = 'Password and confirm password must be same';
                msg_ssn();
                exit;
            }
            if (!email_has_valid_dns($data->email)) {
                $_SESSION['msg'][] = 'Please provide a working email';
                echo js_alert(msg_ssn(return:true));
                exit;
            }
            $obj = new stdClass;
            $obj->col = 'email';
            $obj->val = $data->email;
            $emailcheck = $this->check_dup($obj);
            if ($emailcheck) {
                $_SESSION['msg'][] = 'This email is already taken';
                msg_ssn();
                exit;
            } else {
                $username = generate_username_by_email($data->email);
                $password = md5($data->password);
                $role = 'subscriber';
            }
            try {
                $user_id = (new Model('pk_user'))->store(
                    array(
                        'email' => $data->email,
                        'username' => $username,
                        'password' => $password,
                        'role' => $role,
                    )
                );
                if (intval($user_id)) {
                    $user = $this->login($uniqcol = $data->email, $password = $data->password, $ug = 'user');
                    if ($user != false) {
                        echo RELOAD;
                        exit;
                    }
                }
            } catch (PDOException $e) {
                // echo "Error: " . $e->getMessage();
                $_SESSION['msg'][] = 'Something went wrong while saving in database';
                msg_ssn("msg");
                exit;
            }
        } else {
            msg_ssn("msg");
            exit;
        }
    }
    public function check_dup($obj)
    {
        $arr = null;
        $arr[$obj->col] = $obj->val;
        return (new Model('pk_user'))->exists($arr);
    }
    public function login($uniqcol = null, $password = null, $ug = 'user')
    {
        if ($uniqcol == null) {
            $_SESSION['msg'][] = 'Empty data is not allowed';
            msg_ssn();
            return false;
        }
        $userObj = new Model('pk_user');
        $user = $userObj->filter_index(array('username' => $uniqcol, 'password' => md5($password)));
        if (count($user) == 1) {
            $user = obj($user[0]);
            if (!user_group($user, $ug)) {
                $_SESSION['msg'][] = 'Invalid login portal';
                msg_ssn("msg");
                return false;
            }
            $_SESSION['user_id'] = $user->id;
            $this->save_in_cookie($user->id);
            $_SESSION['msg'][] = 'Logged in success via username';
            msg_ssn("msg");
            return $user;
        }
        $user = $userObj->filter_index(array('email' => $uniqcol, 'password' => md5($password)));
        if (count($user) == 1) {
            $user = obj($user[0]);
            if (!user_group($user, $ug)) {
                $_SESSION['msg'][] = 'Invalid login portal';
                msg_ssn("msg");
                return false;
            }
            $_SESSION['user_id'] = $user->id;
            $this->save_in_cookie($user->id);
            $_SESSION['msg'][] = 'Logged in success via email';
            msg_ssn("msg");
            return $user;
        }
        $user = $userObj->filter_index(array('mobile' => $uniqcol, 'password' => md5($password)));
        if (count($user) == 1) {
            $user = obj($user[0]);
            if (!user_role($user, $ug)) {
                $_SESSION['msg'][] = 'Invalid login portal';
                msg_ssn("msg");
                return false;
            }
            $_SESSION['user_id'] = $user->id;
            $this->save_in_cookie($user->id);
            $_SESSION['msg'][] = 'Logged in success via mobile';
            msg_ssn("msg");
            return $user;
        } else {
            $_SESSION['msg'][] = 'Username or password wrong';
            msg_ssn("msg");
            return false;
        }
    }

    public function save_in_cookie($userid, Dbobjects $db = null)
    {
        if ($db != null) {
            $db = $db;
        } else {
            $db = new Dbobjects;
        }
        $db->tableName = 'pk_user';
        $cookie_name = "remember_token";
        $cookie_value = bin2hex(random_bytes(32)) . "_uid_" . $userid;
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30 * 12), "/"); // 86400 = 1 day
        // $db = new Model('pk_user');
        $db->pk($userid);
        $arr = null;
        $arr['remember_token'] = $cookie_value;
        $db->insertData = $arr;
        $db->update();
        $arr = null;
    }
    public function logout()
    {
        if (USER) {
            $role = USER['role'];
        } else {
            $role = false;
        }
        // Unset all session values
        $_SESSION = array();
        // Destroy the session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 42000, '/');
        }
        if (isset($_COOKIE['remember_token'])) {
            setcookie('remember_token', '', time() - 42000, '/');
        }
        // Destroy the session
        session_destroy();
        if ($role == 'superuser') {
            header("Location: /" . home . route('adminLogin'));
            exit;
        }
        header("Location: /" . home . route('userLogin'));
    }

    ############################################### pages and ajax

    public function user_login_page($req = null)
    {
        if (authenticate()) {
            header("Location: /" . home.route('home'));
            exit;
        }
        $context = (object) array(
            'page' => 'auth/user-login.php',
            'data' => (object) array(
                'req' => obj($req)
            )
        );
        $this->render_main($context);
    }

    public function registration_page($req = null)
    {
        if (is_superuser()) {
            header("Location: /" . home . route('adminhome'));
            exit;
        }
        if (authenticate()) {
            header("Location: /" . home.route('home'));
            exit;
        }
        $context = (object) array(
            'page' => 'auth/registration.php',
            'data' => (object) array(
                'req' => obj($req)
            )
        );
        $this->render_main($context);
    }
    public function admin_login_page($req = null)
    {
        if (is_superuser()) {
            header("Location: /" . home . route('adminhome'));
            exit;
        }
        $context = (object) array(
            'page' => 'auth/admin-login.php',
            'data' => (object) array(
                'req' => obj($req)
            )
        );
        $this->render_main($context);
    }
    public function admin_login($req = null)
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string|min:8|max:20'
        ];
        $pass = validateData(data: $_POST, rules: $rules);
        if ($pass) {
            $auth = new Auth();
            $user = $auth->login(uniqcol: $_POST['username'], password: $_POST['password'], ug: "admin");
            if ($user != false) {
                echo RELOAD;

                exit;
            }
        } else {
            msg_ssn("msg");
        }
    }
    public function user_login($req = null)
    {
        $rules = [
            'username' => 'required|string',
            'password' => 'required|string|max:20'
        ];
        $pass = validateData(data: $_POST, rules: $rules);
        if ($pass) {
            $auth = new Auth();
            $user = $auth->login($_POST['username'], $_POST['password']);
            if ($user != false) {
                echo RELOAD;
                exit;
            }
        } else {
            msg_ssn("msg");
        }
    }
    public function render_main($context = null)
    {
        import("apps/view/layouts/main.php", $context);
    }
}
