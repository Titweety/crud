<?php

require_once 'function.php';
require_once "product.class.php";
require_once 'product.php';
$name = $category = $price = $availability = '';
$nameErr = $categoryErr = $priceErr = $availabilityErr = '';


$productObj = new Product();


if (($_SERVER['REQUEST_METHOD'] == 'POST') AND !empty("add")) {

    $name = clean_input($_POST['name']);
    $category = clean_input($_POST['category']);
    $price = clean_input($_POST['price']);
    $availability = isset($_POST['availability']) ? clean_input($_POST['availability']) : '';



    if (empty($name)) {
    $nameErr = 'Name is required';
    }

    if (empty($category)) {
    $categoryErr = 'Category is required';
    }

    if (empty($price)) {
    $priceErr = 'Price is required';
    } else if (!is_numeric($price)) {
    $priceErr = 'Must be a number';
    } else if ($price < 1) {
    $priceErr = 'Must be greater than zero';
    }

    if (empty($availability)) {
    $availabilityErr = 'Required availability';
    }

    if (empty($codeErr) AND empty($nameErr) AND empty($categoryErr) AND empty($priceErr) AND empty($availabilityErr)) {

        $productObj->name = $name;
        $productObj->category = $category;
        $productObj->price = $price;
        $productObj->availability = $availability;


    if ($productObj->add()) {


        header('location: product.php');
        } else {
        echo 'Something went wrong adding a product';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <!-- <form action="" method="post">
        <span class="error"> * are required fields</span>
        <br>
        <label for="name">Name</label><span class="error">*</span>
        <input type="text" name="name" id="name" value="<?= $name ?>">
        <br>
        <?php if (!empty($nameErr)): ?>
            <span class="error"><?= $nameErr ?></span><br>
            <?php endif; ?>

            <label for="category">Category</label><span class="error">*</span>
            <br>
            <select name="category" id="category">
                <option value="">--Select Category</option>
                <option value="Gadget" <?= (isset($category) AND $category == 'Gadget') ? 'selected=true' : '' ?>>Gadget</option>
                <option value="Toys" <?= (isset($category) && $category == 'Toys') ? 'selected=true' : '' ?>>Toys</option>      

            </select>
            <br>
            <?php if (!empty($categoryErr)): ?>
                <span class="error"><?= $categoryErr ?></span><br>
                <?php endif; ?>

                <label for="price">Price</label><span class="error">*</span>
                <br>
                <input type="number" name="price" id="price" value="<?= $price ?>">
                <br>
                <?php if (!empty($priceErr)): ?>
                    <span class="error"><?= $priceErr ?></span>
                    <br><?php endif; ?>

                    <label for="availability">Availability</label><span class="error">*</span>
                    <div class="radio-group">
                    <input type="radio" value="InStock" name="availability" id="instock" <?= ($availability == 'Instock') ? 'checked' : '' ?>>
                    <label for="instock">In Stock</label>
                    <input type="radio" value="NoStock" name="availability" id="nostock" <?= ($availability == 'Nostock') ? 'checked' : '' ?>>
                    <label for="nostock">No Stock</label>    
                    </div>
                    
                <?php if (!empty($availabilityErr)): ?>
                    <span class="error"><?= $availabilityErr ?></span>
                    <br><?php endif; ?>

                    <br>
                    <input type="submit" value="Save Product">

     </form> -->
    </body>
</html>

