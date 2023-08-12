<style>
      .chat-container{
        position: fixed;
        bottom: 0;
        right: 0;
        height: 300px;
        overflow-y: scroll;
        width: 25%;
    }
    .chat-list{
        position: relative;
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        /* background-color: white; */
    }
    .chat-user-icon{
        height: 40px;
        width: 40px;
        border-radius: 50%;
    }
  
</style>
<div class="chat-container">
<div class="row chat-row">
    <div class="col-12 chat-list py-2">
        <img class="chat-user-icon" src="/<?php echo MEDIA_URL;  ?>/images/profiles/default-user.png" alt="user">
    </div>
    <div class="col-12 chat-list py-2">
        <img class="chat-user-icon" src="/<?php echo MEDIA_URL;  ?>/images/profiles/default-user.png" alt="user">
    </div>
    <div class="col-12 chat-list py-2">
        <img class="chat-user-icon" src="/<?php echo MEDIA_URL;  ?>/images/profiles/default-user.png" alt="user">
    </div>
    <div class="col-12 chat-list">
        <img class="chat-user-icon" src="/<?php echo MEDIA_URL;  ?>/images/profiles/default-user.png" alt="user">
    </div>
</div>
</div>