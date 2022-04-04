<?php

require_once 'src/htmlFunction.php';

$args = $_SERVER["REQUEST_URI"];
$arg_arr = explode("/",$args);
$opt = $arg_arr[3];

print($opt);

?>
<html>

<?php htmlHeader(__FILE__, "Settings"); ?>

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
