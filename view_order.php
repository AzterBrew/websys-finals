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
                Orders
            </h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Ordered Item</th>
                            <th>Quantity Ordered</th>
                            <th>Quantity Received</th>
                            <th>Supplier</th>
                            <th>Supplier Email</th>
                            <th>Date Ordered</th>
                            <th>Last Update</th>
                            <th>Creator Admin</th>
                            <th>Order Status</th>
                            <!-- <th>Record Status</th> -->
                            <th style="text-align : center">Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                            <!-- FETCHING DATA -->
                        <?php
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $page = max($page, 1); // Ensure page is at least 1
                            [$limit, $totalPages] = pagination($con);
                            $start = ($page - 1) * $limit;
                            
                            // Fetch records for the current page
                            $categoryrecords = RetrieveAll("orders", $con, $start, $limit);
                            if (mysqli_num_rows($categoryrecords) > 0) {
                                foreach ($categoryrecords as $item) :
                        ?>
                                    <tr>
                                        <td><?=$item['order_id']?> </td>
                                        <td><?=$item['item_name']?> </td>
                                        <td><?=$item['quantity_ordered']?> </td>
                                        <td><?=$item['quantity_received']?> </td>
                                        <td><?=$item['supplier_name']?> </td>
                                        <td><?=$item['supplier_email']?> </td>
                                        <td><?=$item['order_date']?> </td>
<?php
                                        if($item['last_update_date']== "0000-00-00 00:00:00"){
                                            echo '<td> - </td>';
                                        } else {
?>
                                        <td><?=$item['last_update_date']?> </td>

<?php                                   }
                                        ?>

                                        <td><?=$item['admin_creator']?> </td>
                                        <td><?=$item['order_status']?> </td>
                                        <td>
                                            <!-- <a href="mod_category.php" class="btn">Edit Record</a> -->
                                             <div class="col-md-15 ms-auto me-auto" style="text-align:center">
                                                <form action="mod_order.php?ordidlabel=<?=$item['order_id']?>" method="post">
                                                    <button type="submit" name="ord-edit-btn">Update</button>
                                                    <a href="back_proc.php?delete-order=<?=$item['order_id']?>">Delete</a>
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
                            <form action="mod_order.php?ordidlabel=0" method="post">
                                <button type="submit" name="ord-add-btn">Add New Order</button>

                            </form>
                        </div>

                    </div>


                </div>


            </div>

<!-- END OF CONTENTS -->
</div>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </div>

<?php


function RetrieveAll($table, $con, $start, $limit)
{
    $query = "SELECT 
                o.order_id, 
                i.item_name, 
                o.quantity_ordered, 
                o.quantity_received, 
                s.supplier_name,
                s.supplier_email,
                o.order_date, 
                o.last_update_date, 
                CONCAT('admin', o.admin_order, ' : ', a.admin_firstname) AS admin_creator, 
                o.order_status ,
                o.record_status 
              FROM orders o 
              LEFT JOIN items i ON o.item_id=i.item_id
              LEFT JOIN supplier s ON o.supplier_id=s.supplier_id
              LEFT JOIN administrators a ON o.admin_order = a.admin_id    
              WHERE o.record_status = 'Active'
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
    $totalQuery = "SELECT COUNT(*) as total FROM orders";
    $totalResult = mysqli_fetch_assoc(mysqli_query($con, $totalQuery));
    $total = $totalResult['total'];

    // Calculate total pages
    $totalPages = ceil($total / $limit);

    return [$limit, $totalPages];
}
?>

<div class="footer-footer">
    <?php
        include 'includes/footer.php';
    ?>
</div>