<?php

require_once 'dbConfig.php';

class Product 
{
    private $productId;
    private $categoryId;
    private $name;
    private $description;
    private $price;
    private $quantity;
    private $size;
    private $sellerId;
    private $imagePath;
    
    function __construct($productId, $categoryId, $name, $description, $price, $quantity, $size, $sellerId, $imagePath)
    {
        $this->productId = $productId;
        $this->categoryId = $categoryId;
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
        $this->quantity = $quantity;
        $this->size = $size;
        $this->sellerId = $sellerId;
        $this->imagePath = $imagePath;
    }

    /**
     * @return mixed
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @return mixed
     */
    public function getCategoryId()
    {
        return $this->categoryId;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return mixed
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return mixed
     */
    public function getSellerId()
    {
        return $this->sellerId;
    }

    /**
     * @return mixed
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param mixed $categoryId
     */
    public function setCategoryId($categoryId)
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @param mixed $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @param mixed $imagePath
     */
    public function setImagePath($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    /**
     * Function that returns all products from the product database as an associative array.
     * 
     * @param int $category_filter [optional] filters the results by category
     * @return Product (product_id, category_id, name, description, price, quantity, size, seller_id, image)
     */
    public static function getProductByID($product_id)
    {
        global $connection;

        $sqlStmt = "SELECT * FROM product WHERE product_id = $product_id;";
        
        $result = $connection->query($sqlStmt);

        if ($row = $result->fetch_assoc()) {
            
            $prodId = $row["product_id"];
            $catId = $row["category_id"];
            $name = $row["name"];
            $desc = $row["description"];
            $price = $row["price"];
            $qty = $row["quantity"];
            $size = $row["size"];
            $seller = $row["seller_id"];
            $img = $row["image"];

            $prod = new Product($prodId, $catId, $name, $desc, $price, $qty, $size, $seller, $img);
        }
        return $prod;
    }

    /**
     * Function that returns all products from the product database as an associative array.
     * 
     * @param int $category_filter [optional] filters the results by category
     * @return array (product_id, category_id, name, description, price, quantity, size, seller_id, image)
     */
    public static function getProductList($category_filter = NULL)
    {
        global $connection;

        $cpt = 0;

        // Checks if filter option is set
        if (!is_null($category_filter))
            $sqlStmt = "SELECT * FROM product WHERE category_id = $category_filter;";
        else
            $sqlStmt = "SELECT * FROM product;";

        $result = $connection->query($sqlStmt);

        while ($row = $result->fetch_assoc()) {
            
            $prodId = $row["product_id"];
            $catId = $row["category_id"];
            $name = $row["name"];
            $desc = $row["description"];
            $price = $row["price"];
            $qty = $row["quantity"];
            $size = $row["size"];
            $seller = $row["seller_id"];
            $img = $row["image"];

            $prod = new Product($prodId, $catId, $name, $desc, $price, $qty, $size, $seller, $img);
            $listOfProducts[$cpt++] = $prod;
        }
        return $listOfProducts;
    }


    /**
     * Function that returns an array of products in the shopping cart
     * 
     * @param int $account_id
     * @return Product returns an array of type Product
     */
    public static function getProductListFromCart($account_id)
    {
        global $connection;

        $cpt = 0;

        $sqlStmt = "SELECT * FROM product
                    WHERE product_id IN
                    (SELECT product_id FROM carts WHERE account_id = $account_id);";

        $result = $connection->query($sqlStmt);

        while ($row = $result->fetch_assoc()) {
            $prodId = $row["product_id"];
            $catId = $row["category_id"];
            $name = $row["name"];
            $desc = $row["description"];
            $price = $row["price"];
            $qty = $row["quantity"];
            $size = $row["size"];
            $seller = $row["seller_id"];
            $img = $row["image"];

            $prod = new Product($prodId, $catId, $name, $desc, $price, $qty, $size, $seller, $img);
            $listOfProducts[$cpt++] = $prod;
        }
        return $listOfProducts;
    }



    /**
     * Function that adds a product to the database and returns true on success.
     * 
     * @return bool
     */
    public function addProductToDatabase()
    {

        global $connection;

        $sqlStmt = "INSERT INTO product(category_id, name, description, price, quantity, size, seller_id, image)
                    VALUES($this->category_id, '$this->name', '$this->description', $this->price, $this->quantity, $this->size, $this->seller_id, '$this->image')";
        echo $sqlStmt . "</br>";

        $queryId = mysqli_query($connection, $sqlStmt);

        if ($queryId)
            return true;
        return false;
    }


    /**
     * Function to change the count of a specific product in a cart
     * 
     * @param int $account_id
     * @param int $product_id
     * @param int $newCount
     */
    public static function editProductCountInCart($account_id, $product_id, $newCount)
    {
        global $connection;

        
        if ($newCount > 0) {

            // Checks if there's enough in stock
            if (Product::getQuantityInStock($product_id) >= $newCount)
            {
                $sqlStmt = "UPDATE carts SET count = $newCount WHERE account_id = $account_id AND product_id = $product_id";
                $queryId = mysqli_query($connection, $sqlStmt);

                if ($queryId) {
                    if (mysqli_affected_rows($connection) >= 1)
                        return true;
                } else
                echo mysqli_error($connection);
                return false; // error with sql
            }
            return false; // count is greater than quantity    
                
        } else // if the count is set to 0, remove the product from the cart
            return Product::removeProductFromCart($account_id, $product_id);
    }


    /**
     * Removes an product from the cart table
     * 
     * @param int $account_id
     * @param int $product_id
     */
    public static function removeProductFromCart($account_id, $product_id)
    {
        global $connection;

        $sqlStmt = "DELETE FROM carts WHERE account_id = $account_id AND product_id = $product_id";

        $queryId = mysqli_query($connection, $sqlStmt);

        if ($queryId)
            return true;
        return false;
    }



    /**
     * Adds a product to the shopping cart
     * 
     * @param int $account_id
     * @param int $product_id
     * @param int $count
     * 
     * @return bool
     */
    public static function addProductToCart($account_id, $product_id, $count)
    {
        global $connection;

        $date = date('Y-m-d H:i:s');

        $sqlStmt = "INSERT INTO carts VALUES ($account_id, $product_id, $count, '$date')";

        $queryId = mysqli_query($connection, $sqlStmt);

        if ($queryId)
            return true;
        return false;
    }


    /**
     * Updates product quantity and clears the shopping cart after comparing amount in cart and quantity in stock for each product.
     * 
     * 
     * @param int $account_id
     */
    public static function checkout($account_id)
    {
        global $connection;

        
        $sqlStmt = "SELECT p.quantity, c.count 
                    FROM product AS p
                    INNER JOIN carts as c 
                    ON c.product_id = p.product_id 
                    WHERE c.account_id = $account_id;";

        $result = $connection->query($sqlStmt);

        // check if count is greater than quantity in stock
        while ($row = $result->fetch_assoc()) {
            if ($row["count"] > $row["quantity"])
            {
                echo "count greater than quantity";
                return false;
            }
        }

        // changes quantity from products in cart in product table
        $sqlStmt = "SELECT * FROM carts WHERE account_id = $account_id";

        $result = $connection->query($sqlStmt);

        while ($row = $result->fetch_assoc()) {
            $product_id = $row["product_id"];
            $amount = $row["count"];
            Product::updateProductQuantity($product_id, -$amount);
        }

        // empty cart
        Product::removeAllFromCart($account_id);
    }


    /**
     * Clears the shopping cart.
     * 
     * @param int $account_id
     */
    public static function removeAllFromCart($account_id)
    {
        global $connection;

        $sqlStmt = "DELETE FROM carts WHERE account_id = $account_id";

        $queryId = mysqli_query($connection, $sqlStmt);

        if ($queryId)
            return true;
        return false;
    }

    /**
     * Updates the quantity for the product specified in the product table.
     * 
     * @param int $product_id
     * @param int $amount amount to add or remove
     */
    public static function updateProductQuantity($product_id, $amount)
    {
        global $connection;

        $sqlStmt = "UPDATE product
                    SET quantity = quantity + $amount
                    WHERE product_id = $product_id";

        $queryId = mysqli_query($connection, $sqlStmt);

        if ($queryId)
            return true;
        return false;
    }
    
    private static function getQuantityInStock($product_id)
    {
        global $connection;

        $sqlStmt = "SELECT quantity FROM product WHERE product_id = $product_id";

        $result = $connection->query($sqlStmt);

        if ($row = $result->fetch_assoc()) {
            $category = $row["quantity"];
            return (int)$category;
        }
        return 0;
    }

    public static function getCategoryName($category_id)
    {
        global $connection;

        $sqlStmt = "SELECT * FROM category WHERE category_id = $category_id";
        $result = $connection->query($sqlStmt);
        if ($row = $result->fetch_assoc()) {
            $category = $row["name"];
            return $category;
        }
        return "No Category";
    }


    public static function getSizeToString($num)
    {
        switch ($num) {
            case 1:
                return "XS";
            case 2:
                return "S";
            case 3:
                return "M";
            case 4:
                return "L";
            case 5:
                return "XL";
            case 6:
                return "XXL";
            case 7:
                return "XXXL";
            default:
                return "Invalid Size";
        }
    }
}