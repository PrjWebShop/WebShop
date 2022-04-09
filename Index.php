<?php

require_once 'src/htmlFunction.php';

?>
<html>

<?php htmlHeader(__FILE__, "WebShop"); ?>

<body>

    <?php
    htmlNavBar();
    ?>
    <div class="page-container">
        <div class="content-wrap ProductPageTable">
            <div>
                <div class="d-flex justify-content-center mt-2 mb-2">
                    <form action="Index.php" method="GET" class="form-inline">
                        <?php
                        if (isset($_GET["category"])) {
                            echo "<input type='hidden' name='category' value='$category'/>";
                        }
                        ?>
                        <div class="form-group input-group-sm">
                            <input type="text" required class="form-control input-group-sm" name="search" minlength="3" placeholder="Enter keyword">
                            <button type="submit" class="btn btn-primary ml-1 mr-1"><span class="fa fa-search"></span></button>
                        </div>
                    </form>
                </div>


                <div class="container-fluid">
                    <div class="row">
                        <!-- <div class="col-md-3 col-12">
                            <div class="list-group">
                                <a href="./Index.php" id="all" class="list-group-item list-group-item-action">
                                    All Categories
                                </a>
                                <?php
                                displayCategories();
                                ?>
                            </div>
                        </div> -->
                        <div class="col-md-12 col-12">
                            <div class="text-center">
                                <span class="badge badge-pill badge-primary p-2">All Categories</span>
                                <span class="badge badge-pill badge-secondary p-2">Featured</span>
                                <span class="badge badge-pill badge-success p-2">New</span>
                                <span class="badge badge-pill badge-danger p-2">Sale</span>
                                <span class="badge badge-pill badge-info p-2">Clothing</span>
                                <span class="badge badge-pill badge-warning p-2">Accessories</span>
                            </div>
                        </div>
                        <div class="col-md-12 col-12">
                            <div class="row">
                                <?php
                                if ($productFound) {
                                    displayProducts($listOfProducts);
                                }

                                ?>
                            </div>
                        </div>

                        <div class="w-100 d-flex justify-content-center p-2 mt-4">
                            <?php
                            navigationArrows();
                            ?>
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