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
                Category
            </h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Category Name</th>
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
                            // $categoryrecords = RetrieveAll("categories", $con);
                            // $totalPages = pagination($con);

                            // function RetrieveAll($table, $con)
                            // {
                            //     $query = 'SELECT cat.cat_id, cat.category_name,cat.date_created, CONCAT("admin",cat.admin_creator," : ",us.firstname) AS admin_creator,cat.record_status FROM categories cat LEFT JOIN admin a ON cat.admin_creator = a.admin_id LEFT JOIN user_information us ON a.userinfo_id = us.userinfo_id;';
                            //     $stmt = $con->prepare($query);
                            //     $stmt->execute();
                            //     return $stmt->get_result(); // Always return the result object
                            // }

                            if (mysqli_num_rows($categoryrecords) > 0) {
                                foreach ($categoryrecords as $item) :
                        ?>
                                    <tr>
                                        <td><?=$item['cat_id']?> </td>
                                        <td><?=$item['category']?> </td>
                                        <td><?=$item['date_created']?> </td>
                                        <td><?=$item['admin_creator']?> </td>
                                        <td><?=$item['record_status']?> </td>
                                        <td>
                                            <!-- <a href="mod_category.php" class="btn">Edit Record</a> -->
                                             <div class="col-md-9 ms-auto me-auto" style="text-align:center">
                                                <form action="mod_category.php?catidlabel=<?=$item['cat_id']?>" method="post">
                                                    <button type="submit" name="cat-edit-btn">Edit Records</button>
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
                        <!-- <nav>
                            <ul class="pagination">
                                <?php for ($i = 1; $i <= $totalPages; $i++) {?>
                                    <li class="page-item <?=($page === $i) ? 'active' : ''?>">
                                        <a class="page-link" href="?page=<?=$i;?>"><?=$i;?></a>
                                    </li>
                                <?php }?>
                            </ul>
                        </nav> -->

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
                            <form action="mod_category.php?catidlabel=0" method="post">
                                <button type="submit" name="cat-add-btn">Add New Category</button>

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
                cat.cat_id, 
                cat.category, 
                cat.date_created, 
                CONCAT('admin', cat.admin_creator, ' : ', a.admin_firstname) AS admin_creator, 
                cat.record_status 
              FROM $table cat 
              LEFT JOIN administrators a ON cat.admin_creator = a.admin_id 
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
    $totalQuery = "SELECT COUNT(*) as total FROM categories";
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