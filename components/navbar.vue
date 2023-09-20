<template>
    <nav class="navbar navbar-expand-lg fixed-top navbar-dark" style="background-color: rgba(0,0,0,0.25);">
        <div class="container">
            <a class="navbar-brand" href="./">
                <img src="assets/images/text_logo.png" height="65px" alt="" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto float-end ul-navbar">
                    <li class="nav-item px-3 px-md-0">
                        <a class="nav-link" href="./">หน้าหลัก</a>
                    </li>
                    <li class="nav-item px-3 px-md-0" v-if="auth.data">
                        <a class="nav-link" href="virtualexhibitions">นิทรรศการเสมือนจริง</a>
                    </li>
                    <li class="nav-item px-3 px-md-0" v-if="auth.data">
                        <a class="nav-link" href="branch_workshop">ผลงานของสาขา</a>
                    </li>
                    <li class="nav-item px-3 px-md-0">
                        <a class="nav-link" href="contact">เกี่ยวกับเรา</a>
                    </li>
                    <li class="nav-item px-3 px-md-0" v-if="!auth.data">
                        <a class="nav-link" href="register">สมัครสมาชิก</a>
                    </li>
                    <li class="nav-item px-3 px-md-0" v-if="!auth.data">
                        <a class="nav-link" href="login">เข้าสู่ระบบ</a>
                    </li>
                    
                    <li class="nav-item dropdown ms-auto text-end px-3 px-0" v-if="auth.data">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                            <img class="profile-img"  :src="`assets/images/uploads/${auth.data.image}`" alt="">
                            <strong class="text-capitalize" v-once>{{auth.data.firstname.length > 20 ? auth.data.firstname.substring(0,20)+"..." : auth.data.firstname }}</strong>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end mb-3" aria-labelledby="navbarDropdown">
                            <li>
                                <a class="dropdown-item" href="profile">
                                    <div class="d-flex align-items-center">
                                        <img class="profile-img" :src="`assets/images/uploads/${auth.data.image}`"> 
                                        <div class="p-3 lh-sm">
                                            <span class="fw-bold" v-once v-text="fullname"></span><br>
                                            <small>ดูโปรไฟล์ของคุณ </small>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" @click="logout()">
                                    <i class="fas fa-sign-out-alt"></i> ออกจากระบบ
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
        <div class="progressContainer">
            <div class="progressBar">
            </div>
        </div>
    </nav>
</template>
<script>
module.exports = {
    props: ['auth', 'navlight'],
    mounted() { 
        this.progressBar()
        let navbar = document.querySelector(".navbar")
        let navLinks = document.querySelectorAll('.nav-link')
        let windowPathname = window.location.pathname
        if (this.navlight) {
            navbar.classList.remove("navbar-dark")
            navbar.classList.add("navbar-light","bg-light","shadow-sm")
        } else {
            this.eventScroll(navbar)
        }
        navLinks.forEach(navLink => {
            let navLinkPathname = new URL(navLink.href).pathname

            if((windowPathname === navLinkPathname) || (windowPathname === 'index.html' && navLinkPathname === '/')) {
                navLink.classList.add('active')
            }
        })
    },
    computed: {
        fullname() {
            let name = `${this.auth.data.firstname} ${this.auth.data.lastname}`
            return name.length > 20 ? name.substring(0,20)+"..." : name
        } 
    },
    methods: {
        logout() {
            Swal.fire({
                        title: "คุณต้องการออกจากระบบ ?",
                        icon: 'warning',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        showCancelButton: true,
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'ใช่',
                        cancelButtonText: 'ไม่ใช่'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire({
                                title: 'ออกจากระบบเรียบร้อยแล้ว',
                                icon: 'success',
                                timer: '1500',
                                showConfirmButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false
                            }).then((result) => {
                                localStorage.clear(),
                                location.assign("index")
                            })
                        }
                    })
        },
        progressBar(){
            window.addEventListener('scroll', function() {
                let wintop = this.scrollY
                let winheight = this.innerHeight
                let docheight = document.querySelector("body").offsetHeight
                let totalScroll = ( wintop/(docheight-winheight) ) * 100
                let bar = document.querySelector(".progressBar")
                bar.style.width = `${totalScroll}%`
            })
        },
        eventScroll(navbar) {
            window.addEventListener('scroll', function() {
                let wintop = this.scrollY
                if (wintop > 50) {
                    navbar.classList.remove("navbar-dark")
                    navbar.classList.add("navbar-light","bg-light","shadow-sm")                
                } else {
                    navbar.classList.remove("navbar-light","bg-light","shadow-sm")
                    navbar.classList.add("navbar-dark")
                }
            })
        }
    }
}
</script>

<style scoped>
</style>