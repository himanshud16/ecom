
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
    $url="../login.php";
    header("Location:$url");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include_once("../boot.php"); ?>
    <style>
        img{
            width:100%;            
        }
        .image_col{
            
            width:10%;
        }
    </style>


</head>
<body>

<?php 
require_once("../connect.php");
include_once("nav.php"); 
?>

    <table class="table">
        <thead>
            <tr>
                <th>Brand</th>
                <th>Category</th>
                <th>Name</th>
                <th>Image</th>
                <th>Price</th>
                <th>Sale Price</th>
                <th>Quantity</th>
                <th>Action</th>                
            </tr>
        </thead>

        <tbody>
            <?php
                $query="SELECT * FROM products";
                $result= mysqli_query($conn, $query);
                if($result){
                    // echo "fetcched";

                    //count number of records

                    $total = mysqli_num_rows($result);

                    // echo "$total records found <br/>";

                    while( $record = mysqli_fetch_array($result)){
                        // echo "<pre>";
                        // print_r($record);
                        // echo "</pre>";
                        
                        $id= $record["id"];
                        $name= $record["name"];
                        $brand_id= $record["brand_id"];
                        $category_id= $record["category_id"];
                        $image= $record["image"];
                        $price= $record["price"];
                        $sale_price= $record["sale_price"];
                        $qty= $record["qty"];
                        ?>
                        
                        <tr>
                            <td>
                            <?php 
                                $sql="SELECT * FROM brands WHERE id='$brand_id'";
                                $result_name=mysqli_query($conn, $sql);                                
                                $rows = mysqli_fetch_array($result_name);
                                echo $rows["name"];
                                
                                ?>    
                            </td>
                            <td>
                            <?php 
                                $sql="SELECT * FROM categories WHERE id='$category_id'";
                                $result_name=mysqli_query($conn, $sql);                                
                                $rows = mysqli_fetch_array($result_name);
                                echo $rows["name"];
                                
                                ?>    
                            </td>
                            <td><?= $name ?> </td>
                            <td class="image_col">
                                <img src="profiles/<?= $image ?>" alt="<?= $name?>"  
                                />
                            </td>
                            <td><?= $price ?> </td>
                            <td><?= $sale_price ?> </td>
                            <td><?= $qty ?> </td>
                            <td>
                                <a href="edit_product.php?id=<?= $id ?>">
                                <button class="btn btn-success">Edit</button></a>

                                <a href="delete_product.php?id=<?= $id ?>">
                                <button class="btn btn-danger">Delete</button></a>
                                
                            </td>
                            
                        </tr>
                        
                    <?php

                    }
                }

                else{
                    echo "something wrong";
                }

            ?>
        </tbody>
    </table>
    
</body>
</html>

