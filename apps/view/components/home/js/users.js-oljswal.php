<script>
    // door open close

    function doorOpenClose() {
        document.querySelectorAll(".door-icon").forEach((e) => {
            e.addEventListener('mouseover', () => {
                e.classList.remove('bi-door-closed-fill');
                e.classList.add('bi-door-open-fill');
            })
            e.addEventListener('mouseout', () => {
                e.classList.add('bi-door-closed-fill');
                e.classList.remove('bi-door-open-fill');
            })
        })
    }


    function heartIconzoom() {
        // hert zoom
        document.querySelectorAll(".heart-icon").forEach((e) => {
            e.addEventListener('mouseover', () => {
                e.classList.add('heart-zoom');
            })
            e.addEventListener('mouseout', () => {
                e.classList.remove('heart-zoom');
            })
        })
    }

    function sendRequest() {
        // send reuqest
        document.querySelectorAll(".person-icon").forEach((e) => {
            e.addEventListener('click', async () => {
                const userId = e.getAttribute('data-user-id');
                const url = `/<?php echo home . route('sendRequestAjax'); ?>`;
                await $.ajax({
                    url: url,
                    method: 'post',
                    data: {
                        request_to: userId
                    },
                    dataType: 'JSON',
                    success: await
                    function(res) {
                        if (res.success === true) {
                            if (e.getAttribute('data-request') == "send") {
                                e.classList.remove('bi-person-plus');
                                e.classList.add('bi-person-dash');
                                e.setAttribute("data-request", "cancel");
                            } else if (e.getAttribute('data-request') == "cancel") {
                                e.classList.add('bi-person-plus');
                                e.classList.remove('bi-person-dash');
                                e.setAttribute("data-request", "send");
                            }
                        }
                        alert(res.msg)
                    }
                });

            })
        })
    }

    function profileLikeUnlike() {
        // profile like
        const heartLikes = document.querySelectorAll(".heart-icon");
        for (let i = 0; i < heartLikes.length; i++) {
            const elm = heartLikes[i];
            elm.addEventListener('click', async (ev) => {
                ev.preventDefault(); // Prevent default behavior
                const userId = elm.getAttribute('data-user-id');
                const url = `/<?php echo home . route('likeUnlikeProfileAjax'); ?>`;
                await $.ajax({
                    url: url,
                    method: 'post',
                    data: {
                        obj_id: userId
                    },
                    dataType: 'JSON',
                    success: await
                    function(res) {
                        if (res.success === true && res.msg == 'Liked') {
                            elm.classList.remove('bi-heart');
                            elm.classList.add('bi-heart-fill');
                            elm.setAttribute("data-request", "unlike");
                            return;
                        } else if (res.success === true && res.msg == 'Unliked') {
                            elm.classList.add('bi-heart');
                            elm.classList.remove('bi-heart-fill');
                            elm.setAttribute("data-request", "like");
                            return;
                        }
                        // alert(res.msg)
                    }
                });
                return;
            })
        }
    }
</script>