<?php 
class Main_ctrl
{
    public $post;
    public $get;
    public $files;
    public function __construct() {
        $this->post = obj($_POST);
        $this->get = obj($_GET);
        $this->files = isset($_FILES)?obj($_FILES):null;
    }

    public function render_main($context = null)
    {
        import("apps/view/layouts/main.php", $context);
    }
}
