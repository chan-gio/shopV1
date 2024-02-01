<?php

include "../../db/Connect.php";

if (!isset($_SESSION["account_error"])){
    $_SESSION["account_error"]="";
}


$query = "SELECT * FROM customer";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý khách hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        a{
            text-decoration: none;
        }
        .button-lock{
            color: #f4f1f1;
        }
        
    </style>
</head>
<body style="margin-left:100px;background-color: #f1efef">
    <h2 style="margin-top:20px">Quản lý khách hàng</h2>
    <font color=red><?php echo $_SESSION["account_error"]; ?></font><br>
    <table class="table table-striped" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:50px;">
        <thead>
            <tr>
                <th scope="col">Mã khách hàng</th>
                <th scope="col">Tên khách hàng</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">SĐT</th>
                <th scope="col">Email</th>
                <th scope="col">Tài khoản</th>
                <th scope="col">Mật khẩu</th>
                <th scope="col">Tình trạng</th>
                <th scope="col">Chỉnh sửa</th>
            </tr>
        </thead>
        <tbody>
        <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['cid']}</td>";
                echo "<td>{$row['cname']}</td>";
                echo "<td>{$row['caddress']}</td>";
                echo "<td>{$row['cphone']}</td>";
                echo "<td>{$row['cemail']}</td>";
                echo "<td>{$row['caccount']}</td>";
                echo "<td>{$row['cpassword']}</td>";

                $statusDisplay = ($row['cstatus'] == 0) ? "Khóa" : "Hoạt động";
                echo "<td>{$statusDisplay}</td>";
                // echo "<td><a href='Account_edit.php?cid={$row['cid']}'>Chỉnh sửa</a></td>";
                
                $lockDisplay = ($row['cstatus'] == 0) ? "Mở khóa" : "Khóa";
                echo '<td><button type="button" class="btn btn-warning"><a class="button-lock" onclick="return confirm(\'Bạn có chắc muốn khóa/mở khóa tài khoản của '. $row["cname"] .' không?\')" href="Account_lock.php?cid='. $row["cid"] .'">'.$lockDisplay.'</a></button></td>';

                echo "</tr>";
            }
            ?>
       
        </tbody>
       
    </table>
    
    
</body>
</html>

<?php
unset($_SESSION["account_error"]);
// Đóng kết nối
$conn->close();
?>
