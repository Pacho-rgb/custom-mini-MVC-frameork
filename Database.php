<?php

namespace app;
use PDO;

class Database
{
    // Instantiating an object from an already existing class, to become the class' property 
    // public PDO $pdo;
    public PDO $pdo;
    public static Database $db;

    public function __construct() 
    {
        $this->pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud', 'root', '');
        // Calling setAttribute method in order to verify that there is no error during DB connection
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Storing the Database object inside our static $db variable
        self::$db = $this; //$this is the instance/object of the class. It is instantiated within the class
        // self::$db = $this;
    }

    // Retrieving the products from the database 
    public function getProducts($search='')
    {
        // Searching for a particular item
        $search = $_GET['search'] ?? '';
        if ($search){
        // Preparing the statement for execution
        $statement = $this->pdo->prepare("SELECT * FROM products WHERE title LIKE :search ORDER BY create_date DESC"); 
        $statement->bindValue(':search', "%$search%");
        }else{
        // Preparing the statement for execution
        $statement = $this->pdo->prepare("SELECT * FROM products ORDER BY create_date DESC");
        }
        // Fetching all of the rows in the form of associative array, then assigning them to the $products variable
        $statement->execute();
        $products = $statement -> fetchAll(PDO::FETCH_ASSOC);
        return $products;
    }

    // Getting product by id
    public function getProductById($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM products WHERE id = :id");
        $statement->bindValue(':id', $id);
        $statement->execute();
        $product = $statement -> fetch(PDO::FETCH_ASSOC);
        return $product;
    }

    // Inserting a product into the database
    public function createProduct($product)
    {
        // Inserting the harvested data into the database
        $statement = $this->pdo->prepare("
        INSERT INTO products
        (title, image, description, price, create_date)
        VALUES
        (:title, :image, :description, :price, :create_date)    
        ");
        // We should also bind the values
        $statement->bindValue(':title', $product->title); 
        $statement->bindValue(':image', $product->imagePath);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':create_date', date('Y-m-d H:i:s'));

        $statement->execute();
    }
    
    // Updating a product in the database based on the product's id
    public function updateProduct($product)
    {
        // Inserting the harvested data into the database
        $statement = $this->pdo->prepare("
        UPDATE products SET
        title = :title, image = :image, description = :description, price = :price  
        WHERE id = :id 
        ");

        $statement->bindValue(':title', $product->title); 
        $statement->bindValue(':image', $product->imagePath);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':id', $product->id);

        $statement->execute();
        header('Location: /'); 
    }

    // Deleting a product from the database based on the product's id
    public function deleteProduct($id)
    {
        // SQL delete query
        $statement = $this->pdo->prepare(
            "DELETE FROM products WHERE id = :id"
        );
        $statement->bindValue(':id', $id);
        $statement->execute();
        header('Location: /');

    }
}