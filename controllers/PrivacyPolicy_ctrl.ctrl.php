<?php
class PrivacyPolicy_ctrl
{
    public function index($req=null)
    {
        $GLOBALS['meta_seo'] = (object) array('title' => 'Privacy Policy', 'description' => 'We are providing our privacy policy', 'keywords' => 'privacy-policy, privacy, policy, blog, terms');
        $db = new Dbobjects;
        $db->tableName = 'content';
        $pp = (object)$db->get(['slug'=>'privacy-policy']);
        $context = (object) array(
            'page'=>'privacy-policy.php',
            'data' => (object) array(
                'req' => obj($req),
                'privacy_policy' => $pp->content
            )
        );
        $this->render_main($context);
    }
    public function render_main($context=null)
    {
        import("apps/view/layouts/main.php",$context);
    }
}
