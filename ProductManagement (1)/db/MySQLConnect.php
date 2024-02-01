<?php
$connect =new mysqli("localhost","root","","do_an_web");
$connect -> set_charset("utf8");
//kiem tra ket noi
if($connect->connect_error){
    var_dump($connect->connect_error);
    echo "\n Kết Nối DB thất bại";
    die();
}
?>