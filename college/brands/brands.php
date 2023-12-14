<?php
//first check session is available
//check session has user_type admin

session_start();
if(isset($_SESSION["name"])){
    if($_SESSION["user_type"]!="admin"){
            $url="index.php";
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
            width:15%;            
        }
    </style>

</head>
<body>

<?php 
    require_once("../connect.php");
    include_once("nav.php");
?>


<?php
    if(isset($_POST["delete"])){
        $id=$_GET["id"];
        $name=$_GET["name"];

        $query_fetch="SELECT * FROM products WHERE brand_id='$id'";
        $result_fetch= mysqli_query($conn, $query_fetch);
        if($result_fetch){
            $total = mysqli_num_rows($result_fetch);
            
        }
        if($total>0){ 
        ?>
        <script>
            alert("<?=$name ?> is not empty, cannot delete.");
        </script>
        
            
        <?php } 
        else{ 
            $query_delete="DELETE FROM brands WHERE id='$id'";
            mysqli_query($conn, $query_delete);
            $url="brands.php";
            header("Location:$url");
            exit();
        }
    }
?>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Image</th>                
                <th>Action</th>
                
            </tr>
        </thead>

        <tbody>
            <?php
                
                $query="SELECT * FROM brands";
                $result= mysqli_query($conn, $query);
                

                    while( $record = mysqli_fetch_array($result)){
                        // echo "<pre>";
                        // print_r($record);
                        // echo "</pre>";
                        
                        $id= $record["id"];
                        $name= $record["name"];
                        $image= $record["image"];

                        ?>


                        
                        <tr>
                            <td><?= $name ?> </td>
                            
                            <td><img src="profiles/<?= $image ?>" alt="<?= $name?>"/></td>
                            

                            <td>
                                <a href="edit_brand.php?id=<?= $id ?>">
                                <button class="btn btn-success">Edit</button></a>
                                

                                <!-- <a href="delete_user.php?id=<?= $id ?>">
                                <button class="btn btn-danger">Delete</button></a></a> -->

                                <form action="brands.php?id=<?= $id?>&name=<?=$name?>" method="POST">
                                    <input class="btn btn-danger" type="submit" name="delete" value="Delete">
                                </form>
                            </td>
                            
                        </tr>
                        
                    <?php

                    }
            ?>
        </tbody>
    </table>
    
</body>
</html>