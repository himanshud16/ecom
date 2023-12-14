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
include_once("nav.php"); ?>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email ID</th>
                <th>Password</th>
                <th>User Type</th>
                <th>Action</th>
                <th>Status</th>
                <th>Block/Uncblock</th>        
            </tr>
        </thead>

        <tbody>
            <?php
                
                $query="SELECT * FROM users";
                $result= mysqli_query($conn, $query);
                if($result){
                    // echo "fetcched";

                    //count number of records

                    $total = mysqli_num_rows($result);

                    // echo "$total records found <br/>";

                    while( $record = mysqli_fetch_array($result)){
                        // echo "<pre>";
                        // print_r($record);
                        // echo "</pre>";
                        
                        $id= $record["id"];
                        $name= $record["name"];
                        $email= $record["email"];
                        $password= $record["password"];
                        $user_type= $record["user_type"];
                        $status= $record["status"];



                        ?>


                        
                        <tr>
                            <td><?= $name ?> </td>
                            <td><?= $email ?> </td>
                            <td><?= $password ?> </td>
                            <td><?= $user_type ?> </td>

                            <td>
                                <a href="edit_user.php?id=<?= $id ?>">
                                <button class="btn btn-success">Edit</button></a>

                                <?php if($user_type=="user"){ ?>

                                    <a href="delete_user.php?id=<?= $id ?>"><button class="btn btn-danger">Delete</button></a></a>
                                
                                <?php }  ?>
                            </td>

                            <td><?= $status ?> </td>

                            <?php if($user_type=="user"){ ?>

                                <td>
                                <?php if($status=="UNBLOCK"){ ?>
                                    <a href="block.php?id=<?= $id ?>&action=unblock">
                                    <button class="btn btn-danger">BLOCK</button></a>
                                <?php }else{  ?>                            
                                    <a href="block.php?id=<?= $id ?>&action=block">
                                    <button class="btn btn-success">UNBLOCK</button></a>
                                <?php }  ?>

                                </td>

                            <?php }  ?>

                            
                            

                            
                            
                        </tr>
                        
                    <?php

                    }
                }

                else{
                    echo "something wrong";
                }

            ?>
        </tbody>
    </table>
</body>
</html>