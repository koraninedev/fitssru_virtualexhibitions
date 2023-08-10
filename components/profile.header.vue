<template>
    <header>
        <section class="profile-page d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-11">
                        <div class="position-relative">
                            <img  class="cover"  :src="`assets/images/uploads/${auth.data.image_cover}`" alt="">   
                            <button class="btn btn-upload-cover" data-bs-toggle="modal" data-bs-target="#modalCover">
                                <i class="fas fa-camera"></i> 
                                แก้ไขรูปภาพหน้าปก
                            </button> 
                        </div>
                        <!-- Modal Upload Cover -->
                        <div class="modal fade" id="modalCover" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">อัพโหลดรูปภาพใหม่</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="modal-body">
                                            <img v-if="imageCover" :src="imageCover" class="img-fluid" alt="">
                                            <div class="mt-3">
                                                <label for="imageCover" class="form-label">เลือกรูปภาพปก</label>
                                                <input class="form-control" type="file" id="imageCover" @change="onFileSelected($event, 'cover')" accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        <button type="button" class="btn btn-info text-white" @click="onUpload('uploadcover')" v-if="imageCover">อัพโหลดรูปภาพ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-11">
                        <div class="position-relative">
                            <img class="avatar" :src="`assets/images/uploads/${auth.data.image}`" alt="">
                            <button type="button" class="btn-upload-profile" data-bs-toggle="modal" data-bs-target="#modalProfile">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        <!-- Modal Upload Profile -->
                        <div class="modal fade" id="modalProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">อัพโหลดรูปภาพใหม่</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="modal-body">
                                            <img v-if="imageProfile" :src="imageProfile" class="profile-modal-image" alt="">
                                            <div class="mt-3">
                                                <label for="imageProfile" class="form-label">เลือกรูปภาพโปรไฟล์</label>
                                                <input class="form-control" type="file" id="imageProfile" @change="onFileSelected($event,'profile')"  accept="image/*">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                        <button type="button" class="btn btn-info text-white" @click="onUpload('uploadimage')" v-if="imageProfile">อัพโหลดรูปภาพ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                </div>
            </div>
        </section>
        <section class="container">
            <h1 class="text-center fw-bolder" v-once v-text="fullname" ></h1>
            <p class="text-center text-mute" v-once v-text="auth.data.introduce"></p>
            <hr class="w-75 mx-auto">
        </section>
    </header>
</template>
<script>
module.exports = {
    props: ['auth'],
    data() {
        return {
            selectedFile: null,
            imageProfile: null,
            imageCover: null
        }
    },
    computed: {
        fullname() {
            return `${this.auth.data.firstname} ${this.auth.data.lastname}` //รวมชื่อ นามสกุล
        }
    },
    mounted() {
        document.querySelectorAll(".modal").forEach((element) => {  // selector ทุอย่างที่มี class modal หลังจากนั้นนำไป loop
            element.addEventListener("hidden.bs.modal", () => { // ดักจับเหตการณ์ modal close
                this.selectedFile = null  // สั่งให้ค่า Data ต่างๆ เป็น Null
                this.imageProfile = null
                this.imageCover = null
                document.getElementById('imageProfile').value = null;
                document.getElementById('imageCover').value = null;
            })
        })
    },  
    methods: {
        onFileSelected (event, group) {
            this.selectedFile = event.target.files[0] // เก็บข้อมูลไฟล์อัพโหลดไว้ใน Data
            const size = event.target.files[0].size / 1024 / 1024
            if (this.selectedFile && size.toFixed(2) < 2) {
                const imageType = '|jpg|png|jpeg|gif|' //นามสกุลรูปภาพที่ใช้งาน
                const type = this.selectedFile.type.split('/') // แยกชุดตัวอักษรจากอักขระ "/" ค่าที่ได้ออกมาคือ array
                if (imageType.indexOf(type[1]) !== -1) { // indexOf: ได้ index ของ array แรกที่เจอเหมือนกัน ถ้าไม่เจอจะ return ค่า -1
                    const reader = new FileReader() // สร้าง FileReader Object  สำหรับอ่านไฟล์ใน input
                    reader.onload = (e) => { //onload สั่งให้ทำงานในการโหลดไฟล์
                        if (group == 'profile') {
                            this.imageProfile = e.target.result
                        } else {
                            this.imageCover = e.target.result
                        }
                    }
                    reader.readAsDataURL(this.selectedFile) // อ่านรูปภาพ  
                } else {
                    Swal.fire({ 
                        position: 'center',
                        icon: 'warning',
                        text: `ต้องเป็นไฟล์นามสกุล jpg, png, jpeg, gif เท่านั้น`,
                        showConfirmButton: true,
                    }).then(() => {
                        location.reload()
                    })
                }
            } else {
                Swal.fire({ 
                    position: 'center',
                    icon: 'warning',
                    html: `ไฟล์มีขนาดใหญ่เกิน 2MB`,
                    showConfirmButton: true,
                }).then(() => {
                    location.reload()
                })
            }
        },
        onUpload(path){
            const fd = new FormData() // สร้าง FormData Object
            fd.append('file', this.selectedFile) // เตรียมข้อมูล form สำหรับส่งด้วย FormData Object
            axios({ //ส่งข้อมูลรูปภาพผ่านทาง API ด้วย method POST ตาม path ที่ส่งมา
                method: 'post',
                url: '/user/' + path,
                data: fd,
                headers: {
                    Authorization: 'Bearer ' + this.auth.token, // แนบ token เพื่อยืนยันสิทธิ์การเข้าถึงข้อมูล
                } 
            }).then((response) => {
                Swal.fire({ 
                    position: 'center',
                    icon: 'success',
                    text: response.data.message,
                    showConfirmButton: true,
                }).then(() => {
                    location.reload()
                })
            }).catch((error) => {
                Swal.fire({ 
                    position: 'center',
                    icon: 'error',
                    text: error.response.data.message,
                    showConfirmButton: true,
                }).then(() => {
                    location.reload()
                })
            })
        }
    }
}
</script>

<style scoped>
  span {
    background-color: yellow;
  }
</style>