<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container_1{
            height: 2000px;
            background: #E3E6E6;
        }
        .carousel{
            /* margin-top: 4.45em;             */
            
        }
        .cards_over_img{
            margin: 270px 50px 50px 50px;
            /* border: 1px solid red; */
            width: 90%;

        }
        .pre{            
            /* border: 10px solid yellow; */
            width: 100%;
            height: 50%;

        }
        .carousel-inner img{
            
            -webkit-mask-image: linear-gradient(#000, rgba(255,255,255,0), rgba(255,255,255, 0)180%);

        }

        
        
    </style>
	<?php include_once("boot.php"); ?>
</head>
<body>
<?php include_once("connect.php"); ?>
    
<?php include_once("nav.php"); ?>
<div class="container_1">
    <div id="carouselExample" class="carousel slide position-relative">
        
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="home_img/1.jpg" class="d-block w-100" alt="Image 1">
            </div>
            <div class="carousel-item">
            <img src="home_img/2.jpg" class="d-block w-100" alt="Image 2">
            </div>
            <div class="carousel-item">
            <img src="home_img/3.jpg" class="d-block w-100" alt="Image 3">
            </div>
            <div class="carousel-item">
            <img src="home_img/4.jpg" class="d-block w-100" alt="Image 3">
            </div>
            <div class="carousel-item">
            <img src="home_img/5.jpg" class="d-block w-100" alt="Image 3">
            </div>
            <div class="carousel-item">
            <img src="home_img/6.jpg" class="d-block w-100" alt="Image 3">
            </div>
            <div class="carousel-item">
            <img src="home_img/7.jpg" class="d-block w-100" alt="Image 3">
            </div>
            <div class="carousel-item">
            <img src="home_img/8.jpg" class="d-block w-100" alt="Image 3">
            </div>
            
        </div>

        

        <div class="pre position-absolute top-0 start-0">
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
        

        

            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <div class="fade-out position-absolute top-0 start-0">

        </div>

        <div class="cards_over_img position-absolute top-0 start-0">
            <div class="row row-cols-1 row-cols-md-4 g-2 ">          

            <?php
                $sql = "SELECT * FROM categories";
                $result=mysqli_query($conn, $sql);
                while($record=mysqli_fetch_array($result)){
            ?>

                <div class="col">
                    <div class="card">
                        <!-- <img src="..." class="card-img-top" alt="..."> -->
                        <div class="card-body">                            
                            <h5 class="card-title"><?= $record["name"] ?></h5>
                            <p class="card-text"><a href="#">See more</a></p>                            
                        </div>                        
                    </div>
                    
                </div>
                <?php } ?>                    

                
            </div>
        </div>
    </div>
</div>
</body>
</html>