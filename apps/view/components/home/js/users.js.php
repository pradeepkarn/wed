<script>
    // door open close
    // document.querySelectorAll(".door-icon").forEach((e) => {
    //     e.addEventListener('mouseover', () => {
    //         e.classList.remove('bi-door-closed-fill');
    //         e.classList.add('bi-door-open-fill');
    //     })
    //     e.addEventListener('mouseout', () => {
    //         e.classList.add('bi-door-closed-fill');
    //         e.classList.remove('bi-door-open-fill');
    //     })
    // })
    // person check unchek
    // document.querySelectorAll(".person-icon").forEach((e) => {
    //     e.addEventListener('mouseover', () => {
    //         e.classList.remove('bi-person-plus');
    //         e.classList.add('bi-person-circle');
    //     })
    //     e.addEventListener('mouseout', () => {
    //         e.classList.add('bi-person-plus');
    //         e.classList.remove('bi-person-circle');
    //     })
    // })
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
                    // alert(res.msg)
                    return;
                }
            });

        })
    })

    // profile like
    function profileLIkeUnlike() {
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
                        // alert(res.msg)

                    }
                });

            })
        })
    }
    profileLIkeUnlike();

    // Flag to prevent concurrent data loading
    let page_ = 2;
    let limit_ = 2;
    let loading = false;
    const fetchUsers = async () => {
       
        if (loading) {
            return; // Don't fetch if already loading
        }

        loading = true; // Set the loading flag
        const url = `/<?php echo home . route('loadUsersApi'); ?>`;
        await $.ajax({
            url: url,
            method: 'get',
            data: {
                page: page_,
                limit: limit_,
            },
            dataType: 'JSON',
            success: await
            async function(res) {
                try {
                    if (res.success === true) {
                        res.data.forEach(userData => {
                            $("#append").append(get_card(userData));
                        });
                        profileLIkeUnlike();
                        page_ += limit_;
                    } else {
                        loading = false; // Reset the loading flag after fetching
                        return;
                    }
                } catch (error) {
                    loading = false; // Reset the loading flag after fetching
                } finally {
                    loading = false; // Reset the loading flag after fetching
                }
            }
        });

    }

    function get_card(user) {
        return `
        <div class="col-md-6">
    <div class="card shadow h-100">


        <div class="card-body">
            <div class="row">
                <div class="col-4">
                    <a class="text-decoration-none profile-link" target="_blank" href="${user.profile_link}">
                        <img src="/<?php echo home; ?>/${user.image}" class="card-img-top profile-card-img" alt="${user.first_name} ${user.last_name}">
                    </a>
                </div>
                <div class="col-8">
                    <h5 class="card-title">${user.first_name} ${user.last_name}
                        <small>(${user.bride_or_groom})</small>
                    </h5>
                    <div class="row">
                        <div class="col">Age:</div>
                        <div class="col">
                            ${user.age} Yrs
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">Religion:</div>
                        <div class="col">${user.religion}</div>
                    </div>
                    <div class="row">
                        <div class="col">Caste:</div>
                        <div class="col">${user.caste}</div>
                    </div>
                    <div class="row">
                        <div class="col">Caste details:</div>
                        <div class="col">${user.caste_detail}</div>
                    </div>
                    <div class="row">
                        <div class="col">Location:</div>
                        <div class="col">${user.address}</div>
                    </div>
                    <div class="row">
                        <div class="col">Education:</div>
                        <div class="col">${user.education}</div>
                    </div>
                    <div class="row">
                        <div class="col">Profession:</div>
                        <div class="col">${user.occupation}</div>
                    </div>
                    <div class="row">
                        <div class="col">Annual Income:</div>
                        <div class="col">${user.annual_income} LPA</div>
                    </div>
                </div>
            </div>

        </div>
        <div class="icon-footer card-footer">
            <div class="frnd-icons">
                ${user.myreq.is_accepted ? '<i class="bi bi-person-check-fill"></i>' :
                    (user.myreq.success ? `<i data-request="cancel" data-user-id="${user.id}" class="my-icons person-icon bi bi-person-dash"></i>` :
                        `<i data-request="send" data-user-id="${user.id}" class="my-icons person-icon bi bi-person-plus"></i>`)
                }

                ${user.is_liked ? `<i data-request="unlike" data-user-id="${user.id}" class="my-icons heart-icon bi bi-heart-fill"></i>` :
                    `<i data-request="like" data-user-id="${user.id}" class="my-icons heart-icon bi bi-heart"></i>`
                }

                <a class="text-decoration-none" target="_blank" href="${user.profile_link}">
                    <i class="my-icons door-icon bi-door-closed-fill"></i>
                </a>
            </div>
        </div>
    </div>
    </div>
    `;
    }
  
</script>