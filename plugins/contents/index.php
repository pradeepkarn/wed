<?php
$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['url_last_param'] = end($url);
$GLOBALS['url_2nd_last_param'] = prev($url);
$plugin_dir = "contents";
import("apps/plugins/{$plugin_dir}/function.php");

if ("{$url[0]}/{$url[1]}" == "admin/contents") {
switch ($path) {
    case "admin/contents":
        if (isset($_POST['add_new_content'])) {
            $pageid = addContent($type="content");
            if($pageid == false){
                echo js_alert("Duplicate slug, Change slug");
            }
        }
        import("apps/plugins/{$plugin_dir}/show_contents.php");
        break;
    // case "{$plugin_dir}/post":
    //     if (isset($_POST['add_new_content'])) {
    //         $pageid = addContent($type="post");
    //         if($pageid != false){
    //             echo js_alert("Success");
    //         }
    //     }
    //     import("apps/plugins/{$plugin_dir}/show_contents.php");
    //     break;
    // case "{$plugin_dir}/slider":
    //     if (isset($_POST['add_new_content'])) {
    //         $pageid = addContent($type="slider");
    //         if($pageid != false){
    //             echo js_alert("Success");
    //         }
    //     }
    //     import("apps/plugins/{$plugin_dir}/show_contents.php");
    //     break;
    // case "{$plugin_dir}/service":
    //     if (isset($_POST['add_new_content'])) {
    //         $pageid = addContent($type="service");
    //         if($pageid != false){
    //             echo js_alert("Success");
    //         }
    //     }
    //     import("apps/plugins/{$plugin_dir}/show_contents.php");
    //     break;
    case "admin/{$plugin_dir}/edit/{$GLOBALS['url_last_param']}":
        // if (isset($_FILES['banner']) && isset($_POST['update_banner'])) {
        //     $banner_name = time()."_".$_SESSION['user_id'];
        //     uploadBanner($banner_name);
        // }
        if (isset($_POST['update_banner'])) {
            $contentid = $_POST['update_banner_page_id'];
            $banner=$_FILES['banner'];
            $banner_name = time().uniqid("_banner_").USER['id'];
            change_my_banner($contentid=$contentid,$banner=$banner,$banner_name=$banner_name);
        }
        import("apps/plugins/{$plugin_dir}/edit_content.php");
        break;
    case "admin/{$plugin_dir}/edit/{$GLOBALS['url_2nd_last_param']}/update":
        if (isset($_POST['page_id']) && isset($_POST['update_page'])) {
            if(updatePage() === true){
                echo js_alert("Update");
                echo js("location.reload();");
            }
        }
        break;
    case "admin/{$plugin_dir}/delete/{$GLOBALS['url_last_param']}":
        if (is_superuser()==false) {
            header("Location:/".home."/admin/{$plugin_dir}");
          }
          else{
            if(delContent($id=$GLOBALS['url_last_param']) != false){
                echo js_alert("Deleted Successfully");
                header("Location:/".home."/admin/{$plugin_dir}");
            }
            else{
                echo js_alert("Invalid activity");
                header("Location:/".home."/admin/{$plugin_dir}");
            }
          }
        break;
    default:
    if (count($url)>=3) {
        if ("{$url[1]}/{$url['2']}"=="{$plugin_dir}/add-more-img") {
            if (isset($_FILES['add_more_img']) && $_FILES['add_more_img']['name']!="") {
                import("apps/controllers/ContentDetailsCtrl.php");
                $listObj = new ContentDetailsCtrl;
                if($listObj->add_more_img()==true){
                    echo js_alert('Uploaded');
                    echo js('location.reload();');
                    return;
                }
                else{
                    echo js_alert('Not updated');
                    return;
                }
                msg_ssn("msg");
                return;
            }
            break;
        }
        if ($url[2]=='add-new-item') {
            import("apps/plugins/{$plugin_dir}/add-new-item.php");
            return;
        }
        if ($url[2]=='add-new-item-ajax') {
            if ($_POST['page_title']=="") {
                echo js_alert('Empty name is not allowed');
                return;
            }
            print_r($_POST);
            $pageid = addContent($type="content");
            
            if (isset($_FILES['banner']) && $_FILES['banner']["error"]==0 && filter_var($pageid,FILTER_VALIDATE_INT)) {
                $contentid = $pageid;
                $banner=$_FILES['banner'];
                $banner_name = time().uniqid("_banner_").USER['id'];
                change_my_banner($contentid=$contentid,$banner=$banner,$banner_name=$banner_name);
            }
            if (filter_var($pageid,FILTER_VALIDATE_INT)) {
                echo js_alert('added');
                $home = home;
                echo js("location.href='/$home/admin/contents';");
            }
            return;
        }
        if ("{$url[1]}/{$url['2']}"=="{$plugin_dir}/add-more-detail") {
            if (isset($_POST['add_more_detail']) && isset($_POST['add_more_heading']) && isset($_POST['content_id']) && isset($_POST['content_group'])) {
                import("apps/controllers/ContentDetailsCtrl.php");
                $listObj = new ContentDetailsCtrl;
                if($listObj->add_more_detail()==true){
                    echo js_alert('Added');
                    echo js('location.reload();');
                    return;
                }
                else{
                    echo js_alert('Not updated');
                    return;
                }
                msg_ssn("msg");
                return;
            }
            break;
        }
        if ("{$url[1]}/{$url['2']}"=="{$plugin_dir}/delete-content-details") {
            if (isset($_POST['content_details_delete_id'])) {
                import("apps/controllers/ContentDetailsCtrl.php");
                $listObj = new ContentDetailsCtrl;
                if($listObj->destroy($_POST['content_details_delete_id'])==true){
                    echo js('location.reload();');
                }
                else{
                    echo js_alert('Not Deleted');
                }
                msg_ssn("msg");
                return;
            }
            break;
        }
    }
        // if ($url[1]=='delete') {
        //     if (is_superuser()===false) {
        //         header("Location:/".home);
        //       }
        //       else{
        //         if(delContent($id=$GLOBALS['url_last_param']) != false){
        //             // echo js_alert("Deleted Successfully");
        //             if ($GLOBALS['url_2nd_last_param']!='page') {
        //                 header("Location:/".home."/{$plugin_dir}/{$GLOBALS['url_2nd_last_param']}");
        //                 // echo js('location.href=/'.home.'/'.$GLOBALS['url_2nd_last_param']);
        //             }
        //             else{
        //                 header("Location:/".home."/{$plugin_dir}");
        //             }
                    
        //         }
        //         else{
        //             echo js_alert("Invalid activity");
        //             header("Location:/".home."/{$plugin_dir}");
        //         }
        //       }
        //     break;
        // }
          import("apps/view/404.php");
          break;
    }
}

