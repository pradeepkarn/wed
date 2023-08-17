<?php
$users = $context->user_list;
import(
    "apps/view/components/home/css/users.css.php",
    obj([])
);
?>
<?php if (USER) : ?>
    <div id="send-req-response-users-component"></div>
    <section id="app">
        <div class="container py-5">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <!-- Add more user cards here as needed -->
            </div>

            <div class="row row-cols-1 row-cols-md-3 g-4">
                <div class="col-md-6" v-for="user in users" :key="user.id">
                    <div class="card shadow h-100">


                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <a class="text-decoration-none profile-link" :href="user.profile_link">
                                        <img :src="`/<?php echo home; ?>/${user.image}`" class="card-img-top profile-card-img" :alt="`${user.first_name} ${user.last_name}`">
                                    </a>
                                </div>
                                <div class="col-8">
                                    <h5 class="card-title">{{user.first_name}} {{user.last_name}}
                                        <small>({{user.bride_or_groom}})</small>
                                    </h5>
                                    <div class="row">
                                        <div class="col">Age:</div>
                                        <div class="col">
                                            {{user.age}} Yrs
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Religion:</div>
                                        <div class="col">{{user.religion}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Caste:</div>
                                        <div class="col">{{user.caste}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Caste details:</div>
                                        <div class="col">{{user.catse_detail}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Location:</div>
                                        <div class="col">{{user.address}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Education:</div>
                                        <div class="col">{{user.education}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Profession:</div>
                                        <div class="col">{{user.occupation}}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col">Annual Income:</div>
                                        <div class="col">{{user.annual_income}} LPA</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="icon-footer card-footer">
                            <div class="frnd-icons">

                                <i v-if="user.myreq.is_accepted" class="bi bi-person-check-fill"></i>
                                <template v-else>
                                    <i v-if="user.myreq.success" :data-request="`cancel`" :data-user-id="user.id" class="my-icons person-icon bi bi-person-dash"></i>
                                    <i v-else data-request="`send`" :data-user-id="user.id" class="my-icons person-icon bi bi-person-plus"></i>
                                </template>



                                <i v-if="user.is_liked" :data-request="`unlike`" :data-user-id="user.id" class="my-icons heart-icon bi bi-heart-fill"></i>

                                <i v-else :data-request="`like`" :data-user-id="user.id" class="my-icons heart-icon bi bi-heart"></i>



                                <a class="text-decoration-none" :href="user.profile_link">
                                    <i class="my-icons door-icon bi-door-closed-fill"></i>
                                </a>
                            </div>
                            <?php

                            ?>
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </section>
    <?php
    $users = $context->user_list;
    import(
        "apps/view/components/home/js/users.js.php",
        obj([])
    );
    import(
        "apps/view/components/home/js/load-users-veu.js.php",
        obj([])
    );
   
    
    ?>
<?php endif; ?>