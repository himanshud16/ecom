<?php
session_start();
$url="index.php";
    header("Location:$url");
    exit();
//check session is available or not

// if(!isset($_SESSION["name"])){
//     $url="login.php";
//     header("Location:$url");
//     exit();
// }

require_once("connect.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include_once("boot.php"); ?>
    <style>
        .profile_pic{
            width:300px;
            height: 300px;
            border-radius: 100%;
        }
        .container .row{
            margin-top: 7em;
        }
    </style>
</head>
<body>
    <?php include_once("nav.php"); ?>

    <?php
     
        if(isset($_POST["upload"])){

            // echo "<pre>";
            // print_r($_FILES);
            // echo "</pre>";

            $name_img= $_FILES["profile"]["name"];
            $tmp_name=$_FILES["profile"]["tmp_name"];            

            $path="profiles/$name_img"; //actual_name

            if($name_img != null){
                
                
                if( ! is_null($_SESSION["profile"])) {
                    //deleting old file            
                    $file_name = $_SESSION["profile"];
                    $file_path = "profiles/$file_name";
                    unlink($file_path);

                }

                $ext= pathinfo($path, PATHINFO_EXTENSION);
                // new name
                $name_img= md5( mt_rand(1,10000) ) .".$ext";                
                $path="profiles/$name_img";
                move_uploaded_file($tmp_name, $path);

                $img_name=$name_img;

            }else{
                $img_name=$_SESSION["profile"];
            }



            //update the database record
            $id=$_SESSION['user_id'];
            $query="UPDATE users SET profile='$img_name' Where id='$id'";
            mysqli_query($conn, $query);

            //update the session for profile
            $_SESSION["profile"] = $img_name;
        }

        
    ?>


    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                Welcome, <?= $_SESSION["name"]; ?>
                <!-- <a href="logout.php">Logout</a> -->
            </div>

            <div class="col-sm-4">

            <?php
                // echo "<pre>";
                // print_r($_SESSION);
                // echo "</pre>";
            ?>
                <?php if( is_null($_SESSION["profile"])) {?>
                    <img class="profile_pic" src="profiles/user.jpeg" alt="<?= $_SESSION["name"] ?>" />
                
                <?php } else{ ?>
                    <img class="profile_pic" src="profiles/<?= $_SESSION['profile'] ?>" 
                        alt="<?= $_SESSION["name"] ?>" />
                <?php } ?>


                <form action="dashboard.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-2">
                        <label for="profile">Profile</label>
                        <input type="file" class="form-control" name="profile">
                    </div>
                    
                    <div class="mb-2">
                        <input type="submit" value="upload" name="upload" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
</html>