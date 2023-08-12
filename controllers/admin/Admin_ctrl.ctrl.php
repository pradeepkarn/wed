<?php
class Admin_ctrl
{
    public function index($req=null)
    {
        $context = (object) array(
            'page'=>'admin-dashboard.php',
            'data' => (object) array(
                'req' => obj($req),
                'page_data' => 'other_data'
            )
        );
        $this->render_main($context);
    }
    public function render_main($context=null)
    {
        import("apps/admin/layouts/admin-main.php",$context);
    }
}
