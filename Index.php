<?php

require_once 'src/lib.php';

$accountLogged = false;
$category_filter = null;

// User hit logout
if (isset($_REQUEST["logout"])) {
    setcookie("user", "", time() - 3600);
    header("Location: login.php");
}

// Checks if the user is logged in and retrieves account information if they are
if (isset($_COOKIE["user"])) {
    $user = Account::getAccountInfo($_COOKIE["user"]);
    $accountLogged = true;
}

if (isset($_GET["search"])) {
    $search = $_GET["search"];
    $listOfProducts = Product::searchProduct($search);
}
else {
    $listOfProducts = Product::getProductList($category_filter);
}
?>

<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>


    <nav class="navbar navbar-expand-lg navbar-light bg-light transparentBg mb-4">

        <?php
        if ($accountLogged)
            $welcomeMessage = "Welcome, " . $user->getFirstName() . " " . $user->getLastName();
        else
            $welcomeMessage = "Welcome!";
        echo "<a class='navbar-brand font-weight-bold' href=''>$welcomeMessage</a>";
        ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <form method="GET" class="nav-link">
                        <input type="text" name="search" minlength="3" />
                        <input type="submit" value="Search" class="btn btn-primary pl-1 pr-1 p-0 m-0" />
                    </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./Index.php">Browse</a>
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
                    <a href="./Index.php" class="list-group-item list-group-item-action active">
                        Categories
                    </a>
                    <?php 
                    displayCategories();
                    ?>
                </div>
            </div>
            <div class="col-md-9 col-12">
                <div class="row">
                    <?php
                    displayProducts($listOfProducts);
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