<!-- add comment -->
<!-- You -->
<!-- test  -->
<?php

require_once 'src/lib.php';

$category_filter = null;

if (isset($_REQUEST["logout"])) {
    setcookie("user", "", time() - 3600);
    header("Location: login.php");
}

if (isset($_COOKIE["user"])) {
    $user = Account::getAccountInfo($_COOKIE["user"]);
    
} else {
    header("Location: login.php");
}

if (isset($_GET["search"]))
{
    $category = $_GET["search"];
    
    switch ($category) {
        case 'electronics':
            $category_filter = 1;
            break;
        case 'video games':
            $category_filter = 2;
            break;
        case 'movies':
            $category_filter = 3;
            break;
        case 'clothing':
            $category_filter = 4;
            break;
        
        default:
            break;
    }
}

function itemCard($listOfItems)
{
    foreach ($listOfItems as $oneDim) {
        echo "<div class='col-12 col-md-6'>";
        echo "<div class='card m-2'>";
        // echo "<img class='card-img-top' src='img/" . $oneDim->getImagePath() . "' alt='Card image cap'>";
        echo "<div class='card-body'>";
        echo "<u>" . Product::getCategoryName($oneDim->getCategoryId()) . "</u><br/><br/>";
        echo "<b>" . $oneDim->getName() . "</b><br/>";
        echo "<i>" . $oneDim->getDescription() . "</i><br/><br/>";
        echo "Price: $" . $oneDim->getPrice() . "<br/>";
        echo "Quantity: " . $oneDim->getQuantity() . " in stock <br/>";
        if ($oneDim->getCategoryId() == 4)
            echo "Size: " . Product::getSizeToString($oneDim->getSize()) . "<br/>";
        $seller = Account::getAccountInfo($oneDim->getSellerId());
        echo "Seller: " . $seller->getFirstName() . " " . $seller->getLastName() . "<br/>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
}
?>

<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-light bg-light transparentBg mb-4">

        <?php
        echo "<a class='navbar-brand font-weight-bold' href=''>Welcome, " . $user->getFirstName() . " " . $user->getLastName() . " </a>";
        ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Browse</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Orders</a>
                </li>
                <li class="nav-item">
                    <form method="POST" class="nav-link">
                        <input type="submit" name="logout" value="Logout" class="btn btn-danger pl-1 pr-1 p-0 m-0" />
                    </form>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-12">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">
                        Categories
                    </a>
                    <a href="?search=electronics" class="list-group-item list-group-item-action">Electronics</a>
                    <a href="?search=video games" class="list-group-item list-group-item-action">Video Games</a>
                    <a href="?search=movies" class="list-group-item list-group-item-action">Movies</a>
                    <a href="?search=clothing" class="list-group-item list-group-item-action">Clothing</a>
                </div>
            </div>
            <div class="col-md-9 col-12">
                <div class="row">
                    <?php
                    $listOfItems = Product::getProductList($category_filter);
                    itemCard($listOfItems);
                    ?>
                </div>
            </div>
        </div>
    </div>




    <!-- <?php
            //itemCard(Product::getProductList());
            ?> -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>

</html>