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

<?php
require_once("connect.php");
$id=$_GET["id"];
$query="DELETE FROM users WHERE id='$id'";
mysqli_query($conn, $query);

// echo "deleted";

// or

$url="users.php";

// redirect from one page to other
header("Location:$url");

//stop the execution of code in this page
exit();


?>