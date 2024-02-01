<?php

if (!isset($_SESSION["color_error"])){
    $_SESSION["color_error"]="";
}
include("../../db/MySQLConnect.php");

// Kiểm tra đăng nhập và vai trò của người dùng (ví dụ: chỉ admin mới có quyền quản lý voucher)


$query = "SELECT * FROM color";
$result = $connect->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý màu sắc</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        a{
            text-decoration: none;
        }
        .button-edit,.button-delete,.button-Add{
            color:black;
            font-weight: bold;
        }
    </style>
</head>
<body style="margin-left:100px;background-color: #f1efef">
    <h2 style="margin-top:10px">Quản lý màu sắc</h2>
    <center>
        <font color=red><?php echo $_SESSION["color_error"]; ?></font>
    </center>
    <button type="button" class="btn btn-primary"><a class="button-Add" href="index.php?manage=Color_add">Thêm màu</a></button>

    <table  class="table table-striped" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px">
        <tr>
            <th scope="col">Mã màu sắc</th>
            <th scope="col">Tên màu sắc</th>
            <th scope="col">Sửa</th>
            <th scope="col">Xóa</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['colorid']}</td>";
            echo "<td>{$row['colorname']}</td>";
            echo "<td><button type='button' class='btn btn-warning'><a class='button-edit' href='index.php?manage=Color_edit&colorid={$row['colorid']}'>Sửa</a></button></td>";
            echo '<td><button type="button" class="btn btn-danger"><a class="button-delete" onclick="return confirm(\'Bạn có chắc muốn xóa màu '. $row["colorname"] .' không?\')" href="Color_delete.php?colorid='. $row["colorid"] .'">Xóa</a></button></td>';

            echo "</tr>";
        }
        ?>
    </table>
   
</body>
</html>

<?php
// Đóng kết nối
$connect->close();
unset($_SESSION["color_error"]);
?>
