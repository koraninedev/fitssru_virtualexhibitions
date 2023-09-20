<?php 
    require_once('../authen.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>จัดการบทความ | Admin FIT SSRU</title>
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
  <!-- stylesheet -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit" >
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css">

  <?php

        $blog_id = $_GET['id'];

        $params = array('blog_id' => $blog_id);
        $selectbyid3d = $connect->prepare("SELECT * FROM blogs WHERE blog_id = :blog_id");
        $selectbyid3d->execute($params);
        $row = $selectbyid3d->fetch(PDO::FETCH_ASSOC);

        $row3ds = $connect->prepare("SELECT * FROM 3dmodels WHERE blog_id = :blog_id");
        $row3ds->execute($params);
  ?>

  <style>
    .image-container {
        position: relative;
        display: flex;
        flex-wrap: wrap;
    }

    .image-with-delete {
        position: relative;
        margin-right: 10px;
        margin-bottom: 10px;
    }

    .delete-overlay,
    .remove-image {
        position: absolute;
        top: 7px;
        right: 5px;
        background-color: #dc3545;
        color: white;
        font-weight: bold;
        padding: 5px;
        cursor: pointer;
        z-index: 1;
    }

    .models-preview-container {
        border: 1px solid #ccc;
        padding: 10px;
        margin-top: 5px;
        display: none;
        max-width: auto;
    }

    .models-preview-item {
        margin-bottom: 5px;
    }
  </style>

</head>
<body class="hold-transition sidebar-mini">
<?php 
    if (isset($_GET['page'])) {
        $branchName = $_GET['page'];
    } else {
        $branchName = $row['branch_name'];
    }                                        
 ?>
<div class="wrapper">
    <?php include_once('../includes/sidebar.php') ?>
    <div class="content-wrapper pt-3">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header border-0 pt-4">
                                <h4> 
                                    <i class="fas fa-cube"></i> 
                                    แก้ไขบทความ <?php if($_SESSION['AD_BRANCH_NAME'] == "superadmin") echo "(" . strtoupper($branchName) . ")" ?>
                                </h4>
                                <a href="./<?php echo isset($_GET['page']) ? '?page=' . $_GET['page'] : ''; ?>" class="btn btn-info mt-3">
                                    <i class="fas fa-list"></i>
                                    กลับหน้าหลัก
                                </a>
                            </div>
                            <form id="formData">
                                <div class="card-body">
                                    <div class="form-row">
                                        <input type="hidden" name="blog_id" value="<?php echo $_GET['id']; ?>">
                                        <input name="branch_name" value="<?php echo $branchName?>" style="display: none;">
                                        <div class="form-group col-md-4">
                                            <label for="cat_name">ประเภทบทความ</label>
                                            <select class="custom-select mb-3" disabled  id="category">
                                                <option disabled selected data-category="<?php echo $row['category'] ?>">3D Models</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="subject">เรื่อง</label>
                                            <input type="text" class="form-control" name="subject" id="subject" placeholder="เรื่อง" value="<?php echo $row['subject'] ?>">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="subtitle">คำบรรยาย</label>
                                            <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="คำบรรยายสั้นๆ" value="<?php echo $row['subtitle'] ?>">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="thumbnail">รูปปกบทความ</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail">
                                                <input type="hidden" name="name_thumbnail" value="<?php echo $row['image'] ?>">
                                                <label class="custom-file-label" for="thumbnail">เลือกรูปภาพ</label>
                                            </div>
                                            <div class="image-preview mt-2" id="thumbnail-preview" style="display: none; position: relative;"></div>
                                            <?php
                                                if (!empty($row['image'])) {
                                                    if (isset($_GET['page'])) {
                                                        $branchName = $_GET['page'];
                                                    } else {
                                                        $branchName = $_SESSION['AD_BRANCH_NAME'];
                                                    }
                                                    echo '<img src="../../../assets/3dmodels/' . $branchName . '/thumbnails/' . $row['image'] . '" class="img-fluid mt-2" width="150px">';
                                                }
                                            ?>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="images">โมเดลภายในบทความ (.obj)</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="models" name="model[]" accept=".obj">
                                                <label class="custom-file-label" for="models">เลือกโมเดล</label>
                                            </div>
                                            <div id="models-preview" class="models-preview-container"></div>
                                            <?php
                                                if (!empty($row3ds)) {
                                                    foreach ($row3ds as $row3d) {
                                                        echo '<div class="models-preview-container" style="position: relative; display: inline-block; width: 100%;">';
                                                        echo '<div class="models-preview-item">' . $row3d['model'] . '</div>';
                                                        echo '<input type="hidden" name="name_model" value="' . $row3d['model'] . '">';
                                                        echo '<span class="delete-overlay" data-model-id="' . $row3d['id'] . '" style="position: absolute; top: 50%; transform: translateY(-50%); right: 5px; background-color: #dc3545; color: white; font-weight: bold; padding: 5px; cursor: pointer; z-index: 1;">X</span>';
                                                        echo '</div>';
                                                    }
                                                }
                                            ?>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="url">URL สั้น</label>
                                            <input type="text" class="form-control" name="url" id="url" placeholder="Url บทความเช่น arduino , ชื่อผลงานสั้นๆ" value="<?php echo $row['url'] ?>">
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="url">สถานะของบทความ</label>
                                            <?php
                                                echo '<select class="custom-select mb-3" id="status">';

                                                if ($row['blog_status'] == true) {
                                                    echo '<option selected data-status="true">เผยแพร่</option>';
                                                    echo '<option data-status=" ">ไม่เผยแพร่</option>';
                                                } else if ($row['blog_status'] == ""){
                                                    echo '<option data-status="true">เผยแพร่</option>';
                                                    echo '<option selected data-status=" ">ไม่เผยแพร่</option>';
                                                }
                                                
                                                echo '</select>';
                                            ?>                      
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="detail">รายละเอียดของบทความ</label>
                                            <textarea id="detail" class="form-control" name="detail" style="height: 300px;" placeholder="กรอกรายละเอียดของบทความ..."><?php echo $row['detail'] ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary btn-block mx-auto w-75" name="submit">บันทึกข้อมูล</button>
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

<!-- scripts -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../../plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="../../plugins/summernote/summernote-bs4.min.js"></script>
<script src="../../assets/js/adminlte.min.js"></script>

<script>
    
</script>

<script>
    $(function() {

        $('#formData').on('submit', function (e) {
            e.preventDefault();

            <?php
                $redirectURL = isset($_GET['page']) ? './?page=' . $_GET['page'] : './';
            ?>
            var redirectURL = '<?php echo $redirectURL; ?>';

            const selectedCategory = $("#category option:selected");
            const selectedStatus = $("#status option:selected");
            const dataTypeCategory = selectedCategory.data("category");
            const dataTypeStatus = selectedStatus.data("status");
            const blogId = $("input[name='blog_id']").val();
            const nameOriginalThumbnail = $("input[name='name_thumbnail']").val();
            const nameOriginalVideo = $("input[name='name_video']").val();

            const formData = new FormData($('#formData')[0]);
            formData.append('category', dataTypeCategory);
            formData.append('status', dataTypeStatus);

            $.ajax({
                type: 'POST',
                url: '../../service/3dmodels/update.php',
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
                        location.assign(redirectURL);
                    });
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'อัพเดทข้อมูลล้มเหลวกรุณาลองใหม่',
                        showConfirmButton: false,
                        timer: 1500
                    })/* ; */.then((result) => {
                        location.assign(redirectURL);
                    });
                }
            });
        });

        $("#thumbnail").change(function() {
            imagePreview("thumbnail");
        });

        $("#models").change(function() {
            modelPreview("models");
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

            const label = $("#" + inputId).siblings(".custom-file-label .thumbnail");
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

        function modelPreview(inputId) {
            const files = $("#" + inputId)[0].files;
            const modelsPreviewContainer = $("#models-preview");
            modelsPreviewContainer.empty();

            if (files.length > 0) {
                modelsPreviewContainer.show();

                for (let i = 0; i < files.length; i++) {
                    if (files[i].name.toLowerCase().endsWith(".obj")) {
                        const modelName = $("<div>").addClass("models-preview-item").text(files[i].name);
                        modelsPreviewContainer.append(modelName);
                    }
                }
            } else {
                modelsPreviewContainer.hide();
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
                label.text("เลือกโมเดล");
            }
        }

        $(".custom-file-input").each(function() {
            const inputId = $(this).attr("id");
            imagePreview(inputId);
        });

        if ($("#thumbnail-preview img").length > 0) {
            $("#delete-original-image").show();
        }

        $(".delete-overlay").on("click", function() {
            const $deleteOverlay = $(this);
            const modelId = $deleteOverlay.data("model-id");
            
            Swal.fire({
                icon: 'question',
                title: 'คุณต้องลบโมเดลนี้หรือไม่ ?',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                reverseButtons: true,
                focusCancel: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "../../service/3dmodels/delete_model.php",
                        data: { modelId: modelId },
                        success: function(response) {
                            $deleteOverlay.parent().remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'ลบโมเดลเรียบร้อยแล้ว',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาดขณะลบโมเดล',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            });
        });
    });
</script>
</body>
</html>
