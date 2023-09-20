<template>
    <section>
        <div class="row mt-5 mb-5 align-items-center">
                <div class="col-lg-6 col-sm-12">
                    <p class="fw-bold" style="font-size: 30px; margin-bottom: 10px;">ยินดีต้อนรับเข้าสู่</p>
                    <p class="fw-bold" style="font-size: 30px; color: #CF242B;">แอปพลิเคชันนิทรรศการเสมือนจริง</p>
                    <p style="color: #707070; text-indent: 1.5em; text-align: justify;">เว็บไซต์ของเราให้บริการสำหรับนิทรรศการเสมือนจริง และยังสามารถเลือกดูผลงานของแต่ละสาขาได้อีกด้วย
                    ภายในคณะเทคโนโลยีอุตสาหกรรม Branch Workshop เป็นการจัดแสดงผลงานในรูปแบบเว็บบล็อก
                    สามารถแสดงความคิดเห็นได้</p>
                </div>
                <div class="col-lg-6 col-sm-12">
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                          <div class="carousel-item active">
                            <img src="assets/images/slide1.png" class="d-block w-100" alt="">
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                          </div>
                          <div class="carousel-item">
                            <img src="assets/images/slide2.png" class="d-block w-100" alt="">
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                          </div>
                          <div class="carousel-item">
                            <img src="assets/images/slide3.png" class="d-block w-100" alt="">
                            <div class="carousel-caption d-none d-md-block">
                            </div>
                          </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                          <span class="visually-hidden">Next</span>
                        </button>
                    </div>  
                </div>
        </div>
            <div class="row justify-content-center">
                <div class="col-lg-6 col-sm-12 mt-5 mb-5">
                    <center>
                        <p class="fw-bold" style="font-size: 20px;">วัตถุประสงค์ของเว็บแอปพลิเคชัน</p>
                    </center>
                    <center>
                        <p style="color: #707070;">ผู้จัดงานได้เล็งเห็นถึงปัญหาในการจัดนิทรรศการจึงได้คิดจัดทำ Web Application 
                            ที่ใช้จัดเก็บ <br> และแสดงผลงานต่างๆ ของนักศึกษา คณะเทคโนโลยีอุตสาหกรรม และจัดทำ นิทรรศการ 3 มิติ <br>
                            ของคณะเทคโนโลยีอุตสาหกรรมเพื่อนำผลงานนักศึกษา ให้กับประชาชนทั่วไปหรือนักศึกษา
                        </p>
                    </center>
                </div>
            </div>
            <div class="row g-4 mb-5">
                <div class="col-lg-4">
                    <div class="card card-branch">
                        <div class="d-flex justify-content-center mt-4 pt-2">
                            <i class="fas fa-book" style="font-size: 60px;"></i>
                        </div>
                        <div class="card-body pb-3">
                            <p style="font-size: 18px; display: flex; justify-content: center; margin-bottom: 0.3rem;">เรียนรู้</p> 
                            <p style="font-size: 14px; display: flex; justify-content: center; color: #707070; margin-bottom: 0;">เพื่อศึกษาการใช้งานเว็บโฮสติ้ง</p>
                            <p style="font-size: 14px; display: flex; justify-content: center; color: #707070;">นิทรรศการเสมือนจริง</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card card-branch">
                        <div class="d-flex justify-content-center mt-4 pt-2">
                            <i class="fas fa-pencil-ruler" style="font-size: 60px;"></i>
                        </div>
                        <div class="card-body pb-3">
                            <p style="font-size: 18px; display: flex; justify-content: center; margin-bottom: 0.3rem;">ออกแบบ</p> 
                            <p style="font-size: 14px; display: flex; justify-content: center; color: #707070; margin-bottom: 0;">ออกแบบและสร้างเว็บแอปพลิเคชันสำหรับ</p>
                            <p style="font-size: 14px; display: flex; justify-content: center; color: #707070;">จัดนิทรรศการเสมือนจริง</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card card-branch">
                        <div class="d-flex justify-content-center mt-4 pt-2">
                            <i class="fas fa-tachometer-alt" style="font-size: 60px;"></i>
                        </div>
                        <div class="card-body pb-3">
                            <p style="font-size: 18px; display: flex; justify-content: center; margin-bottom: 0.3rem;">ประเมิน</p> 
                            <p style="font-size: 14px; display: flex; justify-content: center; color: #707070; margin-bottom: 0;">เพื่อประเมินเว็บแอปพลิเคชันสำหรับ</p>
                            <p style="font-size: 14px; display: flex; justify-content: center; color: #707070;">การจัดแสดงนิทรรศการเสมือนจริง</p>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</template>