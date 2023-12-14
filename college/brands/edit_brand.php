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
    <title>Document</title>
    <?php include_once("../boot.php"); ?>

</head>
<body>
<?php include_once("nav.php"); ?>    

    <?php
        require_once("../connect.php");
        $id=$_GET["id"];
        $query = "SELECT * FROM brands WHERE id ='$id'";
        $result = mysqli_query($conn, $query);

        $record = mysqli_fetch_array($result);
        
    ?>

    <?php
        if(isset($_POST["update"])){
            $name=$_POST["name"];

            $name_img= $_FILES["image"]["name"];
            $tmp_name=$_FILES["image"]["tmp_name"];
            $path="profiles/$name_img"; //actual_name   

            
            
            
            // echo "<pre>";
            // print_r($_FILES);
            // echo "</pre>";

            // -------------------------------------

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

            // ---------------------

            

            $query="UPDATE brands SET name='$name',image='$img_name' WHERE id='$id'";

            mysqli_query($conn, $query);

            $url="brands.php";
            header("Location:$url");
            exit();
        }
    ?>
    

    <form action="edit_brand.php?id=<?= $id?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" value="<?= $record["name"] ?>" name="name" required>
        </div>

        

        <div  class="mb-3">

            <label for="image"  class="form-label" >Image</label>
            <input type="text" class="form-control" value="<?= $record["image"] ?>" name="image" >
            <input type="file" class="form-control" name="image">
            
            <!-- <img src="logo/<?= $record["image"] ?>" alt="<?= $record["name"]?>" 
            /> -->
        </div>

        <p>
            <input type="submit" name="update" value="Update">
        </p>
    </form>
</body>
</html>