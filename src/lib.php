<?php

define("SQL_ERROR_DUPLICATE", 1062);
define("SQL_ERROR_DATA_TOO_LONG", 1406); // Data exceeds character limit

require_once 'src/Model/Account.cls.php';
require_once 'src/Model/Product.cls.php';

// Sets the product category filter
if (isset($_GET["category"]))
{
    $category = $_GET["category"];
    
    $category_filter = Product::getCategoryIndexFromName($category);
}
else {
    $category_filter = null;
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
        echo "<b>" . $product->getName() . "</b><br/>";
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