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
        
        <div class="page-container">
            <div class="content-wrap ProductPageTable">
                <div>
                    <table>
                        <tr>
                            <th rowspan="8" class="Photo"><img src="..." alt=" I am Lost '-_-"></th>
                            <th>Detail Information</th>
                        </tr>
                        <tr>
                            <td>
                                <ul>
                                    <ul>Product Name & size(if need it)<hr></ul>
                                    <ul>Product ID<hr></ul>
                                    <ul>Seller<hr></ul>
                                    <ul>Detail Product Info<hr></ul>
                                    <ul>Available Quantity<hr></ul>
                                    <ul>Price<hr></ul>
                                    <ul>Choose Quantity and Add button</ul>
                                </ul>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php
                htmlFooter();
            ?>
        </div>

    </body>
    
</html>