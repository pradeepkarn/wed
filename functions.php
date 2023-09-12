<?php
function msg_ssn($var = 'msg', $return = false, $lnbrk = "\\n")
{
  if (isset($_SESSION[$var])) {
    if ($return == true) {
      $returnmsg = null;
      foreach ($_SESSION[$var] as $msg) {
        $returnmsg .= "{$msg}$lnbrk";
      }
      unset($_SESSION[$var]);
      return $returnmsg;
    }
    foreach ($_SESSION[$var] as $msg) {
      echo "{$msg}<br>";
    }
    unset($_SESSION[$var]);
  }
}
function login()
{
  if (isset($_POST['email']) && isset($_POST['password'])) {
    $account = new Account();
    $user = $account->login($_POST['email'], $_POST['password']);
    if ($user != false) {
      $cookie_name = "remember_token";
      $cookie_value = bin2hex(random_bytes(32)) . "_uid_" . $user['id'];
      setcookie($cookie_name, $cookie_value, time() + (86400 * 30 * 12), "/"); // 86400 = 1 day
      $db = new Mydb('pk_user');
      $db->pk($_SESSION['user_id']);
      $arr = null;
      $arr['remember_token'] = $cookie_value;
      $db->updateData($arr);
      $arr = null;
      // $GLOBALS['msg_signin'][] = "Login Success";
      $_SESSION['msg'][] = "Login Success";
      return $user;
    } else {
      // $GLOBALS['msg_signin'][] = "Invalid credentials";
      $_SESSION['msg'][] = "Invalid credentials";
      return false;
    }
  }
}
function register()
{
  if (isset($_POST['email']) && isset($_POST['password']) && isset($_POST['cnfpassword'])) {
    if ($_POST['password'] === $_POST['cnfpassword']) {
      $account = new Account();
      $user = $account->register($_POST['email'], $_POST['password']);
      if ($user != false) {
        $cookie_name = "remember_token";
        $cookie_value = bin2hex(random_bytes(32)) . "_uid_" . $user['id'];
        setcookie($cookie_name, $cookie_value, time() + (86400 * 30 * 12), "/"); // 86400 = 1 day
        $db = new Mydb('pk_user');
        $db->pk($_SESSION['user_id']);
        $arr = null;
        $arr['remember_token'] = $cookie_value;
        $db->updateData($arr);
        $arr = null;
        return $user;
      } else {
        $GLOBALS['msg_signup'][] = "Sorry something went wrong";
        return false;
      }
    } else {
      $GLOBALS['msg_signup'][] = "Sorry, Password did not match";
      return false;
    }
  }
}
function is_superuser()
{
  $account = new Account();
  return $account->is_superuser();
}

function authenticate()
{
  $account = new Account();
  return $account->authenticate();
}
function myprint($data = null)
{
  echo "<pre>";
  print_r($data);
  echo "</pre>";
}
function pkAjax($button, $url, $data, $response, $event = 'click', $method = "post", $progress = false, $return = false)
{
  $progress_code = "";
  if ($progress == true) {
    $progress_code = "xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener('progress', function(evt) {
              if (evt.lengthComputable) {
                  var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                  $('.progress-bar').width(percentComplete + '%');
                  // $('.progress-bar').html(percentComplete+'%');
              }
          }, false);
          return xhr;
          },";
  }
  $home = home;
  $ajax = "<script>
  $(document).ready(function() {
      $('{$button}').on('{$event}',function(event) {
          event.preventDefault();
          if (typeof tinyMCE != 'undefined') {
            tinyMCE.triggerSave();
          }
          $.ajax({
              $progress_code
              url: '/{$home}{$url}',
              method: '$method',
              data: $('{$data}').serializeArray(),
              dataType: 'html',
              success: function(resultValue) {
                  $('{$response}').html(resultValue)
              }
          });
      });
  });
  </script>";
  if ($return == true) {
    return $ajax;
  }
  echo $ajax;
}
function send_to_server($button, $data, $callback, $event = 'click')
{
  $ajax = "<script>
  $(document).ready(function () {
    $('{$data}').on('submit',(function(e) {
        e.preventDefault();
        var formData = new FormData(this);
        $.ajax({
            type:'POST',
            url: $('{$data}').attr('action'),
            data: $('{$data}').serializeArray(),
            dataType: 'json', // Fixed: dataType should be a string
            success:function(res){
              {$callback}(res); // Call the provided callback function
            }
        });
    }));
    $('{$button}').on('{$event}', function(e) {
      e.preventDefault();
      $('{$data}').submit();
  });
});
</script>";
  echo $ajax;
}

function pkAjax_form($button, $data, $response, $event = 'click', $progress = false)
{
  $progress_code = "";
  if ($progress == true) {
    $progress_code = "xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener('progress', function(evt) {
              if (evt.lengthComputable) {
                  var percentComplete = Math.round((evt.loaded / evt.total) * 100);
                  $('.progress-bar').width(percentComplete + '%');
                  // $('.progress-bar').html(percentComplete+'%');
              }
          }, false);
          return xhr;
          },";
  }
  $ajax = "<script>
  $(document).ready(function (e) {
    $('{$data}').on('submit',(function(e) {
        e.preventDefault();
        if (typeof tinyMCE != 'undefined') {
          tinyMCE.triggerSave();
        }
        event.preventDefault();
        var formData = new FormData(this);
        $.ajax({
          $progress_code
            type:'POST',
            url: $(this).attr('action'),
            data:formData,
            cache:false,
            contentType: false,
            processData: false,
            success:function(resultValue){
              $('{$response}').html(resultValue)
            }
        });
    }));
    $('{$button}').on('{$event}', function() {
      $('{$data}').submit();
  });
});
</script>";
  echo $ajax;
}
function get_content_by_slug($slug)
{
  $obj = new Model('content');
  $cont =  $obj->filter_index(array('slug' => $slug, 'content_group' => 'page'));
  if (count($cont) == 1) {
    return $cont[0];
  } else {
    return false;
  }
}
function generate_username_by_email($email, $try = 100, $db = null)
{
  if (filter_var($email, FILTER_VALIDATE_EMAIL) == true) {
    if ($db != null) {
      $db = $db;
    } else {
      $db = new Dbobjects;
    }
    $db->tableName = 'pk_user';
    $arr['email'] = sanitize_remove_tags($email);
    $emailarr = explode("@", $arr['email']);
    $username = $emailarr[0];
    $dbusername = count($db->filter(array('username' => $username))) > 0 ? true : false;
    if ($dbusername == true) {
      $i = 1;
      while ($dbusername == true) {
        $dbusername = count($db->filter(array('username' => $username . $i))) > 0 ? true : false;
        if ($dbusername == false) {
          return $username . $i;
        }
        if ($i == $try) {
          break;
        }
        $i++;
      }
    } else {
      return $username;
    }
  } else {
    return false;
  }
}
function generate_dummy_email($prefix = null)
{
  return uniqid($prefix . "_" . rand(1, 50)) . "@example.com";
}
function bsmodal($id = "", $title = "", $body = "", $btn_id, $btn_text = "Action", $btn_class = "btn btn-primary", $size = "modal-sm", $modalclasses = "")
{
  $str = "
<div class='modal fade' id='$id' tabindex='-1' aria-hidden='true'>
<div class='modal-dialog $size'>
<div class='modal-content'>
<div class='modal-header'>
    <h5 class='modal-title'>$title</h5>
    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
</div>
<div class='modal-body'>
$body
</div>
<div class='modal-footer'>
    <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
    <button type='button' id='$btn_id' class='$btn_class'>$btn_text</button>
</div>
</div>
</div>
</div>";
  return $str;
}
function popmodal($id = "", $title = "", $body = "", $btn_id, $btn_text = "Action", $btn_class = "btn btn-primary", $size = "modal-sm", $close_btn_class = "")
{
  $str = "
<div class='modal fade' id='$id' tabindex='-1' aria-hidden='true'>
<div class='modal-dialog $size'>
<div class='modal-content'>
<div class='modal-header'>
    <h5 class='modal-title'>$title</h5>
    <button type='button' class='$close_btn_class btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
</div>
<div class='modal-body'>
$body
</div>
<div class='modal-footer'>
    <button type='button' class='$close_btn_class btn btn-secondary' data-bs-dismiss='modal'>Close</button>
    <button type='button' id='$btn_id' class='$btn_class'>$btn_text</button>
</div>
</div>
</div>
</div>";
  return $str;
}
function generate_slug($slug, $try = 1000)
{
  if ($slug !== "") {
    $db = new Model('content');
    $slug = str_replace(" ", "-", sanitize_remove_tags($slug));
    $dbslug = $db->exists(array('slug' => $slug));
    if ($dbslug == true) {
      $i = 1;
      while ($dbslug == true) {
        $dbslug = $db->exists(array('slug' => $slug . "-" . $i));
        if ($dbslug == false) {
          return $slug . "-" . $i;
        }
        if ($i == $try) {
          return false;
          break;
        }
        $i++;
      }
    } else {
      return $slug;
    }
  } else {
    return false;
  }
}
function ajaxLoad($loadId)
{
  $ajax = "<script>
$(document).ready(function() {
          
  $(document).ajaxStart(function(){
  $('{$loadId}').css('display', 'block');
});
$(document).ajaxComplete(function(){
  $('{$loadId}').css('display', 'none');
});
});
</script>";
  echo $ajax;
}
function ajaxLoadModal($loadId)
{
  $ajax = "<script>
$(document).ready(function() {
          
  $(document).ajaxStart(function(){
  $('{$loadId}').modal('show');
});
$(document).ajaxComplete(function(){
  $('{$loadId}').modal('hide');
});
});
</script>";
  echo $ajax;
}
function ajaxActive($qry)
{
  $ajax = "<script>
$(document).ready(function() {
  $('{$qry}').css({'visibility':'hidden'});
  $(document).ajaxStart(function(){
  $('{$qry}').css({'visibility':'visible'});
});
$(document).ajaxComplete(function(){
  $('{$qry}').css({'visibility':'hidden'});
});
});
</script>";
  echo $ajax;
}
function removeSpace($str)
{
  $str = str_replace(" ", "_", sanitize_remove_tags($str));
  $str = str_replace("/", "_", $str);
  $str = str_replace("\\", "_", $str);
  $str = str_replace("&", "_", $str);
  $str = str_replace(";", "", $str);
  $str = str_replace(";", "", $str);
  $str = strtolower($str);
  return $str;
}
function filter_name($file_with_ext = "")
{
  $only_file_name = pathinfo($file_with_ext, PATHINFO_FILENAME);
  $only_file_name =  sanitize_remove_tags(str_ireplace(" ", "_", $only_file_name));
  $only_file_name =  sanitize_remove_tags(str_ireplace("(", "", $only_file_name));
  $only_file_name =  sanitize_remove_tags(str_ireplace(")", "", $only_file_name));
  $only_file_name =  sanitize_remove_tags(str_ireplace("'", "", $only_file_name));
  $only_file_name =  sanitize_remove_tags(str_ireplace("\"", "", $only_file_name));
  $only_file_name =  sanitize_remove_tags(str_ireplace("&", "", $only_file_name));
  $only_file_name =  sanitize_remove_tags(str_ireplace(";", "", $only_file_name));
  $only_file_name =  sanitize_remove_tags(str_ireplace("#", "", $only_file_name));
  return $only_file_name;
}
function getAccessLevel()
{
  if (isset($_SESSION['user_id'])) {
    $db = new Dbobjects();
    $db->tableName = "pk_user";
    $qry['id'] = $_SESSION['user_id'];
    $db->insertData = $qry;
    if (count($db->filter($qry)) != 0) {
      return $db->pk($_SESSION['user_id'])['access_level'];
    } else {
      false;
    }
  } else {
    false;
  }
}
function updateMyProfile()
{
  if (isset($_SESSION['user_id'])) {
    $db = new Mydb('pk_user');
    if (isset($_POST['update_profile_by_admin'])) {
      $qry['id'] = $_POST['update_profile_by_admin'];
    } else {
      $qry['id'] = $_SESSION['user_id'];
    }
    if (isset($_POST['password']) && ($_POST['password'] != "")) {
      $qry['password'] = md5($_POST['password']);
    }


    if (count($db->filterData($qry)) > 0) {
      if (isset($_POST['update_my_profile'])) {
        $upqry['name'] = sanitize_remove_tags($_POST['my_name']);
        $upqry['mobile'] = sanitize_remove_tags($_POST['my_mobile']);
        $upqry['updated_at'] = date('y-m-d h:m:s');
        $db->updateData($upqry);
      }
    } else {
      false;
    }
  } else {
    false;
  }
}

function getTableRowById($tablename, $id)
{
  $db = new Mydb($tablename);
  $qry['id'] = $id;
  if (count($db->filterData($qry)) > 0) {
    return $db->pkData($id);
  } else {
    false;
  }
}
function check_slug_globally($slug = null)
{
  $count = 0;
  $var = ['categories', 'content'];
  for ($i = 0; $i < count($var); $i++) {
    $db = new Dbobjects();
    $db->tableName = $var[$i];
    $qry['slug'] = $slug;
    $count += count($db->filter($qry));
  }
  return $count;
}

function all_books($ord = "DESC", $limit = 100, $post_cat = "", $catid = "")
{
  $novels = array();
  $novelobj = new Model('content');
  $arr['content_group'] = 'book';
  if ($post_cat != "") {
    $arr['post_category'] = $post_cat;
  }
  if ($catid != "") {
    $arr['parent_id'] = $catid;
  }
  $novels = $novelobj->filter_index($arr, $ord, $limit);
  if ($novels == false) {
    $novels = array();
  }
  return $novels;
}
function all_cats()
{
  $novels = array();
  $novelobj = new Model('content');
  $arr['content_group'] = 'listing_category';
  $novels = $novelobj->filter_index($arr);
  if ($novels == false) {
    $novels = array();
  }
  return $novels;
}
function js_alert($msg = "")
{
  return "<script>alert('{$msg}');</script>";
}
function js($msg = "")
{
  return "<script>{$msg}</script>";
}
function matchData($var1 = "null", $var2 = "null", $print = "Pradeep Karn")
{
  if ($var1 == $var2) {
    echo $print;
  }
}
function views($post_category = 'general', $cont_type = 'post')
{
  $views = array();
  $db = new Mydb('content');
  $data = $db->filterData(['post_category' => $post_category, 'content_type' => $cont_type]);
  foreach ($data as $key => $value) {
    $views[] = $value['views'];
  }
  $views = array_sum($views);
  return $views;
}
function pk_excerpt($string = null, $limit = 50, $strip_tags = true)
{
  if ($strip_tags === true) {
    $string = strip_tags($string);
  }
  if (strlen($string) > $limit) {
    // truncate string
    $stringCut = substr($string, 0, $limit);
    $endPoint = strrpos($stringCut, ' ');
    //if the string doesn't contain any space then it will cut without word basis.
    $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
    $string = $string . "...";
  }
  return $string;
}
function filterUnique($table, $col, $ord = "DESC")
{
  $db = new Mydb($table);
  if (count($db->filterDistinct($col)) > 0) {
    return $db->filterDistinct($col, $ord, 100000);
  } else {
    return false;
  }
}
//categories start
function create_category()
{

  global $conn;
  $parent_id = legal_input($_POST['parent_id']);
  $category_name = legal_input($_POST['category_name']);
  $catdb = new Model('content');
  $arr['title'] = $category_name;
  $arr['parent_id'] = $parent_id;
  $new_cat_id = $catdb->store($arr);
  // $query=$conn->prepare("INSERT INTO categories (parent_id, category_name) VALUES (?,?)");
  // $query->bind_param('is',$parent_id,$category_name);
  // $exec= $query->execute();
  if ($new_cat_id != false) {
    return $new_cat_id;
  } else {
    return false;
  }
}

function multilevel_categories($parent_id = 0, $radio = true, $category_group = "listing_category")
{
  $catdb = new Model('content');
  $exec = $catdb->filter_index(array('parent_id' => $parent_id, 'content_group' => $category_group));
  $catData = [];
  if ($exec != false) {
    foreach ($exec as $key => $row) {
      $catData[] = [
        'id' => $row['id'],
        'parent_id' => $row['parent_id'],
        'category_name' => $row['title'],
        'nested_categories' => multilevel_categories($row['id'], $radio, $category_group),
        'radio' => $radio
      ];
    }

    return $catData;
  } else {
    return $catData = [];
  }
}

function display_list($nested_categories)
{
  $rd = null;
  $home = home;
  $list = '<ul class="list-none">';
  foreach ($nested_categories as $nested) {
    if ($nested['radio'] == true) {
      $rd = '<input type="radio" name="parent_id" value=' . $nested['id'] . '> ';
    }
    $list .= '<li>' . $rd . "<a href='/{$home}/admin/categories/edit/{$nested['id']}' class='text-deco-none'>" . $nested['category_name'] . '</a></li>';
    if (!empty($nested['nested_categories'])) {
      $list .= display_list($nested['nested_categories']);
    }
  }
  $list .= '</ul>';
  return $list;
}

function display_option($nested_categories, $mark = ' ')
{
  $option = null;
  foreach ($nested_categories as $nested) {

    $option .= '<option value="' . $nested['id'] . '">' . $mark . $nested['category_name'] . '</option>';

    if (!empty($nested['nested_categories'])) {
      $option .= display_option($nested['nested_categories'], $mark . '-');
    }
  }
  return $option;
}
function getData($table, $id)
{
  return (new Model($table))->show($id);
}
// convert illegal input to legal input
function legal_input($value)
{
  $value = trim($value);
  $value = stripslashes($value);
  $value = htmlspecialchars($value);
  return $value;
}
function getCatTree($parent_id)
{
  $db = new Model('content');
  $listings = $db->filter_index(array('content_group' => 'listing_category', 'parent_id' => $parent_id), $ord = "DESC", $limit = "1000", $change_order_by_col = "");
  if ($listings == false) {
    $listings = array();
  }
  $listing_data = array();
  foreach ($listings as $key => $uv) {
    $listing_data[] = array(
      'id' => $uv['id'],
      'title' => $uv['title'],
      'info' => $uv['content_info'],
      'description' => $uv['content'],
      'image' => "/media/images/pages/" . $uv['banner'],
      'category' => ($uv['parent_id'] == 0) ? 'Main' : getData('content', $uv['parent_id'])['title'],
      'status' => $uv['status'],
      'child' => getCatTree($uv['id'])
    );
  }
  return $listing_data;
}
//cart count
$GLOBALS['cart_cnt'] = 0;
// if (authenticate()===true) {
//    $cartObj = new Model('my_order');
//    $mycart = $cartObj->filter_index(array('user_id'=>$_SESSION['user_id'],'status'=>'cart'));
//    if ($mycart==false) {
//     $mycart = array();
//    }
//    $GLOBALS['cart_cnt'] = count($mycart);
// }

if (isset($_SESSION['cart'])) {
  $GLOBALS['cart_cnt'] = count($_SESSION['cart']);
}
function change_my_banner($contentid, $banner, $banner_name = "img")
{
  if (isset($banner)) {
    $file = $banner;
    $media_folder = "images/pages";
    $imgname = $banner_name;
    $media = new Media();
    $page = new Dbobjects();
    $page->tableName = 'content';
    $pobj = $page->pk($contentid);
    $target_dir = RPATH . "/media/images/pages/";
    if ($pobj['banner'] != "") {
      if (file_exists($target_dir . $pobj['banner'])) {
        unlink($target_dir . $pobj['banner']);
        $_SESSION['msg'][] = "Old image was replaced";
      }
    }
    $file_ext = explode(".", $file["name"]);
    $ext = end($file_ext);
    $page->insertData['banner'] = $imgname . "." . $ext;
    $page->update();
    $media->upload_media($file, $media_folder, $imgname, $file['type']);
  }
}

function user_data_by_token($token, $col = 'email')
{
  $user = new Model('pk_user');
  $arr['app_login_token'] = $token;
  $user = $user->filter_index($arr);
  if (!count($user) > 0) {
    return false;
  } else {
    return $user[0][$col];
  }
}

function nested_array_unique($nested_array)
{
  $flattened = array_map('serialize', $nested_array);
  $flattened = array_unique($flattened);
  return array_map('unserialize', $flattened);
}

function num_to_words($number)
{
  $no = floor($number);
  $point = round($number - $no, 2) * 100;
  $hundred = null;
  $digits_1 = strlen($no);
  $i = 0;
  $str = array();
  $words = array(
    '0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' => 'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety'
  );
  $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
  while ($i < $digits_1) {
    $divider = ($i == 2) ? 10 : 100;
    $number = floor($no % $divider);
    $no = floor($no / $divider);
    $i += ($divider == 10) ? 1 : 2;
    if ($number) {
      $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
      $hundred = ($counter == 1 && $str[0]) ? ' ' : null;
      $str[] = ($number < 21) ? $words[$number] .
        " " . $digits[$counter] . $plural . " " . $hundred
        :
        $words[floor($number / 10) * 10]
        . " " . $words[$number % 10] . " "
        . $digits[$counter] . $plural . " " . $hundred;
    } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point) ?
    "." . $words[$point / 10] . " " .
    $words[$point = $point % 10] : '';
  //  echo $result . "Rupees  " . $points . " Paise";
  return $result;
}

function emaillog($msg = "")
{
  $file = MEDIA_ROOT . "docs/email.log";
  $log_file = fopen($file, 'a');
  $message = date('Y-m-d H:i:s') . " $msg\n";
  fwrite($log_file, $message);
  fclose($log_file);
}
function page_not_found($pagedata = null)
{
  import("apps/view/pages/404.php");
}
function obj($arr)
{
  return (object) $arr;
}
function arr($obj)
{
  return (array) $obj;
}

function rslashtrim()
{
  $var = <<<VAR
    <script>
    if (window.location.href.endsWith('/')) {
      var newUrl = window.location.href.replace(/\/$/, '');
      history.replaceState(null, '', newUrl);
    }
    </script>
    VAR;
  echo $var;
}
function go_to($link = "/")
{
  $home = home;
  $var = <<<RED
            <script>
                location.href="/$home$link";
            </script>
            RED;
  return $var;
}

function validateData($data, $rules)
{
  $errors = [];

  foreach ($rules as $field => $rule) {
    // Check if field is required
    if (strpos($rule, 'required') !== false && (!isset($data[$field]) || empty($data[$field]))) {
      $errors[] = str_replace("_", " ", ucfirst($field)) . ' is required';
    }

    // Check for other rules
    $rulesArr = explode('|', $rule);
    foreach ($rulesArr as $singleRule) {
      // Check if rule has a parameter
      preg_match('/^([a-z]+)(?::([0-9]+))?$/i', $singleRule, $matches);
      $ruleName = $matches[1];
      $ruleParam = isset($matches[2]) ? (int) $matches[2] : null;

      switch ($ruleName) {
        case 'integer':
          if (isset($data[$field]) && !filter_var($data[$field], FILTER_VALIDATE_INT)) {
            $errors[] = str_replace("_", " ", ucfirst($field)) . ' must be an integer';
          }
          break;
        case 'date':
          if (isset($data[$field]) && !strtotime($data[$field])) {
            $errors[] = str_replace("_", " ", ucfirst($field)) . ' must be a valid date format';
          }
          break;
        case 'numeric':
          if (isset($data[$field]) && !is_numeric($data[$field])) {
            $errors[] = str_replace("_", " ", ucfirst($field)) . ' must be a numeric value';
          }
          break;
        case 'string':
          if (isset($data[$field]) && !is_string($data[$field])) {
            $errors[] = str_replace("_", " ", ucfirst($field)) . ' must be a string';
          }
          break;
        case 'email':
          if (isset($data[$field]) && !filter_var($data[$field], FILTER_VALIDATE_EMAIL)) {
            $errors[] = str_replace("_", " ", ucfirst($field)) . ' must be a valid email address';
          }
          break;
        case 'url':
          if (isset($data[$field]) && !filter_var($data[$field], FILTER_VALIDATE_URL)) {
            $errors[] = str_replace("_", " ", ucfirst($field)) . ' must be a valid URL';
          }
          break;
        case 'min':
          if (isset($data[$field]) && strlen($data[$field]) < $ruleParam) {
            $errors[] = str_replace("_", " ", ucfirst($field)) . ' must be at least ' . $ruleParam . ' characters long';
          }
          break;
        case 'max':
          if (isset($data[$field]) && strlen($data[$field]) > $ruleParam) {
            $errors[] = str_replace("_", " ", ucfirst($field)) . ' must not exceed ' . $ruleParam . ' characters';
          }
          break;
        case 'file':
          if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) {
            $errors[] = str_replace("_", " ", ucfirst($field)) . ' is required';
          } else {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $extension = pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION);
            if (!in_array($extension, $allowedExtensions)) {
              $errors[] = 'Only files with extensions ' . implode(', ', $allowedExtensions) . ' are allowed for ' . $field;
            }
          }
          break;
        default:
          break;
      }
    }
  }
  if (!empty($errors)) {
    // There are validation errors - display them to the user
    foreach ($errors as $error) {
      $_SESSION['msg'][] = $error;
    }
    return false;
  } else {
    // Data is valid - process it
    return true;
  }
}

function user_role($user, $role = "subscriber")
{
  if ($user->role == $role) {
    return true;
  } else {
    return false;
  }
}
function user_group($user, $ug = "user")
{
  if ($user->user_group == $ug) {
    return true;
  } else {
    return false;
  }
}

function generate_clean_username($string)
{
  // Convert the string to lowercase
  $string = strtolower($string);

  // Remove all non-alphanumeric characters
  $string = preg_replace("/[^a-zA-Z0-9]/", "", $string);

  // Return the clean username
  return $string;
}

function count_views($id)
{
  $db = new Dbobjects;
  $db->tableName = "content";
  $primary_key = $db->id();
  $sql = "UPDATE content SET views = views + 1 WHERE  $primary_key = $id";
  $db->dbpdo()->exec($sql);
}

function most_read_cats($limit = 10)
{
  $db = new Dbobjects;
  $sql = "SELECT parent_id as cat_id, SUM(views) as views
  FROM content 
  WHERE content_group = 'post' and views > 0
  GROUP BY parent_id 
  ORDER BY views DESC LIMIT $limit";
  return $db->show($sql);
}

function get_meta_details($json)
{
  $data = ($json != '') ? json_decode($json) : obj(array());
  $keyowrds = null;
  $description = null;
  if (isset($data->meta)) {
    if (isset($data->meta->tags)) {
      $keyowrds = $data->meta->tags;
    }
    if (isset($data->meta->description)) {
      $description = $data->meta->description;
    }
  }
  return array('description' => $description, 'keywords' => $keyowrds);
}

function detectSpam($comment)
{
  $jsonData = file_get_contents(RPATH . '/data/json/spam/spam_keywords.json');
  $spamKeywords = json_decode($jsonData, true);
  // Access the keywords array
  $keywords = $spamKeywords['keywords'];
  // Convert comment to lowercase for case-insensitive comparison
  $comment = strtolower($comment);
  // Check if any keyword exists in the comment
  foreach ($keywords as $keyword) {
    if (strpos($comment, $keyword) !== false) {
      return true; // Comment contains a spam, offensive, or 18+ keyword
    }
  }
  return false; // Comment is clean
}

function msg_set($msg, $var = 'msg')
{
  $_SESSION[$var][] = $msg;
}

#################################################################

function check_request($myid, $req_to)
{
  if (intval($myid)) {
    $db = new Dbobjects;
    $db->tableName = 'requests';
    $arr['request_by'] = $myid;
    $arr['request_to'] = $req_to;
    $request_by_me = count($db->filter(['request_by' => $myid, 'request_to' => $req_to, 'is_accepted' => 0]));
    $i_was_requested = count($db->filter(['request_to' => $myid, 'request_by' => $req_to, 'is_accepted' => 0]));
    $im_frnd = count($db->filter(['request_to' => $myid, 'request_by' => $req_to, 'is_accepted' => 1]));
    $my_frnd = count($db->filter(['request_by' => $myid, 'request_to' => $req_to, 'is_accepted' => 1]));
    if ($request_by_me > 0) {
      return array(
        'msg' => 'Request sent',
        'is_accepted' => false,
        'success' => true
      );
    }
    if ($i_was_requested > 0) {
      return array(
        'msg' => 'Request received',
        'is_accepted' => false,
        'success' => true
      );
    }
    if ($my_frnd > 0) {
      return array(
        'msg' => 'friend',
        'is_accepted' => true,
        'success' => true
      );
    }
    if ($im_frnd > 0) {
      return array(
        'msg' => 'friend',
        'is_accepted' => true,
        'success' => true
      );
    } else {
      return array(
        'msg' => 'Request not sent',
        'is_accepted' => false,
        'success' => false
      );
    }
  } else {
    return array(
      'msg' => 'Login to send request',
      'is_accepted' => false,
      'success' => false
    );
  }
}
function is_liked($myid, $obj_id, $obj_group = 'profile')
{
  if (intval($myid)) {
    $db = new Dbobjects;
    $db->tableName = 'likes';
    $arr['like_by'] = $myid;
    $arr['obj_id'] = $obj_id;
    $like_by_me = count($db->filter(['like_by' => USER['id'], 'obj_id' => $obj_id, 'obj_group' => $obj_group]));
    if ($like_by_me > 0) {
      return true;
    } else {
      return false;
    }
  } else {
    return false;
  }
}
function jsonData($file = "")
{
  $fl = RPATH . "/data/json" . $file;
  if ($file != '' && file_exists($fl)) {
    return file_get_contents($fl);
  }
}
function img_or_null($img = null)
{
  if ($img == "") {
    return null;
  }
  if (file_exists(MEDIA_ROOT . "images/pages/" . $img)) {
    return "/media/images/pages/" . $img;
  }
}
function dp_or_null($img = null)
{
  if ($img == "") {
    return null;
  }
  if (file_exists(MEDIA_ROOT . "images/profiles/" . $img)) {
    return "/media/images/profiles/" . $img;
  }
}
function getDOBFromAge($age)
{
  // Get the current date
  $currentDate = new DateTime();

  // Calculate the year of birth
  $birthYear = $currentDate->format('Y') - $age;

  // Assume the birth date is January 1st for simplicity
  $dob = $birthYear . '-01-01';

  return $dob;
}
function getAgeFromDOB($birthdate)
{
  $today = new DateTime();
  $birthdate = new DateTime($birthdate);
  $age = $today->diff($birthdate)->y;
  return $age;
}

function gender_view($gender)
{
  switch (strtolower($gender)) {
    case 'm':
      return 'Male';
      break;
    case 'f':
      return 'Female';
      break;
    default:
      return 'NA';
      break;
  }
}
function bride_or_grom($gender)
{
  switch (strtolower($gender)) {
    case 'm':
      return 'Groom';
      break;
    case 'f':
      return 'Bride';
      break;
    default:
      return 'NA';
      break;
  }
}
function profile_completed($id)
{
  $db = new Dbobjects;
  $db->tableName = 'pk_user';
  $user = $db->pk($id);

  $userarr['first_name'] = $user['first_name'];
  $userarr['last_name'] = $user['last_name'];
  $userarr['occupation'] = $user['occupation'];
  $userarr['mobile'] = $user['mobile'];
  $userarr['gender'] = $user['gender'];
  $userarr['address'] = $user['address'];
  $userarr['dob'] = $user['dob'];
  $userarr['caste'] = $user['caste'];
  $userarr['caste_detail'] = $user['caste_detail'];
  $userarr['city'] = $user['city'];
  $userarr['state'] = $user['state'];
  $userarr['country'] = $user['country'];
  $userarr['bio'] = $user['bio'];
  $userarr['mool'] = $user['mool'];
  $userarr['father'] = $user['father'];
  $userarr['mother'] = $user['mother'];
  $userarr['about_mother'] = $user['about_mother'];
  $userarr['about_father'] = $user['about_father'];
  $userarr['grand_father'] = $user['grand_father'];
  $userarr['about_grand_father'] = $user['about_grand_father'];
  $userarr['jsn'] = $user['jsn'];

  $full = count($userarr);
  $completed = 0;
  foreach ($userarr as $li) {
    if ($li != '') {
      $completed += 1;
    }
  }

  if (!in_array($userarr['gender'], ['m', 'f'])) {
    return 0;
  }
  if (getAgeFromDOB($userarr['dob']) < 18) {
    return 0;
  }
  return round(($completed / $full) * 100);
}
function email_has_valid_dns($email = 'email@example.com'): bool
{
  return (new Email_validator_lcl)->validate($email);
}
// function encrypt($message, $key) {
//   $iv = random_bytes(16);
//   $cipher_text = openssl_encrypt($message, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
//   $encrypted_message = $iv . $cipher_text;
//   return urlencode(base64_encode($encrypted_message));
// }

// function decrypt($encrypted_message, $key) {
//   $encrypted_message = base64_decode(urldecode($encrypted_message));
//   $iv = substr($encrypted_message, 0, 16);
//   $cipher_text = substr($encrypted_message, 16);
//   $decrypted_message = openssl_decrypt($cipher_text, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
//   return $decrypted_message;
// }

function base64_url_encode($data)
{
  return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($data));
}

function base64_url_decode($data)
{
  return base64_decode(str_replace(['-', '_'], ['+', '/'], $data));
}

function encrypt($message, $key)
{
  $iv = random_bytes(16);
  $cipher_text = openssl_encrypt($message, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
  $encrypted_message = $iv . $cipher_text;
  return base64_url_encode($encrypted_message);
}

function decrypt($encrypted_message, $key)
{
  $encrypted_message = base64_url_decode($encrypted_message);
  $iv = substr($encrypted_message, 0, 16);
  $cipher_text = substr($encrypted_message, 16);
  $decrypted_message = openssl_decrypt($cipher_text, 'aes-256-cbc', $key, OPENSSL_RAW_DATA, $iv);
  return $decrypted_message;
}

function render_template($path, $data)
{
  ob_start();
  import(var: "/templates/" . $path, context: $data, many: true);
  $data = ob_get_clean();
  return $data;
}

function maskEmailBy50Percent($email)
{
  // Check if the input is a valid email address
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    // Split the email address into username and domain
    list($username, $domain) = explode('@', $email);

    // Calculate the number of characters to mask in each part
    $usernameToMask = max(0, ceil((strlen($username) - 1) / 2));
    $domainToMask = max(0, ceil((strlen($domain) - 1) / 2));

    // Mask the username and domain
    $maskedUsername = $username[0] . substr_replace(substr($username, 1), str_repeat('*', $usernameToMask), 0, $usernameToMask);
    $maskedDomain = $domain[0] . substr_replace(substr($domain, 1), str_repeat('*', $domainToMask), 0, $domainToMask);

    // Reconstruct the masked email address
    $maskedEmail = $maskedUsername . '@' . $maskedDomain;

    return $maskedEmail;
  } else {
    // Return an error message for invalid email addresses
    return false;
  }
}
function isNotSpamEmail($email)
{
  // List of commonly used email domains
  $allowedDomains = [
    'gmail.com',
    'yahoo.com',
    'yahoo.co.uk',
    'outlook.com',
    'hotmail.com',
    'live.com',
    'live.in',
    'msn.com',
    'aol.com',
    'icloud.com',
    'protonmail.com',
    'mail.com',
    'yandex.com',
    'yahoo.in',      // Add '.in' domain
    'yahoo.co.in',   // Add '.co.in' domain
    'ymail.com'
    // Add more reputable domains as needed
  ];

  // Extract the domain part of the email address
  $parts = explode('@', $email);
  $domain = end($parts);

  // Check if the extracted domain is in the list of allowed domains
  return in_array($domain, $allowedDomains);
}
function compressImage($sourceFile, $maxFileSize)
{
  list($width, $height, $imageType) = getimagesize($sourceFile);
  switch ($imageType) {
    case IMAGETYPE_JPEG:
      $image = imagecreatefromjpeg($sourceFile);
      break;
    case IMAGETYPE_PNG:
      $image = imagecreatefrompng($sourceFile);
      break;
    case IMAGETYPE_GIF:
      $image = imagecreatefromgif($sourceFile);
      break;
    default:
      return false; // Unsupported image type
  }

  $compressionQuality = 90; // Adjust this value as needed

  $targetFile = tempnam(sys_get_temp_dir(), 'compressed_image');

  // Save the compressed image to a temporary file
  switch ($imageType) {
    case IMAGETYPE_JPEG:
      imagejpeg($image, $targetFile, $compressionQuality);
      break;
    case IMAGETYPE_PNG:
      imagepng($image, $targetFile);
      break;
    case IMAGETYPE_GIF:
      imagegif($image, $targetFile);
      break;
  }

  if (filesize($targetFile) > $maxFileSize) {
    return false; // Compression failed to reduce the size
  }

  imagedestroy($image);

  return $targetFile;
}
