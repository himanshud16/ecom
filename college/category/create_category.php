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
<?php
require_once("../connect.php"); 
if(isset($_POST["create"])){
	$name=$_POST["name"];
	$query="INSERT INTO categories(name)VALUES('$name')";
	mysqli_query($conn, $query);
	echo "Created";
}
 ?>
	<form action="create_category.php" method="POST">
		<p>
			<label for="name">Name</label>
			<input type="text" name="name">
		</p>
		<p>
			<input type="submit" name="create" value="Create">
		</p>
	</form>
	
</body>
</html>