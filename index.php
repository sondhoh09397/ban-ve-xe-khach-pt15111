<?php
// bắt đầu sử dụng session
session_start();
require_once "./config/utils.php";
$loggedInUser = isset($_SESSION[AUTH]) ? $_SESSION[AUTH] : null;
$keyword = isset($_GET['keyword']) == true ? $_GET['keyword'] : "";
// lấy dữ liệu từ Routes
$getRoutesQuery = "select * from routes";
$routes = queryExecute($getRoutesQuery, true);

?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include_once './public/_share/style.php' ?>
    <title>Bán vé xe khách - Trang chủ</title>
</head>

<body class="bg-light">
    <?php include_once './public/_share/header.php'; ?>
    <!--END HEADER - START BANNER-->
    <div class="banner border-bottom pt-3 pb-3">
        <div class="container">
            <h1 class="h2 m-5 text-dark text-center text-capitalize">đặt vé xe trước, nhận chỗ sớm, không lo hết vé</h1>
            <p class="text-center text-uppercase h4 font-weight-bold">tìm vé xe</p>

            <form action="<?php echo SEARCH_URL ?>" method="get" enctype="multipart/form-data">
                <div class="row d-flex justify-content-center">
                    <div class="col-8 form-group">
                        <input type="text" class="form-control p-4 border-dark" name="keyword" value="" placeholder="Nhập địa điểm, giá vé, loại xe tìm kiếm ...">
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" name="btn-submit" class="btn btn-primary">Tìm Vé</button>
                </div>
            </form>
        </div>
    </div>
    <!--END CONTACT - START FOOTER-->
    <?php include_once './public/_share/footer.php'; ?>
    <?php include_once './public/_share/script.php'; ?>
    </div>
</body>

</html>