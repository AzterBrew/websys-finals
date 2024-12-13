<?php
include 'includes/header.php';
include 'middleware.php';
include 'dbcon.php';


if(isset($_POST['ord-edit-btn'])){ //IF EDITING RECORD
    if (isset($_GET['ordidlabel'])) {
        $order_id = $_GET['ordidlabel'];

        $getnamequery = "SELECT * FROM orders o 
              LEFT JOIN items i ON o.item_id=i.item_id
              LEFT JOIN supplier s ON o.supplier_id=s.supplier_id
              LEFT JOIN administrators a ON o.admin_order = a.admin_id    
              WHERE AND  order_id = ?";
        $stmt = $con->prepare($getnamequery);
        $stmt->bind_param("i",$order_id);
        if ($stmt->execute()) {
            $results = $stmt->get_result(); // Always return the result object        
            $item_row = mysqli_fetch_assoc($results);            
            $order_item = $item_row['item_name'];
            $q_ordered = $item_row['quantity_ordered'];
            $q_received = $item_row['quantity_received'];
            $supplier_name = $item_row['supplier_name'];
            $supplier_email = $item_row['supplier_email'];
            $order_status = $item_row['order_status'];

        } else {
            echo "Error: " . $stmt->error;
            echo "Order might have been deleted";
        }
        $isEdit = True;

    }                                     
} else if (isset($_POST['ord-add-btn'])){ //IF NEW RECORD
    $sup_id = TableRowCount("supplier",$con)+1;
    $isEdit = False;

}

?>

<!-- CONTENTS -->
<div class="logo-bg-2"></div>
<div class="admin-container">

    <div class="row admin-mod-text">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="font-family: 'Inter', sans-serif; font-size: 40px; font-weight: bold;">
                        Order Product
                    </h2>
                </div>
                <div class="card-body">
                    <form action="back-end/back_proc.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <?php if($isEdit){?> 
                                <div class="col-md-6">
                                    <?php }?>
                                <input type="hidden" name="sup_id" value="<?= $sup_id; ?>"> <!-- Pass the category ID -->
                                <?php
                                    // IF EDIT RECORD
                                    if($isEdit){?> 

                                        <label for="">
                                            Current Supplier Name
                                        </label>
                                        <input type="text" disabled value="<?= $sup_name ?> "name="olditemname" placeholder="Enter Category Name" class="form-control" required>
                                        <br>                                      
                                        <label for="">
                                            Supplier Name
                                        </label>
                                        <input type="text" value="<?= $sup_name ?>" name="sup_name" placeholder="Enter Item Name" class="form-control" required>                                          
                                        <br>                                      
                                        <label for="">
                                            Supplier Location
                                        </label>
                                        <input type="text" value="<?= $sup_location ?>" name="sup_location" placeholder="Enter Item Name" class="form-control" required>                                          
                                        <br>  
                                        <label for="">
                                            Supplier Contact
                                        </label>
                                        <input type="tel" value="<?= $sup_contact ?>" name="sup_contact" placeholder="Enter Item Name" class="form-control" required>                                          
                                        <br>  
                                        <label for="">
                                            Supplier Email
                                        </label>
                                        <input type="email" value="<?= $sup_email ?>" name="sup_email" placeholder="Enter Item Name" class="form-control" required>                                          
                                        <br>                                    
                                        <br>

                                        <?php
                                    // IF NEW RECORD                                
                                    }else {?>
                                        <label for="">
                                            Product Name
                                        </label>
                                        <br>
                                        <select class="admin-sel" name="item_id" id="order-sel">

                                        <?php
                                            $catquery = "SELECT * FROM items WHERE record_status = 'Active'";
                                            $result = mysqli_query($con, $catquery);

                                            // Check if there are any categories
                                            if (mysqli_num_rows($result) > 0) {
                                                $count = 0;
                                                // Loop through the records and create options
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    if($row['record_status']=="Active"){
                                                        echo '<option value="' . $row['item_id'] . '">' . htmlspecialchars($row['item_name']) . '</option>';
                                                    $count++;
                                                    }
                                                }
                                                if($count=== 0){
                                                    echo '<option value="0">No items available</option>';                                                
                                                }
                                            } else {
                                                // If no categories exist, show a message
                                                echo '<option value="0">No items available</option>';
                                            }                                    
                                        ?>
                                        
                                        </select>
                                        <br>
                                        <br>
                                        <div class="supplier-order">
                                            <div >
                                        <br>
                                                <label for="">Supplier</label>
                                            </div>
                                            <div>
                                                <label for="" id="quantity-label">Order Quantity : </label>
                                            </div>
                                        </div>
                                        <hr>
                                        <!-- THIS IS FOR LOOP -->
                                        <div class="supplier-order">
                                            <div >
                                        <select class="admin-sel" name="supplier_id" id="">

                                        <?php
                                            $catquery = "SELECT * FROM supplier";
                                            $result = mysqli_query($con, $catquery);
                                            
                                            // Check if there are any categories
                                            if (mysqli_num_rows($result) > 0) {
                                                $count = 0;
                                                // Loop through the records and create options
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    if($row['record_status']=="Active"){
                                                        echo '<option value="' . $row['supplier_id'] . '">' . htmlspecialchars($row['supplier_name']) . '</option>';
                                                    $count++;
                                                    }
                                                }
                                                if($count=== 0){
                                                    echo '<option value="0">No Supplier Record Available</option>';                                                
                                                }
                                            } else {
                                                // If no categories exist, show a message
                                                echo '<option value="0">No Supplier Record Available</option>';
                                            }                                    
                                        ?>
                                        
                                        </select>
                                        <br>
                                            </div>
                                            <div class="quantity-container">
                                                <button type="button" class="quantity-btn" id="minus">-</button>
                                                <input type="number" id="quantity" name="quantity" value="1" min="1" step="1" class="form-control supplier-order" required>
                                                <button type="button" class="quantity-btn" id="plus">+</button>
                                            </div>
                                        </div>
                                        <br>
                                        <br>

                                        <?php
                                    }
                                ?>
                            </div>
                            
                                <?php 
                                if($isEdit){?> 
                                    <div class="col-md-6">
                                    <label for="" class="cat-label">
                                        Supplier ID : <?=$sup_id?>
                                    </label>        
                                    <br>
                                    <br>
                                    <label for="">
                                        Supplier Status
                                    </label>
                                    <br>
                                    <select class="admin-sel" name="recstat" id="recstat">
                                        <?php
                                        if($sup_stat == "Active"){
                                            ?>
                                                <option value="Active">Active</option>
                                                <option value="Removed">Remove</option>
                                            <?php
                                        } else {
                                            ?>
                                                <option value="Removed">Remove</option>
                                                <option value="Active">Active</option>
                                            <?php
                                        }
                                        ?>
                                    
                                    </select>
                                </div>

                                <?php
                                }
                                ?>                                

                            
                                <br>
                                <?php 
                                    if($isEdit){ ?>
                                    <div>
                                        <button type="submit" value="<?= $isEdit ? '1' : '0'; ?>" name="sup-confirm-btn">Confirm Order</button>
                                        <button type="submit" name="sup-cancel-btn" formnovalidate>Cancel</button>
                                    </div>
                                    <?php } else {
                                        ?>
                                    <div style="margin-left:auto; margin-right:auto">
                                        <button style="align-items: center" type="submit" value="<?= $isEdit ? '1' : '0'; ?>" name="sup-confirm-btn">Confirm Order</button>
                                        <button type="submit" name="sup-cancel-btn" formnovalidate>Cancel</button>
                                    </div>
                                    <?php
                                    }
                                ?>
                                
                            </div>
                        </div>
                    </form>                
                </div>
            </div>
        </div>
    </div>

    <script>
    // JavaScript for handling the quantity increment and decrement
    document.getElementById('plus').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantity');
        let value = parseInt(quantityInput.value);
        quantityInput.value = value + 1;
    });

    document.getElementById('minus').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantity');
        let value = parseInt(quantityInput.value);
        if (value > 1) {
            quantityInput.value = value - 1;
        }
    });

</script>





<!-- END OF CONTENTS -->
</div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<footer>

<?php
include 'includes/footer.php';

function TableRowCount(string $table, $con)
{
    $query = "SELECT COUNT(*) AS total FROM " . $table;
    $count = 0;

    if ($results = mysqli_query($con, $query)) {
        $row = mysqli_fetch_assoc($results);
        $count = $row['total'];
    }

    return $count;
}


?>