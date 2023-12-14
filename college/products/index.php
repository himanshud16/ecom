<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include_once("../boot.php"); ?>
    
</head>
<body>
    

<?php 
    require_once("../connect.php");
    include_once("nav.php"); 
?>

<div class="row row-cols-1 row-cols-md-6 g-4 mt-3 mx-3">
<?php



    $brand_id=$_GET["id"];
    

    if(isset($_SESSION["name"])){
        $user_id=$_SESSION["user_id"];
        // $query="SELECT * FROM cart WHERE user_id ='$user_id';";
        // $result= mysqli_query($conn, $query);
        // while($record = mysqli_fetch_array($result)){
        // echo "<pre>";
        // print_r($record);
        // echo "</pre>";
        // $cart_qty= $record["qty"];
        // }

    }
    

    $query="SELECT * FROM products WHERE products.brand_id ='$brand_id';";

    $result= mysqli_query($conn, $query);

    while( $record = mysqli_fetch_array($result)){
        // echo "<pre>";
        // print_r($record);
        // echo "</pre>";
            
            $id= $record["id"];
            $name= $record["name"];
            $image= $record["image"];
            $price= $record["price"];
            $sale_price= $record["sale_price"];
            $qty= $record["qty"];
            $dis=(($price-$sale_price)/$price)*100;
            $dis=round($dis);
                    
            ?>
    
    

    <div class="col">
        <div class="card cart_parent">
            <img src="profiles/<?= $image ?>" alt="<?= $name?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?= "$name"; ?></h5>

                <div class="mb-2">
                    <span class="card-text text-body-tertiary">M.R.P.<del><?= "$price"; ?></del></span>
                    <span class="card-text ">₹<?= "$sale_price"; ?></span>
                </div>               
                
                    <span class="card-text p-1 bg-danger text-white rounded"><?= "$dis"; ?>% off</span>      

                <label for="qty" class="form-label "></label>
                <select name="qty" class="form-control qty">                

                <?php                
                    
                    for($i=1; $i<=$qty; $i++){ ?>
                        
                        <option 
                        
                        value="<?=$i?>"><?=$i?></option>

                    <?php }?>
                </select>

                <input type="hidden" class="product_id" value="<?=$id?>">
                
                <input type="hidden" class="user_id" value="<?=$user_id?>">
                
                <button 
                type="button" 
                class="btn btn-primary add_cart_button"
                product_id="<?=$id?>"
                city="almora"
                >Add to Cart</button>
            </div>
        </div>
    </div>

<?php }?>
</div>
</body>
</html>
<script>
    $(function(){
       

        $(document).on("click",".add_cart_button",function(){
                var product_id, user_id, qty;


                // console.log("hello",$(this).attr("product_id"));
                // console.log("city", $(this).attr("city") );
                
                var parent = $(this).parents(".cart_parent");
                var cardBody = parent.children(".card-body") ;
               
                var qty = cardBody.children(".qty").val();
                var product_id = cardBody.children(".product_id").val();
                var user_id = $(".user_id").val();


                // console.log(qty, product_id, user_id);
                // console.log(parent.html());

                // request to add cart: insert

                $.ajax({
                    url:"server.php",
                    method:"POST",
                    datatype:"text",
                    data:{
                        action:"add_cart",
                        user_id:user_id,
                        product_id:product_id,
                        qty:qty 

                    },
                    beforeSend:function(){

                    },
                    success:function(data){
                        

                        var obj = JSON.parse(data);

                        //console.log(data);

                        if(obj.status){
                                                    
                          // $(".result").html(obj.message).css("color","green");
                        }
                        else{
                            window.location.href = "../login.php";

                        }
                    }
                })
                loadCartQty();
        });
        // var n=1;

        // loadCart();
        // function loadCart(){
        //     // request to get all the cart products

        //     // var carts=[{id:1},{id:2}];

        //     // $(".result").html(carts.length );

        //     $(".result").html(n++);            
        // }



        function loadCartQty(){
        $.ajax({
                    url:"server.php",
                    method:"POST",
                    datatype:"text",
                    data:{
                        action:"nav_cart",
                        // user_id:user_id
                    },
                    beforeSend:function(){

                    },
                    success:function(data){
                        // console.log(data);
                        $(".cartQty").html(data)
                    }
                })
        }
        loadCartQty();

    })
</script>