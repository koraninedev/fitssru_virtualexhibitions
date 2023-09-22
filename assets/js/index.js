new Vue({
    el: '#app',
    components: {
        'navbar-component': httpVueLoader('./components/navbar.vue'),
        'home-component': httpVueLoader('./components/home.vue'),
        'treed-component': httpVueLoader('./components/3dmodel.vue'),
        'pic-component': httpVueLoader('./components/picture.vue'),
        'video-component': httpVueLoader('./components/video.vue'),
        'aboutus-component': httpVueLoader('./components/aboutus.vue'),
        'footer-component': httpVueLoader('./components/footer.vue'),
        'branch-component': httpVueLoader('./components/branch.vue')
    },
    data() {
        return {
            blogs: null,
            search: getParameterByName('search'),
            auth: {
                token: TOKEN,
                data: AUTH_DATA
            }
        }
    }, 
    mounted() {
        
    },
    methods: {
        
    }
}) 
/**
    mounted()   ในเหตุการณ์นี้ จะเกิดขึ้นเมื่อ DOM ถูกสร้างเสร็จแล้ว เราสามารถ เข้าถึง Element ต่างๆใน DOM ได้ทั้งหมด
*/