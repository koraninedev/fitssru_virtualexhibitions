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
        'branch-component': httpVueLoader('./components/branch.vue'),
        'footer-component': httpVueLoader('./components/footer.vue')
    },
    data() {
        return {
            auth: {
                token: TOKEN,
                data: AUTH_DATA
            }
        }
    }, 
    mounted() {
        /* console.log(test) */
    }
}) 
/**
    mounted()   ในเหตุการณ์นี้ จะเกิดขึ้นเมื่อ DOM ถูกสร้างเสร็จแล้ว เราสามารถ เข้าถึง Element ต่างๆใน DOM ได้ทั้งหมด
*/