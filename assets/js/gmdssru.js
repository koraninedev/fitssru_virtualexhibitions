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

new Vue({
    el: '#app',
    components: {
        'navbar-component': httpVueLoader('./components/navbar.vue'),
        'treed-component': httpVueLoader('./components/3dmodel.vue'),
        'pic-component': httpVueLoader('./components/picture.vue'),
        'video-component': httpVueLoader('./components/video.vue'),
        'footer-component': httpVueLoader('./components/footer.vue')
    },
    data() {
        return {
            treeds: null,
            pics: null,
            videos: null,
            search: getParameterByName('search'),
            auth: {
                token: TOKEN,
                data: AUTH_DATA
            }
        }
    }, 
    mounted() {
        this.get3D()
        this.getPics()
        this.getVideo()
    },
    methods: {
        get3D() {
            axios.get('gmd/3d', {
                params: {
                    search: this.search
                }
            }).then((resp) => {
                this.treeds = resp.data.response
            })
        },
        getPics() {
            axios.get('gmd/pic', {
                params: {
                    search: this.search
                }
            }).then((resp) => {
                this.pics = resp.data.response
            })
        },
        getVideo() {
            axios.get('gmd/video', {
                params: {
                    search: this.search
                }
            }).then((resp) => {
                this.videos = resp.data.response
            })
        }
    }
}) 
/**
    mounted()   ในเหตุการณ์นี้ จะเกิดขึ้นเมื่อ DOM ถูกสร้างเสร็จแล้ว เราสามารถ เข้าถึง Element ต่างๆใน DOM ได้ทั้งหมด
*/