Vue.use(window.vuelidate.default)
let { required, minLength, sameAs, email } = validators
new Vue({
    el: '#login',
    data() {
        return {
            /* text: 'Login Kitchen Enjoy', */
            username: null,
            password: null
        }
    },
    validations: {
        username: {
            required,
            minLength: minLength(6)
        },
        password: {
            required,
            minLength: minLength(6)
        }
    },
    methods: {
        submitLogin() {
            if (!this.$v.$invalid) {
                const auth = { 
                    username: this.username, 
                    password: this.password 
                }
                axios({
                    method: 'post',
                    url: '/auth',
                    data: auth
                }).then((response) => {
                    Swal.fire({
                        icon: 'success',
                        title: 'เข้าสู่ระบบสำเร็จ',
                        text: 'ขอให้เพลิดเพลินกับการชมนิทรรศการเสมือนจริง',
                        timer: '1500',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showConfirmButton: false
                    }).then(function (result) {
                        localStorage.setItem("auth_token", response.data.response.token)
                        localStorage.setItem("auth_data", JSON.stringify(response.data.response.result))
                        location.assign("./");
                    })
                }).catch((error) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'เข้าสู่ระบบไม่สำเร็จ !',
                        text: 'ชื่อผู้ใช้งานหรือรหัสผ่านผิด กรุณาลองใหม่อีกครั้ง',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    })
                })
            }
        }
    }
})