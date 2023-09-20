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
        $selectbyidPic = $connect->prepare("SELECT * FROM blogs WHERE blog_id = :blog_id");
        $selectbyidPic->execute($params);
        $row = $selectbyidPic->fetch(PDO::FETCH_ASSOC);

        $rowVids = $connect->prepare("SELECT * FROM videos WHERE blog_id = :blog_id");
        $rowVids->execute($params);
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
                                    <i class="fas fa-video"></i> 
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
                                        <input name="branch_name" value="<?php echo $row['branch_name']?>" style="display: none;">
                                        <div class="form-group col-md-4">
                                            <label for="cat_name">ประเภทบทความ</label>
                                            <select class="custom-select mb-3" disabled  id="category">
                                                <option disabled selected data-category="<?php echo $row['category'] ?>">วิดีโอ</option>
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
                                                    echo '<img src="../../../assets/videos/' . $branchName . '/thumbnails/' . $row['image'] . '" class="img-fluid mt-2" width="150px">';
                                                }
                                            ?>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="images">วิดีโอภายในบทความ</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="videos" name="video[]" accept="video/*">
                                                <label class="custom-file-label" for="videos">เลือกวิดีโอ</label>
                                            </div>
                                            <div id="videos-preview"></div>
                                            <?php
                                                if (!empty($rowVids)) {
                                                    foreach ($rowVids as $rowVid) {
                                                        echo '<div class="video-with-delete" style="position: relative; display: inline-block;">';
                                                        echo '<video controls src="../../../assets/videos/' . $branchName . '/videos/' . $rowVid['video'] . '" class="video-fluid mt-2" width="100%" style="margin-right: 5px;"></video>';
                                                        echo '<input type="hidden" name="name_video" value="' . $rowVid['video'] . '">';
                                                        echo '<span class="delete-overlay" data-video-id="' . $rowVid['id'] . '" style="position: absolute; top: 5px; right: 5px; background-color: #dc3545; color: white; font-weight: bold; padding: 5px; cursor: pointer; z-index: 1;">X</span>';
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
                url: '../../service/videos/update.php',
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

        $("#videos").change(function() {
            videoPreview("videos");
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

        function videoPreview(inputId) {
            const files = $("#" + inputId)[0].files;
            const videoPreviewContainer = $("#videos-preview");
            videoPreviewContainer.empty();

            if (files.length > 0) {
                videoPreviewContainer.show();

                for (let i = 0; i < files.length; i++) {
                    if (files[i].type.startsWith("video/")) {
                        const video = $("<video controls>").attr({
                            "src": URL.createObjectURL(files[i]),
                            "alt": "Video Preview",
                            "width": "150",
                            "height": "150",
                            "style": "margin-right: 5px; margin-top: -25px;"
                        });
                        videoPreviewContainer.append(video);
                    }
                }
            } else {
                videoPreviewContainer.hide();
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
                    label.text("เลือกวิดีโอ");
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
            const videoId = $deleteOverlay.data("video-id");
            
            Swal.fire({
                icon: 'question',
                title: 'คุณต้องลบวิดีโอนี้หรือไม่ ?',
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
                        url: "../../service/videos/delete_video.php",
                        data: { videoId: videoId },
                        success: function(response) {
                            $deleteOverlay.parent().remove();
                            Swal.fire({
                                icon: 'success',
                                title: 'ลบวิดีโอเรียบร้อยแล้ว',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(xhr.responseText);
                            Swal.fire({
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาดขณะลบวิดีโอ',
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
