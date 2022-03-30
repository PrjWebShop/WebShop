<?php

require_once 'src/lib.php';
require_once 'src/htmlFunction.php';

?>
<html>

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="./Css/index.css">
    <link rel="stylesheet" href="./Css/style.css">
</head>

<body>

    <?php
        htmlNavBar();
    ?>
    <div class="clearfix">
        <form action="Index.php" method="GET" class="nav-link Search_Bar">
            <?php
                if (isset($_GET["category"])) {
                    echo "<input type='hidden' name='category' value='$category'/>";
                }
            ?>
            <input type="text" name="search" minlength="3" />
            <input type="submit" value="Search" class="btn btn-primary pl-1 pr-1 p-0 m-0" />
        </form>
    </div>
    
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-12">
                <div class="list-group">
                    <a href="./Index.php" id="all" class="list-group-item list-group-item-action">
                        All Categories
                    </a>
                    <?php
                    displayCategories();
                    ?>
                </div>
            </div>
            <div class="col-md-9 col-12">
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