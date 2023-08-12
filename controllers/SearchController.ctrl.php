<?php
class SearchController
{
    public function index($req = null)
    {
        $req = obj($req);
        $readPost = new ReadPostController;
        $latest_posts = $readPost->posts_ordbycol($ordbycol = 'created_at', $limit = 5);
        $popular_posts = $readPost->posts_ordbycol($ordbycol = 'views', $limit = 5);
        $trending_posts = $readPost->filtered_posts($ordbycol = 'is_trending', $limit = 5);
        $post_categories = $readPost->post_categories($limit = 10);
        $GLOBALS['meta_seo'] = (object) array('title' => 'Search', 'description' => 'Search blogs', 'keywords' => 'blogs, news, articles');
        // $posts_by_cat = $this->posts_by_cat($req->slug, $limit = 10);
        // $post_cat = $this->cat_by_slug($req->slug);
        // $post_cat = obj($post_cat);
        $q = null;
        if (isset($req->q)) {
            $q = $req->q;
        }
        $posts = $this->post_list($keywords = $q, $ord = "DESC", $limit = 5, $active = 1);
        // myprint($posts);
        $context = (object) array(
            'page' => 'search.php',
            'data' => (object) array(
                'req' => obj($req),
                // 'category' => $post_cat,
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
