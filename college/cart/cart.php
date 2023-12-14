<?php
session_start();

if(isset($_SESSION["name"])){
    $user_id=$_SESSION["user_id"];
    
}
?>
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
include_once("../connect.php"); 

include_once("nav.php"); 
?>

    <div class="cart">

    </div>

    <input type="hidden" class="user_id" value="<?=$user_id?>">

    
</body>
</html>
<script>
    $(function(){

        function loadCart(){
            var user_id = $(".user_id").val();

            $.ajax({
                        url:"get_cart.php",
                        method:"POST",
                        datatype:"text",
                        data:{
                            action:"get_cart",
                            user_id:user_id
                            

                        },
                        beforeSend:function(){

                        },
                        success:function(data){
                            // console.log(data);
                            $(".cart").html(data)
                            

                        }
                    })
            }
            loadCart();    


       
            $(document).on("change","#dropdown_selected",function(){
                var selectedValue = $(this).val();
                var user_id = $(".user_id").val();


                var product_id = $(this).attr("product_id");
                // var cardBody = parent.children(".cart_body") ;

                // var product_id = cardBody.children(".product_id").val();
                // console.log(cardBody.html());

                //console.log(product_id);
                
                $.ajax({
                    url: 'get_selected_value.php',
                    type: 'POST',
                    data:  {
                        action:"change_cart",
                        selectedValue: selectedValue,
                        product_id:product_id,
                        user_id: user_id
                    },
                    success: function (response) {
                       // console.log(response);
                        loadCart();
                        loadCartQty();


                    
                    }
                });
            });

            //change_end



            $(document).on("click",".delete_from_cart",function(){
                var user_id = $(".user_id").val();
                var product_id = $(this).attr("product_id");

                //console.log(user_id, product_id);

                $.ajax({
                    url: 'get_selected_value.php',
                    type: 'POST',
                    data:{
                        action:"delete_cart",
                        user_id: user_id,
                        product_id:product_id
                        
                    },
                    success: function(response) {
                        //console.log(response);
                        loadCart();
                        loadCartQty();


                    
                    }
                });

            });

            //delete cart end

            function loadCartQty(){
            $.ajax({
                        url:"../products/server.php",
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

    });
</script>