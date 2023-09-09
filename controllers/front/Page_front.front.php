<?php
class Page_front extends Main_ctrl
{
    public function index($req=null)
    {
        $req = obj($req);
        $slug = $req->slug;
        $db = new Dbobjects;
        $db->tableName = 'content';
        $page = $db->get(['slug'=>$slug,'content_group'=>'page']);
        if (!$page) {
            header("Location:/".home.route('home'));
            exit;
        }
        $page = (object)$page;
        $meta_tags = "";
        $meta_desc = "";
        if ($page->json_obj != "") {
            $jsn = json_decode($page->json_obj);
            if (isset($jsn->meta->tags)) {
                $meta_tags = $jsn->meta->tags;
            }
            if (isset($jsn->meta->description)) {
                $meta_desc = $jsn->meta->description;
            }
        }
        $GLOBALS['meta_seo'] = (object) array('title' => $page->title, 'description' => $meta_desc, 'keywords' => $meta_tags);
        $context = (object) array(
            'page'=>'page.php',
            'data' => (object) array(
                'req' => obj($req),
                'title' => $page->title,
                'content' => $page->content,
                'banner' => $page->banner
            )
        );
        $this->render_main($context);
    }
    public function render_main($context=null)
    {
        import("apps/view/layouts/main.php",$context);
    }
}
