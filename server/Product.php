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
    public $attribute;
    public $value;

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
            $descriptions = $this->getProductDescription($product_id);
            $row['description'] = $descriptions;
            $products[] = $row;
        }
    
        return $products;
    }

    public function getProductDescription($id) {
        $query = "SELECT attribute, value FROM " . $this->descriptionTableName . " WHERE product_id = ?";
        $stmt = $this->connection->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
    
        $descriptions = [];
        while ($row = $result->fetch_assoc()) {
            $descriptions[] = $row;
        }
    
        $stmt->close();
    
        return $descriptions;
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