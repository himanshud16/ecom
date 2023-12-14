<link rel="stylesheet" href="../nav.css">

<nav class="navbar navbar-expand-lg ">
  <div class="container">
        <a class="navbar-brand logo_a" href="../index.php">
            <img class="logo" src="../profiles/logo_amazon.webp" alt="">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">                

                <li class="nav-item ">
                    <a class="nav-link text-white" href="index.php">Brands</a>
                </li>

                <?php
                    //session_start();
                    if(isset($_SESSION["name"]))
                    {
                        if($_SESSION["user_type"]=="admin"){
                ?>

                <li class="nav-item">
                    <a class="nav-link text-white" href="register.php">BrandRegister</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="../products/register.php">ProductRegister</a>
                </li>                

                <li class="nav-item">
                    <a class="nav-link text-white" href="../users.php">Users</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="brands.php">BrandEdit</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white" href="../products/products.php">ProductEdit</a>
                </li>
                
                <?php } }?>                               
            </ul>

            <ul class="navbar-nav  mb-2 mb-lg-0">
                

                <li class="nav-item position-relative">
                
                 <?php if(isset($_SESSION["name"])){ ?>
                                       

                    <li class="nav-item dropdown">

                        <a class="nav-link text-white dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><b>Accounts & Lists</b></a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Hello, <?= $_SESSION["name"]; ?> </a></li>
                            <li><a class="dropdown-item" href="#">Your Orders</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../logout.php">Sign Out</a></li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-white" href="../dashboard.php">Returns <b>& Orders</b> </a>                        
                    </li>
                    

                    <li class="nav-item cart-number position-absolute fw-bold">
                            <?php 
                            if(isset($_SESSION["user_id"])){
                            $user_id=$_SESSION['user_id'];
                            $query_search = "SELECT SUM(qty) FROM cart WHERE user_id ='$user_id'";
                            $result = mysqli_query($conn, $query_search);
                            $record = mysqli_fetch_array($result);
                            $SUM_qty = $record["SUM(qty)"];
                            if($SUM_qty){
                                echo $SUM_qty;
                            }
                            else {
                                echo "0";
                            }
                            }
                            ?>
                    </li>

                    <li>
                    <a class="nav-item active text-white" aria-current="page" href="../cart/cart.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-cart float-end opacity-100 text-white" viewBox="0 0 16 16">
                                <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </svg>
                    </a>
                    </li>


                    

                <?php }else{ ?>
                    <a class="nav-link text-white" href="../login.php">UserLogin</a>
                <?php } ?>
                </li>
            </ul>
        
        </div>
  </div>
</nav>