<?php
namespace App;
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'Product.php'; 
require_once 'Database.php'; 

use App\Database;
use App\Product;
use function http_response_code;

header("Access-Control-Allow-Origin: http://localhost:3000");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

class ApiHandler {
    private $product;

    public function __construct() {
        $database = new Database();
        $connection = $database->connect();
        $this->product = new Product($connection);
    }

    public function handleRequest() {
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            http_response_code(204);
            exit;
        }

        if (isset($_GET['endpoint'])) {
            $endpoint = $_GET['endpoint'];

            switch ($endpoint) {
                case 'getProducts':
                    $products = $this->product->getAllProducts();
                    echo json_encode($products);
                    break;
                case 'addProduct':
                    $data = json_decode(file_get_contents("php://input"), true);
                    $result = $this->product->save($data);
                    if ($result) {
                        echo json_encode(['message' => 'Product added successfully!']);
                    } else {
                        http_response_code(400);
                        echo json_encode(['message' => 'Failed to add a product.']);
                    }
                    break;
                case 'massDeleteProducts':
                    $data = json_decode(file_get_contents("php://input"), true);
                    $result = $this->product->massDeleteProducts($data['productIds']);
                    if ($result) {
                        echo json_encode(['message' => 'Products deleted successfully']);
                    } else {
                        http_response_code(400);
                        echo json_encode(['message' => 'Failed to delete products.']);
                    }
                    break;
                default:
                    echo "Endpoint not found";
                    break;
            }
        } else {
            http_response_code(500);
            echo json_encode(['message' => 'Invalid request method or endpoint']);
        }
    }
}

$apiHandler = new ApiHandler();
$apiHandler->handleRequest();
?>
