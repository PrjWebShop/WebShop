<?php

require_once 'src/htmlFunction.php';

if (isset($_GET["id"]))
{
    $prod_id = $_GET["id"];
    $prod = Product::getProductByID($prod_id);
    $seller = Account::getAccountInfo($prod->getSellerId());
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
                            <th rowspan="8" class="Photo"><img src="<?php echo $prod->getImagePath(); ?>" alt=" I am Lost '-_-"></th>
                            <th>Detail Information</th>
                        </tr>
                        <tr>
                            <td>
                                <ul>
                                    <ul><?php echo $prod->getName();
                                                if ($prod->getSize() > 0)
                                                { echo " (" . $prod->getSizeToString($prod->getSize()) . ")"; } ?><hr></ul>
                                    <ul>Product Number: <?php echo $prod->getProductId(); ?><hr></ul>
                                    <ul>Sold by: <?php echo $seller->getFirstName() . " " . $seller->getLastName(); ?><hr></ul>
                                    <ul><?php echo $prod->getDescription(); ?><hr></ul>
                                    <ul><?php echo $prod->getQuantity() . " left in stock"; ?><hr></ul>
                                    <ul><?php echo $prod->getPrice() . "$"; ?><hr></ul>
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