<!-- add comment -->
<!-- You -->
<!-- test  -->
<?php

require_once 'src/lib.php';

if (isset($_REQUEST["logout"])) {
    setcookie("user", "", time() - 3600);
    header("Location: login.php");
}

if (isset($_COOKIE["user"])) {
    $user = Account::getAccountInfo($_COOKIE["user"]);
} else {
    header("Location: login.php");
}

function itemCard($listOfItems)
{
    foreach ($listOfItems as $oneDim) {
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

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <?php
    echo "Welcome, " . $user->getFirstName() . " " . $user->getLastName() . " <br/><br/>";
    ?>
    <form method="POST">
        <input type="submit" name="logout" value="Logout" />
    </form>
    <?php
    itemCard(Product::getProductList());
    ?>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>