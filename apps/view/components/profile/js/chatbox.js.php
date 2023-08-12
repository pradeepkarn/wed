<script>
    const myFriends = document.getElementsByClassName("friends");
    const friendArray = [...myFriends];
    friendArray.forEach(frnd => {
        frnd.addEventListener('click', () => {
            const chatBox = document.getElementById("chatBox");
            const userIcon = document.getElementById("user-icon");
            userIcon.style.display = 'none';
            chatBox.style.display = "block";
        })
    });
    // 2nd method
    // for (e of myFriends) {
    //     e.addEventListener('click', () => {
    //         const chatBox = document.getElementById("chatBox");
    //         const userIcon = document.getElementById("user-icon");
    //         userIcon.style.display = 'none';
    //         chatBox.style.display = "block";
    //     })
    // }
    document.getElementById("minimize-chat").addEventListener('click', () => {
        chatBox.style.display = "none";
        document.getElementById("user-icon").style.display = 'block';
        startBounceAnimation();
    })
    document.getElementById("hide-chat").addEventListener('click', () => {
        chatBox.style.display = "none";
    })
    document.getElementById("user-icon").addEventListener('click', () => {
        chatBox.style.display = "block";
        document.getElementById("user-icon").style.display = 'none';
    })

    // Function to start the bouncing animation
    function startBounceAnimation() {
        const userIcon = document.getElementById("user-icon");
        userIcon.style.animation = "bounce 5s infinite";
        userIcon.style.display = "block";

        // Stop the animation after 5 seconds
        setTimeout(() => {
            userIcon.style.animation = "none";
            // userIcon.style.display = "none";
        }, 5000);
    }
</script>