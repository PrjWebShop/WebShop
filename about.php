<?php

require_once 'src/htmlFunction.php';

?>

<html>

<?php htmlHeader(__FILE__, "About"); ?>

    <body>

        <?php htmlNavBar(); ?>

        <div class="page-container <?php echo getThemeBackground(); ?>">
            <div class="content-wrap">
                <div class="AboutPageStyle">
                    <div class="container-fluid negativeMargin fade-in-element">
                        <div class="h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="card p-5 transparentBg hvr-grow-shadow">
                                <h4>About WebShop</h4>
                                <p>
                                    Welcome to The Web Shop, You can find a wide variety of products here.
                                    We ship to all over the world.
                                </p>
                                <p>
                                    Find best deals on Electronics, Books, Toys, and more.
                                    You can create an account and start shopping!
                                    We hope you enjoy your shopping experience and please feel free to contact us for any questions or concerns.
                                </p>
                            </div>

                        </div>
                    </div>
                    
                    <div class="container-fluid negativeMargin fade-in-element">
                        <div class="h-100 w-100 d-flex justify-content-center align-items-center">
                            <div class="card p-5 transparentBg hvr-grow-shadow">
                                <h4>Our Tech Stack</h4>
                                <p>
                                    Here is a list of all the technologies we used to build this website.
                                </p>
                                <ul>
                                    <li><u>HTML and CSS3</u> for layout and animations</li>
                                    <li><u>Bootstrap</u> CSS framework for responsive design</li>
                                    <li><u>PHP</u> for the backend</li>
                                    <li><u>MySQL</u> for the database</li>
                                    <li><u>JavaScript</u> and <u>JQuery</u> for the frontend</li>
                                    <li><u>Image Sources:</u> Pixabay, Unsplash</li>
                                    <li><u>Video Sources:</u> Pexels</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php htmlFooter(); ?>
        </div>
    </body>
    
</html>