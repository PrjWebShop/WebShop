<?php

require_once 'src/htmlFunction.php';

?>
<html>

<?php htmlHeader(__FILE__, "WebShop"); ?>

<body>

    <?php
    htmlNavBar();
    ?>
    <div class="page-container <?php echo getThemeBackground(); ?>">
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
                                <a href="Index"><span class="badge badge-pill badge-primary p-2">All Categories</span></a>
                                <a href="Index?category=Electronics"><span class="badge badge-pill badge-secondary p-2">Electronics</span></a>
                                <a href="Index?category=Video%20Games"><span class="badge badge-pill badge-success p-2">Video Games</span></a>
                                <a href="Index?category=Movies"><span class="badge badge-pill badge-danger p-2">Movies</span></a>
                                <a href="Index?category=Clothing"><span class="badge badge-pill badge-info p-2">Clothing</span></a>
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