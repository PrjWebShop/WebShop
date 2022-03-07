<?php
require_once 'src/lib.php';

$failed_attempt = null;

if (isset($_COOKIE["user"])) {
    header("Location: Index.php");
}

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
            case 1062:
                $error = "Email already registed!";
                break;
            case 1406:
                $error = $th->getMessage(); //"Fields must have less than 100 characters!";
                break;
            default:
                $error = $th->getMessage();
                break;
        }
    }
}

?>

<html>

<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
    </style>
    <link rel="stylesheet" href="./Css/hover-min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <div id="ui" class="container-fluid">
        <div class="h-100 w-100 d-flex justify-content-center align-items-center">
            <div class="card p-4 transparentBg hvr-grow-shadow" style="width: 27rem;">
                <form method="post">
                    <div class="form-group"><label>Email</label><input type="text" name="email" class="form-control" /></div>
                    <div class="form-group"><label>Password</label><input type="password" name="password" class="form-control" /></div>
                    <div class="form-group"><label>First Name</label><input type="text" name="first_name" class="form-control" /></div>
                    <div class="form-group"><label>Last Name</label><input type="text" name="last_name" class="form-control" /></div>
                    <div class="form-group"><label>Address</label><input type="text" name="address" class="form-control" /></div>
                    <?php
                    if ($failed_attempt) {
                        echo  $error . "<br/>";
                    }
                    ?>
                    <input class="btn btn-primary" type="submit" name="register" value="Create Account" />
                </form>
                <form method="post" action="./login.php">
                    <button class="btn btn-danger" type="submit">Home</button>
                </form>
            </div>
        </div>
    </div>



    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>