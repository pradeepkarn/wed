<?php
class ReadPostController
{
    public function index($req = null)
    {
        $req = obj($req);
        // echo $req->slug;
        $latest_posts = $this->posts_ordbycol($ordbycol = 'created_at', $limit = 5);
        $popular_posts = $this->posts_ordbycol($ordbycol = 'views', $limit = 5);
        $trending_posts = $this->filtered_posts($ordbycol = 'is_trending', $limit = 5);
        $post_categories = $this->post_categories($limit = 10);
        $post_detail = $this->active_post_by_slug($req->slug);
        $comments = $this->comments($post_detail ? $post_detail->id : 0, 0);
        $meta = obj(get_meta_details($json = $post_detail->json_obj));
        // myprint($meta);
        $GLOBALS['meta_seo'] = (object) array('title' => $post_detail->title, 'description' => $meta->description, 'keywords' => $meta->keywords);
        $context = (object) array(
            'page' => 'read-post.php',
            'data' => (object) array(
                'req' => obj($req),
                'post_detail' => $post_detail,
                'comments' => $comments,
                'latest_posts' => $latest_posts,
                'popular_posts' => $popular_posts,
                'trending_posts' => $trending_posts,
                'post_categories' => $post_categories
            )
        );
        $this->render_main($context);
        // Add more one view on every load
        count_views($post_detail->id);
    }
    public function render_main($context = null)
    {
        import("apps/view/layouts/main.php", $context);
    }
    public function active_post_by_slug($slug)
    {
        $postObj = new Model('content');
        $post = $postObj->filter_index(assoc_arr: ['is_active' => 1, 'slug' => $slug, 'content_group' => 'post'], limit: 1);
        if (count($post) > 0) {
            $post = obj($post[0]);
            $cat = getData('content', $post->parent_id);
            $author = getData('pk_user', $post->created_by);
            $post_detail = [
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
                'author_image' => $author ? $author['image'] : 'user.png',
                'json_obj' => $post->json_obj
            ];
            return obj($post_detail);
        } else {
            return false;
        }
    }

    public function comments($post_id, $replied_to)
    {
        $postObj = new Model('comments');
        $comments = $postObj->filter_index(assoc_arr: [
            'content_id' => $post_id,
            'replied_to' => $replied_to,
            'is_active' => 1,
            'is_approved' => 1,
            'comment_group' => "post"
        ], change_order_by_col: "created_at");
        $cmtarr = [];
        foreach ($comments as $cmt) {
            $cmt = obj($cmt);
            $cmtarr[] = array(
                "id" => $cmt->id,
                "name" => $cmt->name,
                "message" => $cmt->message,
                "replies" => $this->comments($post_id, $cmt->id)
            );
        }
        return $cmtarr;
    }
    public function posts_ordbycol($ordbycol = 'created_at', $limit = 10)
    {
        $postObj = new Model('content');
        $posts = $postObj->filter_index(assoc_arr: ['is_active' => 1, 'content_group' => 'post'], ord: 'desc', change_order_by_col: $ordbycol, limit: $limit);
        $post_list = [];
        foreach ($posts as $post) {
            $post = obj($post);
            $cat = getData('content', $post->parent_id);
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
                'author' => $post->author,
                'json_obj' => $post->json_obj
            ];
        }
        return $post_list;
    }
    public function filtered_posts($type = 'is_trending', $limit = 10)
    {
        $postObj = new Model('content');
        $posts = $postObj->filter_index(assoc_arr: [$type => 1, 'is_active' => 1, 'content_group' => 'post'], ord: 'desc', change_order_by_col: 'views', limit: $limit);
        $post_list = [];
        foreach ($posts as $post) {
            $post = obj($post);
            $cat = getData('content', $post->parent_id);
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
                'author' => $post->author,
                'json_obj' => $post->json_obj
            ];
        }
        return $post_list;
    }
    public function post_categories($limit = 10)
    {
        $postObj = new Model('content');
        $posts = $postObj->filter_index(assoc_arr: ['is_active' => 1, 'content_group' => 'post_category'], ord: 'desc', change_order_by_col: 'created_at', limit: $limit);
        $post_list = [];
        foreach ($posts as $post) {
            $post = obj($post);
            $cat = getData('content', $post->parent_id);
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
                'author' => $post->author,
                'json_obj' => $post->json_obj
            ];
        }
        return $post_list;
    }
}
