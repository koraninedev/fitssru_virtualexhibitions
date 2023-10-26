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
                containsLetter(value) {
                    return /[A-Za-z]/.test(value);
                },
                isAlphanumeric(value) {
                    return /^[A-Za-z0-9]+$/.test(value);
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
                    if (error.response && error.response.status === 429) {
                        Swal.fire({
                            icon: 'error',
                            title: 'สมัครสมาชิกไม่สำเร็จ !',
                            text: "ขณะนี้มีผู้ใช้งานเกินจำนวนแล้ว ไว้กลับมาใหม่อีกครั้งนะ ขอบพระคุณ",
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'สมัครสมาชิกไม่สำเร็จ !',
                            text: "การกรอกข้อมูลมีความผิดพลาด โปรดกรอกใหม่อีกครั้ง",
                            allowOutsideClick: false,
                            allowEscapeKey: false
                        }).then(() => {
                            location.reload();
                        })
                    } 
                })
            } else {
                if (!this.$v.auth.password.required) {
                    Swal.fire('คำเตือน !', "กรุณากรอกรหัสผ่าน", 'warning');
                } else if (!this.$v.auth.password.minLength) {
                    Swal.fire('คำเตือน !', `รหัสผ่านต้องมีอย่างน้อย ${this.$v.auth.password.$params.minLength.min} ตัวอักษร`, 'warning');
                } else if (!this.$v.auth.password.containsLetter) {
                    Swal.fire('คำเตือน !', "รหัสผ่านต้องมีตัวอักษรอย่างน้อย 1 ตัว", 'warning');
                } else if (!this.$v.auth.password.isAlphanumeric) {
                    Swal.fire('คำเตือน !', "รหัสผ่านห้ามมีอักขระพิเศษ", 'warning');
                }
            }
        }
    }
})