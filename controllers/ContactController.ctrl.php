<?php
class ContactController
{
    public function index($req=null)
    {
        $GLOBALS['meta_seo'] = (object) array('title' => 'Contact us', 'description' => 'We are always available for you just drop a message we will get back to you!', 'keywords' => 'contact us, contact form, contact blog, email');
        $context = (object) array(
            'page'=>'contact.php',
            'data' => (object) array(
                'req' => obj($req),
                'other_data' => 'other_data'
            )
        );
        $this->render_main($context);
    }
    public function render_main($context=null)
    {
        import("apps/view/layouts/main.php",$context);
    }
}
