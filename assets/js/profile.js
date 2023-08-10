if (!AUTH_DATA && !TOKEN) {
    Swal.fire({
        icon: 'error',
        title: 'ไม่สามารถเข้าถึงหน้านี้ได้',
        text: 'คุณยังไม่เข้าสู่ระบบ กรุณาเข้าสู่ระบบก่อนเข้าใช้งาน',
        allowOutsideClick: false,
        allowEscapeKey: false,
        confirmButtonText: 'OK'
    }).then((result) => {
        if (result.isConfirmed) {
            localStorage.clear()
            location.assign("login")
        }
    })
}

Vue.use(window.vuelidate.default)
let { required, minLength, sameAs } = validators

new Vue({
    el: '#profile',
    components: {
        'navbar-component': httpVueLoader('./components/navbar.vue'),
        'profileheader-component': httpVueLoader('./components/profile.header.vue'),
        'footer-component': httpVueLoader('./components/footer.vue')
    },
    data() {
        return {
            navlight: true,
            auth: {
                token: TOKEN,
                data: AUTH_DATA
            }
        }
    },
    mounted() {
        this.getUser()
    },
    validations: {
        auth: {
            data: {
                firstname: {
                    required
                },
                lastname: {
                    required
                }
            }
        }
    },
    methods: {
        getUser() {
            axios({
                method: 'get',
                url: '/user/show',
                headers: {
                    Authorization: 'Bearer ' + this.auth.token,
                }
            }).then((resp) => {
                this.auth.data = resp.data.response
                localStorage.setItem("auth_data", JSON.stringify(this.auth.data))
            }).catch((error) => {
                Swal.fire({
                    icon: 'error',
                    title: 'ไม่สามารถเข้าถึงหน้านี้ได้',
                    text: 'คุณยังไม่เข้าสู่ระบบ กรุณาเข้าสู่ระบบก่อนเข้าใช้งาน',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        localStorage.clear()
                        location.assign("login")
                    }
                })
            })
        },
        editProfile() {
            axios({
                method: 'put',
                url: '/auth/edit',
                data: this.auth.data,
                headers: {
                    Authorization: 'Bearer ' + this.auth.token,
                }
            }).then((resp) => {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: 'อัพเดทข้อมูลสำเร็จแล้ว',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    location.reload();
                })
            }).catch((error) => {
                console.log(error)
            })
        }
    }
}) 
