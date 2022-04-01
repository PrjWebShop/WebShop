<?php

require_once 'src/htmlFunction.php';

$args = $_SERVER["REQUEST_URI"];
$arg_arr = explode("/",$args);
$opt = $arg_arr[3];

print($opt);

?>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="/WebShop/Css/index.css">
    <link rel="stylesheet" href="/WebShop/Css/style.css">
</head>

<body>

<?php htmlNavBar(); ?>

<div class="container-fluid">
        <div class="row">

            <!-- Left Panel -->
            <div class="col-md-3 col-12">
                <div class="list-group">
                    <a href="/WebShop/settings/profile" id="profile" class="list-group-item list-group-item-action">
                        Profile
                    </a>
                    <a href="/WebShop/settings/themes" id="themes" class="list-group-item list-group-item-action">
                        Appearance
                    </a>
                    <a href="/WebShop/settings/listing" id="listing" class="list-group-item list-group-item-action">
                        My Listings
                    </a>
                    <a href="/WebShop/settings/admin" id="admin" class="list-group-item list-group-item-action">
                        Account
                    </a>
                </div>
            </div>
            
        </div>
    </div>

<?php htmlFooter(); ?>
