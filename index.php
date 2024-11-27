<?php

require_once('config/db.php');
$results_per_page = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $results_per_page;

$query = "SELECT * FROM product LIMIT $start_from, $results_per_page";
$result = mysqli_query($con, $query);

$query_total = "SELECT COUNT(*) as total FROM product";
$result_total = mysqli_query($con, $query_total);
$row_total = mysqli_fetch_assoc($result_total);
$total_pages = ceil($row_total['total'] / $results_per_page);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>test_pagination</title>
</head>
<body class="bg-dark">
    <div class = "container">
        <div class = "row mt-5">
            <div class="col">
                <div class="card mt-5">
                    <div class="card-header">
                        <h2 class="display-6 text-center">test e-commerce</h2>
                    </div>
                    <div class="pagination d-flex justify-content-center mt-3">
                        <?php
                            for($i = 1;$i<=$total_pages;$i++){
                                echo "<a href='?page=$i'> $i </a>";
                            }
                        ?>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <tr class="bg-dark text-white">
                                <td> Product ID </td>
                                <td> Name </td>
                                <td> Price</td>
                            </tr>
                            <tr>
                                <?php
                                    while($row = mysqli_fetch_assoc($result))
                                    {
                                ?>
                                    <td><?php echo $row['product_id'] ?></td>
                                    <td><?php echo $row['name'] ?></td>
                                    <td><?php echo $row['price'] ?></td>
                                </tr>
                                <?php
                                    }
                                ?>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>