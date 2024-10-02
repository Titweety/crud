<?php

require_once "function.php";
require_once "product.class.php";

$name = $category = $price = $availability = '';
$nameErr = $categoryErr = $priceErr = $availabilityErr = '';

$productObj = new Product();

if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty("ddd")){

    $name = clean_input($_POST['name']);
    $category = clean_input($_POST['category']);
    $price = clean_input($_POST['price']);
    $availability = isset($_POST['availability']) ? clean_input($_POST['availability']) : '';

    if (empty($name)){
        $nameErr = 'Name is required';
    }
    if (empty($category)){
        $categoryErr = 'Category is required';
    }
    if (empty($price)){
        $priceErr = 'Price is required';
    }
    else if(!is_numeric($price)){
        $priceErr = 'Price should be number';
    }
    else if($price < 1){
        $priceErr = 'Higher than 0';
    }
    if (empty($availability)){
        $availabilityErr = 'Availability is required';
    }

    if (empty($codeErr) && empty ($nameErr) &&  empty($categoryErr) && empty($priceErr) && empty($availabilityErr)){
        $productObj->name = $name;
        $productObj->category = $category;
        $productObj->price = $price;
        $productObj->availability = $availability;

        if($productObj->add()){
            header('Location: index.php');
        }
        else{
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
        .error{
            color: red;
        }
    </style>
</head>
<body>
    <form action="" method="post">
        <span class="error">* are required fields</span>
        <br>
        <label for="name">Name</label><span class="error">*</span>
        <br>
        <input type="text" name="name" id="name" value="<?php echo $name;?>">
        <br>
        <?php if(!empty($nameErr)):?>
        <span class="error"><?php echo $nameErr;?></span>
        <br>
        <?php endif;?>

        <label for="category"></label><span class="error">*</span>
        <br>
        <select name="category" id="category">
            <option value="">--Select Category--</option>
            <option value="Gadget" <?php echo ($category == 'Gadget')?'selected="selected"' : '';?>>Gadget</option>
            <option value="Toys" <?php echo ($category == 'Toys')?'selected="selected"' : '';?>>Toy</option>
        </select>
        <br>
        <?php if (!empty($categoryErr)): ?>
        <span class="error"><?= $categoryErr ?></span>
        <br>
        <?php endif;?>

        <label for="price">Price</label><span class="error">*</span>
        <br>
        <input type="number" name="price" id="price" value="<?php echo $price;?>">
        <br>
        <?php if(!empty($priceErr)):?>
        <span class="error"><?php echo $priceErr;?></span>
        <br>
        <?php endif;?>

        <label for="availability">Availability</label><span class="error">*</span>
        <br>
        <input type="radio" name="availability" id="instock" value="InStock" <?php echo ($availability == 'InStock')?'checked="checked"' : '';?>>
        <label for="instock">In Stock</label>
        <input type="radio" name="availability" id="nostock" value="NoStock" <?php echo ($availability == 'NoStock')?'checked="checked"' : '';?>>
        <label for="nostock">No Stock</label>
        <br>
        <?php if (!empty($availabilityErr)): ?>
        <span class="error"><?= $availability?></span>
        <br>
        <?php endif; ?>
        <br>
        <input type="submit" value="Save Product">
    </form>
</body>
</html>