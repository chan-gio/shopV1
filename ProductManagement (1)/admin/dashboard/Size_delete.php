<?php 
	session_start();
	require("../connect.php");
	$sizeid = $_REQUEST["sizeid"];
	$sql = "delete from size where sizeid=$sizeid";
	$conn->query($sql) or die($conn->error);
	$conn->close();
	$_SESSION["size_error"]="Xóa thành công!";
	header("Location:SizeManagement.php");
?>
