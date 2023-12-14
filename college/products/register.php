<?php
//first check session is available
//check session has user_type admin

session_start();
if(isset($_SESSION["name"])){
    if($_SESSION["user_type"]!="admin"){
            $url="../index.php";
            header("Location:$url");
            exit();
    }
}
else{
    $url="login.php";
    header("Location:$url");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Register</title>
	<?php include_once("../boot.php"); ?>
</head>
<body>
    <?php     include_once("nav.php"); ?>

<div class="container">
    <div class="row">
        <div class="col-sm-4 mx-auto shadow mt-5">
            <div class="card-body">
                <?php
                    require_once("../connect.php");

                    if(isset($_POST["register"])){
                        $name=$_POST["name"];
                        $brand_id=$_POST["brand_id"];
                        $category_id=$_POST["category_id"];
                        //$image=$_POST["image"];
                        $price=$_POST["price"];                        
                        $sale_price=$_POST["sale_price"];                        
                        $qty=$_POST["qty"];  
                        
                        
                        $name_img= $_FILES["image"]["name"];
                        $tmp_name=$_FILES["image"]["tmp_name"];
                        $path="profiles/$name_img"; //actual_name                    
                        $ext= pathinfo($path, PATHINFO_EXTENSION);
                        // new name
                        $name_img= md5( mt_rand(1,10000) ) .".$ext";
                        $path="profiles/$name_img";
                        move_uploaded_file($tmp_name, $path);


                        //now insert this data.

                        $query ="INSERT INTO products(name, brand_id, category_id, image, price, sale_price, qty) 
                        VALUES('$name','$brand_id','$category_id','$name_img','$price','$sale_price','$qty')";

                        $result= mysqli_query($conn, $query);

                        if($result){
                            echo "<div class='alert alert-success'>Your product is registered</div>";
                        }
                        else{
                            echo "<div class='alert alert-danger'>Something went wrong</div>";
                        }

                    }
                ?>

                <form action="register.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-2">
                        <label for="brand_id" class="form-label">Brand Name</label>
                        <select name="brand_id" class="form-control">
                            <option value="">Choose brand</option>
                        <?php 
                        $sql="SELECT * FROM brands ORDER BY id DESC";
                        $result=mysqli_query($conn, $sql);
                        while($rows = mysqli_fetch_array($result)){
                        ?>
                        <option value="<?=$rows["id"]?>"><?=$rows["name"]?></option>
                       <?php } ?>
                       </select>
                    </div>

                    <div class="mb-2">
                        <label for="category_id" class="form-label">Category Name</label>
                        <select name="category_id" class="form-control">
                            <option value="">Choose category</option>
                        <?php 
                        $sql="SELECT * FROM categories";
                        $result=mysqli_query($conn, $sql);
                        while($rows = mysqli_fetch_array($result)){
                        ?>
                        <option value="<?=$rows["id"]?>"><?=$rows["name"]?></option>
                       <?php } ?>
                       </select>
                    </div>

                    <div class="mb-2">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control"  name="name" required>
                    </div>

                    

                    <div  class="mb-2">
                        <label for="image"  class="form-label" >Product Image</label>
                        <input type="file" class="form-control" name="image" required>
                    </div>

                    <div class="mb-2">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control"  name="price" required>
                    </div>

                    <div class="mb-2">
                        <label for="sale_price" class="form-label">Sale Price</label>
                        <input type="text" class="form-control"  name="sale_price" required>
                    </div>

                    <div class="mb-2">
                        <label for="qty" class="form-label">Qty</label>
                        <input type="text" class="form-control"  name="qty" required>
                    </div>
                    

                    <div class="mb-2 text-center">
                        <input class="btn btn-primary" type="submit" name="register" value="Register Product">
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>

    
</body>
</html>