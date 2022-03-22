<?php

require_once 'src/lib.php';

$prod_id = $_GET["id"];
$prod = Product::getProductByID($prod_id);
