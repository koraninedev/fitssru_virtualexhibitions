/* https://github.com/vuelidate/vuelidate */
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
                data: AUTH_DATA,
            },
            change: {
                currentPassword: '',
                newPassword: '',
                repeatPassword: ''
            }
        }
    },
    validations: {
        change: {
            currentPassword: {
                required,
                minLength: minLength(6)
            },
            newPassword: {
                required,
                minLength: minLength(6)
            },
            repeatPassword: {
                sameAsPassword: sameAs('newPassword')
            }
        }
    },
    computed: {
        fullname() {
            return `${this.auth.data.firstname} ${this.auth.data.lastname}`
        }
    },
    mounted() {
        this.getUser()
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
        changePassword() {
            if (!this.$v.$invalid) {
                axios({
                    method: 'put',
                    url: '/auth/changepassword',
                    data: this.change,
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
                        location.reload()
                    })
                }).catch((error) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'รหัสผ่านเดิมไม่ถูกต้อง',
                    })
                })
            }
        }
    }
}) 
