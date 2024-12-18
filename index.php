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
    <style>
        .pagination a {
            padding: 8px 12px;
            margin: 0 5px;
            text-decoration: none;
            border-radius: 5px;
            border: 1px solid #ccc;
            color: #007bff;
        }
        .pagination a:hover {
            background-color: #ddd;
        }
        .pagination .active a {
            background-color: #007bff;
            color: white;
        }
        .pagination .disabled a {
            color: #ccc;
            pointer-events: none;
        }
    </style>
</head>
<body class="bg-dark">
    <div class="container">
        <div class="row mt-5">
            <div class="col">
                <div class="card mt-5">
                    <div class="card-header">
                        <h2 class="display-6 text-center">test e-commerce</h2>
                    </div>
                    <div class="pagination d-flex justify-content-center mt-3">
                        <ul class="pagination">
                            <?php
                            if ($page > 1) {
                                echo "<li class='page-item'><a class='page-link' href='?page=" . ($page - 1) . "'>Précédent</a></li>";
                            } else {
                                echo "<li class='page-item disabled'><a class='page-link'>Précédent</a></li>";
                            }

                            $range = 3;
                            $start = max(1, $page - $range);
                            $end = min($total_pages, $page + $range);

                            for ($i = $start; $i <= $end; $i++) {
                                echo "<li class='page-item " . ($i == $page ? 'active' : '') . "'><a class='page-link' href='?page=$i'>$i</a></li>";
                            }

                            if ($page < $total_pages) {
                                echo "<li class='page-item'><a class='page-link' href='?page=" . ($page + 1) . "'>Suivant</a></li>";
                            } else {
                                echo "<li class='page-item disabled'><a class='page-link'>Suivant</a></li>";
                            }
                            ?>
                        </ul>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <tr class="bg-dark text-white">
                                <td>Product ID</td>
                                <td>Name</td>
                                <td>Price</td>
                                <td>Image</td>
                            </tr>
                            <?php
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>";
                                echo "<td>" . $row['product_id'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['price'] . "</td>";
                                echo "<td><img src='https://m.media-amazon.com/images/I/71DBctmw+YL.jpg' alt='Product Image' style='width: 100px; height: auto;'></td>";
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
