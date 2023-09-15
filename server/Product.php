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

    public function save($data) {
        $existingProductQuery = "SELECT id FROM `" . $this->tableName . "` WHERE sku = ?";
        $stmt = $this->connection->prepare($existingProductQuery);
        $stmt->bind_param('s', $data['sku']);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            echo "SKU already exists";
            return false;
        }

        $query = "INSERT INTO `" .$this->tableName. "`
                  (`sku`, `name`, `price`, `description_id`)
                  VALUES
                  (?, ?, ?, NULL)";
    
        $stmt = $this->connection->prepare($query);
        if (!$stmt) {
            die('Error in query preparation: ' . $this->connection->error);
        }
    
        $stmt->bind_param('sss', $data['sku'], $data['name'], $data['price']);
    
        if ($stmt->execute()) {
            $product_id = $this->connection->insert_id;
            $query = "INSERT INTO `" . $this->descriptionTableName . "`
                          (product_id, attribute, value)
                          VALUES
                          (?, ?, ?)";
        
            $stmt = $this->connection->prepare($query);
            $stmt->bind_param("iss", $product_id, $data['attribute'], $data['value']);

            if ($stmt->execute()) {
                $description_id = $this->connection->insert_id;
                $query = "UPDATE `" . $this->tableName . "`
                      SET description_id=?
                      WHERE id=?";
    
                $stmt = $this->connection->prepare($query);
                $stmt->bind_param("ii", $description_id, $product_id);
        
                if ($stmt->execute()) {
                    return true;
                } else {
                    echo "Query execution failed: " . $stmt->error;
                    return false;
                }
            } else {
                echo "Query_2 execution failed: " . $stmt->error;
            }
        }
        return false;
    }
    
    public function massDeleteProducts($productIds) {
        $productIdsStr = implode(',', $productIds);

        $updateQuery = "UPDATE `" . $this->tableName . "`
                        SET `description_id` = NULL
                        WHERE `id` IN ($productIdsStr)";
        
        $updateStmt = $this->connection->prepare($updateQuery);
        
        if (!$updateStmt) {
            die('Error in query preparation: ' . $this->connection->error);
        }
        
        if (!$updateStmt->execute()) {
            echo "Error during update: " . $updateStmt->error;
            return false;
        }
        
        $deleteQuery = "DELETE FROM " . $this->descriptionTableName . " 
                        WHERE product_id IN ($productIdsStr)";
        
        $deleteStmt = $this->connection->prepare($deleteQuery);
        
        if (!$deleteStmt) {
            die('Error in query preparation: ' . $this->connection->error);
        }
        
        if ($deleteStmt->execute()) {
            $finalDeleteQuery = "DELETE FROM `" . $this->tableName . "`
                                 WHERE `id` IN ($productIdsStr)";
            
            $finalDeleteStmt = $this->connection->prepare($finalDeleteQuery);
            
            if (!$finalDeleteStmt) {
                die('Error in query preparation: ' . $this->connection->error);
            }
            
            if ($finalDeleteStmt->execute()) {
                return true;
            } else {
                echo "Error during final delete: " . $finalDeleteStmt->error;
                return false;
            }
        } else {
            echo "Error during delete: " . $deleteStmt->error;
            return false;
        }
    }
       
}
?>