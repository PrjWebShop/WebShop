<?php

require_once 'src/htmlFunction.php';

if (isset($_GET["id"]))
{
    $prod_id = $_GET["id"];
    $prod = Product::getProductByID($prod_id);
}

?>
<html>

<?php htmlHeader(__FILE__, $prod->getName()); ?>

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