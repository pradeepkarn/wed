<?php
class Blogs_ctrl
{
    public function index($req = null)
    {
        $req = obj($req);
        
        $current_page = 0;
        $data_limit = FRONT_ROW_LIMIT;
        $page_limit = "0,$data_limit";
        $cp = 0;
        if (isset($req->page) && intval($req->page)) {
            $cp = $req->page;
            $current_page = (abs($req->page) - 1) * $data_limit;
            $page_limit = "$current_page,$data_limit";
        }
        $total_post = $this->post_list(ord: "DESC", limit: 10000, active: 1);
        $tp = count($total_post);
        if ($tp %  $data_limit == 0) {
            $tp = $tp / $data_limit;
        } else {
            $tp = floor($tp / $data_limit) + 1;
        }
        
        $readPost = new ReadPostController;
        $latest_posts = $readPost->posts_ordbycol($ordbycol = 'created_at', $limit = 5);
        $popular_posts = $readPost->posts_ordbycol($ordbycol = 'views', $limit = 5);
        $trending_posts = $readPost->filtered_posts($ordbycol = 'is_trending', $limit = 5);
        $post_categories = $readPost->post_categories($limit = 10);
        $q = null;
        if (isset($req->q)) {
            $q = $req->q;
        }
        $posts = $this->post_list($keywords = $q, $ord = "DESC", $limit = $page_limit, $active = 1);
        $GLOBALS['meta_seo'] = (object) array('title' => 'Blogs', 'description' => 'Read articles', 'keywords' => 'article, blog, posts');
        $context = (object) array(
            'page' => 'blogs.php',
            'data' => (object) array(
                'req' => obj($req),
                'total_post' => $tp,
                'current_page' => $cp,
                'posts_by_cat' => $posts,
                'latest_posts' => $latest_posts,
                'popular_posts' => $popular_posts,
                'trending_posts' => $trending_posts,
                'post_categories' => $post_categories
            )
        );
        $this->render_main($context);
    }
    public function post_list($keywords = null, $ord = "DESC", $limit = 1, $active = 1)
    {
        $cntobj = new Model('content');
        $posts = $cntobj->filter_index(array('content_group' => 'post', 'is_active' => $active), $ord, $limit, 'updated_at');
        if ($keywords != "") {
            $posts = $cntobj->search(
                assoc_arr: array(
                    'title' => $keywords,
                    'content' => $keywords,
                    'slug' => $keywords
                ),
                whr_arr: array('content_group' => 'post', 'is_active' => $active),
                ord: $ord,
                limit: $limit,
                change_order_by_col: 'updated_at'
            );
        }
        $post_list = [];
        foreach ($posts as $post) {
            $post = obj($post);
            $cat = getData('content', $post->parent_id);
            $author = getData('pk_user', $post->created_by);
            $post_list[] = [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'banner' => $post->banner,
                'slug' => $post->slug,
                'updated_at' => $post->updated_at,
                'created_at' => $post->created_at,
                'category_id' => $post->parent_id,
                'category_name' => $cat ? $cat['title'] : 'Uncategoried',
                'views' => $post->views,
                'author' => $author ? $author['first_name'] : 'Author',
                'author_image' => $author ? $author['image'] : 'user.png'
            ];
        }
        return $post_list;
    }
    public function render_main($context = null)
    {
        import("apps/view/layouts/main.php", $context);
    }
}
