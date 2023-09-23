<?php 
    require __DIR__.'/service/vendor/autoload.php';
    use App\Database\DB;
    DB::getInstance();
    $params = array('id' => $_GET['id']);
    $blogs = DB::query('SELECT blog_id, branch_name, subject, subtitle, image, url  FROM blogs WHERE blog_id = :id', $params);
    if(!count($blogs))
        header('location: ./');

    if (strpos($_SERVER['REQUEST_URI'], "3d") !== false) {

        $models = DB::query('SELECT 3dmodels.* FROM `3dmodels` WHERE 3dmodels.blog_id = :id', $params);
        if(!count($models))
        header('location: ./');

    } else if (strpos($_SERVER['REQUEST_URI'], "pic") !== false) {

        $pics = DB::query('SELECT pictures.* FROM `pictures` WHERE pictures.blog_id = :id', $params);

        if(!count($pics))
        header('location: ./');

    } else if (strpos($_SERVER['REQUEST_URI'], "video") !== false) {

        $videos = DB::query('SELECT videos.* FROM `videos` WHERE videos.blog_id = :id', $params);

        if(!count($videos))
        header('location: ./');

    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/fitssru_virtualexhibitions/">
    <title><?php echo $blogs[0]['subject'] ?></title>
    <meta name="title" content="<?php echo $blogs[0]['subject'] ?>">
    <meta name="description" content="<?php echo $blogs[0]['subtitle'] ?>">
    <meta property="og:title" content="<?php echo $blogs[0]['subject'] ?>">
    <meta property="og:description" content="<?php echo $blogs[0]['subtitle'] ?>">
    <meta property="og:image" content="<?php echo $blogs[0]['image'] ?>">
    <!-- <?php echo $blogs[0]['blog_id'].'/'.$blogs[0]['url'] ?> -->
    <meta property="og:type" content="website">

    <link rel="shortcut icon" type="image/x-icon" href="assets/images/logo.png" >

    <!-- CSS and dependencies -->
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit">
    <link rel="stylesheet" href="node_modules/@fortawesome/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="node_modules/sweetalert2/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .image-container {
            position: relative;
            overflow: hidden;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
            transition: opacity 0.3s ease;
            border-radius: 10px;
        }

        .overlay-text {
            color: white;
            font-size: 2rem;
        }

        .image-container:hover .overlay {
            opacity: 1;
        }
    </style>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v10.0&appId=1264860467204492&autoLogAppEvents=1" nonce="IU4EXUOc"></script>
</head>
<body>
    <?php 
        $branchName;
        if ($blogs[0]['branch_name'] == "cessru") {
            $branchName = "วิศวกรรมคอมพิวเตอร์";
        } else if ($blogs[0]['branch_name'] == "rbessru") {
            $branchName = "วิศวกรรมหุ่นยนต์";
        } else if ($blogs[0]['branch_name'] == "messru") {
            $branchName = "การจัดการวิศวกรรม";
        } else if ($blogs[0]['branch_name'] == "stohssru") {
            $branchName = "เทคโนโลยีความปลอดภัย";
        } else if ($blogs[0]['branch_name'] == "ietssru") {
            $branchName = "เทคโนโลยีไฟฟ้า";
        } else if ($blogs[0]['branch_name'] == "real-fmssru") {
            $branchName = "การจัดการอสังหาริมทรัพย์และทรัพยากรอาคาร";
        } else if ($blogs[0]['branch_name'] == "gmdssru") {
            $branchName = "การออกแบบกราฟิกและมัลติมีเดีย";
        } else if ($blogs[0]['branch_name'] == "iedssru") {
            $branchName = "การออกแบบนิทรรศการและแอนิเมชันสามมิติ";
        } else if ($blogs[0]['branch_name'] == "idssru") {
            $branchName = "การออกแบบผลิตภัณฑ์และบรรจุภัณฑ์";
        } else if ($blogs[0]['branch_name'] == "printingssru") {
            $branchName = "อุตสาหกรรมศิลป์และวิทยาศาสตร์";
        }
    
    ?>
    <div id="app">
        <navbar-component :auth="auth" style="z-index: 2;"></navbar-component>
        <header class="page-header d-flex align-items-center position-relative" >
            <div class="container mt-5 z-1" v-if="blog">
                <hr>
                <h1 class="fw-bold" v-text="blog.subject"></h1>
                <h2 class="h6 mx-auto w-75" v-text="blog.subtitle"></h2>
                <hr>
            </div>
            <div class="backscreen"></div>
        </header>
      
        <section class="container">
            <div class="card border-0 ">
                
                <div class="card-body">
                    <div class="row justify-content-center py-4 g-2">
                        <section class="col-md-12 col-xl-9 px-1 px-md-5" v-if="!blog">
                            <img src="assets/images/preload.gif" class="img-fluid" alt="">
                        </section>
                        <section class="col-md-12 col-xl-9 px-1 px-md-5" v-if="blog">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb small">
                                    <li class="breadcrumb-item">
                                        <a :href="`./${blog.branch_name}`" class="text-decoration-none"><i class="fas fa-folder-open"></i> บทความ</a>
                                    </li>
                                    <li class="breadcrumb-item active" v-text="blog.subject"></li>
                                </ol>
                            </nav>
                            <p class="text-black-50 small">
                                <img src="backend/assets/images/<?php echo $blogs[0]['branch_name'] ?>.png" width="35px" class="rounded-circle" alt="Admin">
                                <span class="me-2 text-danger"> <?php echo $branchName ?> </span>
                                <span class="me-2" :title="new Date(blog.updated_at).toLocaleString('th-TH', {timeZone: 'Asia/Bangkok'})" data-bs-toggle="tooltip" data-bs-placement="top"> 
                                    วันที่ {{ new Date(blog.updated_at).toLocaleString('th-TH', {timeZone: 'Asia/Bangkok'}).slice(0, 9) }} ({{ timeago.format(blog.updated_at, 'th') }}) 
                                </span>
                            </p>

                            <?php if (strpos($_SERVER['REQUEST_URI'], "3d") !== false) { ?>
                                <div style="box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;">
                                <div id="loadingPlaceholder">
                                    <p>กำลังโหลดโมเดลกรุณารอสักครู่...</p>
                                </div>
                                    <model-obj src="assets/3dmodels/<?php echo $blogs[0]['branch_name'] ?>/3dmodels/<?php echo $models[0]['model'] ?>"></model-obj>
                                </div>
                            <?php } ?>

                            <?php if (strpos($_SERVER['REQUEST_URI'], "pic") !== false) { ?>
                                
                                <div class="row mb-2">
                                    <div class="col-12">
                                        <div id="image-overlay" class="image-container">
                                            <img id="featured" src="assets/pictures/<?php echo $blogs[0]['branch_name'] ?>/images/<?php echo $pics[0]['image'] ?>" style="height: 700px; object-fit: cover;">
                                            <div class="overlay">
                                                <p class="overlay-text">คลิกเพื่อดูรูปเต็ม</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="showFull">
                                        <img id="featuredFull" class="img-fluid py-5" style="height: 100%; object-fit: cover;">
                                        <i id="close-full" class="fas fa-times"></i>
                                    </div>
                                </div>
                                <div id="slide-wrapper" class="mb-3">
                                    <i id="buttonLeft" class="fas fa-arrow-circle-left me-2"></i>
                                    <div id="slider">
                                        <?php foreach($pics as $pic) {?>
                                            <img class="thumbnail me-2" src="assets/pictures/<?php echo $blogs[0]['branch_name'] ?>/images/<?php echo $pic['image'] ?>" style="height: 100px;">
                                        <?php } ?> 
                                    </div>
                                    <i id="buttonRight" class="fas fa-arrow-circle-right ms-2"></i>
                                </div>

                            <?php } ?>

                            <?php if (strpos($_SERVER['REQUEST_URI'], "video") !== false) { ?>

                                <div class="ratio ratio-16x9">
                                    <iframe src="assets/videos/<?php echo $blogs[0]['branch_name'] ?>/videos/<?php echo $videos[0]['video'] ?>" allowfullscreen sandbox></iframe>
                                </div>

                            <?php } ?>

                            <article class="my-3" v-html="blog.detail"></article>
                            <!-- <div class="sharethis-inline-share-buttons"></div> -->
                            <footer class="my-3">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="#">ความคิดเห็น ({{comments.length}})</a>
                                    </li>
                                </ul>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item border-bottom-0" v-if="auth.data">    
                                        <div class="d-flex flex-row">
                                            <div class="px-2">
                                                <img :src="`assets/images/uploads/${auth.data.image}`" class="profile-img" alt="kitchen enjoy">
                                            </div>
                                            <div class="px-2 w-100">
                                                <textarea class="form-control bg-comments f-small" rows="4" v-model="message" placeholder="เขียนความคิดเห็น.." max-height="255" style="resize: none;"></textarea>
                                                <button class="btn btn-outline-danger mt-1 px-5 float-end f-small" @click="submitComment">เขียนความคิดเห็น</button>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item border-bottom-0" v-if="!auth.data">    
                                        <div class="row">
                                            <div class="col-12 text-center p-3">
                                                <p>เข้าสู่ระบบเพื่อแสดงความคิดเห็น</p>
                                                <a href="login" class="btn btn-outline-info"> 
                                                    <i class="fas fa-sign-in-alt"></i> 
                                                    เข้าสู่ระบบ
                                                </a>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="list-group-item border-bottom-0" v-for="comment in comments">    
                                        <div class="d-flex flex-row">
                                            <div class="px-2">
                                                <img :src="`assets/images/uploads/${comment.image}`" class="profile-img" alt="kitchen enjoy">
                                            </div>
                                            <div class="px-2 d-flex flex-column small">
                                                <div class="d-flex flex-column p-2 bg-comments text-break">
                                                   <span class="fw-bold">{{comment.firstname}} {{comment.lastname}}</span>
                                                   <span>{{comment.message}}</span>
                                                </div>
                                                <ul class="list-inline px-2 fw-light">
                                                    <li class="list-inline-item me-0" v-if="auth.data.firstname == comment.firstname">
                                                        <a class="link-secondary" href="javascript:void(0)" @click="deleteComment(comment.comment_id)">ลบความคิดเห็น</a>
                                                    </li>
                                                    <li class="list-inline-item me-0 f-small">
                                                        <span data-bs-toggle="tooltip" data-bs-placement="right" :title="comment.created_at">
                                                            {{ new Date(comment.created_at).toLocaleString('th-TH', {timeZone: 'Asia/Bangkok'}).slice(0, 9) }} ({{ timeago.format(comment.created_at, 'th') }})
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </footer>
                        </section>
                        <section class="col-md-12 col-xl-3">
                            <div class="sticky-top top-90" style="z-index: 1;">
                                <div class="row g-2">
                                    <h5 class="text-center">
                                        บทความอื่นๆ
                                    </h5>
                                    <div class="col-md-6 col-lg-4 col-xl-12" v-for="blog in blogInterest">
                                        <interest-component :key="blog.blog_id" :blog="blog"></interest-component>  
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section> 
        <footer-component :auth="auth"></footer-component>   
    </div>
    <!-- JavaScript and Dependencies -->
    <script src="node_modules/vue/dist/vue.min.js"></script> 
    <script src="node_modules/http-vue-loader/src/httpVueLoader.js"></script>
    <script src="node_modules/axios/dist/axios.min.js"></script>
    <script src="node_modules/vue-3d-model/dist/vue-3d-model.umd.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="node_modules/timeago.js/dist/timeago.full.min.js"></script>
    <script src="node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script>
        var blogBranchName = "<?php echo $blogs[0]['branch_name']; ?>";

        // สร้างตัวแปรเพื่อเก็บข้อมูลการโหลดโมเดล
        var modelLoaded = false;

        // เมื่อโมเดลโหลดเสร็จ
        function onModelLoad() {
            // ซ่อนข้อความ "กำลังโหลดอยู่" และแสดงโมเดล
            document.getElementById('loadingPlaceholder').style.display = 'none';
            modelLoaded = true;
        }

        // เช็คสถานะโมเดลและเรียกใช้ onModelLoad เมื่อโมเดลโหลดเสร็จ
        var modelElement = document.querySelector('model-obj');
        console.log(modelElement);
        modelElement.addEventListener('model-loaded', onModelLoad);

        // ตรวจสอบสถานะโมเดลทันทีหลังหน้า
        if (modelElement.hasAttribute('model-loaded')) {
            onModelLoad();
        }
    </script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/blog-detail.js"></script>
</body>
</html>