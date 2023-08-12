<?php 
class Main_ctrl
{
    protected $req;
    protected $files;
    public function __construct() {
        $this->req = obj($_POST);
        $this->files = isset($_FILES)?obj($_FILES):null;
    }

    public function render_main($context = null)
    {
        import("apps/view/layouts/main.php", $context);
    }
}
