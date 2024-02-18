<?php
$error = [];

//1.Create Connection
require_once("connection.php");

//=======Update====
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    //2.==Get data from form
    $name = $_REQUEST["name"];
    $price = $_REQUEST["price"];
    $note = $_REQUEST["note"];
    //Validation
    if (!$name) {
        $error[] = "Name is required";
    }
    if (!$price) {
        $error[] = "Price is Required";
    }
    if (empty($error)) {
        //Import Global function
        require_once("global_function.php");
        //Upload Picture
        $image = $_FILES['image'] ?? null;
        $imagePath = "";
        if ($image["name"]) {
            //with random
            //$imagePath = "image/" . randomString(8) . $image['name'];
            //with date
            $imagePath = "image/" . date("YYMMDDhhmm") . $image['name'];
            move_uploaded_file($image['tmp_name'], $imagePath);
        } else {
            $imagePath = $_REQUEST["oldimage"];
        }
        //Prepare
        $upSt = $pdo->prepare("
    update product set name=:name,price=:price,note=:note,image=:image 
                where product_id=:id");
        //Bind value
        $upSt->bindValue(':name', $name);
        $upSt->bindValue(':price', $price);
        $upSt->bindValue(':note', $note);
        $upSt->bindValue(':image', $imagePath);
        $upSt->bindValue(':id', $_REQUEST['id']);
        //Exexute
        $upSt->execute();
        header("Location: index.php");
        return false;
    }
}

//======Get data by id from database
$id = $_REQUEST['id'];

//2.Prepare Statement
$st = $pdo->prepare("select * from product where product_id=:id");

//3.bind value
$st->bindValue(':id', $id);

//4.Execute
$st->execute();

//5.Get Data
$product = $st->fetch(PDO::FETCH_ASSOC);

if (!empty($error)) {
    $product['name'] = $name;
    $product['price'] = $price;
    $product['note'] = $note;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container">
        <h1>Edit Product</h1>
        <!-- show message error -->
        <?php require("error.php") ?>

        <form method="post" action="" enctype="multipart/form-data">
            <div class="mb-3 row">
                <label for="proName" class="form-label col-md-3">Product Name </label>
                <div class="col-md-9">
                    <input id="proName" value="<?php echo $product['name'] ?>" class="form-control" type="text" name="name" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="proPrice" class="form-label col-md-3">Price </label>
                <div class="col-md-9">
                    <input id="proPrice" value="<?php echo $product['price'] ?>" class="form-control" type="number" name="price" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="proNote" class="form-label col-md-3">Note </label>
                <div class="col-md-9">
                    <textarea id="proNote" class="form-control" type="text" name="note"><?php echo $product['note'] ?></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="proImage" class="form-label col-md-3">Photo</label>
                <div class="col-md-9">
                    <input id="proImage" class="form-control" type="file" name="image" />
                    <input type="hidden" name="oldimage" value="<?php echo $product["image"] ?>" />
                </div>
            </div>
            <input type="hidden" name="id" value="<?php echo $product['product_id'] ?>" />

            <button class="btn btn-success" type="submit" style="float: right">Save</button>
        </form>
    </div>
</body>

</html>