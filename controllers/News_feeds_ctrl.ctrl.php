<?php
class News_feeds_ctrl extends Main_ctrl
{
    function index($req = null)  {
        if (USER) {
            // $prof = $this->profile_detail($id = USER['id']);
            // $myfrnds = $this->my_friend_list($my_id = USER['id']);
        }
        $context = (object) array(
            'page' => 'news-feeds.php',
            'data' => (object) array(
                'req' => obj($req),
                // 'my_profile' => $prof,
                // 'my_friends' => $myfrnds
            )
        );
        $this->render_main($context);
    }
}
