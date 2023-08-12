<?php
class Chat_ctrl
{
    public function chat($req=null)
    {
        $context = (object) array(
            'page' => 'chat.php',
            'data' => (object) array(
                'req' => obj($req),
                'other_data' => 'other_data'
            )
        );
        $this->render_main($context);
    }
    public function render_main($context = null)
    {
        import("apps/view/layouts/main.php", $context);
    }
}
