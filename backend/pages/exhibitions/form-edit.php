<?php 
    require_once('../authen.php'); 
?>
<?php if ($_SESSION['AD_STATUS'] === 'superadmin') { ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>จัดการชื่อนิทรรศการ| Admin FIT SSRU</title>
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
  <!-- stylesheet -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit" >
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css">

    <?php
        $id = $_GET['id'];

        $params = array('id' => $id);
        $selectbyidHallname = $connect->prepare("SELECT * FROM namehall WHERE id = :id");
        $selectbyidHallname->execute($params);
        $row = $selectbyidHallname->fetch(PDO::FETCH_ASSOC);
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
                                    <i class="fas fa-box"></i> 
                                    แก้ไขชื่อนิทรรศการ
                                </h4>
                                <a href="./" class="btn btn-info my-3 ">
                                    <i class="fas fa-list"></i>
                                    กลับหน้าหลัก
                                </a>
                            </div>
                            <form id="formData">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12 px-1 px-md-5">
                                            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>">
                                            <div class="form-group">
                                                <label for="namehall">ชื่อนิทรรศการ</label>
                                                <input type="text" class="form-control" name="namehall" id="namehall" placeholder="ชื่อนิทรรศการ" value="<?php echo $row['name_hall'] ?>">
                                            </div>
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
                url: '../../service/exhibitions/update.php',
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