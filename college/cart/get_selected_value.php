<?php
require_once("../connect.php");
if (isset($_POST['user_id'])) {

    if($_POST["action"]=="change_cart"){
    $selectedValue = $_POST['selectedValue'];
    $user_id = $_POST['user_id'];
    $product_id = $_POST['product_id'];


    // echo $selectedValue;
    
    $query="UPDATE cart SET qty='$selectedValue' WHERE user_id='$user_id' AND product_id='$product_id';";
    mysqli_query($conn, $query);

    }//change_cart_end


    if($_POST["action"]=="delete_cart"){        
        $user_id = $_POST['user_id'];
        $product_id = $_POST['product_id'];
       
        
        $query="DELETE FROM cart WHERE user_id='$user_id' AND product_id='$product_id';";
        mysqli_query($conn, $query);
    
        }//delete_cart_end
    
    
        
}
?>