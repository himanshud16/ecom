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

<?php
require_once("../connect.php");
$id=$_GET["id"];

$query_search = "SELECT * FROM products WHERE id ='$id'";
        $result = mysqli_query($conn, $query_search);
        $record = mysqli_fetch_array($result);
        
        //deleting file            
        $file_name = $record["image"];
        $file_path = "profiles/$file_name";
        unlink($file_path);        


$query="DELETE FROM products WHERE id='$id'";
mysqli_query($conn, $query);
$url="products.php";
header("Location:$url");
exit();
?>