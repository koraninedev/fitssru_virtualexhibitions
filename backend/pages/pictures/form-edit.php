<?php 
    /**
     * Page Manager
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
        $selectbyidPic = $connect->prepare("SELECT * FROM blogs WHERE blog_id = :blog_id");
        $selectbyidPic->execute($params);
        $row = $selectbyidPic->fetch(PDO::FETCH_ASSOC);

        $rowPics = $connect->prepare("SELECT * FROM pictures WHERE blog_id = :blog_id");
        $rowPics->execute($params);
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
  </style>

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
                        <div class="card">
                            <div class="card-header border-0 pt-4">
                                <h4> 
                                    <i class="fas fa-images"></i> 
                                    แก้ไขบทความ
                                </h4>
                                <a href="./" class="btn btn-info mt-3">
                                    <i class="fas fa-list"></i>
                                    กลับหน้าหลัก
                                </a>
                            </div>
                            <form id="formData">
                                <div class="card-body">
                                    <div class="form-row">
                                        <input type="hidden" name="blog_id" value="<?php echo $_GET['id']; ?>">
                                        <input name="branch_name" value="<?php echo $row['branch_name']?>" style="display: none;">
                                        <div class="form-group col-md-4">
                                            <label for="cat_name">ประเภทบทความ</label>
                                            <select class="custom-select mb-3" disabled  id="category">
                                                <option disabled selected data-category="<?php echo $row['category'] ?>">รูปภาพ</option>
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
                                                    echo '<img src="../../../assets/pictures/' . $_SESSION['AD_BRANCH_NAME'] . '/thumbnails/' . $row['image'] . '" class="img-fluid mt-2" width="150px">';
                                                }
                                            ?>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="images">รูปภาพภายในบทความ (สามารถเลือกได้มากกว่า 1 รูป)</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="images" name="images[]" multiple>
                                                <label class="custom-file-label" for="images">เลือกรูปภาพ</label>
                                            </div>
                                            <div class="image-preview mt-2" id="images-preview" style="display: none;"></div>
                                            <div class="image-container" style="position: relative;">
                                                <?php
                                                    if (!empty($rowPics)) {
                                                        foreach ($rowPics as $rowPic) {
                                                            echo '<div class="image-with-delete">';
                                                            echo '<img src="../../../assets/pictures/' . $_SESSION['AD_BRANCH_NAME'] . '/images/' . $rowPic['image'] . '" class="img-fluid mt-2" width="150px" style="margin-right: 5px;">';
                                                            echo '<span class="delete-overlay" data-image-id="' . $rowPic['id'] . '">X</span>';
                                                            echo '</div>';
                                                        }
                                                    }
                                                ?>
                                            </div>
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
    $(function() {

        $('#formData').on('submit', function (e) {
            e.preventDefault();

            const selectedCategory = $("#category option:selected");
            const selectedStatus = $("#status option:selected");
            const dataTypeCategory = selectedCategory.data("category");
            const dataTypeStatus = selectedStatus.data("status");
            const blogId = $("input[name='blog_id']").val();
            const nameOriginalThumbnail = $("input[name='name_thumbnail']").val();

            const formData = new FormData($('#formData')[0]);
            formData.append('category', dataTypeCategory);
            formData.append('status', dataTypeStatus);

            $.ajax({
                type: 'POST',
                url: '../../service/pictures/update.php',
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

        $("#thumbnail").change(function() {
            imagePreview("thumbnail");
        });

        $("#images").change(function() {
            imagePreview("images");
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

        // Add event listener to the remove buttons
        $(".remove-image").on("click", function() {
            const inputId = $(this).siblings(".custom-file-input").attr("id");
            $("#" + inputId).val("");
            imagePreview(inputId);
        });

        // When the form loads, show the remove buttons for existing images
        $(".custom-file-input").each(function() {
            const inputId = $(this).attr("id");
            imagePreview(inputId);
        });

        if ($("#thumbnail-preview img").length > 0) {
            $("#delete-original-image").show();
        }

        $(".delete-overlay").on("click", function() {
            const $deleteOverlay = $(this); // Store a reference to the clicked overlay
            const imageId = $deleteOverlay.data("image-id");
            
            Swal.fire({
                icon: 'question',
                title: 'คุณต้องลบรูปภาพนี้หรือไม่ ?',
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
                        url: "../../service/pictures/delete_image.php",
                        data: { imageId: imageId },
                        success: function(response) {
                            $deleteOverlay.parent().remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'ลบรูปภาพเรียบร้อยแล้ว',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาดขณะลบรูปภาพ',
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
