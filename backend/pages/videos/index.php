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
  <link rel="stylesheet" href="../../plugins/bootstrap-toggle/bootstrap-toggle.min.css">
  <link rel="stylesheet" href="../../plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css">
  <!-- Datatables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
                                    รายการบทความ <?php if($_SESSION['AD_BRANCH_NAME'] == "superadmin") echo "(" . strtoupper($branchName) . ")" ?>
                                </h4>
                                <?php if(isset($_GET['page'])){ ?>
                                    <a href="form-create.php?page=<?php echo $branchName; ?>" class="btn btn-primary mt-3">
                                        <i class="fas fa-plus"></i>
                                        เพิ่มข้อมูล
                                    </a>
                                    <a href="../<?php echo $_GET['page']?>" class="btn btn-info mt-3">
                                        <i class="fas fa-list"></i>
                                        กลับหน้าหลัก
                                    </a>
                                <?php } else { ?>
                                <a href="form-create.php" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus"></i>
                                    เพิ่มข้อมูล
                                </a>
                                <?php } ?>
                            </div>
                            <div class="card-body">
                                <table  id="logs" 
                                        class="table table-hover" 
                                        width="100%">
                                </table>
                            </div>
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
<script src="../../assets/js/adminlte.min.js"></script>
<script src="../../plugins/bootstrap-toggle/bootstrap-toggle.min.js"></script>
<script src="../../plugins/toastr/toastr.min.js"></script>

<!-- datatables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

<script>
    $(function() {

        var pageValue = <?php echo isset($_GET['page']) ? "'".$_GET['page']."'" : 'null'; ?>;

        $.ajax({
            type: "GET",
            url: "../../service/videos/",
            data: { page: pageValue },
        }).done(function(data) {
            let tableData = []
            data.response.forEach(function (item, index){
                const formattedBlogId = (item.blog_id ?? 0).toString().padStart(3, '0');

                <?php
                    if (isset($_GET['page'])) {
                        echo "var branchName = '{$_GET['page']}';";
                    } else {
                        echo "var branchName = '{$_SESSION['AD_BRANCH_NAME']}';";
                    }
                ?>

                tableData.push([    
                    `<a href="${item.url}" target="_blank" class="btn btn-outline-primary p-1"> BV-${formattedBlogId} </a>`,
                    `<img src="../../../assets/videos/${branchName}/thumbnails/${item.image}" width="150px" height="90px" style="object-fit: cover;">`,
                    `${item.subject}`,
                    `${item.subtitle}`,
                    `<input class="toggle-event" data-id="${item.blog_id}" type="checkbox" name="status" 
                            ${item.blog_status ? 'checked': ''} data-toggle="toggle" data-on="เผยแพร่" 
                            data-off="ปิด" data-onstyle="success" data-style="ios">`,
                    `<div class="btn-group" role="group">
                        <?php if (isset($_GET['page'])) { ?>
                            <a href="form-edit.php?page=${branchName}&id=${item.blog_id}" type="button" class="btn btn-warning">
                                <i class="far fa-edit"></i> แก้ไข
                            </a>
                        <?php } else { ?>
                            <a href="form-edit.php?id=${item.blog_id}" type="button" class="btn btn-warning">
                                <i class="far fa-edit"></i> แก้ไข
                            </a>
                        <?php } ?>
                        <button type="button" class="btn btn-danger" id="delete" data-id="${item.blog_id}">
                            <i class="far fa-trash-alt"></i> ลบ
                        </button>
                    </div>`
                ])
            })
            initDataTables(tableData)
        }).fail(function() {
            Swal.fire({ 
                text: 'ไม่สามารถเรียกดูข้อมูลได้', 
                icon: 'error', 
                confirmButtonText: 'ตกลง', 
            }).then(function() {
                location.assign('../dashboard')
            })
        });
        
        $(document).on('change', '.toggle-event', function() {
            const blogId = $(this).data('id');
            const isChecked = $(this).prop('checked');

            $.ajax({
                type: "PUT",
                url: "../../service/videos/update_status.php",
                data: JSON.stringify({
                    blog_id: blogId,
                    blog_status: isChecked
                })
            });
        });

        function initDataTables(tableData) {
            $('#logs').DataTable( {
                data: tableData,
                columns: [
                    { title: "รหัสบทความ" , className: "align-middle"},
                    { title: "วิดีโอ" , className: "align-middle"},
                    { title: "หัวข้อ" , className: "align-middle"},
                    { title: "คำบรรยาย", className: "align-middle"},
                    { title: "สถานะ", className: "align-middle"},
                    { title: "จัดการ", className: "align-middle"}
                ],
                initComplete: function () {
                    $(document).on('click', '#delete', function(){ 
                        let id = $(this).data('id')
                        Swal.fire({
                            text: "คุณแน่ใจหรือไม่...ที่จะลบรายการนี้?",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'ใช่! ลบเลย',
                            cancelButtonText: 'ยกเลิก'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    type: "POST",
                                    url: "../../service/videos/delete.php",
                                    data: { id: id },
                                    success: function(response) {
                                        Swal.fire({
                                            text: 'ลบข้อมูลเรียบร้อยแล้ว',
                                            icon: 'success',
                                            confirmButtonText: 'ตกลง',
                                        }).then((result) => {
                                            location.reload();
                                        });
                                    },
                                    error: function(xhr, status, error) {
                                        Swal.fire({
                                            text: 'ไม่สามารถลบรายการได้',
                                            icon: 'error',
                                            confirmButtonText: 'ตกลง',
                                        });
                                    }
                                });
                            }
                        })
                    }).on('change', '.toggle-event', function(){
                        toastr.success('อัพเดทข้อมูลเสร็จเรียบร้อย')
                    })
                },
                fnDrawCallback: function() {
                    $('.toggle-event').bootstrapToggle();
                },
                responsive: {
                    details: {
                        // display: $.fn.dataTable.Responsive.display.modal( {
                        //     header: function ( row ) {
                        //         var data = row.data()
                        //         return 'รายการสินค้า'
                        //     }
                        // }),
                        renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                            tableClass: 'table'
                        })
                    }
                },
                language: {
                    "lengthMenu": "แสดงข้อมูล _MENU_ แถว",
                    "zeroRecords": "ไม่พบข้อมูลที่ต้องการ",
                    "info": "แสดงหน้า _PAGE_ จาก _PAGES_",
                    "infoEmpty": "ไม่พบข้อมูลที่ต้องการ",
                    "infoFiltered": "(filtered from _MAX_ total records)",
                    "search": 'ค้นหา',
                    "paginate": {
                        "previous": "ก่อนหน้านี้",
                        "next": "หน้าต่อไป"
                    }
                }
            })
        }
    })
</script>
</body>
</html>
