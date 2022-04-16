<?php

require_once 'src/htmlFunction.php';

$cartEmpty = true;

$listOfProductsInCart = Product::getProductListFromCart($user->getAccountId());
if ($listOfProductsInCart != 0)
    $cartEmpty = false;

?>
<html>

<?php htmlHeader(__FILE__, "Your cart"); ?>


<body>

    <?php
    htmlNavBar();
    ?>
    <div class="page-container <?php echo getThemeBackground(); ?>">
        <div class="content-wrap ProductPageTable">
            <div>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 col-12">
                            <div class="row">
                                <?php
                                if (!$cartEmpty) {
                                    displayCart($listOfProductsInCart);
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php htmlFooter(); ?>
    </div>
    
</body>
 <script>
                var id = document.getElementById('<?php echo $category_filter; ?>');
                if (!id)
                    id = document.getElementById('all');

                id.classList.add('active');
</script>


</html>