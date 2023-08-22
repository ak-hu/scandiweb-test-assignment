<?php
class Product {
    private $connection;
    private $tableName = "products"; // Имя таблицы в базе данных

    public $id;
    public $sku;
    public $name;
    public $price;

    public function __construct($db) {
        $this->connection = $db;
    }
    
    public function getAllProducts() {
        $query = "SELECT * FROM " . $this->tableName;
        $result = $this->connection->query($query);

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return $products;
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
