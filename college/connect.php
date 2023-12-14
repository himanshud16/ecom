<?php
$server="localhost";
$user="root";
$password="";
$database="college";

//conn responsible to run all queries
$conn = mysqli_connect($server, $user, $password, $database);

if($conn){
    // echo "Connected with database <br/>";

    // now create all the tables

    $query="CREATE TABLE IF NOT EXISTS users(
        id INT(10) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        user_type VARCHAR(255) DEFAULT 'user',
        profile VARCHAR(255) DEFAULT NULL,
        status VARCHAR(255) DEFAULT 'UNBLOCK'
        )";

    //now run this query
    mysqli_query($conn, $query);


    $query_brand="CREATE TABLE IF NOT EXISTS brands(
        id INT(10) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        image VARCHAR(255) NOT NULL
        )"; 

    mysqli_query($conn, $query_brand);

    $query_categories="CREATE TABLE IF NOT EXISTS categories(
        id INT(10) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL
        )"; 

    $result = mysqli_query($conn, $query_categories);



    $query_product="CREATE TABLE IF NOT EXISTS products(
        id INT(10) AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        brand_id INT(10) NOT NULL,
        category_id INT(10) NOT NULL,
        image VARCHAR(255) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        sale_price DECIMAL(10,2) NOT NULL,
        qty INT(10) NOT NULL,
        FOREIGN KEY(brand_id) REFERENCES brands(id),
        FOREIGN KEY(category_id) REFERENCES categories(id)
        )";

    mysqli_query($conn, $query_product);


    $query_cart="CREATE TABLE IF NOT EXISTS cart(
        id INT(10) AUTO_INCREMENT PRIMARY KEY,
        user_id INT(10) NOT NULL,
        product_id INT(10) NOT NULL,
        qty INT(10) DEFAULT 1,
        FOREIGN KEY(user_id) REFERENCES users(id),
        FOREIGN KEY(product_id) REFERENCES products(id)


        )"; 

    mysqli_query($conn, $query_cart);

    // payment table

    $sql="CREATE TABLE IF NOT EXISTS payments(
        id INT(10) AUTO_INCREMENT PRIMARY KEY,
        payment_request_id VARCHAR(255) NOT NULL,
        payment_id VARCHAR(255) DEFAULT NULL,
        status VARCHAR(255) DEFAULT 'pending',
        amount DECIMAL(10,2) NOT NULL,
        user_id INT(10) NOT NULL,
        FOREIGN KEY(user_id) REFERENCES users(id)
    )";

    mysqli_query($conn, $sql);


    // order table

    $sql="CREATE TABLE IF NOT EXISTS orders(
        id INT(10) AUTO_INCREMENT PRIMARY KEY,
        payment_id INT(10) NOT NULL,
        user_id INT(10) NOT NULL,
        status VARCHAR(255) DEFAULT 'placed',
        FOREIGN KEY(payment_id) REFERENCES payments(id),
        FOREIGN KEY(user_id) REFERENCES users(id)
    ) ";
    mysqli_query($conn, $sql);


    // order details table

    $sql="CREATE TABLE IF NOT EXISTS order_details(
        id INT(10) AUTO_INCREMENT PRIMARY KEY,
        order_id INT(10) NOT NULL,
        product_id INT(10) NOT NULL,
        qty DECIMAL(10,2) NOT NULL,
        FOREIGN KEY(order_id) REFERENCES orders(id),
        FOREIGN KEY(product_id) REFERENCES products(id)
    )";
    mysqli_query($conn, $sql);  
        
        
}
else{
    echo "failed to connect with database";
}


?>