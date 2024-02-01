<?php

if (!isset($_SESSION["size_error"])){
    $_SESSION["size_error"]="";
}
include("../../db/MySQLConnect.php");

// Kiểm tra đăng nhập và vai trò của người dùng (ví dụ: chỉ admin mới có quyền quản lý voucher)


$query = "SELECT * FROM size";
$result = $connect->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý size</title>
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
    <h2 style="margin-top:10px">Quản lý size</h2>
    <center>
        <font color=red><?php echo $_SESSION["size_error"]; ?></font>
    </center>
    <button type="button" class="btn btn-primary"><a class="button-Add" href="index.php?manage=Size_add">Thêm size</a></button>
    <table class="table table-striped" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px">
        <tr>
            <th  scope="col" >Mã size</th>
            <th  scope="col" >Tên size</th>
            <th  scope="col" >Mô tả</th>
            <th  scope="col" >Sửa</th>
            <th  scope="col" >Xóa</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['sizeid']}</td>";
            echo "<td>{$row['sizename']}</td>";
            echo "<td>{$row['sizedesc']}</td>";
            echo "<td><button type='button' class='btn btn-warning'><a class='button-edit' href='index.php?manage=Size_edit&sizeid={$row['sizeid']}'>Sửa</a></button></td>";
            echo '<td><button type="button" class="btn btn-danger"><a class="button-delete"  onclick="return confirm(\'Bạn có chắc muốn xóa size '. $row["sizename"] .' không?\')" href="Size_delete.php?sizeid='. $row["sizeid"] .'">Xóa</a></button></td>';

            echo "</tr>";
        }
        ?>
    </table>
   
</body>
</html>

<?php
// Đóng kết nối
$connect->close();
unset($_SESSION["size_error"]);
?>
