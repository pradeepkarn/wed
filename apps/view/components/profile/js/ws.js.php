<?php
$prof = $context->prof;
?>
<script>
    const socket = new WebSocket('<?php echo WS_LINK; ?>');
    // Assume sender_id is already defined

    // Function to check if element is scrolled to bottom
    function isScrolledToBottom(element) {
        return element.scrollHeight - element.clientHeight <= element.scrollTop + 1;
    }

    // Function to scroll the element to the bottom
    function scrollToBottom(element) {
        element.scrollTop = element.scrollHeight;
    }


    const msgHistoryFromDatabase = [];

    async function fetchMessagesFromDatabase(obj) {
        await $.ajax({
            url: '/<?php echo home . route('messageHistoryAjax'); ?>',
            method: 'post',
            data: {
                sender_id: obj.sender_id,
                receiver_id: obj.receiver_id
            },
            dataType: 'JSON',
            success: await
            function(res) {
                let messageElement = '';
                res.forEach(msg => {
                    if (msg.sender_id == <?php echo $prof->id; ?>) {
                        messageElement += `<div class="its-me chat-bubble">${msg.message}</div>`;
                    } else {
                        messageElement += `<div class="other chat-bubble">${msg.message}</div>`;
                    }
                });
                $("#message-box").html(messageElement)
                // console.log(res);
            }
        });

    }

    // async function jrm(sender_id, receiver_id) {
    //     let mYrm = [sender_id, receiver_id];
    //     mYrm.sort((a, b) => a - b);
    //     let rmnm = mYrm.join("connected");
    //     await joinRoom(rmnm);
    // }
    let oldRoom = null;
    $(document).ready(async function() {
        socket.addEventListener('open', async function(event) {
            // Set user online
            await socket.send(JSON.stringify({
                type: "online",
                user: <?php echo $prof->id; ?>
            }));
        });

        const myFriends = document.getElementsByClassName("friends");
        const friendArray = [...myFriends];

        // for (const frnd of myFriends) {
        //     await jrm(frnd.getAttribute('data-chat-myId'), frnd.getAttribute('data-chat-friendId'));
        // }
        friendArray.forEach(async (frnd) => {
            frnd.addEventListener('click', async () => {
                const sender_id = frnd.getAttribute('data-chat-myId');
                const receiver_id = frnd.getAttribute('data-chat-friendId');
                const recever_img = frnd.getAttribute('data-chat-friendDp');
                const recever_name = frnd.getAttribute('data-chat-friendName');
                document.querySelector('#send-msg-icon').setAttribute('data-chat-myId', sender_id);
                document.querySelector('#send-msg-icon').setAttribute('data-chat-friendId', receiver_id);
                document.querySelector('#current-user-img').src = recever_img;
                document.querySelector('#chatUserName').textContent = recever_name;
                await fetchMessagesFromDatabase({
                    sender_id: sender_id,
                    receiver_id: receiver_id
                });
                let myroom = [sender_id, receiver_id];
                myroom.sort((a, b) => a - b);
                let roomname = myroom.join("connected");
                await joinRoom(roomname);
                oldRoom = roomname;
                const messageBox = document.getElementById('message-box');
                scrollToBottom(messageBox);
            })
        });



        socket.addEventListener('message', function(event) {
            const msg = JSON.parse(event.data);
            // console.log(msg);
            if (msg.type === 'message') {
                // Display the received message in the chat window
                const chat = msg.content.message;
                if (msg.sender_id == <?php echo $prof->id; ?>) {
                    const messageElement = `<div class="its-me chat-bubble">${chat}</div>`;
                } else {
                    const messageElement = `<div class="other chat-bubble">${chat}</div>`;
                }

                $("#message-box").append(messageElement);
                const messageBox = document.getElementById('message-box');
                scrollToBottom(messageBox);
            }
            if (msg.type === 'ping') {
                const sender_id = msg.content.sender_id;
                const senderDiv = $(`#friend-div-id-${sender_id}`);
                if (senderDiv.length > 0) {
                    senderDiv.html(`<div class="green-dot"></div>`);
                }
            }
            if (msg.type === 'offline') {
                const info = msg.content.message;
                // alert(info);
                // const senderDiv = $(`#friend-div-id-${sender_id}`);
                // if (senderDiv.length > 0) {
                //     senderDiv.html(`<div class="green-dot"></div>`);
                // }
            }

            // console.log('Message from WebSocket server:', event.data);
        });

        socket.addEventListener('close', function(event) {
            console.log('Disconnected from WebSocket server');
            // leaveRoom();
        });

        $('#send-msg-icon').on('click', function(event) {
            event.preventDefault();
            const sender_id = document.querySelector('#send-msg-icon').getAttribute('data-chat-myId');
            const receiver_id = document.querySelector('#send-msg-icon').getAttribute('data-chat-friendId');
            const message = $('#write-msg-input').val();
            messageElement = `<div class="its-me chat-bubble">${message}</div>`;
            $("#message-box").append(messageElement);
            const data = {
                sender_id: sender_id,
                receiver_id: receiver_id,
                message: message
            };
            let myroom = [sender_id, receiver_id];
            myroom.sort((a, b) => a - b);
            // socket.send(JSON.stringify(data));
            let roomname = myroom.join("connected");
            sendMessage(data, roomname);

            $('#write-msg-input').val('');
            const messageBox = document.getElementById('message-box');
            scrollToBottom(messageBox);
        });
    });

    $('#write-msg-input').on('keypress', function(event) {
        if (event.which === 13 && !event.shiftKey) { // Enter key
            event.preventDefault();
            const sender_id = document.querySelector('#send-msg-icon').getAttribute('data-chat-myId');
            const receiver_id = document.querySelector('#send-msg-icon').getAttribute('data-chat-friendId');
            const message = $('#write-msg-input').val();
            messageElement = `<div class="its-me chat-bubble">${message}</div>`;
            $("#message-box").append(messageElement);
            const data = {
                sender_id: sender_id,
                receiver_id: receiver_id,
                message: message
            };
            let myroom = [sender_id, receiver_id];
            myroom.sort((a, b) => a - b);
            // socket.send(JSON.stringify(data));
            let roomname = myroom.join("connected");
            sendMessage(data, roomname);
            $('#write-msg-input').val('');
            const messageBox = document.getElementById('message-box');
            scrollToBottom(messageBox);
        }
    });


    // let currentRoom = null;

    async function joinRoom(room) {
        // if (oldRoom) {
        //     leaveRoom(oldRoom);
        // }
        const joinData = {
            type: 'join',
            room: room
        };
        if (socket.readyState === WebSocket.OPEN) {
            await socket.send(JSON.stringify(joinData));
        }
    }

    function leaveRoom(oldRoom) {

        const leaveData = {
            type: 'leave',
            room: oldRoom
        }

        socket.send(JSON.stringify(leaveData));
        // currentRoom = null;
    }
    

    function sendMessage(data, myroom) {
        // if (currentRoom && data.message.trim() !== '') {
        if (data.message.trim() !== '') {
            const messageData = {
                type: 'message',
                room: myroom,
                content: data
            };

            socket.send(JSON.stringify(messageData));
        }
    }
</script>