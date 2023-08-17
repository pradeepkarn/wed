<script>
    const app = new Vue({
        el: '#app',
        data: {
            users: [],
            loadedUserIds: [], // Keep track of loaded user IDs
            loading: false,
            page: 1,
            limit: 1
        },
        created() {
            this.loadUsers();
            window.addEventListener('scroll', this.loadMoreOnScroll);
        },
        methods: {
            loadUsers() {
                this.loading = true;
                fetch(`/<?php echo home . route('loadUsersApi'); ?>?page=${this.page}&limit=${this.limit}`)
                    .then(response => response.json())
                    .then(data => {
                        try {
                            // Filter out already loaded user IDs
                            const newUsers = data.data.filter(user => !this.loadedUserIds.includes(user.id));
                            this.users = [...this.users, ...newUsers];

                            // Update loadedUserIds array
                            this.loadedUserIds = [...this.loadedUserIds, ...newUsers.map(user => user.id)];
                        } catch (error) {

                        }


                        this.loading = false;
                        this.page++;
                    });
            },
            loadMoreOnScroll() {
                if ((window.innerHeight + window.scrollY) >= 200) {
                    this.loadUsers();
                    loadUserssss();
                }
            },
          
        },
        // mounted (){
        //     loadUserssss()
        // }
        
    });
</script>