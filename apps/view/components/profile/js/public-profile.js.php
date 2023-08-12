<script>
     // hert zoom
     document.querySelectorAll(".heart-icon").forEach((e) => {
        e.addEventListener('mouseover', () => {
            e.classList.add('heart-zoom');
        })
        e.addEventListener('mouseout', () => {
            e.classList.remove('heart-zoom');
        })
    })
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

    // profile like
    document.querySelectorAll(".heart-icon").forEach((e) => {
        e.addEventListener('click', async () => {
            const userId = e.getAttribute('data-user-id');
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
                    if (res.success === true) {
                        if (e.getAttribute('data-request') == "like") {
                            e.classList.remove('bi-heart');
                            e.classList.add('bi-heart-fill');
                            e.setAttribute("data-request", "unlike");
                        } else if (e.getAttribute('data-request') == "unlike") {
                            e.classList.add('bi-heart');
                            e.classList.remove('bi-heart-fill');
                            e.setAttribute("data-request", "like");
                        }
                    }
                    alert(res.msg)
                }
            });

        })
    })
</script>
