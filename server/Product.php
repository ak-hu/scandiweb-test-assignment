<?php
class Product {
    private $connection;
    private $tableName = "products"; 
    private $descriptionTableName = "product_attributes"; 

    public $id;
    public $sku;
    public $name;
    public $price;
    public $description;

    public function __construct($db) {
        $this->connection = $db;
    }
    
    public function getAllProducts() {
        $query = "SELECT * FROM " . $this->tableName;
        $result = $this->connection->query($query);

        if (!$result) {
            echo "Error: " . $this->connection->error; 
            return []; 
        }

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['id'];
            $description = $this->getProductDescription($product_id);
        
            // Добавим отладочный вывод
            echo "Product ID: " . $product_id;
            echo "Description: " . $description;
            
            $row['description'] = $description;
            $products[] = $row;
        }

        return $products;
    }

    public function getProductDescription($product_id) {
        $query = "SELECT * FROM " . $this->descriptionTableName . " WHERE product_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $stmt->bind_result($description);
        $stmt->fetch();
        $stmt->close();

        return $description;
    }
    

    // Метод для сохранения продукта в базу данных
    public function save() {
        $query = "INSERT INTO " . $this->tableName . "
                  SET sku=:sku, name=:name, price=:price";

        $stmt = $this->connection->prepare($query);

        $this->sku = htmlspecialchars(strip_tags($this->sku));
        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->price = htmlspecialchars(strip_tags($this->price));

        $stmt->bindParam(":sku", $this->sku);
        $stmt->bindParam(":name", $this->name);
        $stmt->bindParam(":price", $this->price);

        if ($stmt->execute()) {
            return true;
        }
        
        return false;
    }
}
?>