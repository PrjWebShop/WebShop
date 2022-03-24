<?php

require_once 'src/lib.php';

?>

<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./Css/index.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light transparentBg mb-4">
        <img class="navi-logo img-fluid" src="./Img/Logo/logo.png" alt="Logo Not Found">
        <?php
        if ($accountLogged)
            $welcomeMessage = "Welcome, " . $user->getFirstName() . " " . $user->getLastName();
        else $welcomeMessage = "";
        echo "<a class='navbar-brand font-weight-bold' href=''>$welcomeMessage</a>";
        ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item d-flex align-items-center justify-content-center">
                    <form method="GET" class="nav-link">
                        <?php
                        if (isset($_GET["category"])) {
                            echo "<input type='hidden' name='category' value='$category'/>";
                        }
                        ?>
                        <input type="text" name="search" minlength="3" />
                        <input type="submit" value="Search" class="btn btn-primary pl-1 pr-1 p-0 m-0" />
                    </form>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./Index.php">Browse</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Cart<?php 
                    $countInCart = Product::getTotalCountFromCart($user->getAccountId());
                    if ($countInCart != "0")
                        echo $accountLogged? "(" . Product::getTotalCountFromCart($user->getAccountId()) . ")" : ""; // temp fix 
                    ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Orders</a>
                </li>
                <li class="nav-item d-flex align-items-center justify-content-center">
                    <form method="POST" class="nav-link">
                        <?php
                        if ($accountLogged)
                            echo '<input type="submit" name="logout" value="Logout" class="btn btn-danger pl-1 pr-1 p-0 m-0" />';
                        else
                            echo '<input type="submit" name="logout" value="Login" class="btn btn-success pl-1 pr-1 p-0 m-0" />';
                        ?>
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
                        All Categories
                    </a>
                    <?php
                    displayCategories();
                    ?>
                </div>
            </div>
            <div class="col-md-9 col-12">
                <div class="row">
                    <?php
                    if ($productFound) {
                        displayProducts($listOfProducts);
                    }

                    ?>
                </div>
            </div>
            
            <div class="w-100 d-flex justify-content-center p-2 mt-4">
                <?php
                navigationArrows();
                ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>