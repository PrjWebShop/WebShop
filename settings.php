<?php

require_once 'src/htmlFunction.php';

$args = $_SERVER["REQUEST_URI"];
$arg_arr = explode("/",$args);
$opt = $arg_arr[3]; // parameter (profile, themes, listing, admin)

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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

<?php htmlFooter(); ?>
