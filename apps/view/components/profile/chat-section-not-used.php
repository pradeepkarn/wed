<section>
    <!-- Contact List -->
    <img id="user-icon" src="/<?php echo MEDIA_URL; ?>/images/profiles/default-user.png" alt="">
    <div class="row">

        <div class="col-md-12">
            <h3>Contact List</h3>
            <ul class="list-group user-list">
                <?php
                foreach ($frnds as $key => $frnd) :
                    $frnd = obj($frnd);
                ?>
                    <li data-chat-friendName="<?php echo $frnd->first_name; ?>" data-chat-myId="<?php echo $prof->id; ?>" data-chat-friendId="<?php echo $frnd->id; ?>" data-chat-friendDp="/<?php echo MEDIA_URL; ?>/images/profiles/<?php echo $frnd->image; ?>" class="list-group-item friends">
                        <div>
                            <span id="friend-div-id-<?php echo $frnd->id; ?>"></span>
                            <img class="friend-user-img" src="/<?php echo MEDIA_URL; ?>/images/profiles/<?php echo $frnd->image; ?>" alt="<?php echo $frnd->first_name; ?>">
                            <?php echo $frnd->username; ?>
                        </div>
                    </li>
                <?php endforeach; ?>
                <!-- Add more users here -->
            </ul>

        </div>
    </div>

    <div class="chat-box" id="chatBox">

        <div class="show-hide-icons">
            <div>
                <a id="profile-link" href="">
                    <img id="current-user-img" src="/<?php echo MEDIA_URL; ?>/images/profiles/default-user.png" alt="">
                    <b id="chatUserName" class="ps-1"></b>
                </a>

            </div>
            <div id="min-close-icon">
                <i id="minimize-chat" class="bi bi-dash"></i>
                <i id="hide-chat" class="bi bi-x"></i>
            </div>
        </div>


        <div class="messages" id="message-box">
            <!-- <div class="its-me chat-bubble">
                            HI there adkjhdk hkjsdh hksdh
                        </div>
                        <div class="other chat-bubble">
                            hello jkgkdsg hkjdsh kjh kjhds
                        </div> -->

        </div>
        <div id="write-msg">

            <div id="writing-box">
                <textarea id="write-msg-input" placeholder="Type your message..." class="form-control" name="message" rows="1"></textarea>
            </div>
            <div data-chat-myId="" data-chat-friendId="" id="send-msg-icon">
                <i class="bi bi-send"></i>
            </div>
        </div>


    </div>
</section>