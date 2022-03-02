<?php 
require_once 'src/lib.php'; 

$failed_attempt = null;

if (isset($_COOKIE["user"]))
{
    header("Location: Index.php");
}

if (isset($_REQUEST["register"]))
{
    $email = $_REQUEST["email"];
    $pwd = $_REQUEST["password"];
    $first_name = $_REQUEST["first_name"];
    $last_name = $_REQUEST["last_name"];
    $address = $_REQUEST["address"];
    try {
        if (Account::createAccount($email, $pwd, $first_name, $last_name, $address))
    {
        setcookie("user", $email, time()+600);
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
        .center {
            text-align: center;
            margin-top: 50px;
            width: 40%;
        }
    </style>
</head>
<body>
    <div id="ui" class="center">
        <form method="post">
            Email : <br/><input type="text" name="email"/><br/><br/>
            Password : <br/><input type="password" name="password"/><br/><br/>
            First Name : <br/><input type="text" name="first_name"/><br/><br/>
            Last Name : <br/><input type="text" name="last_name"/><br/><br/>
            Address : <br/><input type="text" name="address"/><br/><br/>
            <?php 
            if ($failed_attempt) { echo  $error . "<br/>"; }
            ?>
            <input type="submit" name="register" value="Create Account"/>
        </form>
        <form method="post" action="./login.php">
            <button type="submit">Back</button>
        </form>
   </div>
</body>
</html>
        