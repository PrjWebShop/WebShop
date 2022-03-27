<?php

define("IMAGE_UPLOAD_FOLDER", "Img/uploads/");

require_once 'src/dbConfig.php';

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

    public function getProductId() { return $this->productId; }

    public function getCategoryId() { return $this->categoryId; }
    public function setCategoryId($categoryId) { $this->categoryId = $categoryId; }

    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }

    public function getDescription() { return $this->description; }
    public function setDescription($description) { $this->description = $description; }

    public function getPrice() { return $this->price; }
    public function setPrice($price) { $this->price = $price; }

    public function getQuantity() { return $this->quantity; }
    public function setQuantity($quantity) { $this->quantity = $quantity; }

    public function getSize() { return $this->size; }
    public function setSize($size) { $this->size = $size; }

    public function getSellerId() { return $this->sellerId; }

    public function getImagePath() 
    { 
        if (file_exists(IMAGE_UPLOAD_FOLDER . $this->imagePath))
            return IMAGE_UPLOAD_FOLDER . $this->imagePath;
        else
            return DEFAULT_IMAGE_PATH;
    }
    public function setImagePath($imagePath) { $this->imagePath = $imagePath; }

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
     * Function that adds a product to the database and returns true on success.
     * 
     * @return bool
     */
    public function addProductToDatabase()
    {

        global $connection;

        $sqlStmt = $connection->prepare("INSERT INTO product(category_id, name, description, price, quantity, size, seller_id, image)
                    VALUES(:category_id, :name, :description, :price, :quantity, :size, :seller_id, :image)");

        $sqlStmt->bindParam(':category_id', $this->categoryId);
        $sqlStmt->bindParam(':name', $this->name);
        $sqlStmt->bindParam(':description', $this->description);
        $sqlStmt->bindParam(':price', $this->price);
        $sqlStmt->bindParam(':quantity', $this->quantity);
        $sqlStmt->bindParam(':size', $this->size);
        $sqlStmt->bindParam(':seller_id', $this->sellerId);
        $sqlStmt->bindParam(':image', $this->imagePath);

        $sqlStmt->execute();

        $queryId = $sqlStmt->fetch();

        if ($queryId)
            return true;
        return false;
    }


    // STATIC METHODS //

    /**
     * Function that returns all products from the product database as an associative array.
     * 
     * @param int $category_filter [optional] filters the results by category
     * @return Product (product_id, category_id, name, description, price, quantity, size, seller_id, image)
     */
    public static function getProductByID(int $product_id)
    {
        global $connection;

        $sqlStmt = $connection->prepare("SELECT * FROM product WHERE product_id = :product_id;");

        $sqlStmt->bindParam(':product_id', $product_id);

        $sqlStmt->execute();

        if ($sqlStmt->rowCount()==0) // no rows
            return null;

        if ($row = $sqlStmt->fetch()) {
            
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
     * @return Product[]
     */
    public static function getProductList(string $category_filter, string $p_search)
    {
        global $connection;

        $cpt = 0;
        if ($category_filter == false && $p_search == false)
        {
            $sqlStmt = $connection->prepare("SELECT * FROM product;");
        }
        elseif ($category_filter == false)
        {
            $sqlStmt = $connection->prepare("SELECT * FROM product WHERE name LIKE :search OR description LIKE :search;");
            $search = "%" . $p_search . "%";
            $sqlStmt->bindValue(':search', $search, PDO::PARAM_STR);
        }
        elseif ($p_search == false)
        {
            $sqlStmt = $connection->prepare("SELECT * FROM product WHERE category_id = :category_filter;");
            $sqlStmt->bindParam(':category_filter', $category_filter);
        }
        else
        {
            $sqlStmt = $connection->prepare("SELECT * FROM product WHERE category_id = :category_filter AND (name LIKE :search OR description LIKE :search);");
            $search = "%" . $p_search . "%";
            $sqlStmt->bindValue(':search', $search, PDO::PARAM_STR);
            $sqlStmt->bindParam(':category_filter', $category_filter);
        }
        
        $sqlStmt->execute();

        $result = $sqlStmt->rowCount();

        if ($result == 0)
            return 0;

        while ($row = $sqlStmt->fetch()) {
            
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
     * @return Product[] returns an array of type Product
     */
    public static function getProductListFromCart(int $account_id)
    {
        global $connection;

        $cpt = 0;

        $sqlStmt = $connection->prepare("SELECT * FROM product
                    WHERE product_id IN
                    (SELECT product_id FROM carts WHERE account_id = :account_id);");
        
        $sqlStmt->bindParam(':account_id', $account_id);

        $sqlStmt->execute();

        $listOfProducts = false;

        while ($row = $sqlStmt->fetch()) {
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
     * Function to change the count of a specific product in a cart
     * 
     * @param int $account_id
     * @param int $product_id
     * @param int $newCount
     */
    public static function editProductCountInCart(int $account_id, int $product_id, int $newCount)
    {
        global $connection;

        
        if ($newCount > 0) {

            // Checks if there's enough in stock
            if (Product::getQuantityInStock($product_id) >= $newCount)
            {
                $sqlStmt = $connection->prepare("UPDATE carts SET count = :newCount WHERE account_id = :account_id AND product_id = :product_id");

                $sqlStmt->bindParam(':newCount', $newCount);
                $sqlStmt->bindParam(':account_id', $account_id);
                $sqlStmt->bindParam(':product_id', $product_id);

                $sqlStmt->execute();

                if ($sqlStmt->rowCount($connection) >= 1)
                    return true;
                
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
    public static function removeProductFromCart(int $account_id, int $product_id)
    {
        global $connection;

        $sqlStmt = $connection->prepare("DELETE FROM carts WHERE account_id = :account_id AND product_id = :product_id");

        $sqlStmt->bindParam(':account_id', $account_id);
        $sqlStmt->bindParam(':product_id', $product_id);

        $sqlStmt->execute();

        if ($sqlStmt->rowCount() == 0)
            return false;
        return true;
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
    public static function addProductToCart(int $account_id, int $product_id, int $count)
    {
        global $connection;

        $date = date('Y-m-d H:i:s');

        $sqlStmt = $connection->prepare("INSERT INTO carts VALUES (:account_id, :product_id, :count, :date)");

        $sqlStmt->bindParam(':account_id', $account_id);
        $sqlStmt->bindParam(':product_id', $product_id);
        $sqlStmt->bindParam(':count', $count);
        $sqlStmt->bindParam(':date', $date);

        $sqlStmt->execute();

        if ($sqlStmt->rowCount() == 0)
            return false;
        return true;
    }

    /**
     * Updates product quantity and clears the shopping cart after comparing amount in cart and quantity in stock for each product.
     * 
     * 
     * @param int $account_id
     */
    public static function checkout(int $account_id)
    {
        global $connection;

        
        $sqlStmt = $connection->prepare("SELECT p.quantity, c.count 
                    FROM product AS p
                    INNER JOIN carts as c 
                    ON c.product_id = p.product_id 
                    WHERE c.account_id = :account_id;");

        $sqlStmt->bindParam(':account_id', $account_id);

        $sqlStmt->execute();

        // check if count is greater than quantity in stock
        while ($row = $sqlStmt->fetch()) {
            if ($row["count"] > $row["quantity"])
            {
                return false;
            }
        }

        // changes quantity from products in cart in product table
        $sqlStmt = $connection->prepare("SELECT * FROM carts WHERE account_id = :account_id");
        
        $sqlStmt->bindParam(':account_id', $account_id);
        
        $sqlStmt->execute();

        while ($row = $sqlStmt->fetch()) {
            $product_id = $row["product_id"];
            $amount = $row["count"];
            Product::updateProductQuantity($product_id, -$amount);
        }

        // empty cart
        Product::removeAllFromCart($account_id);
        return true;
    }

    /**
     * Clears the shopping cart.
     * 
     * @param int $account_id
     */
    public static function removeAllFromCart(int $account_id)
    {
        global $connection;

        $sqlStmt = $connection->prepare("DELETE FROM carts WHERE account_id = :account_id");
        
        $sqlStmt->bindParam(':account_id', $account_id);
        
        $sqlStmt->execute();

        if ($sqlStmt->rowCount() == 0)
            return false;
        return true;
    }

    /**
     * Updates the quantity for the product specified in the product table.
     * 
     * @param int $product_id
     * @param int $amount amount to add or remove
     */
    public static function updateProductQuantity(int $product_id, int $amount)
    {
        global $connection;

        $sqlStmt = $connection->prepare("UPDATE product
                    SET quantity = quantity + :amount
                    WHERE product_id = :product_id");

        
        $sqlStmt->bindParam(':amount', $amount);
        $sqlStmt->bindParam(':product_id', $product_id);

        $sqlStmt->execute();

        if ($sqlStmt->rowCount() == 0)
            return false;
        return true;
    }
    
    /**
     * Function that returns a product's quantity in stock from product table
     * 
     * @param int $product_id
     * @return int returns the quantity in stock of a product
     */
    private static function getQuantityInStock(int $product_id)
    {
        global $connection;

        $sqlStmt = $connection->prepare("SELECT quantity FROM product WHERE product_id = :product_id");

        $sqlStmt->bindParam(':product_id', $product_id);

        $sqlStmt->execute();

        if ($row = $sqlStmt->fetch()) {
            $quantity = $row["quantity"];
            return (int)$quantity;
        }
        return 0;
    }

    /**
     * Returns full list of categories from the database in an array
     */
    public static function getCategoryList()
    {
        global $connection;
        
        $cpt = 0;

        $sqlStmt = $connection->prepare("SELECT * FROM category;");

        $sqlStmt->execute();
                
        while ($row = $sqlStmt->fetch()) {
            
            $category_name = $row["name"];
            
            $ListOfCategories[$cpt++] = $category_name;
        }
        return $ListOfCategories;
    }

    public static function getCategoryIndexFromName(string $name)
    {
        global $connection;

        $sqlStmt = $connection->prepare("SELECT * FROM category WHERE name = :name;");

        $sqlStmt->bindParam(':name', $name);

        $sqlStmt->execute();
        
        if ($row = $sqlStmt->fetch()) {
            $index = $row["category_id"];
            return (int)$index;
        }
        return null;
    } 

    /**
     * Function that returns the name of the category with the given ID
     * 
     * @param int $category_id
     * @return string returns the category name
     */
    public static function getCategoryName(int $category_id)
    {
        global $connection;

        $sqlStmt = $connection->prepare("SELECT * FROM category WHERE category_id = :category_id");

        $sqlStmt->bindParam(':category_id', $category_id);

        $sqlStmt->execute();
        
        if ($row = $sqlStmt->fetch()) {
            $category = $row["name"];
            return $category;
        }
        return "No Category";
    }

    public static function isProductInCart(int $account_id, int $product_id)
    {
        global $connection;

        $sqlStmt = $connection->prepare("SELECT * FROM carts WHERE account_id = :account_id AND product_id = :product_id;");
        
        $sqlStmt->bindParam(':product_id', $product_id);
        $sqlStmt->bindParam(':account_id', $account_id);

        $sqlStmt->execute();

        if ($sqlStmt->fetch()) {
            return true;
        }
        return false;
    }

    public static function getTotalCountFromCart(int $account_id)
    {
        global $connection;

        $sqlStmt = $connection->prepare("SELECT count FROM carts WHERE account_id = :account_id;");

        $sqlStmt->bindParam(':account_id', $account_id);

        $sqlStmt->execute();

        $sqlStmt->setFetchMode(PDO::FETCH_BOTH);

        $total = 0;
        while ($row = $sqlStmt->fetch()) {
            $total += $row[0];
        }
        return $total;
    }

    /**
     * Function that returns size
     * 
     * @param int $num any number between 1 and 7
     * @return string returns size from XS to XXXL
     */
    public static function getSizeToString(int $num)
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