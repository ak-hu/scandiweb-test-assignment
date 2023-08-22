<?php
class ProductList {
    private $product;

    public function __construct($product) {
        $this->product = $product;
    }

    // Метод для отображения списка продуктов
    public function render() {
        // Получите список продуктов из базы данных (ваш запрос к базе данных)
        $products = $this->product->getAllProducts(); 

        // Выводите список продуктов на страницу
        echo "<h1>Product List</h1>";
        echo "<ul>";
        foreach ($products as $product) {
            echo "<li>{$product['name']} - {$product['price']}</li>";
        }
        echo "</ul>";
    }
}
?>
