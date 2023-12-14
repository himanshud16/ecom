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
    <?php include_once("boot.php"); ?>

</head>
<body>

    <?php
        require_once("connect.php");
        $id=$_GET["id"];
        $query = "SELECT * FROM users WHERE id ='$id'";
        $result = mysqli_query($conn, $query);

        $record = mysqli_fetch_array($result);
    ?>

    <?php
        if(isset($_POST["update"])){
            $name=$_POST["name"];
            $email=$_POST["email"];
            $password=$_POST["password"];

            $query="UPDATE users SET name='$name',email='$email', password='$password' WHERE id='$id'";

            mysqli_query($conn, $query);

            $url="users.php";

            // redirect from one page to other
            header("Location:$url");

            //stop the execution of code in this page
            exit();
        }
    ?>
    

    <form action="edit_user.php?id=<?= $id?>" method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" value="<?= $record["name"] ?>" name="name" required>
        </div>

        <div  class="mb-3">
            <label for="email"  class="form-label" >Email</label>
            <input type="text" class="form-control" value="<?= $record["email"] ?>" name="email" required>
        </div>

        <div  class="mb-3">
            <label for="password"  class="form-label">Password</label>
            <input type="password" class="form-control" value="<?= $record["password"] ?>" name="password" required>
        </div>

        <p>
            <input type="submit" name="update" value="Update">
        </p>
    </form>
</body>
</html>