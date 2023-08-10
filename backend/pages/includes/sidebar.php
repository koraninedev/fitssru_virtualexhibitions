<?php 
    /**
     * Main Sidebar
     * 
     * @link https://appzstory.dev
     * @author Yothin Sapsamran (Jame AppzStory Studio)
     */ 
    function isActive ($data) {
        $array = explode('/', $_SERVER['REQUEST_URI']);
        $key = array_search("pages", $array);
        $name = $array[$key + 1];
        return $name === $data ? 'active' : '' ;
    }
?>
<!-- Navbar -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars fa-2x"></i></a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto ">
        <li class="nav-item d-md-block d-none">
            <a class="nav-link">เข้าสู่ระบบครั้งล่าสุด: <?php echo $_SESSION['AD_LOGIN'] ?>  </a>
        </li>
    </ul>
</nav>
<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="../dashboard/" class="brand-link">
        <img src="../../assets/images/AdminLogo.png" 
             alt="Admin Logo" 
             class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">ระบบจัดการบทความ</span>
    </a>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../../assets/images/<?php echo $_SESSION['AD_IMAGE'] ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="">สาขา <?php echo $_SESSION['AD_NAME']?> </a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="../dashboard/" class="nav-link <?php echo isActive('dashboard') ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>หน้าหลัก</p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="../manager/" class="nav-link <?php echo isActive('manager') ?>">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>ผู้ดูแลระบบ</p>
                    </a>
                </li> -->
                <li class="nav-item">
                    <a href="../3dmodels/" class="nav-link <?php echo isActive('3dmodels') ?>">
                        <i class="nav-icon fas fa-cube"></i>
                        <p>บทความ 3D Models</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../pictures/" class="nav-link <?php echo isActive('pictures') ?>">
                        <i class="nav-icon fas fa-images"></i>
                        <p>บทความรูปภาพ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../videos/" class="nav-link <?php echo isActive('videos') ?>">
                        <i class="nav-icon fas fa-video"></i>
                        <p>บทความวิดีโอ</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="../comments/" class="nav-link <?php echo isActive('comments') ?>">
                        <i class="nav-icon fas fa-comments"></i>
                        <p>ความคิดเห็นบทความ</p>
                    </a>
                </li>
                <li class="nav-header">ตัวเลือก</li>
                <li class="nav-item">
                    <a href="../logout.php" id="logout" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>ออกจากระบบ</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<<script>
    function handleLogout() {
    Swal.fire({
      icon: 'question',
      title: 'คุณต้องการออกจากระบบหรือไม่ ?',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'ตกลง',
      cancelButtonText: 'ยกเลิก',
      reverseButtons: true,
      focusCancel: true,
    }).then((result) => {
      if (result.isConfirmed) {
        Swal.fire({
          icon: 'success',
          title: 'ออกจากระบบเรียบร้อยแล้ว',
          showConfirmButton: false,
          timer: 1500
        }).then(() => {
          window.location.href = '../logout.php';
        });
      }
    });
  }

  // Attach the event listener to the logout link
  const logoutLink = document.getElementById('logout');
  logoutLink.addEventListener('click', function(event) {
    event.preventDefault();
    handleLogout(); // Call the function to handle the logout process
  });
</script>