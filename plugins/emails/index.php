<?php
$url = explode("/", $_SERVER["QUERY_STRING"]);
$path = $_SERVER["QUERY_STRING"];
$GLOBALS['url_last_param'] = end($url);
$GLOBALS['url_2nd_last_param'] = prev($url);
$plugin_dir = "emails";
import("apps/plugins/{$plugin_dir}/functions.php");

if ("{$url[0]}/{$url[1]}" == "admin/$plugin_dir") {
    switch ($path) {
        case "admin/emails":
            import("apps/plugins/{$plugin_dir}/email-list.php");
            break;

        default:
            if (count($url) >= 3) {
                if ("{$url[1]}/{$url['2']}" == "{$plugin_dir}/import-emails") {

                    import("apps/plugins/{$plugin_dir}/import-emails.php");
                    return;
                }
                if ("{$url[1]}/{$url['2']}" == "{$plugin_dir}/csv-upload-ajax") {
                    // myprint($_FILES);
                    if (isset($_FILES) && $_FILES['csv_file']['error'] == 0) {
                        $file = $_FILES['csv_file']['tmp_name'];
                        $data =  csv_heading($file);
                        if (verifyArrayKeys($data, array('name', 'email', 'mobile', 'city', 'country', 'attempt', 'status'))) {
                            import_csv($file);
                        } else {
                            echo "Missing required field(s) or wrong file";
                            return;
                        }
                    }
                    return;
                }
            }

            import("apps/view/404.php");
            break;
    }
}
