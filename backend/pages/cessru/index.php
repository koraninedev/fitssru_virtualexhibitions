<?php
    require_once('../authen.php');
    require_once('../../service/connect.php');

    function getFolderSize($dir) {
        $size = 0;
        $files = scandir($dir);
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') continue;
            $path = $dir . DIRECTORY_SEPARATOR . $file;
            if (is_dir($path)) {
                $size += getFolderSize($path);
            } else {
                $size += filesize($path);
            }
        }
        return $size;
    }

    $folderPathpictures = "../../../assets/pictures/cessru";
    $folderPathvideos = "../../../assets/videos/cessru";
    $folderPath3dmodels = "../../../assets/3dmodels/cessru";
    $folderSizepictures = getFolderSize($folderPathpictures);
    $folderSizevideos = getFolderSize($folderPathvideos);
    $folderSize3dmodels = getFolderSize($folderPath3dmodels);

    // รวมขนาดทั้งหมด
    $totalSize = $folderSizepictures + $folderSizevideos + $folderSize3dmodels;

    // แปลงเป็น MB
    $totalSizeInMB = round($totalSize / (1024 * 1024), 2);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CESSRU | Admin FIT SSRU</title>
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
  <!-- stylesheet -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <?php include_once('../includes/sidebar.php') ?> 
    <div class="content-wrapper pt-3">
        <!-- Main content -->
        <div class="content">
            <div class="container-fluid">
                <div class="small-box py-3 bg-white shadow">
                    <div class="inner text-center">
                        <h3>วิศวกรรมคอมพิวเตอร์</h3>
                        <p class="text-danger">Computer Engineering</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-laptop"></i>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-info shadow">
                            <div class="inner text-center">
                                <h1 class="py-3">&nbsp;3D Models&nbsp;</h1>
                            </div>
                            <a href="../3dmodels?page=cessru" class="small-box-footer py-3"> คลิกจัดการระบบ <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-primary shadow">
                            <div class="inner text-center">
                                <h1 class="py-3">รูปภาพ</h1>
                            </div>
                            <a href="../pictures?page=cessru" class="small-box-footer py-3"> คลิกจัดการระบบ <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>

                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-success shadow">
                            <div class="inner text-center">
                                <h1 class="py-3">วิดีโอ</h1>
                            </div>
                            <a href="../videos?page=cessru" class="small-box-footer py-3"> คลิกจัดการระบบ <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <div class="small-box bg-danger shadow">
                            <div class="inner text-center">
                                <h1 class="py-3">ความคิดเห็น</h1>
                            </div>
                            <a href="../comments?page=cessru" class="small-box-footer py-3"> คลิกจัดการระบบ <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-3">
                        <div class="small-box py-3 bg-white shadow">
                            <div class="inner">
                                <?php     
                                    $params = array('branch_name' => 'cessru', 'category' => '3dmodel');
                                    $blogs3d = $connect->prepare("SELECT * FROM blogs WHERE branch_name = :branch_name AND category = :category");
                                    $blogs3d->execute($params);
                                ?>
                                <h3><?php echo $blogs3d->rowCount(); ?> บทความ</h3>
                                <p class="text-danger">จำนวนบทความประเภท 3D Models</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-cube"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="small-box py-3 bg-white shadow">
                            <div class="inner">
                                <?php     
                                    $params = array('branch_name' => 'cessru', 'category' => 'picture');
                                    $blogsPic = $connect->prepare("SELECT * FROM blogs WHERE branch_name = :branch_name AND category = :category");
                                    $blogsPic->execute($params); 
                                ?>
                                <h3><?php echo $blogsPic->rowCount(); ?> บทความ</h3>
                                <p class="text-danger">จำนวนบทความประเภท รูปภาพ</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-images"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="small-box py-3 bg-white shadow">
                            <div class="inner">
                                <?php     
                                    $params = array('branch_name' => 'cessru', 'category' => 'video');
                                    $blogsVideo = $connect->prepare("SELECT * FROM blogs WHERE branch_name = :branch_name AND category = :category");
                                    $blogsVideo->execute($params); 
                                ?>
                                <h3><?php echo $blogsVideo->rowCount(); ?> บทความ</h3>
                                <p class="text-danger">จำนวนบทความประเภท วิดีโอ</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-video"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="small-box py-3 bg-white shadow">
                            <div class="inner">
                                <?php     
                                    $params = array('branch_name' => 'cessru');
                                    $comments = $connect->prepare("SELECT c.* FROM comments c JOIN blogs b ON c.blog_id = b.blog_id WHERE b.branch_name = :branch_name");
                                    $comments->execute($params); 
                                ?>
                                <h3><?php echo $comments->rowCount(); ?> ความคิดเห็น</h3>
                                <p class="text-danger">จำนวนความคิดเห็นของผลความ</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-comments"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-12">
                        <div class="small-box bg-secondary shadow">
                            <div class="inner text-center">
                                <h3><?php echo $totalSizeInMB; ?> MB</h3>
                                <p class="text-light">พื้นที่เก็บผลงานที่ใช้ไปตอนนี้</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-folder"></i>
                            </div>
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
<script src="../../assets/js/adminlte.min.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="../../plugins/chart.js/Chart.min.js"></script>
<script src="../../plugins/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>
<script src="../../assets/js/pages/dashboard.js"></script>
</body>
</html>
