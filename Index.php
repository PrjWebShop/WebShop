<!-- add comment -->
<?php

require_once 'src/lib.php';

if (isset($_REQUEST["logout"]))
{
    setcookie("user", "", time() - 3600);
    header("Location: login.php");
}

if (isset($_COOKIE["user"]))
{
    $user = Account::getAccountInfo($_COOKIE["user"]);
}
else
{
    header("Location: login.php");
}

function itemCard($listOfItems)
{
    foreach ($listOfItems as $oneDim)
    {
        echo "<div style='border-style: solid; text-align: center; width: 40%; margin: auto;'>";
        echo "<u>" . Product::getCategoryName($oneDim->getCategoryId()) . "</u><br/><br/>";
        echo "<b>" . $oneDim->getName() . "</b><br/>";
        echo "<i>" . $oneDim->getDescription() . "</i><br/><br/>";
        echo "Price: $" . $oneDim->getPrice() . "<br/>";
        echo "Quantity: " . $oneDim->getQuantity() . " in stock <br/>";
        if ($oneDim->getCategoryId() == 4)
            echo "Size: " . Product::getSizeToString($oneDim->getSize()) . "<br/>";
        $seller = Account::getAccountInfo($oneDim->getSellerId());
        echo "Seller: " . $seller->getFirstName() . " " . $seller->getLastName() . "<br/>";
        // echo "Seller: " . getAccountName($oneDim["seller_id"]) . "<br/>";
        echo "</div>";
        echo "<br/>";
        
    }
}
?>

<html>
    <body>
        <?php
        echo "Welcome, " . $user->getFirstName() . " " . $user->getLastName() . " <br/><br/>";
        ?>
        <form method="POST">
            <input type="submit" name="logout" value="Logout"/>
        </form>
        <?php
        itemCard(Product::getProductList());
        ?>
    </body>
</html>
