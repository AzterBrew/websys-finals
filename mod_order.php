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
              WHERE order_id = ?";
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
            $rec_stat = $item_row['record_status'];

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
<div class="admin-container" style="max-width: 50%">

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
                        <div class="row supplier-order">
                            <?php if($isEdit){?> 
                                    <?php }?>
                                <input type="hidden" name="order_id" value="<?= $order_id; ?>"> <!-- Pass the category ID -->
                                <?php
                                    // IF EDIT RECORD
                                    if($isEdit){?> 
                                    <!-- <div class="col-md-6"> -->
                                    <label for="" class="cat-label">
                                        Order ID : <?=$order_id?>
                                    </label>        
                                    <br>
                                    <br>
                                        <label for="">
                                            Product
                                        </label>
                                        <input type="text" disabled value="<?= $order_item ?> "name="olditemname" placeholder="Enter Category Name" class="form-control" required>
                                        <br> 
                                        <br> 
                                        <div  class="supplier-order">
                                            <div>
                                                <label for="">
                                                Quantity Ordered
                                                </label>
                                            </div>   
                                            <div>
                                                <label for="">
                                                Quantity Received
                                                </label>
                                            </div>  
                                        </div>    
                                        <div class="supplier-order">
                                            <div>
                                                <input type="number" disabled value="<?=$q_ordered?>" name="q_ordered" placeholder="Quantity Ordered" class="form-control" required>
                                            </div>
                                            <div>
                                                <input type="number" disabled value="<?=$q_received?>" name="q_received" placeholder="Quantity Received" class="form-control" required>
                                            </div>
                                        </div>                                    
                                        <br>                                      
                                        <br> 
                                        <br>                                      
                                        <label for="">
                                            Supplier Name
                                        </label>
                                        <input type="text" disabled value="<?= $supplier_name ?>" name="sup_name" placeholder="Enter Item Name" class="form-control" required>                                          
                                        <br> 
                                        <br> 
                                        <br> 
                                        <hr>                                     
                                        <label for="">
                                            Quantity Delivered
                                        </label>
                                        <br>
                                        <div class="quantity-container">
                                                <button type="button" class="quantity-btn" id="minus">-</button>
                                                <input type="number" id="quantity" name="q_delivered" value="1" min="0" max="<?=$q_ordered-$q_received?>" step="1" class="form-control s  upplier-order" required>
                                                <button type="button" class="quantity-btn" id="plus">+</button>
                                            </div>                                     
                                        <br>  
                                        <br>  
                                        <br>
                                    <label for="" style="margin-top: 5%">
                                        Order Status
                                    </label>
                                    <br>
                                    <select class="admin-sel" name="order_status" id="recstat">
                                        <?php
                                        echo $q_received;
                                        if($order_status == "Pending"){
                                            ?>
                                                <option value="Pending">Pending</option>
                                                <option value="Incomplete">Incomplete</option>
                                                <option value="Complete">Complete</option>
                                            <?php
                                        } else if($order_status == "Incomplete") {
                                            ?>
                                                <option value="Incomplete">Incomplete</option>
                                                <option value="Complete">Complete</option>
                                                <option value="Pending">Pending</option>
                                            <?php
                                        } else if($order_status == "Complete") {
                                        ?>
                                                <option value="Complete">Complete</option>
                                                <option value="Pending">Pending</option>
                                                <option value="Incomplete">Incomplete</option>
                                            <?php
                                        } ?>
                                    </select>

                                                            
                                        <br>
                                        <br>

                                        <?php
                                    // IF NEW RECORD                                
                                    }else {?>
                                    <div>
                                        <label for="" class="supplier-order">
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
                                                <label for="" id="quantity-label">Order Quantity  </label>
                                            </div>
                                        </div>
                                        <hr>
                                        <!-- THIS IS FOR LOOP -->
                                        <div class="supplier-order" style="padding-left: 40px">
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
                                        </div>
                                        <?php
                                    }
                                ?>
                            </div>
                            
                                <?php 
                                if($isEdit){?> 
                                    

                                <?php
                                }
                                ?>                                

                            
                                <br>
                                <?php 
                                    if($isEdit){ ?>
                                    <div>
                                        <button type="submit" value="<?= $isEdit ? '1' : '0'; ?>" name="ord-confirm-btn">Confirm Order</button>
                                        <button type="submit" name="ord-cancel-btn" formnovalidate>Cancel</button>
                                    </div>
                                    <?php } else {
                                        ?>
                                    <div style="margin-left:auto; margin-right:auto">
                                        <button style="align-items: center" type="submit" value="<?= $isEdit ? '1' : '0'; ?>" name="ord-confirm-btn">Confirm Order</button>
                                        <button type="submit" name="ord-cancel-btn" formnovalidate>Cancel</button>
                                    </div>
                                    <?php
                                    }
                                ?>
                                </form>                
                                
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // JavaScript for handling the quantity increment and decrement
    document.getElementById('plus').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantity');
        let value = parseInt(quantityInput.value);
        let maxaddition = <?=$q_ordered - $q_received?>;
        if(value < maxaddition){
            quantityInput.value = value + 1;
        }
    });

    document.getElementById('minus').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantity');
        let value = parseInt(quantityInput.value);
        if (value > 0) {
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