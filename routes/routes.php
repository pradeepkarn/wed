<?php
// $lang = DEFAULT_LANG;
// if (isset($_COOKIE['lang'])) {
//     $lang = $_COOKIE['lang'];
// }
$home = home;
// Define the routes
$login_routes = [
    "/set-language/{lang}" => "Lang_ctrl@set_lang@name.setLang",
    "/login" => 'Auth@user_login_page@name.userLogin',
    "/logout" => 'Auth@logout@name.logout',
    "/user-login-ajax" => 'Auth@user_login@name.userLoginAjax',
    "/admin-login" => 'Auth@admin_login_page@name.adminLogin',
    "/admin-login-ajax" => 'Auth@admin_login@name.adminLoginAjax',
    "/register" => 'Auth@registration_page@name.register',
    "/user-registration-ajax" => 'Auth@register@name.registerAjax',
    "/reset-password" => 'Auth@reset_password_page@name.resetPassword',
    "/reset-password-ajax" => 'Auth@reset_password_ajax@name.resetPasswordAjax',
    "/cnp/{prt}" => 'Auth@create_new_password_page@name.createNewPassword',
    "/send-temp-pass-on-ajax" => 'Auth@send_me_temp_password_ajax@name.sendMeTempPassAjax',
    "/send-otp-on-ajax" => 'Auth@send_otp@name.sendOtpAjax',
];
$public_routes = [
    // "" => "Home_ctrl@redirect_to_lang@name.homeNolang",
    // "/" => "Home_ctrl@redirect_to_lang@name.homeSlashNoLang",
    "" => "Home_ctrl@index@name.home",
    "/" => "Home_ctrl@index@name.homeSlash",
    // "/about" => "About_ctrl@index@name.about",
    "/contact" => "ContactController@index@name.contact",
    "/category/{slug}" => "CategoryController@index@name.category",
    "/category/{slug}/load-page-on-scroll" => "CategoryController@load_cat_on_scroll@name.catOnScroll",
    "/read" => "Blogs_ctrl@index@name.allPosts",
    "/read/{slug}" => "ReadPostController@index@name.readPost",
    "/read/{slug}/post-comment-ajax" => "PostComment_ctrl@comment@name.postCommentAjax",
    // "/privacy-policy" => "PrivacyPolicy_ctrl@index@name.privacyPolicy",
    "/dashboard/profile/{profile_id}" => 'Profile_ctrl@show_public_profile@name.showPublicProfile',
];
$user_routes = [
    // '/dashboard' => 'DashboardController@index@name.dashboard',
    "/search" => "Search_users_ctrl@index@name.search",
    // "/dashboard/profile" => 'Profile_ctrl@index@name.userProfile', // currently disabled for testing and full confirmation of no bug
    "/dashboard/news-feeds" => 'News_feeds_ctrl@index@name.newsFeeds',
    "/dashboard/profile-gallery" => 'Profile_ctrl@gallery@name.userProfileGallery',
    "/dashboard/profile-gallery-upload-ajax" => 'Profile_ctrl@gallery_upload_ajax@name.uploadGalleryFile',
    "/dashboard/profile-edit" => 'Profile_ctrl@edit@name.userProfileEdit',
    "/dashboard/upload-user-cover-image-ajax" => 'Profile_ctrl@upload_cover_image_ajax@name.uploadUserCoverImageAjax',
    "/dashboard/upload-user-profile-image-ajax" => 'Profile_ctrl@upload_profile_image_ajax@name.uploadUserProfileImageAjax',
    "/dashboard/upload-user-profile-ajax" => 'Profile_ctrl@update_my_profile_ajax@name.updateMyProfileAjax',
    "/dashboard/send-request-ajax" => 'Profile_ctrl@send_request_ajax@name.sendRequestAjax',
    "/dashboard/like-unlike-ajax" => 'Profile_ctrl@like_unlike_ajax@name.likeUnlikeProfileAjax',
    "/dashboard/remove-album-image" => 'Profile_ctrl@remove_album_img@name.removeAlbumImgAjax',
    "/dashboard/setting-album-image" => 'Profile_ctrl@set_img_as@name.setAsAlbumImgAjax',

];
$api_routes = [
    "/api/v1/user-list" => 'Users_api@load_users@name.loadUsersApi',
];
$chat_routes = [
    "/chat/populate-messages" => 'Profile_ctrl@message_history@name.messageHistoryAjax',
];
$admin_routes = [
    '/admin' => 'Admin_ctrl@index@name.adminhome',
    // posts
    '/admin/post/create' => 'Post_ctrl@create@name.postCreate',
    '/admin/post/create/save-by-ajax' => 'Post_ctrl@save@name.postStoreAjax',
    '/admin/post/list' => 'Post_ctrl@list@name.postList',
    '/admin/post/trash-list' => 'Post_ctrl@trash_list@name.postTrashList',
    '/admin/post/edit/{id}' => 'Post_ctrl@edit@name.postEdit',
    '/admin/post/trash/{id}' => 'Post_ctrl@move_to_trash@name.postTrash',
    '/admin/post/restore/{id}' => 'Post_ctrl@restore@name.postRestore',
    '/admin/post/delete/{id}' => 'Post_ctrl@delete_trash@name.postDelete',
    '/admin/post/edit/{id}/save-by-ajax' => 'Post_ctrl@update@name.postUpdateAjax',
    '/admin/post/toggle-marked-post' => 'Post_ctrl@toggle_trending@name.postToggleMarked',
    // pages
    '/admin/page/create' => 'Page_ctrl@create@name.pageCreate',
    '/admin/page/create/save-by-ajax' => 'Page_ctrl@save@name.pageStoreAjax',
    '/admin/page/list' => 'Page_ctrl@list@name.pageList',
    '/admin/page/trash-list' => 'Page_ctrl@trash_list@name.pageTrashList',
    '/admin/page/edit/{id}' => 'Page_ctrl@edit@name.pageEdit',
    '/admin/page/trash/{id}' => 'Page_ctrl@move_to_trash@name.pageTrash',
    '/admin/page/restore/{id}' => 'Page_ctrl@restore@name.pageRestore',
    '/admin/page/delete/{id}' => 'Page_ctrl@delete_trash@name.pageDelete',
    '/admin/page/edit/{id}/save-by-ajax' => 'Page_ctrl@update@name.pageUpdateAjax',
    '/admin/page/toggle-marked-page' => 'Page_ctrl@toggle_trending@name.pageToggleMarked',
    // Sliders
    '/admin/slider/create' => 'Slider_ctrl@create@name.sliderCreate',
    '/admin/slider/create/save-by-ajax' => 'Slider_ctrl@save@name.sliderStoreAjax',
    '/admin/slider/list' => 'Slider_ctrl@list@name.sliderList',
    '/admin/slider/trash-list' => 'Slider_ctrl@trash_list@name.sliderTrashList',
    '/admin/slider/edit/{id}' => 'Slider_ctrl@edit@name.sliderEdit',
    '/admin/slider/trash/{id}' => 'Slider_ctrl@move_to_trash@name.sliderTrash',
    '/admin/slider/restore/{id}' => 'Slider_ctrl@restore@name.sliderRestore',
    '/admin/slider/delete/{id}' => 'Slider_ctrl@delete_trash@name.sliderDelete',
    '/admin/slider/edit/{id}/save-by-ajax' => 'Slider_ctrl@update@name.sliderUpdateAjax',
    '/admin/slider/toggle-marked-page' => 'Slider_ctrl@toggle_trending@name.sliderToggleMarked',
    // post category 
    '/admin/post-category/create' => 'Post_category_ctrl@create@name.postCatCreate',
    '/admin/post-category/create/save-by-ajax' => 'Post_category_ctrl@save@name.postCatStoreAjax',
    '/admin/post-category/list' => 'Post_category_ctrl@list@name.postCatList',
    '/admin/post-category/trash-list' => 'Post_category_ctrl@trash_list@name.postCatTrashList',
    '/admin/post-category/edit/{id}' => 'Post_category_ctrl@edit@name.postCatEdit',
    '/admin/post-category/trash/{id}' => 'Post_category_ctrl@move_to_trash@name.postCatTrash',
    '/admin/post-category/restore/{id}' => 'Post_category_ctrl@restore@name.postCatRestore',
    '/admin/post-category/delete/{id}' => 'Post_category_ctrl@delete_trash@name.postCatDelete',
    '/admin/post-category/edit/{id}/save-by-ajax' => 'Post_category_ctrl@update@name.postCatUpdateAjax',
    // Product category 
    '/admin/product-category/create' => 'Product_category_admin_ctrl@create@name.productCatCreate',
    '/admin/product-category/create/save-by-ajax' => 'Product_category_admin_ctrl@save@name.productCatStoreAjax',
    '/admin/product-category/list' => 'Product_category_admin_ctrl@list@name.productCatList',
    '/admin/product-category/trash-list' => 'Product_category_admin_ctrl@trash_list@name.productCatTrashList',
    '/admin/product-category/edit/{id}' => 'Product_category_admin_ctrl@edit@name.productCatEdit',
    '/admin/product-category/trash/{id}' => 'Product_category_admin_ctrl@move_to_trash@name.productCatTrash',
    '/admin/product-category/restore/{id}' => 'Product_category_admin_ctrl@restore@name.productCatRestore',
    '/admin/product-category/delete/{id}' => 'Product_category_admin_ctrl@delete_trash@name.productCatDelete',
    '/admin/product-category/edit/{id}/save-by-ajax' => 'Product_category_admin_ctrl@update@name.productCatUpdateAjax',
    // Users
    '/admin/user/{ug}/create' => 'Admin_user_ctrl@create@name.userCreate',
    '/admin/user/{ug}/create/save-by-ajax' => 'Admin_user_ctrl@save@name.userStoreAjax',
    '/admin/user/{ug}/list' => 'Admin_user_ctrl@list@name.userList',
    '/admin/user/{ug}/trash-list' => 'Admin_user_ctrl@trash_list@name.userTrashList',
    '/admin/user/{ug}/edit/{id}' => 'Admin_user_ctrl@edit@name.userEdit',
    '/admin/user/{ug}/trash/{id}' => 'Admin_user_ctrl@move_to_trash@name.userTrash',
    '/admin/user/{ug}/restore/{id}' => 'Admin_user_ctrl@restore@name.userRestore',
    '/admin/user/{ug}/delete/{id}' => 'Admin_user_ctrl@delete_trash@name.userDelete',
    '/admin/user/{ug}/edit/{id}/save-by-ajax' => 'Admin_user_ctrl@update@name.userUpdateAjax',
    // Comments
    '/admin/comments/{cg}/list' => 'Comment_admin_ctrl@list@name.commentList',
    '/admin/comments/{cg}/trash-list' => 'Comment_admin_ctrl@trash_list@name.commentTrashList',
    '/admin/comments/{cg}/trash/{id}' => 'Comment_admin_ctrl@move_to_trash@name.commentTrash',
    '/admin/comments/{cg}/restore/{id}' => 'Comment_admin_ctrl@restore@name.commentRestore',
    '/admin/comments/{cg}/delete/{id}' => 'Comment_admin_ctrl@delete_trash@name.commentDelete',
    '/admin/comments/{cg}/edit/{id}' => 'Comment_admin_ctrl@edit@name.commentEdit',
    '/admin/comments/{cg}/edit/{id}/save-by-ajax' => 'Comment_admin_ctrl@update@name.commentUpdateAjax',
    '/admin/comments/{cg}/toggle-marked-comment' => 'Comment_admin_ctrl@toggle_approve@name.commentToggleMarked',
    '/admin/comments/{cg}/toggle-spam-comment' => 'Comment_admin_ctrl@toggle_spam@name.commentToggleSpam',

];
$ajax = [
    '/send-contact-message-ajax' => 'Contact_front@send_message@name.sendContactMessageAjax'
];
$pages = [
    "/{slug}" => 'Page_front@index@name.pageBySlug'
];
$routes = array_merge(
    $login_routes,
    $public_routes,
    $user_routes,
    $admin_routes,
    $chat_routes,
    $api_routes,
    $ajax,
    $pages
);
// define('ROUTES',$routes);

// Define middleware for user authentication
function userAuthMiddleware($next)
{
    if (!authenticate()) {
        // Redirect to login page if user is not logged in
        header("Location: /" . home . route('userLogin'));
        exit;
    }
    // Call the next middleware or route handler
    return $next;
}
function userProfileCompleteMiddleware($next)
{
    if (authenticate()) {
        $completed = profile_completed(USER['id']);
        if ($completed < 80) {
            header("Location: /" . home . route('userProfileEdit'));
            exit;
        }
    }
    // Call the next middleware or route handler
    return $next;
}

// Define middleware for admin authentication
function adminAuthMiddleware($next)
{
    if (!authenticate()) {
        // Redirect to login page if admin is not logged in
        header("Location: /" . home . route('adminLogin'));
        exit;
    }
    if (!is_superuser()) {
        // Redirect to login page if admin is not logged in
        header("Location: /" . home . route('adminLogin'));
        exit;
    }
    // Call the next middleware or route handler
    return $next;
}

// $routes = ROUTES;
// Get the current request URI an
$query_string = $_SERVER["QUERY_STRING"];
$request_uri = REQUEST_URI;
$request_method = $_SERVER['REQUEST_METHOD'];
// Iterate through the routes to find a match
$routeObjs = new stdClass;

foreach ($routes as $route => $handler) {
    $contCtrl = count(explode('@', $handler));
    if ($contCtrl > 2) {
        list($controller, $method, $name) = explode('@', $handler);
        list($namekey, $rtname) = explode('.', $name);
        $routeObjs->$rtname = $route;
    }
}
define('ROUTES', $routeObjs);
function route($name, $params = [])
{
    $rt = ROUTES;
    $url = $rt->$name;
    if (count($params) > 0) {
        foreach ($params as $k => $v) {
            $url = str_replace("{{$k}}", $v, $url);
        }
    }
    return $url;
}
foreach ($routes as $route => $handler) {
    // Replace named parameters with regex patterns
    // $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>\w+)', $route);
    $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[\w-]+)', $route);
    //    myprint($pattern);
    // Match the request URI against the pattern
    $req_uri = explode("?", $request_uri);
    if (isset($req_uri[0])) {
        $request_uri = $req_uri[0];
    }
    if (preg_match("#^$pattern$#", $request_uri, $matches)) {
        // Split the handler into controller and method

        list($controller, $method) = explode('@', $handler);

        // Instantiate the controller
        $controller = new $controller();

        // Apply middleware for user authentication to the routes in the $user_routes array
        if (in_array($route, array_keys($user_routes))) {
            $controller = userAuthMiddleware($controller);
        }
        // Apply middleware for chat message authentication to the routes in the $user_routes array
        if (in_array($route, array_keys($chat_routes))) {
            $controller = userAuthMiddleware($controller);
        }

        // Apply middleware for admin authentication to the routes in the $admin_routes array
        if (in_array($route, array_keys($admin_routes))) {
            $controller = adminAuthMiddleware($controller);
        }
        // Apply middleware for profile complete in public routes
        if (in_array($route, array_keys($public_routes))) {
            $controller = userProfileCompleteMiddleware($controller);
        }

        // Call the method with any named parameters and GET parameters
        $params = array_intersect_key($matches, array_flip(array_filter(array_keys($matches), 'is_string')));
        $params += $_GET;

        // call_user_func_array([$controller, $method], $params);
        $controller->$method($params);

        // Stop processing further routes

        exit;
    }
}

// If no route matched, return a 404 error
http_response_code(404);
echo '404 Not Found';
