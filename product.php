<?php

require_once 'src/htmlFunction.php';

if (!isset($_REQUEST["ProductId"]))
{
    header("Location:Index");
    exit;
}

?>
<html>

    <?php htmlHeader(__FILE__, $prod->getName()); ?>

    <body>

        <?php
            htmlNavBar();
        ?>
        
        <div class="page-container <?php echo getThemeBackground(); ?>">
            <div class="content-wrap ProductPageTable">
                <div>
                    <table class="<?php echo getThemeBackground(); ?> bgWhite">
                        <tr>
                            <th rowspan="8" class="Photo"><img src="<?php echo $prod->getImagePath(); ?>" alt=" I am Lost '-_-"></th>
                            <th>Detail Information</th>
                        </tr>
                        <tr>
                            <td>
                                <ul>
                                    <ul><?php echo $prod->getName();
                                                if ($prod->getSize() > 0)
                                                { echo " (" . $prod->getSizeToString($prod->getSize())["short"] . ")"; } ?><hr></ul>
                                    <ul>Product Number: <?php echo  " " . $prod->getProductId(); ?><hr></ul>
                                    <ul>Sold by: <?php echo $seller->getFirstName() . " " . $seller->getLastName(); ?><hr></ul>
                                    <ul><?php echo $prod->getDescription(); ?><hr></ul>
                                    <ul><?php echo $prod->getQuantity() . " left in stock"; ?><hr></ul>
                                    <ul><?php echo "Price: " . $prod->getPrice() . "$"; ?><hr></ul>
                                    <ul>
                                        <form method="post" action="Index">
                                            <input type="hidden" name="ProductId" value="<?php echo $prod->getProductId(); ?>"/>
                                            <input type="number" name="quantityToAdd" value="1" style="width: 3rem;"/>
                                            <input type="submit" name="addToCart" value="Add to Cart" class="themeButton <?php echo getThemeContrast(); ?>">
                                        </form>
                                    </ul>
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