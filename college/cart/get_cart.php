<?php
session_start();
require_once("../connect.php");
include_once("../boot.php");

if(isset($_POST["action"])){
    if($_POST["action"]=="get_cart"){
        $user_id=$_POST["user_id"];
       
        $query="SELECT * FROM cart WHERE user_id='$user_id';";
        $result=mysqli_query($conn, $query);
        $total=mysqli_num_rows($result);

        if($total=0){
            $data=["status"=>false, "message"=>"Your cart is empty."];
            echo json_encode($data);
        }
        else{
            while($row= mysqli_fetch_array($result)){
                // echo "<pre>";
                // print_r($row);
                // echo "</pre>";
                $product_id= $row["product_id"];                                        
                $qty= $row["qty"];
        }//while_end

        

?>

    
                <h3>Shopping Cart</h3>
                <div class="container">
                    <div class="row">
                        <div class="col col-sm-8">
                            <?php                    
                                require_once("../connect.php");
                                                            
                                $query="SELECT products.id,products.name,products.image,products.price, products.sale_price, 
                                products.qty AS products_qty,cart.user_id, cart.qty AS cart_qty FROM products 
                                LEFT JOIN cart ON cart.product_id = products.id
                                WHERE cart.user_id = '$user_id';";
                                $result= mysqli_query($conn, $query);

                                $total_price=0;
                                $sum_qty=0;
                                $colsm4=1;                        


                                while( $record = mysqli_fetch_array($result)){
                                    // echo "<pre>";
                                    // print_r($record);
                                    // echo "</pre>";
                                    
                                    $id= $record["id"];
                                    $name= $record["name"];
                                    $image= $record["image"];
                                    $price= $record["price"];
                                    $sale_price= $record["sale_price"];                             
                                    $cart_qty= $record["cart_qty"];
                                    $products_qty= $record["products_qty"];
                                    $dis=(($price-$sale_price)/$price)*100;
                                    $dis=round($dis);                   
                                    
                                    $total_price+=($sale_price)*($cart_qty);
                                    $sum_qty+=$cart_qty;
                            

                            ?>
                        

                            <div class="row border-bottom border-3 mb-5">
                                <div class="col-sm-4">
                                    <img class="img-fluid " src="../products/profiles/<?= $image ?>" alt="<?= $name?>" class="card-img-top">
                                </div>

                                <div class="col-sm-8">
                                    <p class="item-name fw-semibold fs-4" ><?= "$name"; ?></p>
                                    ₹<span class="item-price fw-semibold fs-5"><?= "$sale_price"; ?></span>
                                    <span class="card-text p-1 bg-danger text-white rounded"><?= "$dis"; ?>% off</span>
                                    <p class="card-text text-body-tertiary">M.R.P.<del><?= "$price"; ?></del></p>
                                    <p class="item-quantity  card-body">Qty:
                                        <select 
                                        product_id="<?=$id?>"
                                        name="cart_qty" class="shadow rounded cart_qty" id="dropdown_selected"> 
                                            
                                                <?php 
                                                for($i=1; $i<=$products_qty; $i++){ ?>
                                                    
                                                    <option 
                                                    <?= $i == $cart_qty ? "selected" :"" ?>
                                                    value="<?=$i?>"><?=$i?></option>

                                                <?php }  ?>
                                        </select> 
                                        <button  product_id="<?=$id?>" type="button" class="delete_from_cart">Delete</button>                       
                                    </p>
                                    <input type="hidden" class="user_id" value="<?=$user_id?>">
                                </div>
                            </div>                        

                        <?php } ?><!-- while_record_end -->
                        <div class="text-end">
                            <?php if($sum_qty==0){ 
                                ?>
                                    <p class="text-center">Your cart is empty, <a href="../">click here</a> for homepage.</p>
                            <?php   }else{ ?>
                            <p>Subtotal (<?=$sum_qty?> items): <b> ₹<?=$total_price?> </b></p>
                        </div>
                    </div><!--col-sm-8_end -->

                                
                        <!-- <div class="col col-sm-4 text-end ">
                            <p>Subtotal (<?=$sum_qty?> items): <b> ₹<?=$total_price?> </b></p>
                            <a href="checkout.php" class="checkout-button btn btn-primary ">Proceed to Checkout</a>
                            <?php } ?>
                        </div> -->


                        <div class="col col-sm-4 text-end ">
                        <p>Subtotal (<?=$sum_qty?> items): <b> ₹<?=$total_price?> </b></p>

                            <form action="checkout.php" method="POST">
                                <input type="hidden" name="amount" value="<?= $total_price ?>">
                                <button type="submit" name="checkout" class="checkout-button btn btn-primary">Proceed to Checkout</button>
                            </form>
                        </div>
                        
                    </div>
                    <!-- row_end -->
                </div>
                <!-- container_end -->
<?php           
            }//else_end
        }//action=get_cart_end
    }//isset-action_end

?>