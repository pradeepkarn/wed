<script>
    document.addEventListener('DOMContentLoaded', () => {

        let page_ = 0;
        let limit_ = 2;
        let loading = false; // Flag to prevent concurrent data loading

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

        // await fetchUsers();
        // profile like
        const loadMOreBtn = document.getElementById('load_more_btn');
        loadMOreBtn.addEventListener('click', async () => {
            await fetchUsers();
            profileLikeUnlike()
            doorOpenClose();
            sendRequest();
            heartIconzoom();
        })

        // window.addEventListener('scroll', async function() {
        //     const windowHeight = window.innerHeight;
        //     const documentHeight = document.documentElement.scrollHeight;
        //     const scrollTop = window.scrollY;
        //     if (windowHeight + scrollTop >= documentHeight - 100) {
        //         await fetchUsers(); // Use the debounced fetch function
        //         profileLikeUnlike()
        //         doorOpenClose();
        //         sendRequest();
        //         heartIconzoom();
        //     }
        // });

    })
</script>