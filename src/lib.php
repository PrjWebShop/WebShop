<?php

define("SQL_ERROR_DUPLICATE", 1062);
define("SQL_ERROR_DATA_TOO_LONG", 1406); // Data exceeds character limit

require_once 'src/Model/Account.cls.php';
require_once 'src/Model/Product.cls.php';

// Checks if the user is logged in and retrieves account information if they are
if (isset($_COOKIE["user"])) {
    $user = Account::getAccountInfo($_COOKIE["user"]);
    $accountLogged = true;
}
else {
    $accountLogged = false;
}

// User hit logout
if (isset($_REQUEST["logout"])) {
    setcookie("user", "", time() - 3600);
    header("Location: login.php");
}

// Sets the product category filter
if (isset($_GET["category"]))
{
    $category = $_GET["category"];

    $category_filter = Product::getCategoryIndexFromName($category);
}
else {
    $category_filter = false;
}

// Search button
if (isset($_GET["search"])) 
{
    $search = $_GET["search"];
}
else {
    $search = false;
}

function displayCategories()
{
    $listOfCategories = Product::getCategoryList();
    
    foreach ($listOfCategories as $category)
    {
        echo "<a href='?category=$category' class='list-group-item list-group-item-action'>$category</a>";
    }
}

/**
 * Function that displays the products
 * 
 * @param Product[] $listOfProducts
 */
function displayProducts($listOfProducts)
{
    foreach ($listOfProducts as $product) {
        echo "<div class='col-12 col-md-6'>";
            echo "<div class='card m-2'>";
                // echo "<img class='card-img-top' src='" . $product->getImage() . "' alt='Card image cap'>";
                echo "<div class='card-body'>";
                    echo "<u>" . Product::getCategoryName($product->getCategoryId()) . "</u><br/><br/>";
                    echo "<b><a href='product.php?id=". $product->getProductId() . "'>" . $product->getName() . "</a></b><br/>";
                    echo "<i>" . $product->getDescription() . "</i><br/><br/>";
                    echo "Price: $" . $product->getPrice() . "<br/>";
                    echo "Quantity: " . $product->getQuantity() . " in stock <br/>";
                    if ($product->getCategoryId() == 4)
                        echo "Size: " . Product::getSizeToString($product->getSize()) . "<br/>";
                    $seller = Account::getAccountInfo($product->getSellerId());
                    echo "Seller: " . $seller->getFirstName() . " " . $seller->getLastName() . "<br/>";
                echo "</div>";
            echo "</div>";
        echo "</div>";
    }
}