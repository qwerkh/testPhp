<?php
$error = [];
$name = "";
$price = "";
$note = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //1 . ==Create Connection
    require("connection.php");
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
        if ($image) {
            //with random
            //$imagePath = "image/" . randomString(8) . $image['name'];
            //with date
            $imagePath = "image/" . date("YYMMDDhhmm") . $image['name'];
            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        //3. ==Prepare statement
        $statement = $pdo->prepare(
            "Insert Into product(name,price,note,image) 
                 VALUES(:name,:price,:note,:image)"
        );
        //4.== Bind value
        $statement->bindValue(":name", $name);
        $statement->bindValue(":price", $price);
        $statement->bindValue(":note", $note);
        $statement->bindValue(":image", $imagePath);
        //5.== Execute
        $statement->execute();
        //6.==Redirect to List
        header("Location: index.php");
    }
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
        <h1>Add New Product</h1>
        <!-- show message error -->
        <?php require("error.php") ?>

        <form method="post" action="" enctype="multipart/form-data">
            <div class="mb-3 row">
                <label for="proName" class="form-label col-md-3">Product Name </label>
                <div class="col-md-9">
                    <input value="<?php echo $name ?>" id="proName" class="form-control" type="text" name="name" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="proPrice" class="form-label col-md-3">Price </label>
                <div class="col-md-9">
                    <input value="<?php echo $price ?>" id="proPrice" class="form-control" type="number" name="price" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="proNote" class="form-label col-md-3">Note </label>
                <div class="col-md-9">
                    <textarea value="<?php echo $note ?>" id="proNote" class="form-control" type="text" name="note"></textarea>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="proImage" class="form-label col-md-3">Photo</label>
                <div class="col-md-9">
                    <input id="proImage" class="form-control" type="file" name="image" />
                </div>
            </div>

            <button class="btn btn-success" type="submit" style="float: right">Save</button>
        </form>
    </div>
</body>

</html>