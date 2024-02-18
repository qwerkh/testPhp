<?php
//Connection
require("connection.php");
//Prepare Query
$statement = $pdo->prepare("select * from product ORDER BY product_id desc");
//Execute Query
$statement->execute();
//Get Data
$productList = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h1>Product</h1>
        <a href="add.php" style="float:right" class="btn btn-primary">+Add Product</a>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Note</th>
                    <th scope="col">Image</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productList as $key => $pro) { ?>
                    <tr>
                        <th scope="row"><?php echo $key + 1 ?></th>
                        <td><?php echo $pro['name'] ?></td>
                        <td><?php echo $pro['price'] ?></td>
                        <td><?php echo $pro['note'] ?></td>
                        <td><img style="width:30px; height:30px" src="<?php echo $pro['image'] ?>" /></td>
                        <td>
                            <div class="d-grid gap-2 d-md-block">
                                <a href="delete.php?id=<?php echo $pro['product_id']  ?>" class="btn btn-danger" type="button"><i class="bi bi-trash"></i></a>
                                <a href="edit.php?id=<?php echo $pro["product_id"] ?>" class="btn btn-success" type="button"><i class="bi bi-pencil"></i></a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>

</html>