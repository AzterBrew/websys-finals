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
                Supplier
            </h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Supplier Name</th>
                            <th>Products</th>
                            <th>Supplier Location</th>
                            <th>Contact Number</th>
                            <th>Email</th>
                            <th>Date Created</th>
                            <th>Creator Admin</th>
                            <th>Record Status</th>
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
                            $categoryrecords = RetrieveAll("categories", $con, $start, $limit);
                       

                            if (mysqli_num_rows($categoryrecords) > 0) {
                                foreach ($categoryrecords as $item) :
                        ?>
                                    <tr>
                                        <td><?=$item['supplier_id']?> </td>
                                        <td><?=$item['supplier_name']?> </td>
                                        <td>
                                            <ul>
<?php
                                        $query = "SELECT * FROM items WHERE supplier_id = ?";
                                        $stmt = $con->prepare($query);
                                        $stmt->bind_param("i",$item['supplier_id']);
                                        $stmt->execute();
                                        $result = $stmt->get_result();
                                        if ($result->num_rows > 0) {
                                            // $row = $result->fetch_assoc();
                                            // // foreach($row as $prod){
                                            // //     $product = $row['item_name'];
                                            // //     echo $product . '<br>';
                                            // // }
                                            // $product = $row['item_name'];
                                            // echo $product;
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<li>' .($row['item_name']) . '</li>';
                                            }
                                        } 
     ?>                                   
                                            </ul>
                                        </td>
                                        <td><?=$item['supplier_location']?> </td>
                                        <td><?=$item['supplier_contact']?> </td>
                                        <td><?=$item['supplier_email']?> </td>
                                        <td><?=$item['date_created']?> </td>
                                        <td><?=$item['admin_creator']?> </td>
                                        <td><?=$item['record_status']?> </td>
                                        <td>
                                            <!-- <a href="mod_category.php" class="btn">Edit Record</a> -->
                                             <div class="col-md-9 ms-auto me-auto" style="text-align:center">
                                                <form action="mod_supplier.php?supidlabel=<?=$item['supplier_id']?>" method="post">
                                                    <button type="submit" name="sup-edit-btn">Edit Records</button>
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
                            <form action="mod_supplier.php?supidlabel=0" method="post">
                                <button type="submit" name="sup-add-btn">Add New Supplier</button>

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
                s.supplier_id, 
                s.supplier_name, 
                s.supplier_location, 
                s.supplier_contact, 
                s.supplier_email, 
                s.date_created, 
                CONCAT('admin', s.admin_creator, ' : ', a.admin_firstname) AS admin_creator, 
                s.record_status 
              FROM supplier s 
              LEFT JOIN administrators a ON s.admin_creator = a.admin_id  
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
    $totalQuery = "SELECT COUNT(*) as total FROM supplier";
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