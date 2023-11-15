<?php

namespace app;
use app\controllers\ProductController;
use app\Database;


class Router
{
    // Array for get requests 
    public array $getRoutes = [];

    // Array for post requests
    public array $postRoutes = [];

    // Declaring property of database instance
    public $db;

    // Database instance is created when router object is instanciated. We know that router is instantiated in the 
    // index file. 
    public function __construct()
    {
        $this->db = new Database;
    }

    public function get($url, $fn)
    {
        // Populating the $getRoutes array with the values from outside
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        // Populating the $postRoutes array with the values from outside
        $this->postRoutes[$url] = $fn;
    }

    // Detects the current route and the request method, and will execute the corresponding function.
    public function resolve()
    { 
        // The current route
        $currentUrl = $_SERVER['REQUEST_URI'] ?? '/';
        if (stripos($currentUrl, '?')){
            $currentUrl = substr($currentUrl, 0, strpos($currentUrl, '?'));
        }

        // The current request method
        $method =  $_SERVER['REQUEST_METHOD'];
        if ($method === 'GET'){
            $fn = $this->getRoutes[$currentUrl] ?? null;
        }else{
            $fn = $this->postRoutes[$currentUrl] ?? null; 
        }
        if ($fn){
            // We pass the optional $this parameter, which means that we pass this class to the destination method.
            // We pass this class to the destination since we'll need the class to render the view pages.
            call_user_func($fn, $this);
        }else{
            echo "Page not found";
        }
    }

    // Render views
    public function renderView($view, array $params = []) //Path to the view file e.g products/index
    {
        // Now here, we have the $products variable
        foreach ($params as $key=>$value):
            $$key = $value;
        endforeach;

        // any type of the output, eg echo statemnt and include will be saved to the buffer, hence not sent to the browser 
        ob_start();
        // Therefore, this file below will be saved to the buffer
        require_once __DIR__."/views/$view.php";
        // Get current buffer contents and delete current output buffer
        $content = ob_get_clean();
        // Including the layout file
        require_once __DIR__."/views/layout.php";
    }
}
