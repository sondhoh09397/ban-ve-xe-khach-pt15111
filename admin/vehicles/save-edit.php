<?php
session_start();
include_once "../../config/utils.php";
checkAdminLoggedIn();
$id = trim($_POST['id']);
$plate_number = trim($_POST['plate_number']);
$vehicletype_id = trim($_POST['vehicletype_id']);
$seat_booked = trim($_POST['seat_booked']);

// validate bằng php
$plate_numbererr = "";
$seat_bookedrr = "";

if(strlen($plate_number) < 2 || strlen($plate_number) > 191){
    $plate_numbererr = "Yêu cầu nhập trong khoảng 2-191 ký tự";
}
if(strlen($plate_number) == 0){
    $plate_numbererr = "Yêu cầu nhập biển số xe";
}

// check plate_number đã tồn tại hay chưa
$checkPlateQuery = "select * from vehicles where plate_number = '$plate_number' and id != $id";

$plates = queryExecute($checkPlateQuery, true);
if($plates == "" && count($plates) > 0){
    $plate_numbererr = "Biển số đã tồn tại, vui lòng sử dụng biển số khác";
}


if($plate_numbererr . $owner_iderr . $manufactureerr . $colorerr . $modelerr != "" ){
    header('location: ' . ADMIN_URL . "vehicles/edit-form.php?plate_numbererr=$plate_numbererr&owner_iderr=$owner_iderr&manufactureerr=$manufactureerr&colorerr=$colorerr&modelerr=$modelerr");
    die;
}

$updateVehicleQuery = "update vehicles
                    set
                        vehicletype_id = '$vehicletype_id',
                        seat_booked = '$seat_booked',
                        plate_number = '$plate_number'
                    where id = '$id'";


queryExecute($updateVehicleQuery, false);

header("location: " . ADMIN_URL . "vehicles?msg=Sửa thông tin phương tiện thành công");
die;