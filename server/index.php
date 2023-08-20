<?php
    // Include necessary classes and configuration files
    require_once 'Product.php'; // Your main product class
    require_once 'Database.php'; // Your database connection class
    require_once 'ProductList.php'; // Your product list page logic
    require_once 'AddProduct.php'; // Your add product page logic

    // Initialize database connection
    $database = new Database();
    $connection = $database->connect();

    // Initialize product objects
    $product = new Product($connection);
    $productList = new ProductList($product);
    $addProduct = new AddProduct($product);

    // Handle requests based on the requested page
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
        if ($page === 'product_list') {
            $productList->render();
        } elseif ($page === 'add_product') {
            $addProduct->render();
        } else {
            echo "Page not found";
        }
    } else {
        echo "Welcome to the web app!";
    }

    // Additional code to get products for JSON API
    $query = "SELECT * FROM products";
    $result = $connection->query($query);

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    header('Content-Type: application/json');
    echo json_encode($products);

?>