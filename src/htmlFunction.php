<?php
require_once 'src/lib.php';


function htmlNavBar()
{
    global $accountLogged, $user, $category;
    $location = $_SERVER["PHP_SELF"];
?>

    <div className="topBaar">

        <nav class="navbar navbar-expand-lg nav-dark transparentBg">
            <img class="navi-logo img-fluid" src="./Img/Logo/logo.png" alt="Logo Not Found">

            <?php
            //Welcome text with User full name
            if ($accountLogged)
                $welcomeMessage = "Welcome, " . $user->getFirstName() . " " . $user->getLastName();
            else $welcomeMessage = "";

            echo "<a class='navbar-brand font-weight-bold' href=''>$welcomeMessage</a>";

            ?>
                <li class="nav-item d-flex align-item-right" >
                    <form action="Index.php" method="GET" class="nav-link">
                        <?php
                            if (isset($_GET["category"])) {
                                echo "<input type='hidden' name='category' value='$category'/>";
                            }
                        ?>
                        <input type="text" name="search" minlength="3" />
                        <input type="submit" value="Search" class="btn btn-primary pl-1 pr-1 p-0 m-0" />
                    </form>
                </li>

            <!-- nav bar toggle into a small button -->
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ml-auto">
                   
                    
                    <li class="nav-item">
                        <a class="nav-link" href="Index.php">Browse</a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#">Cart
                            <?php
                                if ($accountLogged) {
                                    $countInCart = Product::getTotalCountFromCart($user->getAccountId());
                                    if ($countInCart != "0")
                                        echo "(" . Product::getTotalCountFromCart($user->getAccountId()) . ")"; // temp fix
                                }
                            ?>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <?php
                            if ($accountLogged)
                                echo "<a class='nav-link' href='register_product.php'>Sell</a>";
                            else
                                echo "<a class='nav-link disabled'>Sell</a>";
                        ?>
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
                    
                    <!-- link to the #secondScreen -->
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                </ul>
            </div>

        </nav>
        <div class="bg-light w-100 p-2 d-flex justify-content-end">
            
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
