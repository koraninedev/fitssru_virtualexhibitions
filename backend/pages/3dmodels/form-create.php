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
                                    <i class="fas fa-cube"></i> 
                                    เพิ่มข้อมูลบทความ
                                </h4>
                                <a href="./" class="btn btn-info mt-3">
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
                                                <option disabled selected data-category="3dmodel">3D Models</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="subject">เรื่อง</label>
                                            <input type="text" class="form-control" name="subject" id="subject" placeholder="เรื่อง" >
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label for="subtitle">คำบรรยาย</label>
                                            <input type="text" class="form-control" name="subtitle" id="subtitle" placeholder="คำบรรยายสั้นๆ">
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="thumbnail">รูปปกบทความ</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail">
                                                <label class="custom-file-label" for="thumbnail">เลือกรูปภาพ</label>
                                                <span class="remove-image" id="remove-thumbnail" style="display: none;">X</span>
                                            </div>
                                            <div class="image-preview mt-2" id="thumbnail-preview" style="display: none;"></div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="images">โมเดลภายในบทความ (.obj)</label>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="models" name="model[]" accept=".obj">
                                                <label class="custom-file-label" for="models">เลือกโมเดล</label>
                                            </div>
                                            <div id="models-preview" class="models-preview-container"></div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="url">URL สั้น</label>
                                            <input type="text" class="form-control" name="url" id="url" placeholder="Url บทความเช่น arduino , ชื่อผลงานสั้นๆ" >
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
                                            <textarea id="detail" class="form-control" name="detail" style="height: 300px;" placeholder="กรอกรายละเอียดของบทความ..."></textarea>
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
<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.js"></script>

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

            const formData = new FormData($('#formData')[0]);
            formData.append("category", dataTypeCategory);
            formData.append("status", dataTypeStatus);

            $.ajax({
                type: 'POST',
                url: '../../service/3dmodels/create.php',
                data: formData,
                processData: false,
                contentType: false,
                success: function (resp) {
                        console.log(resp);
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
                    console.log(xhr.responseText);
                },
            })
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

    });
</script>
</body>
</html>
