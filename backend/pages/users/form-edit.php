<?php 
    /**
     * Page Manager Edit Admin
     * 
     * @link https://appzstory.dev
     * @author Yothin Sapsamran (Jame AppzStory Studio)
     */
    require_once('../authen.php'); 
?>
<?php if ($_SESSION['AD_STATUS'] === 'superadmin') { ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>จัดการผู้เข้าชม | Admin FIT SSRU</title>
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
  <!-- stylesheet -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit" >
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css">

    <?php
        $u_id = $_GET['id'];

        $params = array('u_id' => $u_id);
        $selectbyidUser = $connect->prepare("SELECT * FROM users WHERE u_id = :u_id");
        $selectbyidUser->execute($params);
        $row = $selectbyidUser->fetch(PDO::FETCH_ASSOC);
    ?>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include_once('../includes/sidebar.php') ?>
    <div class="content-wrapper pt-3">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card shadow">
                            <div class="card-header border-0 pt-4">
                                <h4>
                                    <i class="fas fa-user"></i> 
                                    แก้ไขข้อมูลผู้เข้าชม
                                </h4>
                                <a href="./" class="btn btn-info my-3 ">
                                    <i class="fas fa-list"></i>
                                    กลับหน้าหลัก
                                </a>
                            </div>
                            <form id="formData">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 px-1 px-md-5">
                                            <input type="hidden" name="u_id" value="<?php echo $_GET['id']; ?>">
                                            <div class="form-group">
                                                <label for="firstname">ชื่อจริง</label>
                                                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="ชื่อจริง" value="<?php echo $row['firstname'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="lastname">นามสกุล</label>
                                                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="นามสกุล" value="<?php echo $row['lastname'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">อีเมล</label>
                                                <input type="email" class="form-control" name="email" id="email" placeholder="อีเมล" value="<?php echo $row['email'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">แก้ไขรหัสผ่าน</label>
                                                <input type="password" class="form-control" name="password" id="password" placeholder="รหัสผ่าน">
                                            </div>

                                        </div>
                                        <div class="col-md-6 text-center">
                                            <img src="../../../assets/images/uploads/<?php echo $row['image'] ?>" alt="Image Profile" class="img-fluid pt-2" width="250px" height="250px">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-block mx-auto w-50" name="submit">บันทึกข้อมูล</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('../includes/footer.php') ?>
</div>
<!-- SCRIPTS -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../assets/js/adminlte.min.js"></script>

<script>
     $(function() {
        $('#formData').on('submit', function (e) {
            e.preventDefault();

            const formData = new FormData($('#formData')[0]);

            $.ajax({
                type: 'POST',
                url: '../../service/users/update.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function (resp) {
                    Swal.fire({
                        icon: 'success',
                        title: 'อัพเดทข้อมูลเรียบร้อยแล้ว',
                        showConfirmButton: false,
                        timer: 1500
                    })/* ; */.then((result) => {
                        location.assign('./');
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'อัพเดทข้อมูลล้มเหลวกรุณาลองใหม่',
                        showConfirmButton: false,
                        timer: 1500
                    })/* ; */.then((result) => {
                        location.assign('./');
                    });
                }
            });
        });
    });
</script>

</body>
</html>
<?php 
    } else {
        
        echo "<script>
                window.location.href = '../dashboard';
            </script>";

        exit;
    } 
?>