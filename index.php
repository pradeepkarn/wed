<?php
require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/settings.php");
import("/includes/class-autoload.inc.php");
import("functions.php");
import("settings.php");
define("direct_access", 1);
// import('/vendor/autoload.php');
define('DEFAULT_LANG', 'hi');
$home = home;
$languages = ["hi", "en"];
if (!isset($_COOKIE['lang'])) {
  setcookie('lang', DEFAULT_LANG, time() + (86400 * 30 * 12), "/");
}
if (isset($_COOKIE['lang'])) {
  if (!in_array($_COOKIE['lang'], $languages)) {
    setcookie('lang', DEFAULT_LANG, time() + (86400 * 30 * 12), "/");
  }
}

function lang($dir)
{
  if (!isset($_COOKIE['lang'])) {
    $lang = 'hi';
  } else {
    $lang = $_COOKIE['lang'];
  }

  $filePath = RPATH . "/data/json/lang/$dir/{$lang}.json";

  if (!is_file($filePath)) {
    $lang = DEFAULT_LANG;
    $filePath = RPATH . "/data/json/lang/$dir/{$lang}.json";
  }

  return json_decode(file_get_contents($filePath));
}

// define('lang', $lang_file);

// include_once "libraries/vendor/autoload.php";
// Define Google API configuration
define('GOOGLE_CLIENT_ID', '149115951835-r6uvsqun1bb6b16ct9ebhkao4qj4eq9e.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URL', 'http://localhost/me/wed');







$home = home;
define('RELOAD', js("location.reload();"));
if (authenticate() == false) {
  $gctrl = new Fb_auth_ctlr;
  $gctrl->sign_up_or_login();
}
$acnt = new Account;
if (isset($_COOKIE['remember_token'])) {
  $acnt->loginWithCookie($cookie = $_COOKIE['remember_token']);
}
$acnt = $acnt->getLoggedInAccount();
define('USER', $acnt);
$checkaccess = ['admin', 'subadmin'];
if (authenticate() == true) {
  if (isset(USER['user_group'])) {
    $pass = in_array(USER['user_group'], $checkaccess);
    define('PASS', $pass);
  } else {
    $pass = false;
    define('PASS', $pass);
  }
} else {
  $pass = false;
  define('PASS', $pass);
}

import("routes/routes.php");

// Login via cookie



// class MyServer implements \Ratchet\MessageComponentInterface {
//     public function onOpen(\Ratchet\ConnectionInterface $conn) {
//         // Called when a new connection is opened
//     }

//     public function onClose(\Ratchet\ConnectionInterface $conn) {
//         // Called when a connection is closed
//     }

//     public function onError(\Ratchet\ConnectionInterface $conn, \Exception $e) {
//         // Called when an error occurs
//     }

//     public function onMessage(\Ratchet\ConnectionInterface $from, $msg) {
//         // Called when a message is received
//     }
// }
