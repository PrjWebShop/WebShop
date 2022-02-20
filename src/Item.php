<?php

require_once 'dbConfig.php';

define("PRODUCT_CATEGORY_CLOTHES", 1);
define("PRODUCT_CATEGORY_ELECTRONICS", 2);


/**
 * Function that returns all products from the item database as an associative array.
 * 
 * @param int $category_filter [optional] filters the results by category
 * @return array (item_id, category_id, name, description, price, quantity, size, seller_id, image)
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
        //if ($row["quantity"] > 0)
        //{
            $listOfItems[$cpt++] = array("item_id"=>$row["item_id"], "category_id"=>$row["category_id"], "name"=>$row["name"],
                "description"=>$row["description"], "price"=>$row["price"], "quantity"=>$row["quantity"], "size"=>$row["size"],
                "seller_id"=>$row["seller_id"], "image"=>$row["image"]);
        //}
            
    }
    $connection->close();
    return $listOfItems;
}


/**
 * Function that returns an array of items in the shopping cart
 * 
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



/**
 * Function to change the count of a specific item in a cart
 * 
 * @param int $account_id
 * @param int $item_id
 * @param int $newCount
 */
function editItemCountInCart($account_id, $item_id, $newCount)
{
    global $connection;
    
    if ($newCount > 0)
    {
        $sqlStmt = "UPDATE carts SET count = $newCount WHERE account_id = $account_id AND item_id = $item_id";
        
        $queryId = mysqli_query($connection, $sqlStmt);
        
        if ($queryId)
        {
            if (mysqli_affected_rows($connection) >= 1)
                return true;
        }
        else
            echo mysqli_error($connection);
            return false;
    }
    else 
        return removeItemFromCart($account_id, $item_id);    
}



/**
 * Removes an item from the cart table
 * 
 * @param int $account_id
 * @param int $item_id
 */
function removeItemFromCart($account_id, $item_id)
{
    global $connection;
    
    $sqlStmt = "DELETE FROM carts WHERE account_id = $account_id AND item_id = $item_id";

    $queryId = mysqli_query($connection, $sqlStmt);
    
    if ($queryId)
        return true;
    return false;
}



/**
 * Adds an item to the shopping cart
 * 
 * @param int $account_id
 * @param int $item_id
 * @param int $count
 */
function addItemToCart($account_id, $item_id, $count)
{
    global $connection;
    
    $date = date('Y-m-d H:i:s');
    
    $sqlStmt = "INSERT INTO carts VALUES ($account_id, $item_id, $count, '$date')";
    
    $queryId = mysqli_query($connection, $sqlStmt);
    
    if ($queryId)
        return true;
    return false;
}


/**
 * Updates item quantity and clears the shopping cart after comparing amount in cart and quantity in stock for each item.
 * 
 * 
 * @param int $account_id
 */
function checkout($account_id)
{
    global $connection;
    
    // check if count is greater than quantity in stock
    $sqlStmt = "SELECT i.quantity, c.count 
                FROM item AS i 
                INNER JOIN carts as c 
                ON c.item_id = i.item_id 
                WHERE c.account_id = $account_id;";
    
    $result = $connection->query($sqlStmt);
    
    while ($row = $result->fetch_assoc())
    {
        if ($row["count"] > $row["quantity"])
            echo "count greater than quantity";
            return false;
    }
    
    // remove items in cart from item table
    $sqlStmt = "SELECT * FROM carts WHERE account_id = $account_id";
    
    $result = $connection->query($sqlStmt);
    
    while ($row = $result->fetch_assoc())
    {
        $item_id = $row["item_id"];
        $amount = $row["count"];
        updateItemQuantity($item_id, ($amount * -1));
    }
    
    // empty cart
    removeAllFromCart($account_id);
    
}


/**
 * Clears the shopping cart.
 * 
 * @param int $account_id
 */
function removeAllFromCart($account_id)
{
    global $connection;
    
    $sqlStmt = "DELETE FROM carts WHERE account_id = $account_id";
    
    $queryId = mysqli_query($connection, $sqlStmt);
    
    if ($queryId)
        return true;
    return false;
}


/**
 * Updates the quantity for the item specified in the item table.
 * 
 * @param int $item_id
 * @param int $amount amount to add or remove
 */
function updateItemQuantity($item_id, $amount)
{
    global $connection;
    
    $sqlStmt = "UPDATE item
                SET quantity = quantity + $amount
                WHERE item_id = $item_id";

    $queryId = mysqli_query($connection, $sqlStmt);
    
    if ($queryId)
        return true;
    return false;
}
