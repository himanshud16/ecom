<?php 

	if(isset($_GET["payment_request_id"])){

		require_once("connect.php");

		 $payment_request_id=$_GET["payment_request_id"];
		 $payment_id=$_GET["payment_id"];
		 $payment_status=$_GET["payment_status"];

		 if($payment_status=="Credit"){
		 	// now update the payment table

		 	$sql="UPDATE payments SET payment_id='$payment_id', status='$payment_status' WHERE payment_request_id='$payment_request_id'";
		 	mysqli_query($conn, $sql);

		 	

		 	header("Location:myorders.php");
		 	exit();

		 }


	}
	else{
		echo "something wrong, try again";
	}




?>