<?php
session_start();
include_once "../../config/utils.php";
checkAdminLoggedIn();
$plate_number = trim($_POST['plate_number']);
$type_id = trim($_POST['type_id']);
$seat = trim($_POST['seat']);
// validate bằng php

$plate_numbererr = "";
$seaterr = "";

if(strlen($plate_number) < 2 || strlen($plate_number) > 191){
    $plate_numbererr = "Yêu cầu nhập trong khoảng 2-191 ký tự";
}
if(strlen($plate_number) == 0){
    $plate_numbererr = "Yêu cầu nhập biển số xe";
}

// check plate_number đã tồn tại hay chưa
$checkPlateQuery = "select * from vehicles where plate_number = '$plate_number'";
$plates = queryExecute($checkPlateQuery, true);
if($plates == "" && count($plates) > 0){
    $plate_numbererr = "Biển số đã tồn tại, vui lòng sử dụng biển số khác";
}


if($plate_numbererr . $seaterr != "" ){
    header('location: ' . ADMIN_URL . "vehicles/add-form.php?plate_numbererr=$plate_numbererr");
    die;
}

$insertVehicleQuery = "insert into vehicles
                          (type_id, seat, plate_number)
                    values
                          ('$type_id ', '$seat','$plate_number')";

queryExecute($insertVehicleQuery, false);
// dd($insertVehicleQuery);
header("location: " . ADMIN_URL . "vehicles?msg=Thêm phương tiện thành công");
die;