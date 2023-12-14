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
        <div class="col-sm-4 mx-auto shadow mt-5">
            <div class="card-body">
                <?php
                    require_once("connect.php");

                    if(isset($_POST["register"])){
                        $name=$_POST["name"];
                        $email=$_POST["email"];
                        $password=$_POST["password"];

                        //now insert this data.

                        $query ="INSERT INTO users(name, email, password) VALUES('$name','$email','$password')";

                        $result= mysqli_query($conn, $query);

                        if($result){
                            echo "<div class='alert alert-success'>Your account created</div>";
                        }
                        else{
                            echo "<div class='alert alert-danger'>Something went wrong</div>";
                        }

                    }
                ?>

                <form action="register.php" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control"  name="name" required>
                    </div>

                    <div  class="mb-3">
                        <label for="email"  class="form-label" >Email</label>
                        <input type="text" class="form-control" name="email" required>
                    </div>

                    <div  class="mb-3">
                        <label for="password"  class="form-label">Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>

                    <div class="mb-3 text-center">
                        <input class="btn btn-primary" type="submit" name="register" value="Register">
                    </div>

                    <div class="mb-3 text-center">
                        <a href="login.php">Already have an account?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    
</body>
</html>