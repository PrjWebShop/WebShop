<?php
$host   = "127.0.0.1";
$dbName = "WebShop";
$user   = "root";
$pass   = "";

try
{
    $connection = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} 
catch(PDOException $e) 
{
    echo "Error: " . $e->getMessage();
}
