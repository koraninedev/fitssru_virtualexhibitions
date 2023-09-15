<?php 
    /**
     * Page Manager
     * 
     * @link https://appzstory.dev
     * @author Yothin Sapsamran (Jame AppzStory Studio)
     */
    require_once('../authen.php'); 
?>

<?php if ($_SESSION['AD_STATUS'] === 'superadmin') { ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>จัดการผู้จัดนิทรรศการ | Organizer FIT SSRU</title>
  <link rel="shortcut icon" type="image/x-icon" href="../../assets/images/favicon.ico">
  <!-- stylesheet -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kanit" >
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="../../plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <link rel="stylesheet" href="../../assets/css/adminlte.min.css">
  <link rel="stylesheet" href="../../assets/css/style.css">
  <!-- Datatables -->
  <link rel="stylesheet" href="../../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="../../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
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
                                    ผู้จัดนิทรรศการ
                                </h4>
                                <!-- <a href="form-create.php" class="btn btn-primary mt-3">
                                    <i class="fas fa-plus"></i>
                                    เพิ่มข้อมูล
                                </a> -->
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

<!-- datatables -->
<script src="../../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../../plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="../../plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="../../plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<!-- ../../assets/images/cessru.png -->
<script>
    $(function() {
        $.ajax({
            type: "GET",
            url: "../../service/organizer/index.php"
        }).done(function(data) {
            let tableData = []
            data.response.forEach(function (item, index){
                tableData.push([    
                    ++index,
                    `<img src="../../assets/images/${item.image}" class="img-fluid text-center" width="50px">`,
                    item.name,
                    item.username,
                    item.login_latest,
                    `<div class="btn-group" role="group">
                        <a href="form-edit.php?id=${item.u_id}" type="button" class="btn btn-warning text-white">
                            <i class="far fa-edit"></i> แก้ไข
                        </a>
                        <button type="button" class="btn btn-danger" id="delete" data-id="${item.u_id}" data-index="${index}">
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
        })

        function initDataTables(tableData) {
            $('#logs').DataTable( {
                data: tableData,
                columns: [
                    { title: "ลำดับ" , className: "align-middle"},
                    { title: "รูปภาพสาขา" , className: "align-middle"},
                    { title: "ชื่อสาขา" , className: "align-middle"},
                    { title: "ชื่อผู้ใช้งาน", className: "align-middle"},
                    { title: "ใช้งานล่าสุด", className: "align-middle"},
                    { title: "จัดการ", className: "align-middle"}
                ],
                initComplete: function () {
                    $(document).on('click', '#delete', function () {
                        let id = $(this).data('id');
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
                                    url: "../../service/organizer/delete.php",
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
                                    error: function (xhr, status, error) {
                                        Swal.fire({
                                            text: 'ไม่สามารถลบรายการได้',
                                            icon: 'error',
                                            confirmButtonText: 'ตกลง',
                                        });
                                    }
                                });
                            }
                        })
                    })
                },
                responsive: {
                    details: {
                        display: $.fn.dataTable.Responsive.display.modal( {
                            header: function ( row ) {
                                var data = row.data()
                                return 'ผู้ใช้งาน: ' + data[1]
                            }
                        }),
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
<?php 
    } else {
        
        echo "<script>
                window.location.href = '../dashboard';
            </script>";

        exit;
    } 
?>
