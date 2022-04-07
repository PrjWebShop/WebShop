<?php

require_once 'src/htmlFunction.php';

?>

<html>

<?php htmlHeader(__FILE__, "About"); ?>

<body style="background-color: aquamarine;">

    <?php
        htmlNavBar();
    ?>

    <div id="secondScreen" class="container-fluid negativeMargin fade-in-element">
        <div class="h-100 w-100 d-flex justify-content-center align-items-center">
            <div class="card p-4 transparentBg hvr-grow-shadow" style="width: 30rem;">
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
    <div id="thirdScreen" class="container-fluid negativeMargin fade-in-element">
        <div class="h-100 w-100 d-flex justify-content-center align-items-center">
            <div class="card p-4 transparentBg hvr-grow-shadow" style="width: 30rem;">
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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
</body>
<?php
    htmlFooter();
?>
</html>