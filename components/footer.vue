<template>
  <footer class="site-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <h6>About</h6>
                    <p style="text-indent: 1.5rem;">
                        คณะเทคโนโลยีอุตสาหกรรม ได้เริ่มจากการเป็นหน่วยงานในสังกัดคณะวิทยาศาสตร์และเทคโนโลยี ซึ่งมีการเปิดสอนหลักสูตรหัตกรรมศึกษาและอุตสาหกรรมศิลป์ 
                        มาตั้งแต่ปีการศึกษา 2522 ต่อมาได้มีการเปิดสอนในหลักสูตรด้านอุตสาหกรรมที่หลากหลาย เพื่อให้สอดคล้องกับความ ต้องการสภาพเศรษฐกิจ สังคมและเทคโนโลยี 
                        ที่แปรเปลี่ยนเมื่อปีการศึกษา 2543 มีการ เปิดสอนหลักสูตรด้านอุตสาหกรรมมากขึ้น จึงได้จัดตั้งคณะเทคโนโลยีอุตสาหกรรม จนกระทั่งปี พ.ศ. 2547 
                        สถาบันราชภัฏสวนสุนันทาได้เปลี่ยนสภาพเป็นมหาวิทยาลัยราชภัฏสวนสุนันทา ตามพระราชบัญญัติ มหาวิทยาลัยราชภัฏ พ.ศ. 2547 
                    </p>
                    <p> <b>ปรัชญา :</b> ทักษะเป็นเลิศ เชิดชูคุณธรรม ก้าวนํา วิชาการ เชี่ยวชาญเทคโนโลยี </p>
                    <p> <b>วิสัยทัศน์ :</b> หน่วยงานจัดการศึกษาที่มีคุณภาพและ มาตรฐานวิชาชีพ </p>
                    <p> <b>พันธกิจ :</b> ผลิตบัณฑิตที่เน้นทักษะในการประกอบวิชาชีพ มีความรับผิดชอบ มีความพร้อมในการเรียนรู้ทันต่อการเปลี่ยนแปลงอยู่เสมอ
                        การวิจัยที่สามารถนําไปใช้ประโยชน์ และสอดคล้องกับความต้องการของสถานประกอบการหรือชุมชน
                        บริการวิชาการ ให้การบริการวิชาการที่เป็นเอตทัคคะ ที่ตอบและแก้ปัญหาของสังคม โดยการมีส่วนร่วมกับชุมชน ท้องถิ่น และสังคม
                        การทํานุบํารุงศิลปะและวัฒนธรรม ประเพณีไทยและสืบสานวัฒนธรรมวังสวนสุนันทา
                    </p>
                </div>
                <div class="col-md-4">
                    <h6>Categories</h6>
                    <ul class="footer-links">
                        <li><a href="http://www.ce.fit.ssru.ac.th/" target="_blank">สาขาวิชาวิศวกรรมคอมพิวเตอร์</a></li>
                        <li><a href="https://rbe.fit.ssru.ac.th/" target="_blank">สาขาวิชาวิศวกรรมหุ่นยนต์</a></li>
                        <li><a href="http://www.im.fit.ssru.ac.th/home" target="_blank">สาขาวิชาการจัดการวิศวกรรม</a></li>
                        <li><a href="http://www.stoh.fit.ssru.ac.th/home" target="_blank">สาขาวิชาเทคโนโลยีความปลอดภัยและอาชีวอนามัย</a></li>
                        <li><a href="http://www.iet.fit.ssru.ac.th/home" target="_blank">สาขาวิชาเทคโนโลยีไฟฟ้า</a></li>
                        <li><a href="http://real-fm.fit.ssru.ac.th/home" target="_blank">สาขาวิชาการจัดการอสังหาริมทรัพย์และทรัพยากรอาคาร</a></li>
                        <li><a href="http://www.gmd.fit.ssru.ac.th/home" target="_blank">สาขาวิชาการออกแบบกราฟิกและมัลติมีเดีย</a></li>
                        <li><a href="http://www.ied.fit.ssru.ac.th/home" target="_blank">สาขาวิชาการออกแบบนิทรรศการและแอนิเมชันสามมิติ</a></li>
                        <li><a href="http://www.id.fit.ssru.ac.th/home" target="_blank">สาขาวิชาการออกแบบผลิตภัณฑ์และบรรจุภัณฑ์</a></li>
                        <li><a href="http://www.id.fit.ssru.ac.th/home" target="_blank">สาขาวิชาอุตสาหกรรมศิลป์และวิทยาศาสตร์</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h6>Quick Links</h6>
                    <ul class="footer-links">
                        <li><a href="https://fit.ssru.ac.th/" target="_blank">FIT SSRU</a></li>
                        <li><a href="register" v-if="!auth.data">สมัครสมาชิก</a></li>
                        <li><a href="login" v-if="!auth.data">เข้าสู่ระบบ</a></li>
                    </ul>
                </div>
            </div>
            <hr>
        </div>
        <div class="container">
            <div class="row text-center text-md-start">
                <div class="col-12 col-md-8">
                    <p>
                        Copyright &copy; 2022 All Rights Reserved by
                        <a href="http://www.ce.fit.ssru.ac.th/" target="_blank"> Computer Engineering.</a>
                    </p>
                </div>
                <div class="col-12 col-md-4">
                    <ul class="social-icons text-center text-md-end">
                        <li>
                            <a href="https://www.facebook.com/ComputerEngineeringSSRU/" class="facebook" target="_black"><i class="fab fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="https://www.youtube.com/@cessru672" class="youtube" target="_black"><i class="fab fa-youtube"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
</template>

<script>
module.exports = {
    props: ['auth'],
}
</script>

<style scoped>
  span {
    background-color: yellow;
  }
</style>