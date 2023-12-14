<?php
session_start();
require_once("../connect.php");



if(isset($_POST["action"])){
    if($_POST["action"]=="nav_cart"){

        if(isset($_SESSION["name"])){
            $user_id=$_SESSION["user_id"];

            $query_search = "SELECT SUM(qty) FROM cart WHERE user_id ='$user_id'";
            $result = mysqli_query($conn, $query_search);
            $record = mysqli_fetch_array($result);
            // echo "<pre>";
            // print_r($record);
            // echo "<pre>";
            $SUM_qty = $record["SUM(qty)"];
            if($SUM_qty){
                echo $SUM_qty;
            }
            else {
                echo "0";
            }

            
            
        }

        

    }//nav_cart_end


    if($_POST["action"]=="add_cart"){
        
    
    $user_id=$_POST["user_id"];
    $product_id=$_POST["product_id"];  

    $qty=$_POST["qty"];

    if(!isset($_SESSION["name"]))
    {
        $data=["status"=>false, "message"=>"Login needed."];
        echo json_encode($data);
    }
    else
    {
        $query="SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'";
        $result= mysqli_query($conn, $query);
        
        $total = mysqli_num_rows($result);
        if($total>0){
            $record = mysqli_fetch_array($result);
            $old_qty = $record["qty"];
            $qty+=$old_qty;
            //comparison with product max qty 
            $query="SELECT qty FROM products WHERE id='$product_id'";
            $result= mysqli_query($conn, $query);
            $record=mysqli_fetch_array($result);
            $product_max_qty = $record["qty"];

            if($qty>$product_max_qty){
                $qty = $product_max_qty;                
            }            
            
            $query="UPDATE cart SET qty='$qty' WHERE user_id='$user_id' AND product_id='$product_id'";
            mysqli_query($conn, $query);
        }
        else{
                $query="INSERT INTO cart(user_id,product_id,qty)VALUES('$user_id','$product_id','$qty')";
                mysqli_query($conn, $query);
        }

        $data=["status"=>true, "message"=>"Data added."];
        echo json_encode($data);
    }

       

    }
    //add_cart end  


}



?>