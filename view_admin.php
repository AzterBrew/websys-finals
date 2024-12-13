<?php
include 'includes/header.php';
include 'middleware.php';
require "dbcon.php";

if(isset($_SESSION['isPriv'])){


?>

<!-- CONTENT -->
 
<div class="logo-bg-2"></div>
<div class="admin-container">
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
            <h2 style="font-family: 'Inter', sans-serif; font-size: 40px; font-weight: bold;">
                Administrators
            </h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Contact Number</th>
                            <th>Account Created</th>
                            <th>User Information Access</th>
                            <th>Account Status</th>
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
                            $categoryrecords = RetrieveAll("administrators", $con, $start, $limit);
                            if (mysqli_num_rows($categoryrecords) > 0) {
                                foreach ($categoryrecords as $item) :
                        ?>
                                    <tr>
                                        <td><?=$item['admin_id']?> </td>
                                        <td><?=$item['admin_firstname']?> </td>
                                        <td><?=$item['admin_surname']?> </td>
                                        <td><?=$item['admin_email']?> </td>
                                        <td><?=$item['admin_contact']?> </td>
                                        <td><?=$item['admin_created']?> </td>
                                        <td><?=$item['admin_priv']?> </td>
                                        <td><?=$item['admin_status']?> </td>

                                        <td>
                                            <!-- <a href="mod_category.php" class="btn">Edit Record</a> -->
                                             <div class="col-md-15 ms-auto me-auto" style="text-align:center; width:7em">
                                                <form action="mod_admin.php?adidlabel=<?=$item['admin_id']?>" method="post">
                                                    <button type="submit" name="ad-edit-btn">Edit</button>
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
                            <form action="mod_admin.php?adidlabel=0" method="post">
                                <button type="submit" name="ad-add-btn">Add New Administrator Account</button>

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

} else {
    header("Location: home.php?error=You are not authorized to access that page");
}


function RetrieveAll($table, $con, $start, $limit)
{
    $query = "SELECT * FROM administrators WHERE admin_status = 'Active'
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
    $totalQuery = "SELECT COUNT(*) as total FROM administrators";
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


