<?php
class PrivacyPolicy_ctrl
{
    public function index($req=null)
    {
        $GLOBALS['meta_seo'] = (object) array('title' => 'Privacy Policy', 'description' => 'We are providing our privacy policy', 'keywords' => 'privacy-policy, privacy, policy, blog, terms');
        $context = (object) array(
            'page'=>'privacy-policy.php',
            'data' => (object) array(
                'req' => obj($req),
                'privacy_policy' => "Lorem ipsum dolor sit amet consectetur adipisicing elit. Possimus, mollitia delectus molestiae voluptate voluptates, facere quidem unde obcaecati eius est eaque, natus quo. Labore beatae doloribus magnam recusandae suscipit. Repellat."
            )
        );
        $this->render_main($context);
    }
    public function render_main($context=null)
    {
        import("apps/view/layouts/main.php",$context);
    }
}
