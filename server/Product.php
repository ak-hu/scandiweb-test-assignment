<?php
namespace App;
require_once 'CustomException.php';

use App\CustomException;


class Product
{
    private $connection;
    private $tableName = "products";
    private $descriptionTableName = "product_attributes";

    public function __construct($db)
    {
        $this->connection = $db;
    }

    public function getAllProducts()
    {
        $query = "SELECT * FROM {$this->tableName}";
        $result = $this->connection->query($query);

        if (!$result) {
            throw new CustomException("Error retrieving products: " . $this->connection->error);
        }

        $products = [];
        while ($row = $result->fetch_assoc()) {
            $product_id = $row['id'];
            $row['description'] = $this->getProductDescription($product_id);
            $products[] = $row;
        }

        return $products;
    }

    public function getProductDescription($id)
    {
        $query = "SELECT attribute, value FROM {$this->descriptionTableName} WHERE product_id = ?";
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

    public function save($data)
    {
        $existingProductQuery = "SELECT id FROM `{$this->tableName}` WHERE sku = ?";
        $stmt = $this->connection->prepare($existingProductQuery);
        $stmt->bind_param('s', $data['sku']);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            throw new CustomException("SKU already exists");
        }

        $insertProductQuery = "INSERT INTO `{$this->tableName}`
            (`sku`, `name`, `price`, `description_id`)
            VALUES (?, ?, ?, NULL)";
        $stmt = $this->connection->prepare($insertProductQuery);

        if (!$stmt) {
            throw new CustomException("Error in query preparation: " . $this->connection->error);
        }

        $stmt->bind_param('sss', $data['sku'], $data['name'], $data['price']);

        if ($stmt->execute()) {
            $product_id = $this->connection->insert_id;
            $insertDescriptionQuery = "INSERT INTO `{$this->descriptionTableName}`
                (product_id, attribute, value)
                VALUES (?, ?, ?)";
            $stmt = $this->connection->prepare($insertDescriptionQuery);
            $stmt->bind_param("iss", $product_id, $data['attribute'], $data['value']);

            if ($stmt->execute()) {
                $description_id = $this->connection->insert_id;
                $updateProductQuery = "UPDATE `{$this->tableName}`
                    SET description_id=?
                    WHERE id=?";
                $stmt = $this->connection->prepare($updateProductQuery);
                $stmt->bind_param("ii", $description_id, $product_id);

                if ($stmt->execute()) {
                    return true;
                } else {
                    throw new CustomException("Query execution failed: " . $stmt->error);
                }
            } else {
                throw new CustomException("Error executing query: " . $stmt->error);
            }
        }
        return false;
    }

    public function massDeleteProducts($productIds)
    {
        $productIdsStr = implode(',', $productIds);
        $updateQuery = "UPDATE `{$this->tableName}`
            SET `description_id` = NULL
            WHERE `id` IN ($productIdsStr)";
        $updateStmt = $this->connection->prepare($updateQuery);

        if (!$updateStmt) {
            throw new CustomException("Error in query preparation: " . $this->connection->error);
        }

        if (!$updateStmt->execute()) {
            throw new CustomException("Error during update: " . $updateStmt->error);
        }

        $deleteQuery = "DELETE FROM {$this->descriptionTableName}
            WHERE product_id IN ($productIdsStr)";
        $deleteStmt = $this->connection->prepare($deleteQuery);

        if (!$deleteStmt) {
            throw new CustomException("Error during delete: " . $this->connection->error);
        }

        if ($deleteStmt->execute()) {
            $finalDeleteQuery = "DELETE FROM `{$this->tableName}`
                WHERE `id` IN ($productIdsStr)";
            $finalDeleteStmt = $this->connection->prepare($finalDeleteQuery);

            if (!$finalDeleteStmt) {
                throw new CustomException("Error in query preparation: " . $this->connection->error);
            }

            if ($finalDeleteStmt->execute()) {
                return true;
            } else {
                throw new CustomException("Error during final delete: " . $finalDeleteStmt->error);
            }
        } else {
            throw new CustomException("Error during delete: " . $deleteStmt->error);
        }
    }
}
?>
