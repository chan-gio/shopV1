<?php
session_start();

// Kiểm tra nếu có dữ liệu được gửi từ form POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pname = $_POST["txtpname"];
    $pdesc = $_POST["txtpdesc"];
    $poriginalprice = $_POST["txtporiginalprice"];
    $psellprice = $_POST["txtpsellprice"];
    $pquantity = $_POST["txtpquantity"];
    $pstatus = $_POST["pstatus"];
    
    if (isset($_POST['categories']) && !empty($_POST['categories'])) {
        $selected_categories = $_POST['categories'];
    }
    else {
        $_SESSION["product_add_error"] = "Vui lòng chọn ít nhất một danh mục!!";
        header("Location:index.php?manage=Product_add");
        exit();
    }
    if (isset($_POST['sizes']) && !empty($_POST['sizes'])) {
        $selected_sizes = $_POST['sizes'];
    }
    else {
        $_SESSION["product_add_error"] = "Vui lòng chọn ít nhất một size!!";
        header("Location:index.php?manage=Product_add");
        exit();
    }
    if (isset($_POST['colors']) && !empty($_POST['colors'])) {
        $selectedColors = $_POST['colors'];
    }
    else {
        $_SESSION["product_add_error"] = "Vui lòng chọn ít nhất một màu sắc!!";
        header("Location:index.php?manage=Product_add");
        exit();
    }

    // Kết nối đến CSDL
    include("../../db/MySQLConnect.php");
    include("../../db/Connect.php");
    $check = "Select * from product where pname='" .$pname. "' ";
    $result=$conn->query($check) or die($conn->error);
	if ($result->num_rows>0){
		$_SESSION["product_add_error"]="Sản phẩm $pname đã tồn tại!";
		header("Location:index.php?manage=product");
        exit();
    }
    // Thêm sản phẩm vào bảng product
    $sql_insert_product = "INSERT INTO product (pname, pdesc, poriginalprice, psellprice, pquantity, pstatus) VALUES ('$pname', '$pdesc', $poriginalprice, $psellprice, $pquantity, $pstatus)";
    if ($connect->query($sql_insert_product) === TRUE) {
        $last_insert_id = $connect->insert_id; // Lấy ID của sản phẩm mới được thêm vào

        // Thêm danh mục sản phẩm vào bảng product_categories
        foreach ($selected_categories as $category_id) {
            $sql_insert_product_categories = "INSERT INTO product_categories (pid, cateid) VALUES ($last_insert_id, $category_id)";
            $connect->query($sql_insert_product_categories);
        }

        // Thêm size sản phẩm vào bảng product_size
        foreach ($selected_sizes as $size_id) {
            $sql_insert_product_size = "INSERT INTO product_size (pid, sizeid) VALUES ($last_insert_id, $size_id)";
            $connect->query($sql_insert_product_size);
        }

        // Thêm màu sắc sản phẩm vào bảng product_color
        foreach ($selected_colors as $color_id) {
            $sql_insert_product_color = "INSERT INTO product_color (pid, colorid) VALUES ($last_insert_id, $color_id)";
            $connect->query($sql_insert_product_color);
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
                $sql_update_product_image = "UPDATE product SET pimage='$new_image_name' WHERE pid=$last_insert_id";
                $connect->query($sql_update_product_image);

                $_SESSION["product_error"] = "Tải ảnh lên và lưu tên ảnh thành công!";
                header("Location:index.php?manage=product");
                exit();
            } else {
                $_SESSION["product_add_error"] = "Đã có lỗi xảy ra khi tải ảnh lên. Vui lòng thử lại!";
            }
        } else {
            $_SESSION["product_error"] = "Thêm sản phẩm thành công";
            header("Location: index.php?manage=product");
            exit();
        }
    } else {
        $_SESSION["product_add_error"] = "Lỗi thêm sản phẩm: " . $connect->error;
    }

    // Nếu có lỗi xảy ra, chuyển hướng trở lại trang Product_add.php
    header("Location: index.php?manage=Product_add");
    exit();
} else {
    // Nếu không có dữ liệu được gửi từ form POST, chuyển hướng trở lại trang Product_add.php
    header("Location: index.php?manage=Product_add");
    exit();
}
?>
