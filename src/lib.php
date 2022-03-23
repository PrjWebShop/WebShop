<?php

define("SQL_ERROR_DUPLICATE", 1062);
define("SQL_ERROR_DATA_TOO_LONG", 1406); // Data exceeds character limit
define("MAX_PRODUCT_PER_PAGE", 8);
define("DEFAULT_IMAGE_PATH", "Img/default.jpg");

require_once 'src/Model/Account.cls.php';
require_once 'src/Model/Product.cls.php';

// Checks if the user is logged in and retrieves account information if they are
if (isset($_COOKIE["user"])) {
    $user = Account::getAccountInfo($_COOKIE["user"]);
    $cart = Product::getProductListFromCart($user->getAccountId());
    $accountLogged = true;
}
else {
    //local cart - todo
    $accountLogged = false;
}

// User hit logout
if (isset($_REQUEST["logout"])) {
    setcookie("user", "", time() - 3600);
    header("Location: login.php");
}
// Add to cart button
if (isset($_REQUEST["addToCart"])) {
    $prodID = $_REQUEST["productID"];
    $prod = Product::getProductByID($prodID);

    // check if user is the seller of the product
    
    if ($accountLogged)
    {
        Product::addProductToCart($user->getAccountId(), $prod->getProductId(), 1);
    }
    // add product to local storage

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

$listOfProducts = Product::getProductList($category_filter, $search);

if ($listOfProducts != 0)
{
    $maxPage = ceil(count($listOfProducts) / MAX_PRODUCT_PER_PAGE);

    if (isset($_GET["page"]))
    {
        $currentPage = min($_GET["page"], $maxPage);
    }
    else
    {
        $currentPage = 1;
    }
    $productFound = true;
}
else 
{
    $productFound = false;
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
    global $currentPage, $user, $accountLogged;

    if ($listOfProducts == 0)
        return;

    $start = ($currentPage - 1) * MAX_PRODUCT_PER_PAGE + 1;
    $end = $start + MAX_PRODUCT_PER_PAGE;
    $count = 1;
    foreach ($listOfProducts as $product) {
        if ($count++ < $start)
        {
            continue;
        }
            echo "<div class='col-12 col-md-6'>";
                echo "<div class='card m-2'>";
                    echo "<img class='card-img-top' src='" . $product->getImagePath() . "' alt='Card image cap'>";
                    echo "<div class='card-body'>";
                        echo "<b><a href='product.php?id=". $product->getProductId() . "'>" . $product->getName() . "</a></b><br/>";
                        echo "<i>" . $product->getDescription() . "</i><br/><br/>";
                        echo "Price: $" . $product->getPrice() . "<br/>";
                        echo "Quantity: " . $product->getQuantity() . " in stock <br/>";
                        if ($product->getCategoryId() == 4)
                            echo "Size: " . Product::getSizeToString($product->getSize()) . "<br/>";
                        $seller = Account::getAccountInfo($product->getSellerId());
                        echo "Seller: " . $seller->getFirstName() . " " . $seller->getLastName() . "<br/>";
                        if ($accountLogged && $user->getAccountId() == $product->getSellerId())
                        {
                            echo "<input type='button' value='Cannot purchase your own products' disabled />";
                        }
                        elseif ($accountLogged && Product::isProductInCart($user->getAccountId(), $product->getProductId()))
                        {
                            echo "<input type='button' value='In Cart' disabled />";
                        }
                        else
                        {
                            echo "<form method='POST'>";
                                echo "<input type='hidden' name='productID' value='". $product->getProductId() ."'/>";
                                echo "<input type='submit' name='addToCart' value='Add to cart'/>";
                            echo "</form>";
                        }
                        

                        
                    echo "</div>";
                echo "</div>";
            echo "</div>";
        
        if ($count == $end)
        { return; }
    }
}

function navigationArrows()
{
    global $currentPage, $maxPage;
    
    echo "<input type='button' value='|<'" . ($currentPage == 1 ? "disabled" : "") . " />";
    echo "<input type='button' value='<'" . ($currentPage == 1 ? "disabled" : "") . " />";
    echo "&nbsp $currentPage / $maxPage &nbsp";
    echo "<input type='button' value='>'" . ($currentPage == $maxPage ? "disabled" : "") . "/>";
    echo "<input type='button' value='>|'" . ($currentPage == $maxPage ? "disabled" : "") . "/>";
}