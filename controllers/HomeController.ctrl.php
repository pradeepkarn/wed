<?php
class HomeController
{
    public function redirect_to_lang($req = null)
    {
        header("Location:/".home.route('home'));
        return;
    }
    public function index($req = null)
    {
        // $cat_list = $this->cat_list($ord = "DESC", $limit = 6, $active = 1);
        $user_list = $this->user_list($ord = "DESC", $limit = 6, $active = 1);
        
        $GLOBALS['meta_seo'] = (object) array('title' => 'Home', 'description' => 'Welcome to our blog', 'keywords' => 'blog, article, education, news');
        $context = (object) array(
            'page' => 'home.php',
            'data' => (object) array(
                'req' => obj($req),
                'user_list' => $user_list,
                // 'trending_post_list' => $this->marked_post_list($marked = 'is_trending', $ord = "DESC", $limit = 100, $active = 1),
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

    // category list
    // public function cat_list($ord = "DESC", $limit = 6, $active = 1)
    // {
    //     $cntobj = new Model('content');
    //     return $cntobj->filter_index(array('content_group' => 'post_category', 'is_active' => $active), $ord, $limit);
    // }
    // Post list
    // public function post_list($ord = "DESC", $limit = 1, $active = 1)
    // {
    //     $cntobj = new Model('content');
    //     return $cntobj->filter_index(array('content_group' => 'post', 'is_active' => $active), $ord, $limit);
    // }
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
    function about_content()  {
        $db = new Model('content');
        $abt = $db->filter_index(['slug'=>'about','content_group'=>'page','is_active'=>1]);
        if (count($abt)>0) {
            return $abt[0];
        }
        return null;
    }
    // public function recent_post_list($ord = "DESC", $limit = 1, $active = 1)
    // {
    //     $cntobj = new Model('content');
    //     $posts = $cntobj->filter_index(array('content_group' => 'post', 'is_active' => $active), $ord, $limit, 'updated_at');
    //     $post_list = [];
    //     foreach ($posts as $post) {
    //         $post = obj($post);
    //         $cat = getData('content', $post->parent_id);
    //         $author = getData('pk_user', $post->created_by);
    //         $post_list[] = [
    //             'id' => $post->id,
    //             'title' => $post->title,
    //             'content' => $post->content,
    //             'banner' => $post->banner,
    //             'slug' => $post->slug,
    //             'updated_at' => $post->updated_at,
    //             'created_at' => $post->created_at,
    //             'category_id' => $post->parent_id,
    //             'category_name' => $cat ? $cat['title'] : 'Uncategoried',
    //             'views' => $post->views,
    //             'author' => $author ? $author['first_name'] : 'Author',
    //             'author_image' => $author ? $author['image'] : 'user.png'
    //         ];
    //     }
    //     return $post_list;
    // }
    // Post list by cat id
    // public function post_list_by_cat_id($cat_id = 0, $ord = "DESC", $limit = 100, $active = 1)
    // {
    //     $cntobj = new Model('content');
    //     return $cntobj->filter_index(array('content_group' => 'post', 'parent_id' => $cat_id, 'is_active' => $active), $ord, $limit);
    // }
    // public function marked_post_list($marked = 'is_featured', $ord = "DESC", $limit = 100, $active = 1)
    // {
    //     $cntobj = new Model('content');
    //     return $cntobj->filter_index(array('content_group' => 'post', 'is_active' => $active, $marked => 1), $ord, $limit);
    // }
    // public function posts_by_catid($catid, $limit = 10)
    // {
    //     $Obj = new Model('content');
    //     $post_cat = $Obj->show($catid);
    //     if ($post_cat == false) {
    //         return [];
    //     }
    //     $post_cat = obj($post_cat);
    //     $posts = $Obj->filter_index(assoc_arr: ['is_active' => 1, 'content_group' => 'post', 'parent_id' => $post_cat->id], ord: 'desc', change_order_by_col: 'views', limit: $limit);
    //     $post_list = [];
    //     foreach ($posts as $post) {
    //         $post = obj($post);
    //         $cat = getData('content', $post->parent_id);
    //         $author = getData('pk_user', $post->created_by);
    //         $post_list[] = [
    //             'id' => $post->id,
    //             'title' => $post->title,
    //             'content' => $post->content,
    //             'banner' => $post->banner,
    //             'slug' => $post->slug,
    //             'updated_at' => $post->updated_at,
    //             'created_at' => $post->created_at,
    //             'category_id' => $post->parent_id,
    //             'category_name' => $cat ? $cat['title'] : 'Uncategoried',
    //             'views' => $post->views,
    //             'author' => $author ? $author['first_name'] : 'Author',
    //             'author_image' => $author ? $author['image'] : 'user.png'
    //         ];
    //     }
    //     return $post_list;
    // }
}
