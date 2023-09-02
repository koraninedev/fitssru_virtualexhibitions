<?php 
    /**
     * Page Manager Edit Admin
     * 
     * @link https://appzstory.dev
     * @author Yothin Sapsamran (Jame AppzStory Studio)
     */
    require_once('../authen.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>จัดการผู้ดูแลระบบ | Admin FIT SSRU</title>
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
        $selectbyidUser = $connect->prepare("SELECT * FROM users_admin WHERE u_id = :u_id");
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
                                    <i class="fas fa-sitemap"></i> 
                                    แก้ไขข้อมูลผู้จัดนิทรรศการ
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

                                            <div class="form-group">
                                                <label for="first_name">ชื่อสาขา</label>
                                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="ชื่อจริง" value="<?php echo $row['name'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="last_name">ชื่อผู้ใช้งาน</label>
                                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="นามสกุล" value="<?php echo $row['username'] ?>">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">แก้ไขรหัสผ่าน</label>
                                                <input type="password" class="form-control" name="password" id="password" placeholder="รหัสผ่าน">
                                            </div>

                                        </div>
                                        <div class="col-md-6 px-1 px-md-5">

                                            <div class="form-group">
                                                <label for="customFile">รูปภาพสาขา</label>
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" accept="image/*">
                                                    <label class="custom-file-label" for="customFile">เลือกรูปภาพใหม่</label>
                                                </div>
                                                <div class="image-preview mt-2" id="customFile-preview" style="display: none; position: relative;"></div>
                                                <?php
                                                    if (!empty($row['image'])) {
                                                        echo '<img src="../../assets/images/'. $row['image'] .'" alt="Image Profile" class="img-fluid">';
                                                    }
                                                ?>
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
        $('#formData').submit(function (e) {
            e.preventDefault();
            $.ajax({
                type: 'PUT',
                url: '../../service/manager/update.php',
                data: $('#formData').serialize()
            }).done(function(resp) {
                Swal.fire({
                    text: 'อัพเดทข้อมูลเรียบร้อย',
                    icon: 'success',
                    confirmButtonText: 'ตกลง',
                }).then((result) => {
                    location.assign('./');
                });
            })
        });
    });

    $("#customFile").change(function() {
            imagePreview("customFile");
    });

    function imagePreview(inputId) {
            const files = $("#" + inputId)[0].files;
            const imagePreviewContainer = $("#" + inputId + "-preview");
            imagePreviewContainer.empty();

            if (files.length > 0) {
                imagePreviewContainer.show();

                for (let i = 0; i < files.length; i++) {
                    if (files[i].type.startsWith("image/")) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const img = $("<img>").attr({
                                "src": e.target.result,
                                "alt": "Image Preview",
                                "width": "150",
                                "height": "150",
                                "style": "margin-right: 5px;"
                            });
                            imagePreviewContainer.append(img);
                        };
                        reader.readAsDataURL(files[i]);
                    }
                }
                $("#" + inputId).siblings(".remove-image").show();
            } else {
                imagePreviewContainer.hide();
                $("#" + inputId).siblings(".remove-image").hide();
            }

            const label = $("#" + inputId).siblings(".custom-file-label");
            if (files.length > 0) {
                let fileNameList = "";
                for (let i = 0; i < files.length; i++) {
                    fileNameList += files[i].name;
                    if (i < files.length - 1) {
                        fileNameList += ", ";
                    }
                }
                label.text(fileNameList);
            } else {
                label.text("เลือกรูปภาพ");
            }
        }
</script>

</body>
</html>
