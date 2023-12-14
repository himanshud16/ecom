<?php
require_once("connect.php");
$id=$_GET["id"];
$action=$_GET["action"];

if($action == "block"){
    $query="UPDATE users SET status='UNBLOCK' WHERE id='$id'";

}
else{
    $query="UPDATE users SET status='BLOCK' WHERE id='$id'";

}

mysqli_query($conn, $query);
$url="users.php";
header("Location:$url");
exit();


?>