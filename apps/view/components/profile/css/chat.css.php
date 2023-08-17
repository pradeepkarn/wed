<style>
    .chat-box {
        position: fixed;
        bottom: 15px;
        right: 10px;
        width: 300px;
        background-color: #f5f5f5;
        border: 1px solid #ccc;
        border-radius: 5px;
        /* padding: 0 5px 0 5px; */
        display: none;
        z-index: +100;
    }

    #user-icon {
        height: 50px;
        width: 50px;
        border-radius: 50%;
        position: fixed;
        bottom: 50px;
        right: 50px;
        display: none;
    }

    .back-to-top {
        display: none !important;
    }

    @keyframes bounce {

        0%,
        20%,
        50%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-30px);
        }

        60% {
            transform: translateY(-15px);
        }
    }



    .messages {
        height: 300px;
        overflow-y: scroll;
        display: flex;
        flex-direction: column;
        /* border-top: 1px solid grey; */
    }

    .friend-user-img,
    #current-user-img {
        height: 50px;
        width: 50px;
        border-radius: 50%;

    }

    .show-hide-icons {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 5px;
        border-bottom: 1px solid grey;
        width: 100%;
    }

    #write-msg {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
        padding: 5px;
        /* gap: 20px; */
        width: 100%;
        padding-bottom: 20px;
    }

    #min-close-icon {
        position: relative;
        right: 5px;
        padding: 5px;
    }

    #minimize-chat,
    #hide-chat {
        font-size: 30px;
        font-weight: 500;
        cursor: pointer;
    }

    #send-msg-icon {
        display: flex;
        font-size: 25px;
        justify-content: space-around;
        align-items: center;
        cursor: pointer;
    }

    #write-msg-input {
        border-radius: 30px;
    }

    .chat-bubble {
        max-width: 70%;
        padding: 10px 15px;
        margin: 10px;
        border-radius: 10px;
        font-size: 18px;
        line-height: 1.4;
    }

    .its-me {
        background-color: #fcc;
        /* Light yellow for user's chat bubble */
        align-self: flex-end;
    }

    .other {
        background-color: #bce;
        align-self: flex-start;
        /* Light blue for other's chat bubble */
    }

    /* Adding the "tail" to the chat bubble */
    .its-me:before {
        content: '';
        position: absolute;
        bottom: 0;
        right: -10px;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 10px 10px 0;
        border-color: transparent #fcc transparent transparent;
    }

    .other:before {
        content: '';
        position: absolute;
        bottom: 0;
        left: -10px;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 0 10px 10px;
        border-color: transparent transparent #bce transparent;
    }

    /* Add this to your CSS file */
    .green-dot {
        position: absolute;
        width: 10px;
        height: 10px;
        background-color: green;
        border-radius: 50%;
        display: inline-block;
        margin-right: 5px;
        border: 2px solid white;
        /* Optional: Add some spacing after the green dot */
    }
</style>