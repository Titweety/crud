<?php

require_once('function.php');
require_once('product.class.php');

$name = $category = $price = $availability = "";
$nameErr = $categoryErr = $priceErr = $availabilityErr = '';
$productObj = new Product();

if ($_SERVER['REQUEST_METHOD'] == 'GET' ) {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $record = $productObj->fetchRecord($id);
        // echo "<pre>";
        // print_r($record);
        // echo "</pre>";
        if (!empty($record)) {
            $name = $record["name"];
            $category = $record['category'];
            $price = $record['price'];
            $availability = $record['availability'];
        } else {
            echo 'No Product found';
            exit;
        }
    } else {
        echo 'No Product Found';
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $id = clean_input($_GET['id']);
    $name = clean_input($_POST['name']);
    $category = clean_input($_POST['category']);
    $price = clean_input($_POST['price']);
    $availability = isset($_POST['availability']) ? clean_input($_POST['availability']) : '';
    if (empty($name)) {
        $nameErr = 'Name is Required';
    }

    if (empty($category)) {
        $categoryErr = 'category is required';
    }

    if (empty($price)) {
        $priceErr = 'price is required';
    } elseif (!is_numeric($price)) {
        $priceErr = 'price should be number';
    } elseif ($price < 1) {
        $priceErr = 'higher than 0';
    }

    if (empty($availability)) {
        $availabilityErr = 'availabilty is required';
    }

    if (empty($codeErr) && empty($nameErr) && empty($priceErr) && empty($categoryErr) && empty($availabilityErr)) {
        $productObj->id = $id;
        $productObj->name = $name;
        $productObj->category = $category;
        $productObj->price = $price;
        $productObj->availability = $availability;
    
        if ($productObj->edit()) {
            header('Location: product.php');
        } else {
            echo 'Something went wrong';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="?id=<?= $id ?>" method="post">
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
                <option value="Toys" <?= (isset($category) && $category == "'Toys'") ? 'selected=true' : '' ?>>Toys</option>      

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

                    <label for="availablity">Availability</label><span class="error">*</span>
                    <div class="radio-group">
                    <input type="radio" value="InStock" name="availability" id="instock" <?= ($availability == 'InStock') ? 'checked' : '' ?>>
                    <label for="instock">In Stock</label>
                    <input type="radio" value="NoStock" name="availability" id="nostock" <?= ($availability == 'NoStock') ? 'checked' : '' ?>>
                    <label for="nostock">No Stock</label>    
                    </div>
                    <br>
                <?php if (!empty($availabilityErr)): ?>
                    <span class="error"><?= $availabilityErr ?></span>
                    <br><?php endif; ?>

                    <br>
                    <input type="submit" value="Save Product">

     </form>
    
</body>
</html>




