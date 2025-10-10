<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *"); 


$products = [
    ["id" => 1, "name" => "Laptop", "price" => 800],
    ["id" => 2, "name" => "Phone", "price" => 500],
    ["id" => 3, "name" => "Headphones", "price" => 100],
];

echo json_encode($products);
?>
