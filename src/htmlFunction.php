<?php
require_once 'src/lib.php';

$failed_login = null;
$entered_email = "";
$failed_attempt = null;

// If the user is already logged in, redirect to index
if (isset($_COOKIE["user"])) {
    header("Location: Index.php");
}

// Login button
if (isset($_REQUEST["login"])) {
    $email = $_REQUEST["email"];
    $pwd = $_REQUEST["password"];
    if (Account::checkLogin($email, $pwd)) {
        setcookie("user", $email, time() + 86400);
        header("Location: Index.php");
    } else {
        $failed_login = true;
        $entered_email = $_REQUEST["email"];
    }
}

// Register button
if (isset($_REQUEST["create_account"])) {
    header("Location: create_account.php");
}

// is set for sign up

if (isset($_REQUEST["register"])) {
    $email = $_REQUEST["email"];
    $pwd = $_REQUEST["password"];
    $first_name = $_REQUEST["first_name"];
    $last_name = $_REQUEST["last_name"];
    $address = $_REQUEST["address"];
    try {
        if (Account::createAccount($email, $pwd, $first_name, $last_name, $address)) {
            setcookie("user", $email, time() + 600);
            header("Location: Index.php");
        }
    } catch (\Throwable $th) {
        $failed_attempt = true;
        switch ($th->getCode()) {
            case SQL_ERROR_DUPLICATE:
                $error = "Email already registed!";
                break;
            case SQL_ERROR_DATA_TOO_LONG:
                $error = $th->getMessage(); //"Fields must have less than 100 characters!";
                break;
            default:
                $error = $th->getMessage();
                break;
        }
    }
}

function htmlNavBar()
{
    global $accountLogged, $user, $category, $failed_login, $entered_email, $failed_attempt, $error;
    $location = $_SERVER["PHP_SELF"];
?>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#">Disabled</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <button type="button" class="btn btn-primary  my-2 my-sm-0" data-toggle="modal" data-target="#exampleModal">
                    Sign in
                </button>
            </form>
        </div>
    </nav>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item">
                            <a class="nav-link active" href="#SignIn" data-toggle="tab">Sign in</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#SignUp" data-toggle="tab">Sign up</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="SignIn">

                            <form method="post" action="./login.php">
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

                        <div class="tab-pane" id="SignUp">
                            <form method="post">
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
