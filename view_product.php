<?php
include 'includes/header.php';
include 'middleware.php';
require "dbcon.php";
?>

<!-- CONTENT -->
<div class="logo-bg-2"></div>
<div class="admin-container">

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h2 style="font-family: 'Inter', sans-serif; font-size: 40px; font-weight: bold;">
                    Products
                </h2>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Item Name</th>
                                <th>Image</th>
                                <th>Description</th>
                                <th>Supplier</th>
                                <th>Stock</th>
                                <th>Category</th>
                                <th>Date Created</th>
                                <th>Creator Admin ID</th>
                                <th>Record Status</th>
                                <th style="text-align : center">Edit</th>
                            </tr>
                        </thead>
                        <tbody class="record-img">
                                <!-- FETCHING DATA -->
                            <?php
                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                $page = max($page, 1); // Ensure page is at least 1
                                [$limit, $totalPages] = pagination($con);
                                $start = ($page - 1) * $limit;
                                
                                // Fetch records for the current page
                                $itemrecords = RetrieveAll("items", $con, $start, $limit);

                                if (mysqli_num_rows($itemrecords) > 0) {
                                    foreach ($itemrecords as $item) :
                            ?>
                                        <tr>
                                            <td><?=$item['item_id']?> </td>
                                            <td><?=$item['item_name']?> </td>

                                            <td> 
                                                <img  src="record_images/item_images/<?=$item['item_img'];?>" alt="item">
                                            
                                            
                                            </td>
                                            <td><?=htmlspecialchars($item['item_desc'])?> </td>
                                            <td><?=$item['supplier_name']?> </td>
                                            <td><?=$item['stock']?> </td>
                                            <td><?=$item['category']?> </td>
                                            <td><?=$item['date_created']?> </td>
                                            <td><?=$item['admin_creator']?> </td>
                                            <td class="item-txt"><?=$item['record_status']?> </td>
                                            <td>
                                                <div class="col-md-15 ms-auto me-auto" style="text-align:center">
                                                    <form action="mod_product.php?itemidlabel=<?=$item['item_id']?>" method="post">
                                                        <button type="submit" name="item-edit-btn">Edit Records</button>
                                                    </form>
                                                </div>                                             
                                            </td>
                                        </tr>

                                <?php
                                endforeach;                                                                 
                            } else {
                                ?>
                                <tr>
                                    <td colspan="15" class="text-center">No records found</td>
                                </tr>
                            <?php
                            }
                        ?>
                    </tbody>
                </table>
                <div>
               

                    <nav>
                        <ul class="pagination">
                            <!-- Previous Button -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                                <a class="page-link" href="?page=<?= $page - 1; ?>">Previous</a>
                            </li>

                                <!-- Page Numbers -->
                                <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                    <li class="page-item <?= ($page === $i) ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Next Button -->
                                <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="?page=<?= $page + 1; ?>">Next</a>
                                </li>
                            </ul>
                        </nav>
                        <div class="col-md-4 ms-auto">
                            <form action="mod_product.php?itemidlabel?=0" method="post">
                                <button type="submit" name="item-add-btn">Add New Item</button>

                            </form>
                        </div>

                    </div>


                </div>


<!-- END OF CONTENTS -->
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>




<?php
include 'includes/footer.php';

function RetrieveAll($table, $con, $start, $limit)
{
    
    $query = "SELECT i.item_id, i.item_name,i.item_img, i.item_desc, s.supplier_name,i.stock, c.category,i.date_created,CONCAT(a.admin_firstname, ' ' , a.admin_surname) AS admin_creator, i.record_status 
                FROM items i LEFT JOIN administrators a ON i.admin_creator = a.admin_id
                LEFT JOIN categories c ON i.cat_id=c.cat_id
                LEFT JOIN supplier s ON i.supplier_id=s.supplier_id
                LIMIT ?, ?;"; // Use LIMIT with placeholders for pagination

    $stmt = $con->prepare($query);
    $stmt->bind_param("ii", $start, $limit);
    $stmt->execute();
    return $stmt->get_result();
}

function pagination($con)
{
    // Number of rows per page
    $limit = 10;

    // Fetch total number of rows
    $totalQuery = "SELECT COUNT(*) as total FROM items";
    $totalResult = mysqli_fetch_assoc(mysqli_query($con, $totalQuery));
    $total = $totalResult['total'];

    // Calculate total pages
    $totalPages = ceil($total / $limit);

    return [$limit, $totalPages];
}


?>

