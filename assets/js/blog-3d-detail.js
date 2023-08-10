new Vue({
    el: '#app',
    components: {
        'navbar-component': httpVueLoader('./components/navbar.vue'),
        'treed-component': httpVueLoader('./components/3dmodel.vue'),
        'star-component': httpVueLoader('./components/star.vue'),
        'footer-component': httpVueLoader('./components/footer.vue')
    },
    data() {
        return {
            blogInterest: null,
            blog3d: null,
            auth: {
                token: TOKEN,
                data: AUTH_DATA
            },
            message: null,
            comments: []
        }
    }, 
    mounted() {
        this.getBlog3d()
        this.interest()
    },
    methods: {
        getId() {
            let regex = new RegExp('3d/[0-9]+'),
                results = regex.exec(window.location.href),
                id = results[0].split('/')
            return id[1]
        },
        getBlog3d() {
            axios.get('3d/detail', { 
                params: { 
                    id: this.getId() 
                } 
            })
            .then((resp) => {
                this.blog = resp.data.response
                this.comments = this.blog.comments
            })
            .catch(() => location.assign("./"))
        },
        interest() {
            axios.get('3d/interest', { 
                params: { 
                    current: this.getId() 
                } 
            })
            .then((resp) => this.blogInterest = resp.data.response)
            .catch(() => location.assign("./"))
        },
        submitComment() {
            let comment = {
                comment_id: 2,
                u_id: this.auth.data.u_id,
                message: this.message,
                firstname: this.auth.data.firstname,
                lastname: this.auth.data.lastname,
                image: this.auth.data.image,
                created_at: new Date(),
                blog_id: this.getId()
            }
            this.comments.push(comment)
            this.message = null

            axios({
                method: 'post',
                url: '/comment/create',
                data: comment
            }).catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "การกรอกข้อมูลมีความผิดพลาด โปรดกรอกใหม่อีกครั้ง",
                }).then(() => {
                    location.reload();
                })
            })
        }
    },
    beforeUpdate() {
        this.$nextTick(function () {
            /** call tooltips bootstrap5 */
            let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
            /** call sharethis */
            var script = document.createElement('script');
            script.src = "https://platform-api.sharethis.com/js/sharethis.js#property=5fa59bebea34a200144b93aa&product=inline-reaction-buttons";
            document.getElementsByTagName("head")[0].appendChild(script);
        })
    }
}) 

// const urlParams = new URLSearchParams(window.location.search);
// const myParam = urlParams.get('myParam');
