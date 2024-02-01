<?php

include "../../db/Connect.php";

// Kiểm tra đăng nhập và vai trò của người dùng (ví dụ: chỉ admin mới có quyền quản lý voucher)


// Lấy danh sách voucher từ bảng voucher
$query = "SELECT * FROM voucher";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý voucher</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/Product-Management.css">
   
</head>
<body style="margin-left:100px;background-color: #f1efef">
    <h2 style="margin-top:10px">Quản lý voucher</h2>
    <button type="button" class="btn btn-primary"><a class="button-Add" href="index.php?manage=Voucher_add">Thêm voucher</a></button>
    <table class="table table-striped" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px">
        <tr>
            <th scope="col" >ID Voucher</th>
            <th scope="col" >Tên Voucher</th>
            <th scope="col" >Loại Voucher</th>
            <th scope="col" >Mô tả</th>
            <th scope="col" >Phần trăm giảm giá</th>
            <th scope="col" >Số lượng</th>
            <th scope="col" >Ngày bắt đầu</th>
            <th scope="col" >Ngày kết thúc</th>
            <th scope="col" >Trạng thái</th>
            <th scope="col" >Số lượng còn lại</th>
            <th scope="col" >Điều kiện</th>
            <th scope="col" >Thao tác</th>
        </tr>
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['vid']}</td>";
            echo "<td>{$row['vname']}</td>";
            echo "<td>{$row['vtype']}</td>";
            echo "<td>{$row['vdesc']}</td>";
            echo "<td>{$row['vpercent']}</td>";
            echo "<td>{$row['vamount']}</td>";
            echo "<td>{$row['vstart']}</td>";
            echo "<td>{$row['vend']}</td>";
            echo "<td>{$row['vstatus']}</td>";
            echo "<td>{$row['vremaining']}</td>";
            echo "<td>{$row['vcondition']}</td>";
            echo "<td><button type='button' class='btn btn-warning'><a class='button-edit' href='index.php?manage=update_voucher_status&vid={$row['vid']}'>Cập nhật trạng thái</a></button></td>";
           
            echo "</tr>";
        }
        ?>
    </table>
    
</body>
</html>

<?php
// Đóng kết nối
$conn->close();
?>
