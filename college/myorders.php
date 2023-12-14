<?php 
session_start();
$user_id=$_SESSION["user_id"];
require_once("connect.php");
$sql="SELECT 
 orders.id,
 orders.payment_id,
 orders.user_id,
 orders.status AS order_status,
 payments.status AS payment_status
 FROM orders 
 JOIN payments ON orders.payment_id = payments.id
 WHERE orders.user_id='$user_id'";
$result=mysqli_query($conn, $sql);
$total = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<?php include_once("boot.php"); ?>
	<style>
		.order-image{
			width: 110px;
			height: 110px;
			object-fit: cover;
		}
	</style>
</head>
<body>
	
<div class="container">
	<div class="row">
		<div class="col-sm-12">


	<?php if($total>0): ?>
	<h2>There is <?= $total ?> orders</h2>
	<?php 
		$orders=[];
		while($row = mysqli_fetch_array($result)){
			// echo "<pre>";
			// print_r($row);
			// echo "</pre>";
			$orders [] = $row;
		}
	 ?>

	 <?php foreach($orders as $order): ?>
	 	<?php 
	 		$order_id=$order["id"];
	 		$sql="SELECT 
	 				order_details.qty, 
	 				order_details.product_id,
	 				order_details.order_id,
	 				products.name,
	 				products.image 
	 				FROM order_details 
	 				JOIN products ON order_details.product_id = products.id
	 				WHERE order_id='$order_id'";
	 		$result=mysqli_query($conn, $sql);
	 	 ?>

	 	 <h2>Payment status: <?= $order["payment_status"] ?></h2>
	 	 <h3>Order status: <?= $order["order_status"] ?></h3>
	 	 <table class="table table-bordered">
	 	 <?php while($row = mysqli_fetch_array($result)): ?>
	 	 	<tr>
	 	 		<td><?=$row["name"]?></td>
	 	 		<td>
	 	 			<img 
	 	 			class="order-image"
	 	 			src="product/images/<?=$row["image"]?>" alt="">
	 	 		</td>
	 	 		<td>
	 	 			Qty: <?= $row["qty"] ?>
	 	 		</td>
	 	 	</tr>
	 	 <?php endwhile ?>
	 	 </table>
	 <?php endforeach ?>


<?php else: ?>
	<h2>There is no order.</h2>
<?php endif ?>
		</div>
	</div>
</div>

</body>
</html>




