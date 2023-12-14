<?php
session_start();
if(isset($_SESSION["name"])){       
            $url="dashboard.php";
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
	<?php include_once("boot.php"); ?>
</head>
<body>
	<?php include_once("nav.php"); ?>


<div class="container mt-5">
    <div class="row">
        <div class="col-sm-4 mx-auto">
            <div class="card mt-5 shadow">
                <div class="card-body">


<?php
require_once("connect.php");

if(isset($_POST["login"])){
    $email=$_POST["email"];
    $password=$_POST["password"];

    $query="SELECT * FROM users WHERE email ='$email' OR name ='$email' AND password='$password' ";
    $result= mysqli_query($conn, $query);
    
    if($result){
        $total = mysqli_num_rows($result);

        // echo $total;
        if($total>0){
            // do login

            //now put data in session

            //session_start();  //already started at the top
            $record= mysqli_fetch_array($result);

            // echo "<pre>";
            // print_r($record);
            // echo "</pre>";


            if($record["status"]=="UNBLOCK"){

            $_SESSION["user_id"]=$record["id"];
            $_SESSION["name"]=$record["name"];
            $_SESSION["email"]=$record["email"];
            $_SESSION["user_type"]=$record["user_type"];
            $_SESSION["profile"]=$record["profile"];
            // $_SESSION["status"]=$record["status"];

            $url="dashboard.php";
            header("Location:$url");
            exit();
                
            }

            else{
                
                echo "<div class='alert alert-danger'>You have been blocked by the admin.</div>";
            }
        }
        else{
            echo "<div class='alert alert-danger'>Login failed please check your credentials.</div>";
            
        }
    }
    else{
        echo "Something wrong";
    }
}

?>

<form action="login.php" method="POST">

    <div  class="mb-3">
        <label for="email"  class="form-label" >Email or Username</label>
        <input type="text" class="form-control" name="email" required>
    </div>

    <div  class="mb-3">
        <label for="password"  class="form-label">Password</label>
        <input type="password" class="form-control" name="password" required>
    </div>

    <div class="mb-3 text-center">
        <input class="btn btn-primary" type="submit" name="login" value="Login">
    </div>

    <div class="mb-3 text-center">
        <a href="register.php">Does not have an account?</a>
    </div>
    
</form>
                </div>
            </div>
        </div>
    </div>
</div>
    
</body>
</html>