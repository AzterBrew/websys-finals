<div class="offcanvas offcanvas-start sidebar-color" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
<div class="sidebar">
<img src="images/Keepy-White.png" alt="Keepy Sidebar Logo" height="auto" width="200px">
</div>
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasExampleLabel">Menu</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="list-group">
                <a href="view_category.php" class="list-group-item list-group-item-action">Categories</a>
                <a href="view_product.php" class="list-group-item list-group-item-action">Products</a>
                <a href="view_supplier.php" class="list-group-item list-group-item-action">Supplier</a>
                <a href="view_order.php" class="list-group-item list-group-item-action">Orders</a>
                <!-- Collapsible Section -->
<?php 

    if(isset($_SESSION['isPriv'])){ ?>
                <a class="list-group-item list-group-item-action" href="view_admin.php">Administrators</a>
        </div>
        <style>
            .collapse {
                text-indent: 20px;
            }
        </style>
    <?php }

?>

                
        </div>
    </div>

    
    <!-- Sidebar JS -->
 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
 
