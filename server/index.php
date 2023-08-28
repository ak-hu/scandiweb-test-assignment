<?php
    require_once 'Product.php'; 
    require_once 'Database.php'; 
    require_once 'ProductList.php';
    require_once 'AddProduct.php';

    // database connection
    $database = new Database();
    $connection = $database->connect();

    // product objects
    $product = new Product($connection);
    $productList = new ProductList($product);
    $addProduct = new AddProduct($product);

    // requests based on the requested page
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if ($page === 'add_product') {
            $addProduct->render();
        } else {
            echo "Page not found";
        }
    } elseif (isset($_GET['endpoint'])) {
        $endpoint = $_GET['endpoint'];
        if ($endpoint === 'getProducts') {
            $products = $product->getAllProducts();
            header('Content-Type: application/json');
            echo json_encode($products);
        } else {
            echo "Endpoint not found";
        }
    } else {
        echo "Welcome to the web app!";
    }
?>