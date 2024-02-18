<?php
//Create Connection
require_once("connection.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Prepare statement for remove
    $stRemove = $pdo->prepare("Delete from product where product_id=:id");
    //Bind value
    $id = $_REQUEST["id"];
    $stRemove->bindValue(':id', $id);
    //Execute 
    $stRemove->execute();
    //Go to Product List
    header("Location: index.php");
    exit();
}

$id = $_REQUEST["id"];
//Prepare statement
$st = $pdo->prepare("select * from product where product_id=:id");
//Bind Value
$st->bindValue(':id', $id);
//Excecute
$st->execute();
//Get Data
$proDoc = $st->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Remove</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>

</head>

<body>
    <center>
        <h1>Delete Product</h1>
        Product Name : <?php echo $proDoc['name'] ?> <br>
        Price : <?php echo $proDoc['price'] ?><br>
        Note: <?php echo $proDoc['note'] ?><br>
        <form action="delete.php" method="post">
            <input type="hidden" name="id" value="<?php echo $proDoc['product_id'] ?>" />
            <input class="btn btn-danger" type="submit" value="Confirm Delete" />
        </form>
    </center>
</body>

</html>