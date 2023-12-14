<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php include_once("../boot.php"); ?>
    <style>
        .card img{
            width: 100%;
            height: 12.2em;
            object-fit: contain ;
        }
    </style>
</head>
<body>
    <?php 
    require_once("../connect.php");    
    include_once("nav.php");     ?>
<div class="row row-cols-1 row-cols-md-6 g-4 mt-3 mx-3">
<?php

    $query="SELECT * FROM brands";
    $result= mysqli_query($conn, $query);

        while( $record = mysqli_fetch_array($result)){
            // echo "<pre>";
            // print_r($record);
            // echo "</pre>";
            
            $id= $record["id"];
            $name= $record["name"];
            $image= $record["image"];
            ?>
        
            <div class="col">
                <div class="card">
                    <img src="profiles/<?= $image ?>" alt="<?= $name?>" class="card-img-top">
                    <div class="card-body">
                    <h5 class="card-title"><?= "$name"; ?></h5>
                    <a href="../products/index.php?id=<?= $id ?>" class="btn btn-primary">Product page</a>
                </div>
                </div>
            </div>
  

<?php } ?>

</div>


</body>
</html>