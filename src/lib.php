<?php

require_once 'src/Model/Account.cls.php';
require_once 'src/Model/Product.cls.php';

include 'js/javascript.php';

define("SQL_ERROR_DUPLICATE", 1062);
define("SQL_ERROR_DATA_TOO_LONG", 1406); // Data exceeds character limit

define("MAX_PRODUCT_PER_PAGE", 15);

define("DEFAULT_IMAGE_PATH", "Img/default.png");

$failed_login = null;
$entered_email = "";
$failed_attempt = null;

// Login button
if (isset($_REQUEST["login"])) {
    $email = $_REQUEST["email"];
    $pwd = $_REQUEST["password"];
    if (Account::checkLogin($email, $pwd)) {
        setcookie("user", $email, time() + 86400);
        $_POST = array();
        header("Refresh:0");
    } else {
        $failed_login = true;
        $entered_email = $_REQUEST["email"];
    }
    $_POST = array();
}

// is set for sign up

if (isset($_REQUEST["register"])) {
    $email = $_REQUEST["email"];
    $pwd = $_REQUEST["password"];
    $first_name = $_REQUEST["first_name"];
    $last_name = $_REQUEST["last_name"];
    $address = $_REQUEST["address"];
    try {
        if (Account::createAccount($email, $pwd, $first_name, $last_name, $address)) {
            setcookie("user", $email, time() + 600);
            $_POST = array();
            header("Refresh:0");
        }
    } catch (\Throwable $th) {
        $failed_attempt = true;
        switch ($th->getCode()) {
            case SQL_ERROR_DUPLICATE:
                $error = "Email already registed!";
                break;
            case SQL_ERROR_DATA_TOO_LONG:
                $error = $th->getMessage(); //"Fields must have less than 100 characters!";
                break;
            default:
                $error = $th->getMessage();
                break;
        }
    }
    $_POST = array();
}

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
    $_POST = array();
    header("Refresh:0");
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

function getThemeBackground()
{
    if (!isset($_COOKIE["user"]))
    {
        return "theme1";
    }

    global $user;

    return "theme".$user->getTheme();
}

function getThemeContrast()
{
    return getThemeBackground()."Contrast";
}

