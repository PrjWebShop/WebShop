<?php

require_once 'src/htmlFunction.php';

?>

<html>

<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./Css/login.css">
    <link rel="stylesheet" href="./Css/hover-min.css">
</head>

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
</body>
<?php
    htmlFooter();
?>
</html>