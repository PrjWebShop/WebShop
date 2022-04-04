<?php
require_once 'src/lib.php';
require_once 'src/htmlFunction.php';

$failed_login = null;
$entered_email = "";

// Login button
if (isset($_REQUEST["login"])) {
    $email = $_REQUEST["email"];
    $pwd = $_REQUEST["password"];
    if (Account::checkLogin($email, $pwd)) {
        setcookie("user", $email, time() + 86400);
    } else {
        $failed_login = true;
        $entered_email = $_REQUEST["email"];
    }
}

?>

<html>

<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./Css/login.css">
    <link rel="stylesheet" href="./Css/hover-min.css">
    <link rel="stylesheet" href="./Css/style.css">
</head>

<body>

    <?php
        htmlNavBar();
    ?>

    <video autoplay muted id="videoBg" class="w-100 text-center">
        <source src="./Video/vdo.mp4" type="video/mp4">
    </video>
    <div id="ui" class="container-fluid negativeMargin fade-in-element">
        <div class="h-100 w-100 d-flex justify-content-center align-items-center">
            <div class="card p-4 transparentBg hvr-grow-shadow" style="width: 27rem;">
                <form method="post" action="#">
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
                    <div class="d-flex justify-content-center">
                        <input type="submit" name="login" value="Login" class="btn btn-primary ml-1 mr-1" />
                        <input type="submit" name="create_account" value="Register" class="btn btn-danger ml-1 mr-1" />
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
    <<?php
        htmlFooter();
    ?>
</html>