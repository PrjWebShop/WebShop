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
        
        <div class="page-container <?php echo getThemeBackground(); ?>">
            <div class="container-fluid">
                <div class="content-wrap ProductPageTable">
                    <div class="row">
                        <!-- Left Panel -->
                        <div class="ml-3 col-md-3 col-12">
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
                        </div class="ml-3 col-md-3 col-12">

                        <?php 
                        
                        switch ($opt)
                        {
                            case "profile":
                                profileSettings();
                                break;
                            case "themes":
                                themesSettings();
                                break;
                            case "listing":
                                listingSettings();
                                break;
                            case "admin":
                                adminSettings();
                                break;
                            default:
                                break;
                        }
                        ?>                        
                    </div>
                </div>
            </div>
            <?php htmlFooter(); ?>
        </div>
    </body>
</html>

<?php

function profileSettings()
{
    
}

function themesSettings()
{ ?>
    <form method="POST">
        Theme: <input type="number" name="theme"/><br/>
        <input type="submit" name="themes" value="Save"/>
    </form>
<?php }

function listingSettings()
{
    
}

function adminSettings()
{
    
}
