<?php
session_start();
require_once '../../config/utils.php';
checkAdminLoggedIn();

$getRoleQuery = "select * from roles where status = 1";
$roles = queryExecute($getRoleQuery, true);

$getSchedules = "select * from route_shedules";
$schedules = queryExecute($getSchedules, true);

$getRoutes = "select * from routes";
$routes = queryExecute($getRoutes, true);

$getVehicles = "select * from vehicles";
$vehicles = queryExecute($getVehicles, true);

// lấy thông tin của người dùng ra ngoài thông id trên đường dẫn
$id = isset($_GET['id']) ? $_GET['id'] : -1;
// kiem tra su ton tai cua lich trinh
$getSchedulesByIdQuery = "select * from route_schedules where id = $id";
$schedules = queryExecute($getSchedulesByIdQuery, false);
if (!$schedules) {
    header("location: " . ADMIN_URL . 'schedules?msg=Lịch trình không tồn tại');
    die;
}


?>
<!DOCTYPE html>
<html>

<head>
    <?php include_once '../_share/style.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        <?php include_once '../_share/header.php'; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include_once '../_share/sidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Cập nhật thông tin lịch trình</h1>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <form id="edit-user-form" action="<?= ADMIN_URL . 'schedules/save-edit.php' ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        <div class="row">
                            <div class="col-md-6">
                            <div class="form-group">
                                    <label for="">ID<span class="text-danger">*</span></label>
                                    <input type="text" value="<?php echo $id?>" name="id" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="">Tuyến đường<span class="text-danger">*</span></label>
                                    <select name="route_id" class="form-control">
                                        <?php foreach ($routes as $route) : ?>
                                            <option value="<?php echo $route['id'] ?>"><?php echo $route['begin_point'] . "  -  " . $route['end_point'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="">Biển số xe<span class="text-danger">*</span></label>
                                    <select name="vehicle_id" class="form-control">
                                        <?php foreach ($vehicles as $vehicle) : ?>
                                            <option value="<?php echo $vehicle['id'] ?>"><?php echo $vehicle['plate_number'] ?></option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Giá tiền<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="price" min="0" value="<?php echo $schedules['price'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">Thời gian bắt đầu<span class="text-danger">*</span></label>
                                    <input type="datetime" class="form-control" name="start_time" value=" <?php echo $schedules['start_time'] ?>">
                                </div>
                                <div class="form-group">
                                    <label for="">Thời gian kết thúc<span class="text-danger">*</span></label>
                                    <input type="datetime" class="form-control" name="end_time" value=" <?php echo $schedules['end_time'] ?>">
                                </div>
                                <div class="col d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Sửa</button>&nbsp;
                                    <a href="<?= ADMIN_URL . 'schedules' ?>" class="btn btn-danger">Hủy</a>
                                </div>
                            </div>
                        </div>
                    </form>

                    <!-- /.row -->

                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <?php include_once '../_share/footer.php'; ?>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    <?php include_once '../_share/script.php'; ?>
    <script>
        function encodeImageFileAsURL(element) {
            var file = element.files[0];
            if (file === undefined) {
                $('#preview-img').attr('src', "<?= BASE_URL . $user['avatar'] ?>");
                return false;
            }
            var reader = new FileReader();
            reader.onloadend = function() {
                $('#preview-img').attr('src', reader.result)
            }
            reader.readAsDataURL(file);
        }
        $('#edit-user-form').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 191
                },
                email: {
                    required: true,
                    maxlength: 191,
                    email: true,
                    remote: {
                        url: "<?= ADMIN_URL . 'users/verify-email-existed.php' ?>",
                        type: "post",
                        data: {
                            email: function() {
                                return $("input[name='email']").val();
                            },
                            id: <?= $user['id']; ?>
                        }
                    }
                },
                phone_number: {
                    number: true
                },
                house_no: {
                    maxlength: 191
                },
                avatar: {
                    extension: "png|jpg|jpeg|gif"
                }
            },
            messages: {
                name: {
                    required: "Hãy nhập tên người dùng",
                    maxlength: "Số lượng ký tự tối đa bằng 191 ký tự"
                },
                email: {
                    required: "Hãy nhập email",
                    maxlength: "Số lượng ký tự tối đa bằng 191 ký tự",
                    email: "Không đúng định dạng email",
                    remote: "Email đã tồn tại, vui lòng sử dụng email khác"
                },
                phone_number: {
                    min: "Bắt buộc là số có 10 chữ số",
                    max: "Bắt buộc là số có 10 chữ số",
                    number: "Nhập định dạng số"
                },
                house_no: {
                    maxlength: "Số lượng ký tự tối đa bằng 191 ký tự"
                },
                avatar: {
                    extension: "Hãy nhập đúng định dạng ảnh (jpg | jpeg | png | gif)"
                }
            }
        });
    </script>
</body>

</html>