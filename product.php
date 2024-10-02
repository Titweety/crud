<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <style>
        /* body{
            background-image: url(r.png);
        } */
        p.search {
            text-align: center;
            margin: 20px 0;
        }
        btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #008000;
        }
    </style>
</head>
<body>
    <?php
    include_once "function.php";
    $keyword=$category='';
    if(($_SERVER["REQUEST_METHOD"] == 'POST') AND isset($_POST["search"])) {
        $keyword = clean_input($_POST["keyword"]);
        $category = clean_input($_POST["category"]);
        
    }
    ?>

<a href="addProduct.php" class="btn">Add Product</a>
<br>

<br>
<br>
<form action="" method="post">
        <label for="keyword">Keyword:</label>
        <input type="text" name="keyword" id="keyword" placeholder="Enter Keyword" value="<?= $keyword?>" >
        
        <label for="category">Category:</label>
        <select name="category" id="category" >
            <option value="">--Select Category--</option>
            <option value="Gadget" <?= $category == "Gadget" ? "selected" : "" ?>>Gadget</option>
            <option value="Toys" <?= $category == "Toys" ? "selected" : "" ?>>Toys</option>
            <option value="Sonny" <?= $category == "Sonny" ? "selected" : "" ?>>Sonny</option>
        </select>
        
        <input type="submit" value="Search" name = "search">
    </form>

    <?php 
    require_once 'product.class.php';

    $productObj = new Product();
    $array = $productObj->showAll($keyword, $category);
    ?>
    <table border="1">
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Availability</th>
            <th>Action</th>
        </tr>
        <?php 
        $i = 1;

        if (empty($array)) {
        ?>
            <tr>
                <td colspan="7">
                    <p class="search">No product found.</p>
                </td> 
            </tr>
        <?php
        }

        foreach ($array as $arr) {
        ?>
            <tr>
                <td><?=  $i ?></td>
                <td><?php echo $arr['name'] ?></td>
                <td><?php echo $arr['category'] ?></td>
                <td><?php echo $arr['price'] ?></td>
                <td><?php echo $arr['availability'] ?></td>
                <td>
                    <a href="editProduct.php?id=<?= $arr['id'] ?>">Edit</a>
                    <a href="deleteProduct.php?id=<?= $arr['id'] ?>">Delete</a>
                </td>
            </tr>
        <?php 
            $i++;
        }
        ?>
        </table>
</body>
</html>

