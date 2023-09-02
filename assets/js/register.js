Vue.use(window.vuelidate.default)
let { required, minLength, sameAs, email } = validators
new Vue({
    el: '#register',
    data() {
        return {
            auth: {
                firstname: null,
                lastname: null,
                email: null,
                username: null,
                password: null,
                repeatPassword: null
            },
            checkEmail: null,
            checkUsername: null
        }
    },
    validations: {
        auth: {
            firstname: {
                required
            },
            lastname: {
                required
            },
            email: {
                required,
                email,
                isUnique(value) {
                    return new Promise((resolve, reject) => {
                        clearTimeout(this.checkEmail)
                        this.checkEmail = setTimeout(() => {
                            if (value !== null && value.length >= 6) {
                                axios({
                                    method: 'get',
                                    url: '/user/email',
                                    params: {
                                        email: value
                                    }
                                }).then((response) => {
                                    resolve(response.status === 204 ? true : false)
                                }).catch((err) => {
                                    Swal.fire('Error!', err, 'error').then( () => location.reload() )
                                })    
                            } else {
                                resolve(Boolean(true)) 
                            }
                        }, 600)
                    })
                }
            },
            username: {
                required,
                minLength: minLength(6),
                async isUnique(value) {
                    if (value !== null && value.length >= 6) {
                        const response = await axios({
                            method: 'get',
                            url: '/user/username',
                            params: {
                                username: value
                            }
                        })    
                        return await response.status === 204 ? true : false
                    } else {
                        return Boolean(true)  
                    }
                }
            },
            password: {
                required,
                minLength: minLength(6),
                containsLetterAndNumber(value) {
                    const containsLetter = /[a-zA-Z]/.test(value);
                    const containsNumber = /\d/.test(value);
                    return containsLetter && containsNumber;
                }
            },
            repeatPassword: {
                required,
                sameAsPassword: sameAs('password')
            }
        }
    },
    methods: {
        submitRegister() {
            if (!this.$v.$invalid) {
                axios({
                    method: 'post',
                    url: '/auth/create',
                    data: this.auth
                }).then((response) => {
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'ลงทะเบียนสำเร็จแล้ว',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 1500
                    }).then(() => {
                        location.assign("login");
                    })
                }).catch((error) => {
                    Swal.fire({
                        icon: 'error',
                        title: 'สมัครสมาชิกไม่สำเร็จ !',
                        text: "การกรอกข้อมูลมีความผิดพลาด โปรดกรอกใหม่อีกครั้ง",
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then(() => {
                        location.reload();
                    })
                })
            } else {
                Swal.fire('คำเตือน !', "โปรดกรอกข้อมูลให้ถูกต้องครบถ้วน", 'warning')
            }
        }
    }
})