<?php 
  /**
   * Login Page
   *
   * @link https://appzstory.dev
   * @author Yothin Sapsamran (Jame AppzStory Studio)
   */  
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>FIT SSRU Virtual Exhibitions Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico">
  <!-- stylesheet -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
  <link rel="stylesheet" href="assets/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>
</head>
<body>
<header class="bg"></header>
<section class="d-flex align-items-center min-vh-100">
  <div class="container">
    <div class="row justify-content-center">
      <section class="col-lg-6">
        <div class="card shadow p-3 p-md-4">
          <img src="../assets/images/text_logo.png" class="img-fluid d-block mx-auto" style="height: 150px; margin: 0 0 12px;">
          <h4 style="color: rgba(0, 0, 0, 0.38); font-weight: 500; font-size: 1rem;" class="text-center">เข้าสู่ระบบหลังบ้าน</h4> 
          <div class="card-body">
            <!-- HTML Form Login --> 
            <form id="formLogin">
              <div class="form-group col-sm-12">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text px-2">ชื่อผู้ใช้งาน</div>
                  </div>
                  <input type="text" class="form-control" name="username" placeholder="username">
                </div>
              </div>
              <div class="form-group col-sm-12">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <div class="input-group-text px-3">รหัสผ่าน</div>
                  </div>
                  <input type="password" class="form-control" name="password" placeholder="password">
                </div>
              </div>
              <button type="submit" name="login" class="btn btn-block"> เข้าสู่ระบบ</button>
            </form>
          </div>
        </div>
      </section>
    </div>
  </div>
</section>

<!-- script -->
<script src="plugins/jquery/jquery.min.js"></script>
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="plugins/toastr/toastr.min.js"></script>
<script>
  $(function() {
    /** Ajax Submit Login */
    $("#formLogin").submit(function(e){
      e.preventDefault()
      $.ajax({
        type: "POST",
        url: "service/auth/login.php",
        data: $(this).serialize()
      }).done(function(resp) {
         Swal.fire({
          icon: 'success',
          title: 'เข้าสู่ระบบเรียบร้อยแล้ว',
          showConfirmButton: false,
          timer: 1500
        }).then((result) => {
          if (result) {
            location.href = 'pages/dashboard/'
          }
        })
      }).fail(function(resp) {
        Swal.fire({
          icon: 'error',
          title: 'ไม่สามารถเข้าสู่ระบบได้',
          text: resp['responseJSON']['message'],
          showConfirmButton: false,
          timer: 1500
        })
      })
    })
  })
</script>
</body>
</html>
