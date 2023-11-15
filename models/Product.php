<?php

namespace app\models;

use app\Database;
use app\helpers\UtilHelper;

// This will be the mapping of the class to the database table
class Product
{
    public $helper;
    
    // The following properties will be the table columns.
    public ?int $id = null;
    public ?string $title = null;
    public ?string $description = null;
    public ?string $imagePath = null;
    public ?float $price = null;
    public ?array $imageFile = null;

    // Takes the data from the $data parameter and assign the to the properties declared above.
    public function load($data): void
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'];
        $this->description = $data['description'] ?? '';
        $this->price = $data['price'];
        $this->imagePath = $data['image'] ?? null;
        $this->imageFile = $data['imageFile'] ?? null; // This is the image array. 
    }

    public function save(): array
    {
        $errors = [];
        // Validation
        if (!$this->title){
            $errors[] = 'Title is required';
        }
        if (!$this->price){
            $errors[] = 'Price is required';
        }

        if (!is_dir(__DIR__.'/../public/images')){
            mkdir(__DIR__.'/../public/images');
        }

        if (empty($errors)){
            // Handling of file data 
            // If the uploaded image exists
            if ($this->imageFile && $this->imageFile['tmp_name']){
        
                // If the existing product has an image, and we want to update it, we'll have to delete the existing image
                if ($this->imagePath){
                    unlink(__DIR__.'/../public/'. $this->imagePath);
                }
                $this->helper = new UtilHelper;

                $this->imagePath = 'images/' .$this->helper->randomString() . '/' . $this->imageFile['name'];
        
                mkdir(dirname(__DIR__.'/../public/'. $this->imagePath));
                move_uploaded_file($this->imageFile['tmp_name'], __DIR__.'/../public/'. $this->imagePath);
                }
                $db = Database::$db;
                // $db = new Database;
                if ($this->id){
                    $db->updateProduct($this);
                }else{
                    $db->createProduct($this);
            }
            
        }
        return $errors;
    }
}