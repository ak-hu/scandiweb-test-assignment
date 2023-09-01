<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once 'Product.php'; 
    require_once 'Database.php'; 

    header("Access-Control-Allow-Origin: http://localhost:3000");
    header("Content-Type: application/json");

    // database connection
    $database = new Database();
    $connection = $database->connect();

    // product object
    $product = new Product($connection);

    // fetching products from the database
    $products = $product->getAllProducts();

    echo json_encode($products);
?>
