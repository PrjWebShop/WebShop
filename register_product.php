<?php

require_once 'src/htmlFunction.php';

if (!$accountLogged)
    header("Location: Index");

$fieldCheck = true;

?>

<!DOCTYPE html>
<html>

<?php htmlHeader(__FILE__, "Register your product"); ?>

<body>

    <?php
    htmlNavBar();
    ?>
    <h2>Register your product</h2><br />
    <div>
        <form method="POST" action="#" enctype="multipart/form-data">

            <!-- Category -->
            <label>Category</label><?php checkField("name"); ?>
            <br />
            <select name="category" id="category" onchange="categoryOnChange()">
                <?php listCategories(); ?>
            </select><br /><br />

            <!-- Name -->
            <label>Product Name</label><?php checkField("name"); ?>
            <br /><input required type="text" name="name" /><br /><br />

            <!-- Description -->
            <label>Description</label><?php checkField("description"); ?>
            <br /><textarea name="description" cols="40" rows="5" required></textarea><br /><br />


            <!-- Quantity -->
            <label>Quantity</label><?php checkField("quantity"); ?>
            <br /><input required type="number" name="quantity" min="1" /><br /><br />

            <!-- Size -->
            <label>Size</label><?php checkField("size"); ?>
            <br /><input type="number" name="size" id="size" min="0" disabled /><br /><br />

            <!-- Image -->
            <label>Image</label>
            <br /><input type="file" name="image" accept="image/*" /><br /><br />

            <!-- Price -->
            <label>Price</label><?php checkField("price"); ?>
            <br /><input required name="price" pattern="^\d*(\.\d{0,2})?$" /><br /><br />

            <!-- Register Button -->
            <input type="submit" name="submit" value="Register" />
            <a href="Index.php">
                <input type="button" value="Go back" />
            </a>
        </form>
    </div>


    <script>
        function categoryOnChange() {

            var category = document.getElementById("category");
            var txtSize = document.getElementById("size");
            // Enables the size field for clothing products
            if (category.value == "Clothing") {
                txtSize.disabled = false;
            } else {
                txtSize.disabled = true;
                txtSize.value = "";
            }
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    
</body>

</html>

<?php

if (isset($_REQUEST["submit"]) && $fieldCheck) {

    // Get File Info //

    $file = $_FILES['image'];

    $prodCategory = Product::getCategoryIndexFromName($_REQUEST["category"]);
    $prodName = $_REQUEST["name"];
    $prodDesc = $_REQUEST["description"];
    $prodPrice = $_REQUEST["price"];
    $prodQuantity = $_REQUEST["quantity"];
    $prodSize = $_REQUEST["size"] != "" ? $_REQUEST["size"] : 0; // Needs to be optimized to only fire when Clothing category is selected
    $prodSeller = $user->getAccountId();
    $prodImagePath = "";

    $newProd = new Product(null, $prodCategory, $prodName, $prodDesc, $prodPrice, $prodQuantity, $prodSize, $prodSeller, $prodImagePath);

    // Upload File //

    $uploadOK = true;

    $fileName = $file['name'];
    $fileTmpName = $file['tmp_name'];
    $fileSize = $file['size'];
    $fileError = $file['error'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    if (!$fileError === 0) {
        echo "There was an error uploading your file!";
        exit;
    }
    if ($fileSize > 10000000) {
        echo "Your file is too big";
        exit;
    }

    $fileNameNew = uniqid('', true) . "." . $fileActualExt;
    $fileDestination = IMAGE_UPLOAD_FOLDER . $fileNameNew;
    move_uploaded_file($fileTmpName, $fileDestination);
    $newProd->setImagePath($fileNameNew);

    if ($uploadOK) {
        $newProd->addProductToDatabase();

        unset($_POST);
        header("Location: Index.php");
        exit;
    }
}
?>