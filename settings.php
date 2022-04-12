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
        
        <div class="page-container <?php echo getThemeBackground(); ?>" id="background2">
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
    <script>
        function themeOnChange() {

            var themeSelector = document.getElementById("themeSelector");
            var theme = themeSelector.value;
            
            // Header
            var header = document.getElementById("header");
            header.classList.remove("theme1Contrast", "theme2Contrast", "theme3Contrast", "theme4Contrast");
            header.classList.add("theme" + theme + "Contrast");

            // Labels
            var label1 = document.getElementById("headerLabel1");
            var label2 = document.getElementById("headerLabel2");
            var label3 = document.getElementById("headerLabel3");
            var label4 = document.getElementById("headerLabel4");
            var label5 = document.getElementById("headerLabel5");
            label1.classList.remove("theme1Contrast", "theme2Contrast", "theme3Contrast", "theme4Contrast");
            label1.classList.add("theme" + theme + "Contrast");
            label2.classList.remove("theme1Contrast", "theme2Contrast", "theme3Contrast", "theme4Contrast");
            label2.classList.add("theme" + theme + "Contrast");
            label3.classList.remove("theme1Contrast", "theme2Contrast", "theme3Contrast", "theme4Contrast");
            label3.classList.add("theme" + theme + "Contrast");
            label4.classList.remove("theme1Contrast", "theme2Contrast", "theme3Contrast", "theme4Contrast");
            label4.classList.add("theme" + theme + "Contrast");
            label5.classList.remove("theme1Contrast", "theme2Contrast", "theme3Contrast", "theme4Contrast");
            label5.classList.add("theme" + theme + "Contrast");

            // Background
            var background = document.getElementById("background2");
            background.classList.remove("theme1", "theme2", "theme3", "theme4");
            background.classList.add("theme" + theme);
        }
    </script>
</html>

<?php

function profileSettings()
{
    echo "Profile Settings <br/>// TO DO";
}

function themesSettings()
{
    global $user;
    $theme = $user->getTheme();
    
    echo "<form method='POST'>";
        echo "<select name='theme' id='themeSelector' onchange='themeOnChange()'>";
            echo "<option value='1'" . ($theme == 1 ? "selected" : "") . ">Blue</option>";
            echo "<option value='2'" . ($theme == 2 ? "selected" : "") . ">Green</option>";
            echo "<option value='3'" . ($theme == 3 ? "selected" : "") . ">Red</option>";
            echo "<option value='4'" . ($theme == 4 ? "selected" : "") . ">Yellow</option>";
        echo "</select>";
        echo "<br/>";
        echo "<input type='submit' name='themes' value='Save'/>";
    echo "</form>";
}

function listingSettings()
{
    echo "Product Listings <br/>// TO DO";
}

function adminSettings()
{
    echo "Account Settings <br/>// TO DO";
}
