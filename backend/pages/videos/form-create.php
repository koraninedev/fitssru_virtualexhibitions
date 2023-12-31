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
  <title>จัดการบทความวิดีโอ | Admin FIT SSRU</title>
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
  <!-- stylesheet -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit" >
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="../../plugins/summernote/summernote-bs4.css">
  <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css">
  <style>
        .remove-image {
            position: absolute;
            right: 10px;
            top: 5px;
            cursor: pointer;
            display: none;
        }
  </style>

</head>
<body class="hold-transition sidebar-mini">
<?php 
    if (isset($_GET['page'])) {
        $branchName = $_GET['page'];
    } else {
        $branchName = $_SESSION['AD_BRANCH_NAME'];
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
                                    เพิ่มข้อมูลบทความ <?php if($_SESSION['AD_BRANCH_NAME'] == "superadmin") echo "(" . strtoupper($branchName) . ")" ?>
                                </h4>
                                <a href="./<?php echo isset($_GET['page']) ? '?page=' . $_GET['page'] : ''; ?>" class="btn btn-info mt-3">
                                    <i class="fas fa-list"></i>
                                    กลับหน้าหลัก
                                </a>
                            </div>
                            <form id="formData" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-row">
                                        <input name="branch_name" value="<?php echo $branchName ?>" style="display: none;">
                                        <div class="form-group col-md-4">
                                            <label for="cat_name">ประเภทบทความ</label>
                                            <select class="custom-select mb-3" disabled  id="category">
                                                <option disabled selected data-category="video">วิดีโอ</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="subject">เรื่อง</label>
                                            <input type="text" class="form-control" name="subject" id="subject" placeholder="เรื่อง" required>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="subtitle">คำบรรยาย</label>
                                            <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="คำบรรยายสั้นๆ" required>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="thumbnail">รูปปกบทความ</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail" required>
                                                <label class="custom-file-label" for="thumbnail">เลือกรูปภาพ</label>
                                                <span class="remove-image" id="remove-thumbnail" style="display: none;">X</span>
                                            </div>
                                            <div class="image-preview mt-2" id="thumbnail-preview" style="display: none;"></div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="images">วิดีโอภายในบทความ</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="videos" name="video[]" accept="video/*" required>
                                                <label class="custom-file-label" for="images">เลือกวิดีโอ</label>
                                            </div>
                                            <div id="videos-preview"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="url">URL สั้น (แสดงบน URL **ห้ามซ้ำกับบทความอื่นๆ**)</label>
                                            <input type="text" class="form-control" name="url" id="url" placeholder="Url บทความเช่น arduino , ชื่อผลงานสั้นๆ" required>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label for="url">สถานะของบทความ</label>
                                            <select class="custom-select mb-3" id="status">
                                                    <option selected data-status="true">เผยแพร่</option>
                                                    <option data-status=" ">ไม่เผยแพร่</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="detail">รายละเอียดของบทความ</label>
                                            <textarea id="detail" class="form-control" name="detail" style="height: 300px;" placeholder="กรอกรายละเอียดของบทความ..." required></textarea>
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
        /* $('#detail').summernote({
            height: 300,
        }); */

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

            const formData = new FormData($('#formData')[0]);
            formData.append("category", dataTypeCategory);
            formData.append("status", dataTypeStatus);

            var loadingPopup = Swal.fire({
                title: 'กำลังดำเนินการ...',
                icon: 'info',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false
            });

            $.ajax({
                type: 'POST',
                url: '../../service/videos/create.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function (resp) {
                        loadingPopup.close();
                        Swal.fire({
                        text: 'เพิ่มข้อมูลเรียบร้อย',
                        icon: 'success',
                        confirmButtonText: 'ตกลง',
                    }).then((result) => {
                        location.assign(redirectURL);
                    });
                },
                error: function (xhr, status, error) {
                    console.log('AJAX Error:', xhr, status, error);
                    loadingPopup.close();

                    if (xhr.responseText) {
                        errorMessage = xhr.responseText;
                    }

                    Swal.fire({
                        text: xhr.responseJSON.message,
                        icon: 'error',
                        confirmButtonText: 'ตกลง'
                    });
                },
            })
        });

        $("#thumbnail").on('click', function() {
            this.value = '';
        }).on('change', handleFileChange);

        $("#videos").change(function() {
            videoPreview("videos");
        });

        function handleFileChange() {
            const inputId = $(this).attr('id');
            const files = $(this).get(0).files;
            
            if (!files.length) return;
            
            if (!checkFileExtension(files[0].name)) {
                Swal.fire({
                    title: 'ไม่สามารถอัพโหลดได้ !',
                    text: 'รองรับเฉพาะไฟล์ภาพนามสกุล png และ jpg เท่านั้น',
                    icon: 'warning',
                    confirmButtonText: 'ตกลง'
                });
                resetInputFile(inputId);
                return;
            }

            checkImageDimensions(files[0]).then(() => {
                imagePreview(inputId);
            }).catch(error => {
                if (error.message === 'InvalidImageSize') {
                    Swal.fire({
                        title: 'ไม่สามารถอัพโหลดได้ !',
                        text: 'ขนาดของรูปภาพรองรับตั้งแต่ 640x480 ถึง 1920x1080 พิกเซล',
                        icon: 'warning',
                        confirmButtonText: 'ตกลง'
                    });
                    resetInputFile(inputId);
                }
            });

            $(this).off('change', handleFileChange);
            resetInputFile(inputId);
            $("#" + inputId).on('change', handleFileChange);
        }

        function checkFileExtension(filename) {
            const validExtensions = ['png', 'jpg', 'jpeg'];
            const fileExtention = filename.split('.').pop().toLowerCase();
            return validExtensions.includes(fileExtention);
        }

        function checkImageDimensions(imageFile) {
            return new Promise((resolve, reject) => {
                const MIN_WIDTH = 640;
                const MIN_HEIGHT = 480;
                const MAX_WIDTH = 1920;
                const MAX_HEIGHT = 1080;
                
                const img = new Image();
                img.src = URL.createObjectURL(imageFile);
                img.onload = function() {
                    if (this.width < MIN_WIDTH || this.height < MIN_HEIGHT || this.width > MAX_WIDTH || this.height > MAX_HEIGHT) {
                        reject(new Error('InvalidImageSize'));
                    } else {
                        resolve();
                    }
                };
            });
        }

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
                                "style": "margin-right: 5px; object-fit: cover;"
                            });
                            imagePreviewContainer.append(img);
                        };
                        reader.readAsDataURL(files[i]);
                    }
                }
            } else {
                imagePreviewContainer.hide();
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

        function clearPreviewAndInput(inputId) {

            $("#" + inputId + "-preview").empty().hide();
            $("#" + inputId).val("");

            const label = $("#" + inputId).siblings(".custom-file-label");
            label.text("เลือกวิดีโอ");
        }

        function resetInputFile(inputId) {
            const input = $("#" + inputId);
            const newInput = input.clone();
            newInput.on('change', handleFileChange);
            input.replaceWith(newInput);
        }

        document.getElementById('videos').addEventListener('change', function() {
            
            const videoFiles = this.files;
            const inputFieldId = 'videos';
            
            for (let i = 0; i < videoFiles.length; i++) {
                const video = videoFiles[i];
                const fileExtension = video.name.split('.').pop().toLowerCase();
                // ตรวจสอบนามสกุลไฟล์วิดีโอ
                if (fileExtension !== 'mp4') {
                    Swal.fire({
                        title: 'ไม่สามารถเพิ่มวิดีโอได้',
                        text: 'รองรับเฉพาะวิดีโอนามสกุล MP4 เท่านั้น',
                        icon: 'error',
                        confirmButtonText: 'ตกลง',
                    }).then((result) => {
                        clearPreviewAndInput(inputFieldId);
                    });
                    return;
                }

                const videoDuration = getVideoDuration(video);
                videoDuration.then(result => {
                    if (result > 5 * 60) {
                        Swal.fire({
                            title: 'ไม่สามารถเพิ่มวิดีโอได้',
                            text: 'ความยาวของวิดีโอเกิน 5 นาที',
                            icon: 'error',
                            confirmButtonText: 'ตกลง',
                        }).then((result) => {
                            clearPreviewAndInput(inputFieldId);
                        });
                        return;
                    }
                });
            }
        });

        function getVideoDuration(videoFile) {
            return new Promise((resolve, reject) => {
                const video = document.createElement('video');
                video.preload = 'metadata';
                video.onloadedmetadata = function() {
                    window.URL.revokeObjectURL(video.src);
                    resolve(video.duration);
                };
                video.onerror = function() {
                    reject('ไม่สามารถอ่านวิดีโอ');
                };

                video.src = URL.createObjectURL(videoFile);
            });
        }

    });
</script>
</body>
</html>
