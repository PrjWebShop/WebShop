<?php

require_once 'dbConfig.php';

define("PRODUCT_CATEGORY_CLOTHES", 1);



/**
 * Function that returns all products from the item database as an associative array.
 * 
 * @param int $category_filter [optional] filters the results by category
 */
function getItemList($category_filter = NULL)
{
    global $connection;
    
    $cpt = 0;
    
    if (is_null($category_filter))
        $sqlStmt = "SELECT * FROM item";
    else 
        $sqlStmt = "SELECT * FROM item WHERE category_id = $category_filter";
    
    $result = $connection->query($sqlStmt);
    
    while ($row = $result->fetch_assoc())
    {
        $item_id = $row["item_id"];	$category_id = $row["category_id"];	$name = $row["name"];
        $description = $row["description"];	$price = $row["price"];	$quantity = $row["quantity"];
        $size = $row["size"]; $seller_id = $row["seller_id"];	$image = $row["image"];
        
        $listOfItems[$cpt++] = array("item_id"=>$item_id, "category_id"=>$category_id, "name"=>$name,
            "description"=>$description, "price"=>$price, "quantity"=>$quantity, "size"=>$size,
            "seller_id"=>$seller_id, "image"=>$image);
    }
    $connection->close();
    return $listOfItems;
}

/**
 * function that returns an array of items in the shopping cart
 * @param int $account_id
 * @return array (item_id, category_id, name, description, price, quantity, size, seller_id, image, count)
 */
function getItemListFromCart($account_id)
{
    global $connection;
    
    $cpt = 0;
    
    $sqlStmt = "SELECT i.item_id, i.category_id, i.name, i.description, i.price, i.quantity, i.size, i.seller_id, i.image, c.count 
                FROM item AS i 
                INNER JOIN carts as c 
                ON c.item_id = i.item_id
                WHERE c.account_id = $account_id";
    
    $result = $connection->query($sqlStmt);
    
    while ($row = $result->fetch_assoc())
    {        
        $listOfItems[$cpt++] = array("item_id"=>$row["item_id"], "category_id"=>$row["category_id"], "name"=>$row["name"],
            "description"=>$row["description"], "price"=>$row["price"], "quantity"=>$row["quantity"], "size"=>$row["size"],
            "seller_id"=>$row["seller_id"], "image"=>$row["image"], "count"=>$row["count"]);
    }
    $connection->close();
    return $listOfItems;
}


/**
 * Function that adds a product to the database and returns true on success.
 * 
 * @param int $category_id
 * @param string $name
 * @param string $description
 * @param double $price
 * @param int $quantity Quantity available in stock	
 * @param int $size Size for clothes (1 = small, 2 = medium, etc)	
 * @param int $seller_id
 * @param string $image 
 */
function addItemToDatabase($category_id, $name, $description, $price, $quantity, $size, $seller_id, $image) {
    global $connection;
    
    $sqlStmt = "INSERT INTO item(category_id, name, description, price, quantity, size, seller_id, image)
                VALUES($category_id, '$name', '$description', $price, $quantity, $size, $seller_id, '$image')";
    
    $queryId = mysqli_query($connection, $sqlStmt);
    
    if ($queryId)
        return true;
    return false;
}