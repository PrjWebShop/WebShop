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
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">

                <ul class="navbar-nav ml-auto">
                    <?php
                    if ($location == "/WebShop/Index.php") {
                    ?>
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

                    <?php }
                    ?>
                    <li class="nav-item">
                        <a class="nav-link" href="Index.php">Browse</a>
                    </li>
                    <!-- link to the #secondScreen -->
                    <li class="nav-item">
                        <a class="nav-link" href="#secondScreen">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#thirdScreen">Tech Stack</a>
                    </li>
                </ul>
            </div>

        </nav>
        <div class="bg-light w-100 p-2 d-flex justify-content-end">
            Yo tihs is second div
        </div>
    </div>


<?php
}

function htmlFooter()
{
?>
    <footer>

        <span>Alexandre Boucher</span>
        <span>Alexandre Michaud</span>
        <span>Anurag Nandi</span>
        <span>Yue Yin</span>
        <span>&copy; 2022</span>

    </footer>
<?php
}
