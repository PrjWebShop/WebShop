<?php 
require_once 'src/lib.php'; 

$failed_login = null;
$entered_email = "";

if (isset($_COOKIE["user"]))
{
    header("Location: Index.php");
}

if (isset($_REQUEST["login"]))
{
    $email = $_REQUEST["email"];
    $pwd = $_REQUEST["password"];
    if (Account::checkLogin($email, $pwd))
    {
        setcookie("user", $email, time()+600);
        header("Location: Index.php");
    }
    else
    {
        $failed_login = true;
        $entered_email = $_REQUEST["email"];
    }
}

if (isset($_REQUEST["create_account"]))
{
    header("Location: create_account.php");
}

?>

<html>
<head>
    <style>
        .center {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div id="ui" class="center">
        <form method="post">
            Email : <br/><input type="text" name="email" value="<?php echo $entered_email ?>"/><br/><br/>
            Password : <br/><input type="password" name="password"/><br/><br/>
            <?php 
            if ($failed_login) { echo "<div style='color:red'>Invalid Credentials</div>"; }
            ?>
            <input type="submit" name="login" value="Login"/>
            <input type="submit" name="create_account" value="Register"/>
        </form>
   </div>
</body>
</html>
        