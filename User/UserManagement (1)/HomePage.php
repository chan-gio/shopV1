<?php 
        // Update sellPrice
    $sqlUpdatePrices = "UPDATE product
    LEFT JOIN sale ON product.saleid = sale.saleid
    SET product.psellprice = CASE
        WHEN (sale.saleid IS NOT NULL) AND (sale.salebegin IS NOT NULL AND sale.saleend IS NOT NULL) AND (sale.salebegin <= NOW() AND sale.saleend >= NOW()) THEN
            product.poriginalprice - (product.poriginalprice * sale.salepercent / 100)
        ELSE
            product.poriginalprice
    END";
    $resultUpdatePrices = $conn->query($sqlUpdatePrices);

    // Fetch all products if no category is selected or fetch products based on the selected category with pagination
    $rs1 = $conn->query("SELECT p.*, s.*
    FROM product p LEFT JOIN sale s ON s.saleid = p.saleid
	Where p.psold>5 and p.pstatus=1
    ORDER BY p.psold DESC");// Thêm phần sắp xếp theo psold từ cao đến thấp
?>

<div  class="container-fluid content-product">

	
		<br>

		<!--- Sản Phẩm Bán Chạy-->
	
	<div class="container-fluid  top-sold row">
		<p class="text-center title ">SẢN PHẨM BÁN CHẠY</p>
		<hr class="hr-arrival">
		<br>
		<div class="col-md-1 col-sm-1"></div>
		<div class="col-md-10 col-sm-10 row top-sold-content " id="bestseller">
		<?php
            while($row_best_seller=$rs1->fetch_assoc()) {
				$name_product_best_sell=$row_best_seller['pname'];
                $price_original=$row_best_seller['poriginalprice'];
				$price_product_best_sell=$row_best_seller['psellprice'];
				$url_product_best_sell=$row_best_seller['pimage'];
				$id_product_best_sell=$row_best_seller['pid'];
				//Lay thông tin cac san pham giam gia neu co
				$getSale=$row_best_seller['saleid'];
				$idsale="";$notificationfoot="";$notificationhead="";$notificationpercent="";
				if($getSale!=null){
					$getpercentSale=$row_best_seller['salepercent'];
					$idsale=$getSale;
					//Hien BadGe thong bao % giam gia
					$notificationhead= '  <div class="percent-sale">-';
					$notificationfoot='%</div> ';
					 $notificationpercent=$getpercentSale;

				}

		?>	
			<div class="col-md-4 col-sm-12 text-center top-sold-product  css-rieng">
				<div class="  top-sold-items">
					<?php  echo $notificationhead; echo $notificationpercent; echo $notificationfoot; ?>
					<img src="Usermanagement (1)/uploads/<?php echo $url_product_best_sell?>" class="img-fluid img-top-sold">
					<div class="overlay">
					<a class="info" href="UserManagement (1)/detail.php?pid=<?php echo $id_product_best_sell ?>">Chi Tiết</a>
					</div>										
				</div>
				<div class="top-sold-infor">
					<?php echo "<h2 style='font-weight:bold;'>".$name_product_best_sell."</h2>" ?>
					<p class="price-info" style="margin-bottom: 1ex;">
                                <?php if ($idsale != ""): ?>
                                    <b class="original-price" style="font-size:15px; text-decoration:line-through; font-weight:600;"><?php echo number_format($price_original) ?> VNĐ </b>
                                <?php endif; ?>
                                <br>
                                <b class="sale-price" style="color: red; font-size:22px;"><?php echo number_format($price_product_best_sell) ?> VNĐ </b>
                     </p>
				</div>	
			</div>
			<?php
			}
			?>
		</div>
		<div class="col-md-1 col-sm-1"></div>

			
		

		<button type="button" class="btn btn-outline-warning extendend"><a href="./UserManagement (1)/AllProduct.php"> Xem Thêm</a> </button>

		<br>
	
	</div>
</div>
<!--SELECT p.MA_PN,ct.MA_SP,sp.TEN_SP,sp.DON_GIA,sp.HINH_ANH_URL  FROM phieunhap as p inner join chitietphieunhap as ct inner join  sanpham as sp on p.MA_PN = ct.MA_PN and ct.MA_SP=sp.MA_SP  
WHERE p.NGAY_NHAP BETWEEN '2020-02-01' AND '2021-05-05' GROUP BY sp.TEN_SP ORDER BY p.NGAY_NHAP DESC 

	//SELECT p.PHAN_TRAM_GIAM_GIA,od.MA_CTGG,od.MA_SP from chuongtrinhgiamgia as p inner join chitietgiamgia as od on p.MA_CTGG = od.MA_CTGG GROUP BY od.MA_SP-->
<style>
    .css-rieng {
        
        border-radius: 10px;
        

    }
</style>