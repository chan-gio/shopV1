<?php 
	session_start();
	require("../connect.php");
	$cateid = $_REQUEST["cateid"];
	$sql = "delete from categories where cateid=$cateid";
	$conn->query($sql) or die($conn->error);
	$conn->close();
	$_SESSION["cate_error"]="Xóa thành công!";
	header("Location:CategoriesManagement.php");
?>
