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
    <title>Brand Register</title>
	<?php include_once("../boot.php"); ?>
</head>
<body>
    <?php 
        require_once("../connect.php");
        include_once("nav.php"); 
    ?>    

<div class="container">
    <div class="row">
        <div class="col-sm-4 mx-auto shadow mt-5">
            <div class="card-body">
            <?php
            

                if(isset($_POST["register"])){
                    $name=$_POST["name"];

                    // ---------------------------------------

                    // echo "<pre>";
                    // print_r($_FILES);
                    // echo "</pre>";

                    $name_img= $_FILES["image"]["name"];
                    $tmp_name=$_FILES["image"]["tmp_name"];

                    $path="profiles/$name_img"; //actual_name                    
                    $ext= pathinfo($path, PATHINFO_EXTENSION);
                    // new name
                    $name_img= md5( mt_rand(1,10000) ) .".$ext";
                    $path="profiles/$name_img";

                    move_uploaded_file($tmp_name, $path);

                    // ----------------------------------------


                    //now insert this data.

                    $query ="INSERT INTO brands(name, image) VALUES('$name','$name_img')";

                    $result= mysqli_query($conn, $query);

                    if($result){
                        echo "<div class='alert alert-success'>Your brand is registered</div>";
                    }
                    else{
                        echo "<div class='alert alert-danger'>Something went wrong</div>";
                    }

                }
            ?>

            <form action="register.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control"  name="name" required>
                </div>                

                <div class="mb-3">
                    <label for="image" class="form-label">Brand Logo</label>
                    <input type="file" class="form-control" name="image" required>
                </div>
                
                
                <div class="mb-3 text-center">
                    <input class="btn btn-primary" type="submit" name="register" value="Register Brand">
                </div>
            </form>

            </div>
        </div>
    </div>
</div>

    
</body>
</html>