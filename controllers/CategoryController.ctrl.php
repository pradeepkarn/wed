<?php
class CategoryController
{
    public function index($req = null)
    {
        $req = obj($req);
        $readPost = new ReadPostController;
        $latest_posts = $readPost->posts_ordbycol($ordbycol = 'created_at', $limit = 5);
        $popular_posts = $readPost->posts_ordbycol($ordbycol = 'views', $limit = 5);
        $trending_posts = $readPost->filtered_posts($ordbycol = 'is_trending', $limit = 5);
        $post_categories = $readPost->post_categories($limit = 10);

        $posts_by_cat = $this->posts_by_cat($req->slug, $limit = 10);
        $post_cat = $this->cat_by_slug($req->slug);
        $post_cat = obj($post_cat);
        $meta = obj(get_meta_details($json = $post_cat->json_obj));
        $GLOBALS['meta_seo'] = (object) array('title' => $post_cat->title, 'description' => $meta->description, 'keywords' => $meta->keywords);
        $context = (object) array(
            'page' => 'category.php',
            'data' => (object) array(
                'req' => obj($req),
                'category' => $post_cat,
                'posts_by_cat' => $posts_by_cat,
                'latest_posts' => $latest_posts,
                'popular_posts' => $popular_posts,
                'trending_posts' => $trending_posts,
                'post_categories' => $post_categories,
                'slug' => $req->slug
            )
        );
        $this->render_main($context);
    }
    public function load_cat_on_scroll($req = null)
    {
        $req = obj($req);
        $Obj = new Model('content');
        $post_cat = $this->cat_by_slug($req->slug);
        if ($post_cat == false) {
            return [];
        }
        $limit = "{$req->page},{$req->limit}";
        $post_cat = obj($post_cat);
        $posts = $Obj->filter_index(assoc_arr: ['is_active' => 1, 'content_group' => 'post', 'parent_id' => $post_cat->id], ord: 'desc', change_order_by_col: 'id', limit: $limit);
        $post_list = [];
        foreach ($posts as $post) {
            $post = obj($post);
            $cat = getData('content', $post->parent_id);
            $author = getData('pk_user', $post->created_by);
            $post_list[] = [
                'id' => $post->id,
                'title' => $post->title,
                'content' => pk_excerpt($post->content, 200),
                'banner' => "/" . home . "/media/images/pages/$post->banner",
                'slug' => $post->slug,
                'link' => "/" . home . route('readPost', ['slug' => $post->slug]),
                'updated_at' => $post->updated_at,
                'created_at' => $post->created_at,
                'category_id' => $post->parent_id,
                'category_name' => $cat ? $cat['title'] : 'Uncategoried',
                'views' => $post->views,
                'author' => $author ? $author['first_name'] : 'Author',
                'author_image' => $author ? "/" . home . "/media/images/profiles/{$author['image']}" : '/media/images/profiles/user.png'
            ];
        }
        echo json_encode($post_list);
        exit;
    }
    public function posts_by_cat($catslug, $limit = 10)
    {
        $Obj = new Model('content');
        $post_cat = $this->cat_by_slug($catslug);
        if ($post_cat == false) {
            return [];
        }
        $post_cat = obj($post_cat);
        $posts = $Obj->filter_index(assoc_arr: ['is_active' => 1, 'content_group' => 'post', 'parent_id' => $post_cat->id], ord: 'desc', change_order_by_col: 'views', limit: $limit);
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
    public function cat_by_slug($catslug)
    {
        $Obj = new Model('content');
        $post_cat = $Obj->filter_index(assoc_arr: ['is_active' => 1, 'slug' => $catslug, 'content_group' => 'post_category'], limit: 1);
        if (count($post_cat) > 0) {
            return $post_cat[0];
        } else {
            return false;
        }
    }
    public function render_main($context = null)
    {
        import("apps/view/layouts/main.php", $context);
    }
}
