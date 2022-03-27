<?php

require_once 'src/lib.php';

if(!$accountLogged)
    header("Location: Index.php");

$fieldCheck = true;

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Register your product</title>
    </head>
    <body>
        <h2>Register your product</h2><br/>
        <div>
            <form method="POST" action="#">

                <!-- Category -->
                <label>Category</label><?php checkField("category"); ?>
                <br/><input type="text" name="category"/><br/><br/>

                <!-- Name -->
                <label>Product Name</label><?php checkField("name"); ?>
                <br/><input type="text" name="name"/><br/><br/>

                <!-- Description -->
                <label>Description</label><?php checkField("description"); ?>
                <br/><input type="text" name="description"/><br/><br/>

                <!-- Quantity -->
                <label>Quantity</label><?php checkField("quantity"); ?>
                <br/><input type="text" name="quantity"/><br/><br/>

                <!-- Size -->
                <label>Size</label><?php checkField("size"); ?>
                <br/><input type="text" name="size"/><br/><br/>

                <!-- Size -->
                <label>Image</label><?php checkField("image"); ?>
                <br/><input type="text" name="image"/><br/><br/>

                <!-- Price -->
                <label>Price</label><?php checkField("price"); ?>
                <br/><input type="text" name="price"/><br/><br/>

                <!-- Register Button -->
                <input type="submit" name="submit" value="Register"/>
                <a href="Index.php">
                <input type="button" value="Go back"/>
                </a>

            </form>
        </div>
    </body>
</html>

<?php

if (isset($_REQUEST["submit"]) && $fieldCheck)
{
    $prodCategory = $_REQUEST["category"];
    $prodName = $_REQUEST["name"];
    $prodDesc = $_REQUEST["description"];
    $prodPrice = $_REQUEST["price"];
    $prodQuantity = $_REQUEST["quantity"];
    $prodSize = $_REQUEST["size"] != "" ? $_REQUEST["size"] : 0;
    $prodSeller = $user->getAccountId();
    $prodImagePath = $_REQUEST["image"];

    $newProd = new Product(null, $prodCategory, $prodName, $prodDesc, $prodPrice, $prodQuantity, $prodSize, $prodSeller, $prodImagePath);
    
    $newProd->addProductToDatabase();

    unset($_POST);
    header("Location: Index.php");
    exit;
}

?>