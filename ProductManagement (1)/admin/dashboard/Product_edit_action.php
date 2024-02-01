<?php
require("../../db/Connect.php");
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_GET["pid"])) {
        $pid = $_REQUEST["pid"];
        $pname = $_POST["txtpname"];
        $pdesc = $_POST["txtpdesc"];
        $poriginalprice = $_POST["txtporiginalprice"];
        $psellprice = $_POST["txtpsellprice"];
        $pquantity = $_POST["txtpquantity"];
        $pstatus = $_POST["txtpstatus"];
        if($_POST["txtpsale"] == "none") {
            $psale = 0;
        }
        else {
            $psale = $_POST["txtpsale"];
        }
        // Xóa các kết nối cũ trong các bảng product_categories, product_size, product_color
        $conn->query("DELETE FROM product_categories WHERE pid=$pid");
        $conn->query("DELETE FROM product_size WHERE pid=$pid");
        $conn->query("DELETE FROM product_color WHERE pid=$pid");

        // Thêm các kết nối mới vào các bảng tương ứng
        if (isset($_POST['categories'])) {
            foreach ($_POST['categories'] as $category_id) {
                $sql_insert_product_categories = "INSERT INTO product_categories(pid, cateid) VALUES ($pid, $category_id)";
                $conn->query($sql_insert_product_categories);
            }
        }

        if (isset($_POST['sizes'])) {
            foreach ($_POST['sizes'] as $size_id) {
                $sql_insert_product_size = "INSERT INTO product_size(pid, sizeid) VALUES ($pid, $size_id)";
                $conn->query($sql_insert_product_size);
            }
        }

        if (isset($_POST['colors'])) {
            foreach ($_POST['colors'] as $color_id) {
                $sql_insert_product_color = "INSERT INTO product_color(pid, colorid) VALUES ($pid, $color_id)";
                $conn->query($sql_insert_product_color);
            }
        }

        // Cập nhật thông tin sản phẩm vào bảng product
        $sql_update_product = "UPDATE product SET pname='$pname', pdesc='$pdesc', poriginalprice=$poriginalprice, psellprice=$psellprice, pquantity=$pquantity, pstatus=$pstatus WHERE pid=$pid";
        $result = $conn->query($sql_update_product);
        if ($psale != 0) {
            $sql = "UPDATE product SET saleid = " . $psale . " WHERE pid = " . $pid;
            $resultSaleUpdate = $conn->query($sql);
            if (!$resultSaleUpdate) {
                die('Error updating saleid: ' . $conn->error);
            }
        }
        if ($result === TRUE) {
            echo "Cập nhật sản phẩm thành công.";
        } else {
            echo "Lỗi: " . $conn->error;
        }



        // Xử lý tệp tin được tải lên
        if ($_FILES['txtpimage']['size'] > 0) {
            $target_directory = "../../../User/UserManagement (1)/uploads/"; // Thư mục lưu trữ ảnh
            $file_extension = pathinfo($_FILES["txtpimage"]["name"], PATHINFO_EXTENSION);
            $new_image_name = uniqid() . '.' . $file_extension; // Tạo tên mới ngẫu nhiên cho tệp tin ảnh
            $target_file = $target_directory . $new_image_name; // Đường dẫn tệp tin ảnh mới

            // Kiểm tra và di chuyển tệp tin ảnh đã tải lên vào thư mục đích
            if (move_uploaded_file($_FILES["txtpimage"]["tmp_name"], $target_file)) {
                // Lưu đường dẫn của ảnh đã upload vào cơ sở dữ liệu
                $sql_update_product_image = "UPDATE product SET pimage='$new_image_name' WHERE pid=$pid";
                $conn->query($sql_update_product_image);
            } else {
                $_SESSION["product_edit_error"] = "Đã có lỗi xảy ra khi tải ảnh lên. Vui lòng thử lại!";
                header("Location:index.php?manage=Product_edit&pid=$pid");
                exit();
            }
        }

        $_SESSION["product_edit_error"] = "Sửa sản phẩm thành công";
        header("Location:index.php?manage=product");
        exit();
    } else {
        $_SESSION["product_edit_error"] = "Lỗi: Không tìm thấy ID sản phẩm";
        header("Location:  index.php?manage=Product_edit&pid=$pid"); // Chuyển hướng quay lại trang chỉnh sửa sản phẩm
        exit();
    }
} else {
    $_SESSION["product_edit_error"] = "Lỗi: Phương thức không hợp lệ";
    header("Location: index.php?manage=Product_edit&pid=$pid"); // Chuyển hướng quay lại trang chỉnh sửa sản phẩm
    exit();
}
