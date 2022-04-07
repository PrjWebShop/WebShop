<?php

require_once 'src/htmlFunction.php';

?>
<html>

<?php htmlHeader(__FILE__, "WebShop"); ?>

<body>

    <?php
    htmlNavBar();
    ?>

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

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        var id = document.getElementById('<?php echo $category_filter; ?>');
        if (!id)
            id = document.getElementById('all');

        id.classList.add('active');
    </script>

</body>

<?php
htmlFooter();
?>

</html>