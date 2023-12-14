<?php 
session_start();

require_once("../settings/payment.php");
require_once("../connect.php");



if(isset($_POST["checkout"])){
	$amount = $_POST["amount"];
	$user_id=$_SESSION['user_id'];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://$PAYMENT_WEBSITE/api/1.1/payment-requests/");
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
curl_setopt($ch, CURLOPT_HTTPHEADER,
            array("X-Api-Key:$PAYMENT_API_KEY",
                  "X-Auth-Token:$PAYMENT_AUTH_TOKEN"));
$payload = Array(
    'purpose' => 'amazon order',
    'amount' => $amount,
    'phone' => '7579237515',
    'buyer_name' => 'Aman singh',
    'redirect_url' => 'http://localhost/college/payment_redirect.php',
    'send_email' => true,
    'webhook' => 'http://www.example.com/webhook/',
    'send_sms' => true,
    'email' => 'foo@example.com',
    'allow_repeated_payments' => false
);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
$response = curl_exec($ch);
curl_close($ch); 

$data= json_decode($response, true);

if($data["success"]){
    $payment_request_id=$data["payment_request"]["id"];
    $amount=$data["payment_request"]["amount"];
    $user_id=$_SESSION['user_id'];


    // insert payment details
    $sql="INSERT INTO payments(payment_request_id, amount, user_id)VALUES('$payment_request_id','$amount','$user_id')";
    mysqli_query($conn, $sql); 
    $last_inserted_id = mysqli_insert_id($conn);

    // create new order
    $sql="INSERT INTO orders(payment_id, user_id)VALUES('$last_inserted_id','$user_id')";
    mysqli_query($conn, $sql);

    // now insert order details
    // $last_order_id = mysqli_insert_id($conn);

    // $sql="SELECT * FROM carts WHERE user_id='$user_id'";
    // $result=mysqli_query($conn, $sql);
    // $carts=[];
    // while($row = mysqli_fetch_array($result)){
    //     $carts[]=$row;
    // }

    foreach($carts as $cart){
        $product_id=$cart["product_id"];
        $qty=$cart["qty"];
        $sql="INSERT INTO order_details(order_id, product_id, qty)VALUES('$last_order_id','$product_id','$qty')";
        mysqli_query($conn, $sql);
    }


    // now empty the cart

    $sql="DELETE FROM carts WHERE user_id='$user_id'";
    mysqli_query($conn, $sql);



}


// echo "<pre>";
// print_r($data);
// echo "</pre>";

$longurl=$data["payment_request"]["longurl"];
header("Location: $longurl");
exit();


}
 ?>
