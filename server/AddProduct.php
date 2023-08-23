<?php
class AddProduct {
    private $product;

    public function __construct($product) {
        $this->product = $product;
    }

    public function render() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $sku = $_POST['sku'];
            $name = $_POST['name'];
            $price = $_POST['price'];

            $this->product->setSku($sku);
            $this->product->setName($name);
            $this->product->setPrice($price);

            if ($this->product->save()) {
                echo "Product added successfully!";
            } else {
                echo "Failed to add product.";
            }
        } else {
            echo "<h1>Add Product</h1>";
            echo "<form method='post'>";
            echo "SKU: <input type='text' name='sku'><br>";
            echo "Name: <input type='text' name='name'><br>";
            echo "Price: <input type='text' name='price'><br>";
            echo "<input type='submit' value='Add Product'>";
            echo "</form>";
        }
    }
}
?>
