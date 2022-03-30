<?php

require_once 'src/lib.php';

if (isset($_GET["id"]))
{
    $prod_id = $_GET["id"];
    $prod = Product::getProductByID($prod_id);
}


