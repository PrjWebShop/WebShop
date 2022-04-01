<?php

require_once 'src/Model/Account.cls.php';
require_once 'src/Model/Product.cls.php';

include 'js/javascript.php';

define("SQL_ERROR_DUPLICATE", 1062);
define("SQL_ERROR_DATA_TOO_LONG", 1406); // Data exceeds character limit

define("MAX_PRODUCT_PER_PAGE", 8);

define("DEFAULT_IMAGE_PATH", "Img/default.jpg");

// Checks if the user is logged in and retrieves account information if they are
if (isset($_COOKIE["user"])) {
    $user = Account::getAccountInfo($_COOKIE["user"]);
    $cart = Product::getProductListFromCart($user->getAccountId());
    $accountLogged = true;
} else {
    //TODO - Add to local cart
    $accountLogged = false;
}

// User hit logout
if (isset($_REQUEST["logout"])) {
    setcookie("user", "", time() - 3600);
}
// Add to cart button
if (isset($_REQUEST["addToCart"])) {
    $addToCartOK = true;
    $prodID = $_REQUEST["productID"];
    $prod = Product::getProductByID($prodID);

    // check if user is the seller of the product
    if ($prod->getSellerId() == $user->getAccountId()) {
        $addToCartOK = false;
        alert("You cannot add your own products in your cart!");
    }

    if ($accountLogged && $addToCartOK) {
        Product::addProductToCart($user->getAccountId(), $prod->getProductId(), 1);
        unset($_POST);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    //TODO - Add to local cart

}

// Sets the product category filter
if (isset($_GET["category"])) {
    $category = $_GET["category"];
    $category_filter = Product::getCategoryIndexFromName($category);
} else {
    $category = false;
    $category_filter = false;
}

// Search button
if (isset($_GET["search"])) {
    $search = $_GET["search"];
} else {
    $search = false;
}

$listOfProducts = Product::getProductList($category_filter, $search);

if ($listOfProducts != 0) {
    $maxPage = ceil(count($listOfProducts) / MAX_PRODUCT_PER_PAGE);

    if (isset($_GET["page"])) {
        $currentPage = min($_GET["page"], $maxPage);
    } else {
        $currentPage = 1;
    }
    $productFound = true;
} else {
    $productFound = false;
}


function displayCategories()
{
    global $category;
    $listOfCategories = Product::getCategoryList();

    foreach ($listOfCategories as $oneCategory) {
        echo "<a href='?category=$oneCategory' id='" . Product::getCategoryIndexFromName($oneCategory) . "' class='list-group-item list-group-item-action";
        if ($oneCategory == $category) echo "active";
        echo "'>$oneCategory</a>";
    }
}

function listCategories()
{
    $listOfCategories = Product::getCategoryList();

    foreach ($listOfCategories as $category) {
        echo "<option>$category</option>";
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
        if ($count++ < $start) {
            continue;
        }
        echo "<div class='col-12 col-md-4'>";
        echo "<a title='" . $product->getName() . "' href='product.php?id=" . $product->getProductId() . "'>";
        echo "<div class='card m-2'>";
        echo "<div class='CardImgWrap'>";
        echo "<img class='card-img-top maxSizeImage' src='" . $product->getImagePath() . "' alt='Card image cap'>";
        echo "</div>";
        echo "<div class='card-body'>";
        echo "<b>" . $product->getName() . "</b><br/>";
        echo "<i>" . $product->getDescription() . "</i><br/><br/>";
        echo "Price: $" . number_format($product->getPrice(), 2) . "<br/>";
        echo "Quantity: " . $product->getQuantity() . " in stock <br/>";
        if ($product->getCategoryId() == 4) // Hard-coded - need to rewrite this
            echo "Size: " . Product::getSizeToString($product->getSize()) . "<br/>";
        $seller = Account::getAccountInfo($product->getSellerId());
        echo "Seller: " . $seller->getFirstName() . " " . $seller->getLastName() . "<br/>";
        if ($accountLogged && $user->getAccountId() == $product->getSellerId()) {
            echo "<input type='button' value='Cannot purchase your own products' disabled />";
        } elseif ($accountLogged && Product::isProductInCart($user->getAccountId(), $product->getProductId())) {
            echo "<input type='button' value='In Cart' disabled />";
        } else {
            echo "<form method='POST' class='d-flex justify-content-end mt-1'>";
            echo "<input type='hidden' name='productID' value='" . $product->getProductId() . "'/>";
            echo "<input type='submit' name='addToCart' value='Add to cart'/>";
            echo "</form>";
        }
        echo "</div>";
        echo "</div>";
        echo "</a>";
        echo "</div>";

        if ($count == $end) {
            return;
        }
    }
}

function navigationArrows()
{
    global $currentPage, $maxPage;
    echo "<div class='d-inline'>";

    echo "<a href='Index.php'>";
    echo "<input type='submit' value='|<'" . ($currentPage == 1 ? "disabled" : "") . " />";
    echo "</a>";
    echo "<a href='Index.php?page=" . max(((int)$currentPage - 1), 1) . "'>";
    echo "<input type='submit' value='<'" . ($currentPage == 1 ? "disabled" : "") . " />";
    echo "</a>";
    echo "&nbsp $currentPage / $maxPage &nbsp";
    echo "<a href='Index.php?page=" . min(((int)$currentPage + 1), $maxPage) . "'>";
    echo "<input type='button' value='>'" . ($currentPage == $maxPage ? "disabled" : "") . "/>";
    echo "</a>";
    echo "<a href='Index.php?page=" . $maxPage . "'>";
    echo "<input type='button' value='>|'" . ($currentPage == $maxPage ? "disabled" : "") . "/>";
    echo "</a>";

    echo "</div>";
}

function checkField($field)
{
    if (!isset($_REQUEST["submit"]))
        return;

    $fieldValue = $_REQUEST[$field];

    if ($fieldValue == "") {
        $fieldCheck = false;
        echo "<label style='color: red;'>*</label>";
    }
}


