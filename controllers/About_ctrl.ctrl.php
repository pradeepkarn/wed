<?php
class About_ctrl
{
    public function index($req=null)
    {
        $GLOBALS['meta_seo'] = (object) array('title' => 'About', 'description' => 'We are spreading knowledge and wisdom', 'keywords' => 'blog, article, education, news');
        $context = (object) array(
            'page'=>'about.php',
            'data' => (object) array(
                'req' => obj($req),
                'about_data' => "
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis, perspiciatis repellat maxime, adipisci non ipsam at itaque rerum vitae, necessitatibus nulla animi expedita cumque provident inventore? Voluptatum in tempora earum deleniti, culpa odit veniam, ea reiciendis sunt ullam temporibus aut!</p>
                <p>Fugit eaque illum blanditiis, quo exercitationem maiores autem laudantium unde excepturi dolores quasi eos vero harum ipsa quam laborum illo aut facere voluptates aliquam adipisci sapiente beatae ullam. Tempora culpa iusto illum accusantium cum hic quisquam dolor placeat officiis eligendi.</p>
             ",
             "mission_vision"=>"

             <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Facilis, perspiciatis repellat maxime, adipisci non ipsam at itaque rerum vitae, necessitatibus nulla animi expedita cumque provident inventore? Voluptatum in tempora earum deleniti, culpa odit veniam, ea reiciendis sunt ullam temporibus aut!</p>
             <p>Fugit eaque illum blanditiis, quo exercitationem maiores autem laudantium unde excepturi dolores quasi eos vero harum ipsa quam laborum illo aut facere voluptates aliquam adipisci sapiente beatae ullam. Tempora culpa iusto illum accusantium cum hic quisquam dolor placeat officiis eligendi.</p>
         "
            )
        );
        
        $this->render_main($context);
    }
    public function render_main($context=null)
    {
        import("apps/view/layouts/main.php",$context);
    }
}
