<?php

class Fb_auth_ctlr
{
  function login_url()
  {
    $APP_ID = APP_ID;
    $REDIRECT_URI = REDIRECT_URI;
    $login_url = "https://www.facebook.com/v12.0/dialog/oauth?client_id={$APP_ID}&redirect_uri={$REDIRECT_URI}&scope=email";
    return $login_url;
  }
  function authenticate()
  {
    $APP_ID = APP_ID;
    $APP_SECRET = APP_SECRET;
    $REDIRECT_URI = REDIRECT_URI;

    if (isset($_GET['code'])) {
      $code = $_GET['code'];
      // Exchange the code for an access token
      $token_url = "https://graph.facebook.com/v12.0/oauth/access_token?client_id={$APP_ID}&redirect_uri={$REDIRECT_URI}&client_secret={$APP_SECRET}&code={$code}";
      $response = file_get_contents($token_url);
      $params = json_decode($response, true);

      if (isset($params['access_token'])) {
        // Get user data from Facebook
        $user_url = "https://graph.facebook.com/v12.0/me?fields=name,email&access_token={$params['access_token']}";
        $user_response = file_get_contents($user_url);
        $user = json_decode($user_response, true);
        if (isset($user['id'])) {
          // Save user data in the session or your database and consider the user logged in.
          $_SESSION['fb_user'] = $user;
          // $_SESSION['msg'][] = 'Login success via facebook';
          $_SESSION['fb_code'] = $code;
          return $_SESSION['fb_user'];
        } else {
          $_SESSION['msg'][] = 'Failed to get user data from Facebook.';
        }
      } else {
        $_SESSION['msg'][] = 'Failed to get access token from Facebook.';
      }
    }
  }

  function sign_up_or_login()
  {
    $this->authenticate();
    if (!isset($_SESSION['fb_user'])) {
      return false;
    }
    $fb = obj($_SESSION['fb_user']);
    // myprint($fb);
    $db = new Dbobjects;
    $pdo = $db->dbpdo();
    $pdo->beginTransaction();
    try {
      $sql = "select * from pk_user where email = '$fb->email'";
      $user = $db->show($sql);
      if (count($user) == 1) {
        $user = obj($user[0]);
        $_SESSION['user_id'] = $user->id;
        $_SESSION['msg'][] = 'Log in success via facebook';
        $pdo->commit();
        echo js_alert(msg_ssn(return: true));
        return true;
      } else {
        $pass = uniqid('pass') . "pass";
        $password = md5($pass);
        $namearr = explode(" ", $fb->name);
        $first_name = isset($namearr[0]) ? $namearr[0] : $fb->name;
        $last_name = isset($namearr[1]) ? $namearr[1] : null;
        $username = generate_username_by_email($fb->email, 1000, $db);
        $sql = "insert into pk_user (email,username,first_name,last_name,password)  values('$fb->email','$username', '$first_name','$last_name','$password');";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $userid = $pdo->lastInsertId();
        if (intval($userid)) {
          $_SESSION['user_id'] = $userid;
          $_SESSION['msg'][] = 'Signup success via facebook';
        }
        $pdo->commit();
        echo js_alert(msg_ssn(return: true));
        return true;
      }
    } catch (PDOException $th) {
      echo js_alert(msg_ssn(return: true));
      $pdo->rollback();
    }
  }
}
