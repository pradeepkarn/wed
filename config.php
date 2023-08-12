<?php 
//phpinfo();
date_default_timezone_set("Asia/Kolkata");
session_start();
require_once 'vendor/autoload.php'; // Load Composer's autoloader
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); // Path to your project root
$env = (object) $dotenv->load();
#server host name or simply leave it as it is
define("MY_DOMAIN",$env->MY_DOMAIN);
#server host name or simply leave it as it is
define("PK_DB_HOST",$env->DB_HOST);
#Database name
define("PK_DB_NAME",$env->DB_NAME);
#Database username
define("PK_DB_USER",$env->DB_USER);
#Database password
define("PK_DB_PASS",$env->DB_PASS);
define("email",$env->EMAIL);
#Define real location of file
define ('RPATH', realpath(dirname(__FILE__)));
$year = Date('Y');
define("SITE_NAME",$env->SITE_NAME);
define("CREDIT","&copy;".SITE_NAME." {$year}. All Rights Reserved.");
define("DEV_NOTE","Design & Developed by <a style='text-decoration: none; color: inherit;' href='https://fb.com/itsme.pkarn'>$env->AUTHOR</a>");
define('home',$env->HOME);
define('HOME',$env->HOME);
const STATIC_ROOT = RPATH."/static";
const STATIC_URL = home."/static";
const MEDIA_ROOT = RPATH."/media/";
const MEDIA_URL = home."/media";
$requri = isset($_SERVER['REQUEST_URI'])?rtrim($_SERVER['REQUEST_URI'], '/'):[];
$request_uri = str_replace("/".home,'',$requri, $requri);
define("REQUEST_URI",$request_uri);

define("APP_ID",$env->APP_ID);
#server host name or simply leave it as it is
define("REDIRECT_URI",$env->REDIRECT_URI);
#Database name
define("TOKEN_URL",$env->TOKEN_URL);
#Database username
define("USER_DATA_URL",$env->USER_DATA_URL);
#Database password
define("APP_SECRET",$env->APP_SECRET);

// General Codes
function import($var=null,$context="",$many=false)
{
   /**
      * @context variable defiend as parameteres of the function, we can set any value to get the value on rendered page
   */ 
   $ctxObj = $context;
   if($many===true){
      include __DIR__."/".$var;
      return;
   }else{
      include_once __DIR__."/".$var;
      return;
   }
   
}
function render($template=null,$context=null)
{
   include_once __DIR__."/".$template;
}
// excerpt
   function the_excerpt($string = null, $len = 20)
   {
      if (strlen($string) >= $len) {
         return substr($string, 0, $len). " ... ";
      }
      else 
      {
            return $string;
      }
   }

if (empty($_SESSION['token'])) {
   $_SESSION['token'] = bin2hex(random_bytes(32));
}
$csrf_token = "<input type='hidden' name='csrf_token' value='{$_SESSION['token']}'>";
function csrf_token($html_attribute=''){
   $csrf_token = "<input type='hidden' {$html_attribute} name='csrf_token' value='{$_SESSION['token']}'>";
   echo $csrf_token;
}
function verify_csrf($var = null)
{
   if ($var == $_SESSION['token']) {
      $_SESSION['token'] = bin2hex(random_bytes(32));
      return true;
   }
   else {
      $_SESSION['token'] = bin2hex(random_bytes(32));
      return false;
   }
}

// form validations
function sanitize_remove_tags($data) {
  $data = strip_tags($data);
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
const sitekey = "ksjhdlks0797834hjrgfv3trk43gwugr4gui";
const token_security = false;