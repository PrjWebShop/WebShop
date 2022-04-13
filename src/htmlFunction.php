<?php

require_once 'src/lib.php';

function htmlHeader($currFile, $title)
{ ?>

<head>
    <meta charset="utf-8" name="viewport" content="width=device-width, initial-scale=1">
    <title> <?php echo $title; ?> </title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="/WebShop/Css/hover-min.css">
    <link rel="stylesheet" href="/WebShop/Css/style.css">
    <link rel="stylesheet" href="/WebShop/Css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <?php // get current file's css if it exists (Index.php -> index.css)
        $cssFile = "/" . strtolower(pathinfo($currFile)["filename"]) . ".css";
        $cssPath = "/WebShop/Css" . $cssFile;
        $cssFullPath = pathinfo($currFile)["dirname"] . "/Css" . $cssFile;
        if (file_exists($cssFullPath))
            echo "<link rel='stylesheet' href='$cssPath'>";
    ?>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
</head>

<?php 
}

function htmlNavBar()
{
    global $accountLogged, $user, $category, $failed_login, $entered_email, $failed_attempt, $error;
    $location = $_SERVER["PHP_SELF"];
?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light <?php echo getThemeContrast(); ?>" id="header">
        <a class="navbar-brand" href="/WebShop/Index">
            <img class="navi-logo img-fluid" src="/WebShop/Img/Logo/logo.png" alt="Logo Not Found">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="<?php echo getThemeContrast(); ?> nav-link" id="headerLabel1" href="/WebShop/Index">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="<?php echo getThemeContrast(); ?> nav-link" id="headerLabel2" href="#">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="<?php echo getThemeContrast(); ?> nav-link <?php if (!$accountLogged) echo "disabled"; ?>" id="headerLabel3" href="/WebShop/register_product">Sell</a>
                </li>
                <li class="nav-item">
                    <a class="<?php echo getThemeContrast(); ?> nav-link" id="headerLabel4" href="/WebShop/about">About</a>
                </li>
                
            
                <?php if ($accountLogged) { ?>
                    <li class="nav-item dropdown">
                    <a class="<?php echo getThemeContrast(); ?> nav-link dropdown-toggle" id="headerLabel5" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Account
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="/WebShop/settings/profile">Settings</a>
                        <a class="dropdown-item" href="/WebShop/settings/listing">My Listings</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST">
                        <input type="submit" class="dropdown-item" href="#" name="logout" value="Sign Out"></input>
                        </form>
                    </div>
                </li>
                </ul>
                <?php } else {
                    echo "<form onsubmit='return false' class='form-inline my-2 my-lg-0'>";
                    echo "</ul>";
                    echo "<button type='button' class='btn btn-primary  my-2 my-sm-0' data-toggle='modal' data-target='#exampleModal'>";
                    echo "Sign In";
                    echo "</button>";
                    echo "</form>";
                }
                ?>
        </div>
    </nav>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body <?php echo getThemeBackground(); ?>" id="background">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#SignIn" data-toggle="tab">Sign in</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#SignUp" data-toggle="tab">Sign up</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="SignIn">

                            <form method="post">
                                <br/>
                                <div class="form-group" for="email">
                                    <label> Email </label> <input type="email" name="email" id="email" class="form-control" value="<?php echo $entered_email ?>" />
                                </div>
                                <div class="form-group" for="password">
                                    <label>Password </label> <input type="password" name="password" class="form-control" id="password" />
                                </div>
                                <?php
                                if ($failed_login) {
                                    echo "<div style='color:red'>Invalid Credentials</div>";
                                }
                                ?>
                                <div class="d-flex justify-content-end">
                                    <input type="submit" name="login" value="Login" class="btn btn-primary ml-1 mr-1" />
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="SignUp">
                            <form method="post">
                                <br/>
                                <div class="form-group"><label>Email</label><input type="email" name="email" class="form-control" /></div>
                                <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" /></div>
                                <div class="form-group"><label>First Name</label><input type="text" name="first_name" class="form-control" /></div>
                                <div class="form-group"><label>Last Name</label><input type="text" name="last_name" class="form-control" /></div>
                                <div class="form-group"><label>Address</label><input type="text" name="address" class="form-control" /></div>
                                <?php
                                if ($failed_attempt) {
                                    echo  $error . "<br/>";
                                }
                                ?>
                                <div class="d-flex justify-content-end">
                                    <input class="btn btn-primary" type="submit" name="register" value="Create Account" />
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
}

function htmlFooter()
{
?>
    <footer>
        <div>
            <span>Created by</span>
            <span class="AB">Alexandre Boucher</span>
            <span class="AM">Alexandre Michaud</span>
            <span class="AN">Anurag Nandi</span>
            <span class="YY">Yue Yin</span>
            <span>&copy; 2022</span>
        </div>
    </footer>
<?php
}

function displayCategories()
{
    global $category;
    $listOfCategories = Product::getCategoryList();

    foreach ($listOfCategories as $oneCategory) {
        echo "<a href='?category=$oneCategory' id='" . Product::getCategoryIndexFromName($oneCategory) . "' class='list-group-item list-group-item-action";
        if ($oneCategory == $category) echo "active";
        echo "'>$oneCategory</a>";
    }
}

function listCategories()
{
    $listOfCategories = Product::getCategoryList();

    foreach ($listOfCategories as $category) {
        echo "<option>$category</option>";
    }
}

/**
 * Function that displays the products
 * 
 * @param Product[] $listOfProducts
 */
function displayProducts($listOfProducts)
{
    global $currentPage, $user, $accountLogged;

    if ($listOfProducts == 0)
        return;

    $start = ($currentPage - 1) * MAX_PRODUCT_PER_PAGE + 1;
    $end = $start + MAX_PRODUCT_PER_PAGE;
    $count = 1;
    foreach ($listOfProducts as $product) {
        if ($count++ < $start) {
            continue;
        }
        echo "<div class='col-12 col-md-4'>";
        echo "<a title='" . $product->getName() . "' href='product.php?id=" . $product->getProductId() . "'>";
        echo "<div class='card m-2'>";
        echo "<div class='CardImgWrap'>";
        echo "<center><b>" . $product->getName() . "</b></center><br/>";
        echo "<img class='card-img-top maxSizeImage' src='" . $product->getImagePath() . "' alt='Card image cap'>";
        echo "</div>";
        echo "<div class='card-body'>";
        // if (strlen($product->getDescription()) > 45)
        // {
        //     $desc = substr($product->getDescription(), 0, 45);
        //     echo "<i>" . $desc . "...</i><br/><br/>";
        // }
        // else
        // {
            echo "<div class='description'>";
            echo "<i>" . $product->getDescription() . "</i><br/><br/>";
            echo "</div>";
        // }
        echo "Price: $" . number_format($product->getPrice(), 2) . "<br/>";
        echo "Quantity: " . $product->getQuantity() . " in stock <br/>";
        if ($product->getCategoryId() == 4) // Hard-coded - need to rewrite this
            echo "Size: " . Product::getSizeToString($product->getSize()) . "<br/>";
        $seller = Account::getAccountInfo($product->getSellerId());
        echo "Seller: " . $seller->getFirstName() . " " . $seller->getLastName() . "<br/>";
        echo "<div class='d-flex justify-content-end mt-1'>";
        if ($accountLogged && $user->getAccountId() == $product->getSellerId()) {
            echo "<input type='button' class='themeButton ". getThemeBackground() ."' value='Owned by you' disabled />";
        } elseif ($accountLogged && Product::isProductInCart($user->getAccountId(), $product->getProductId())) {
            echo "<input type='button' class='themeButton ". getThemeBackground() ."' value='In Cart' disabled />";
        } else {
            echo "<form method='POST' class='formCard'>";
            echo "<input type='hidden' name='productID' value='" . $product->getProductId() . "'/>";
            echo "<input type='submit' name='addToCart' value='Add 1 to cart' class='themeButton ". getThemeContrast() ."'/>";
            echo "</form>";
        }
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</a>";
        echo "</div>";

        if ($count == $end) {
            return;
        }
    }
}

function navigationArrows()
{
    global $currentPage, $maxPage;
    echo "<div class='d-inline'>";

    echo "<a href='Index.php'>";
    echo "<input type='submit' value='|<'" . ($currentPage == 1 ? "disabled" : "") . " />";
    echo "</a>";
    echo "<a href='Index.php?page=" . max(((int)$currentPage - 1), 1) . "'>";
    echo "<input type='submit' value='<'" . ($currentPage == 1 ? "disabled" : "") . " />";
    echo "</a>";
    echo "&nbsp $currentPage / $maxPage &nbsp";
    echo "<a href='Index.php?page=" . min(((int)$currentPage + 1), $maxPage) . "'>";
    echo "<input type='button' value='>'" . ($currentPage == $maxPage ? "disabled" : "") . "/>";
    echo "</a>";
    echo "<a href='Index.php?page=" . $maxPage . "'>";
    echo "<input type='button' value='>|'" . ($currentPage == $maxPage ? "disabled" : "") . "/>";
    echo "</a>";

    echo "</div>";
}

function displayListings()
{
    global $user;

    $listOfProducts = Product::getPostedProductList($user->getAccountId());
    foreach ($listOfProducts as $product) {
        echo "<form method='POST'>";
        echo "<li>".$product->getName();
        echo "<input type='hidden' name='productID' value='" . $product->getProductId() . "'/>";
        echo "<input type='submit' name='editProduct' value='Edit'/>";
        echo "<input type='submit' name='editProduct' value='Remove'/>";
        echo "</li>";
        echo "</form>";
    }
}
