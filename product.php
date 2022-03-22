<?php

require_once 'src/lib.php';

// Checks if there is an id parameter and sends the user back to index if there isn't one
if (!isset($_GET["id"]))
{ header("Location: Index.php"); }

// Checks if the user is logged in and retrieves account information if they are
if (isset($_COOKIE["user"])) {
    $user = Account::getAccountInfo($_COOKIE["user"]);
    $accountLogged = true;
}
else {
    $accountLogged = false;
}

$prod_id = $_GET["id"];
$prod = Product::getProductByID($prod_id);
