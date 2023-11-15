<?php


namespace app\controllers;

use app\models\Product;
use app\Router;

// This class contains the main logic of the app operations on products.
class ProductController  
{
    // Render the list of products
    public static function index(Router $router)
    {
        $search = $_GET['search'] ?? '';
        $products = $router->db->getProducts($search);

        echo $router->renderView('products/index', [
            'products' => $products,
            'search' => $search
        ]);
    }

    // Create a product
    public static function create(Router $router)
    {
        
        $errors = [];
        $productData = [
            'title' => '',
            'description' => '',
            'price' => '',
            'image' => ''
        ];
        // For the post request
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $productData['title'] = $_POST['title'];
            $productData['description'] = $_POST['description'] ;
            $productData['price'] = (float) $_POST['price'];
            $productData['imageFile'] = $_FILES['image'] ?? null;

            // In this case, all the validation and connection to the database methods  will be done in the Product class
            $product = new Product;
            $product -> load($productData); 
            $errors = $product -> save();
            if (empty($errors)){
                header('Location: /');
                exit;
            }
        }
        echo $router->renderView('products/create', [
            'product' => $productData,
            'errors' => $errors
        ]);
    }

    // Update a product based on the product id
    public static function update(Router $router)
    {
        $id = $_GET['id'] ?? null;
        $errors = [];
        if (!$id){
            header('Location: /');
            exit;
        }
        // We need to populate the fields in the form of the products which we want to update
        // Therefore, we'll like to get the current data
        $productData = $router->db->getProductById($id);
        
        // If we post the updated products
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $productData['title'] = $_POST['title'];
            $productData['description'] = $_POST['description'] ;
            $productData['price'] = (float) $_POST['price'];
            $productData['imageFile'] = $_FILES['image'] ?? null;

            $product = new Product;
            $product -> load($productData); 
            $errors = $product -> save();

            if (empty($errors)){
                header('Location: /');
                exit;
            }
        }

        $router->renderView('products/update', [
            'product' => $productData,
            'errors' => $errors,
        ]);

    }

    // Delete a product based on the product id
    public static function delete(Router $router)
    {
        $id = $_POST['id'] ?? null;
        if ($id){
            $router->db->deleteProduct($id);
        }else{
            header('Location: /');
            exit;
        }
    }
}