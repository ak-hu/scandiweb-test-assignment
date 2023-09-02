<?php
class ProductList {
    private $product;

    public function __construct($product) {
        $this->product = $product;
    }
    
    public function render() {
        $products = $this->product->getAllProducts(); 
        echo "<h1>Product List</h1>";
        echo "<ul>";
        foreach ($products as $product) {
            echo "<li>{$product['name']} - {$product['price']}</li>";
        }
        echo "</ul>";
    }
}
?>
