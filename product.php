<?php

require_once 'src/lib.php';
require_once 'src/htmlFunction.php';

if (isset($_GET["id"]))
{
    $prod_id = $_GET["id"];
    $prod = Product::getProductByID($prod_id);
}

?>
<html>

<head>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
    </style>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./Css/style.css">
    <link rel="stylesheet" href="./Css/index.css">
</head>

<body>

    <?php
        htmlNavBar();
    ?>
    
    <div>
    
    </div>

</body>
    <?php
        htmlFooter();
    ?>
</html>