<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include_once("../boot.php"); ?>
    
</head>
<body>
<?php include_once("nav.php"); ?>    


    <?php
        require_once("../connect.php");
        $id=$_GET["id"];
        $query = "SELECT * FROM products WHERE id ='$id'";
        $result = mysqli_query($conn, $query);
        $record = mysqli_fetch_array($result);
        // echo "<pre>";
        // print_r($record);
        // echo "</pre>";

        $selection_id = $record["brand_id"];
        $selection_category_id = $record["category_id"];

        
    ?>

    <?php
        if(isset($_POST["update"])){
            $name=$_POST["name"];
            $brand_id=$_POST["brand_id"];
            $category_id=$_POST["category_id"];            
            $name_img= $_FILES["image"]["name"];
            $tmp_name=$_FILES["image"]["tmp_name"];
            $path="profiles/$name_img"; //actual_name                    
            
            

            $price=$_POST["price"];
            $sale_price=$_POST["sale_price"];
            $qty=$_POST["qty"];

            // ----------------------------------------------
            if($name_img != null){   
                //deleting old file            
                $file_name = $record["image"];
                $file_path = "profiles/$file_name";
                unlink($file_path);

                $ext= pathinfo($path, PATHINFO_EXTENSION);
                // new name
                $name_img= md5( mt_rand(1,10000) ) .".$ext";                
                $path="profiles/$name_img";
                move_uploaded_file($tmp_name, $path);

                $img_name=$name_img;

            }else{
                $img_name=$record["image"];
            }
            // ----------------------------------------------------


            $query="UPDATE products SET name='$name',brand_id='$brand_id',category_id='$category_id',image='$img_name',price='$price',sale_price='$sale_price',qty='$qty' WHERE id='$id'";

            mysqli_query($conn, $query);

            $url="products.php";
            header("Location:$url");
            exit();
        }
    ?>
    

    <form action="edit_product.php?id=<?= $id?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" value="<?= $record["name"] ?>" name="name" required>
        </div>

        <div class="mb-2">
            <label for="brand_id" class="form-label">Brand Name</label>
            <select name="brand_id" class="form-control" id="dropdown_selected">
                    <option value=""></option>
                <?php 
                $sql="SELECT * FROM brands";
                $result=mysqli_query($conn, $sql);
                while($rows = mysqli_fetch_array($result)){
                ?>
                <option value="<?=$rows["id"]?>"><?=$rows["name"]?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-2">
            <label for="category_id" class="form-label">Category Name</label>
            <select name="category_id" class="form-control" id="dropdown_selected_category">
                    <option value=""></option>
                <?php 
                $sql="SELECT * FROM categories";
                $result=mysqli_query($conn, $sql);
                while($rows = mysqli_fetch_array($result)){
                ?>
                <option value="<?=$rows["id"]?>"><?=$rows["name"]?></option>
                <?php } ?>
            </select>
        </div>

        <div  class="mb-3">
            <label for="image"  class="form-label" >Image</label>
            <input type="text" class="form-control" value="<?= $record["image"] ?>" name="image" >
            <input type="file" class="form-control" name="image" >            
        </div>

        

        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="text" class="form-control" value="<?= $record["price"] ?>" name="price" required>
        </div>

        <div class="mb-3">
            <label for="sale_price" class="form-label">Sale Price</label>
            <input type="text" class="form-control" value="<?= $record["sale_price"] ?>" name="sale_price" required>
        </div>

        <div class="mb-3">
            <label for="qty" class="form-label">Quantity</label>
            <input type="text" class="form-control" value="<?= $record["qty"] ?>" name="qty" required>
        </div>

        <p>
            <input type="submit" name="update" value="Update">
        </p>
    </form>
    
</body>
</html>

<script>
    var id = <?=$selection_id ?>;
    var id_category = <?=$selection_category_id ?>;
    function selection() {
        document.getElementById("dropdown_selected").selectedIndex = id;
        document.getElementById("dropdown_selected_category").selectedIndex = id_category;

}
selection();
</script>