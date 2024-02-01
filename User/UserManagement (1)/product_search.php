<?php
include "Connect.php";

// Check if a search query is provided in the URL
session_start();


// Check if the search keyword is set
if (isset($_GET['keyword'])) {
    $searchKeyword = $_GET['keyword'];

    // Fetch products based on the provided search query
    $stmt = $conn->prepare("SELECT p.*, s.*, c.catename
                           FROM product p
                           LEFT JOIN sale s ON s.saleid = p.saleid
                           LEFT JOIN product_categories pc ON p.pid = pc.pid
                           LEFT JOIN categories c ON pc.cateid = c.cateid
                           WHERE p.pname LIKE ? and p.pstatus=1");

    // Add "%" to search for products with names containing the search query
    $search_param = "%" . $searchKeyword . "%"; // Change $search_query to $searchKeyword
    $stmt->bind_param("s", $search_param);

    if (!$stmt->execute()) {
        echo "Execution failed: " . $stmt->error;
        exit();
    }

    $result = $stmt->get_result();
}




?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Website</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../fonts/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../index.css">
    <link rel="stylesheet" type="text/css" href="../css/index_product.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


</head>

<body>
    <!-- Header -->
    <header>
        <div class="container-fluid index" id="index">
            <!--HEADER-->
            <?php include_once("./header_da_2.php"); ?>
        </div>
    </header>

    <!-- Thanh navigation -->


    <?php include_once("./navigation_da_2.php"); ?>





    <!-- Phần chính của trang -->
    <div id="content">
        <div id="content">
            <div class="container-fluid content-product">


                <br>

                <!--- Sản Phẩm Bán Chạy-->

                <div class="container-fluid  top-sold row">
                    <p class="text-center title ">KẾT QUẢ TÌM KIẾM</p>
                    <hr class="hr-arrival">
                    <br>
                    <div class="col-md-1 col-sm-1"></div>
                    <div class="col-md-10 col-sm-10 row top-sold-content " id="bestseller">
                        <?php
                        while ($row_best_seller = $result->fetch_assoc()) {
                            $name_product_best_sell = $row_best_seller['pname'];
                            $price_original = $row_best_seller['poriginalprice'];
                            $price_product_best_sell = $row_best_seller['psellprice'];
                            $url_product_best_sell = $row_best_seller['pimage'];
                            $id_product_best_sell = $row_best_seller['pid'];
                            //Lay thông tin cac san pham giam gia neu co
                            $getSale = $row_best_seller['saleid'];
                            $idsale = "";
                            $notificationfoot = "";
                            $notificationhead = "";
                            $notificationpercent = "";
                            if ($getSale != null) {
                                $getpercentSale = $row_best_seller['salepercent'];
                                $idsale = $getSale;
                                //Hien BadGe thong bao % giam gia
                                $notificationhead = '  <div class="percent-sale">-';
                                $notificationfoot = '%</div> ';
                                $notificationpercent = $getpercentSale;
                            }

                        ?>
                            <div class="col-md-4 col-sm-12 text-center top-sold-product  css-rieng">
                                <div class="  top-sold-items">
                                    <?php echo $notificationhead;
                                    echo $notificationpercent;
                                    echo $notificationfoot; ?>
                                    <img src="uploads/<?php echo $url_product_best_sell ?>" class="img-fluid img-top-sold">
                                    <div class="overlay">
                                        <a class="info" href="./detail.php?pid=<?php echo $id_product_best_sell ?>">Chi Tiết</a>
                                    </div>
                                </div>
                                <div class="top-sold-infor">
                                    <?php echo "<h2 style='font-weight:bold;'>" . $name_product_best_sell . "</h2>" ?>
                                    <p style="margin-bottom: 1ex;">
                                        <b class="price " style="font-size:15px; text-decoration:line-through; font-weight:600;"><?php echo number_format($price_original) ?> VNĐ </b>
                                        <br>
                                        <b class="price " style="color: red; font-size:22px;"><?php echo number_format($price_product_best_sell) ?> VNĐ </b>
                                    </p>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-md-1 col-sm-1"></div>






                </div>
            </div>


        </div>

        
        <br><br>

    </div>

    <!-- Footer -->
    <div class="container-fluid index" id="index">
        <footer>
            <?php include_once("./footer.php");  ?>
        </footer>
    </div>


</body>