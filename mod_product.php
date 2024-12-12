<?php
include 'includes/header.php';
include 'middleware.php';
include 'dbcon.php';


if(isset($_POST['item-edit-btn'])){ //IF EDITING RECORD
    if (isset($_GET['itemidlabel'])) {
        $item_id = $_GET['itemidlabel'];

        $getnamequery = "SELECT * FROM items WHERE item_id = ?";
        $stmt = $con->prepare($getnamequery);
        $stmt->bind_param("s",$item_id);
        if ($stmt->execute()) {
            $results = $stmt->get_result(); // Always return the result object        
            $item_row = mysqli_fetch_assoc($results);            
            $item_name = $item_row['item_name'];
            $item_desc = htmlspecialchars($item_row['item_desc']);
            $supplier_id = $item_row['supplier_id'];
            $cat_id = $item_row['cat_id'];
            $item_stock = $item_row['stock'];
            $item_stat = $item_row['record_status'];
            $item_img = $item_row['item_img'];

        } else {
            echo "Error: " . $stmt->error;
        }
        $isEdit = True;

    }                                     
} else if (isset($_POST['item-add-btn'])){ //IF NEW RECORD
    $item_id = TableRowCount("items",$con)+1;
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
                        Modify Item
                    </h2>
                </div>
                <div class="card-body">
                    <form action="back-end/back_proc.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="item_id" value="<?= $item_id; ?>"> <!-- Pass the category ID -->
                                <?php
                                    // IF EDIT RECORD
                                    if($isEdit){?> 
                                        <input type="hidden" name="init_img"  value="<?=$item_img?>">

                                        <div class="mod-img-preview" align="center">
                                            <img src="record_images/item_images/<?=$item_img?>"  alt="item image">
                                        </div>
                                        <label for="">
                                            Current Item Name
                                        </label>
                                        <input type="text" disabled value="<?= $item_name ?> "name="olditemname" placeholder="Enter Category Name" class="form-control" required>
                                        <br>                                      
                                        <label for="">
                                            Item Name
                                        </label>
                                        <input type="text" value="<?= $item_name ?>" name="item_name" placeholder="Enter Item Name" class="form-control" required>                                          
                                        <br>                                      
                                        <label for="">
                                            Item Description
                                        </label>
                                        <textarea name="item_desc" id="item_desc" placeholder="Enter Item Description" class="form-control" required> <?=htmlspecialchars($item_desc) ?></textarea>
                                        <br>                                      
                                        <label for="">
                                            Item Stock
                                        </label>
                                        <input type="number" value="<?= $item_stock ?>" name="item_stock" placeholder="Enter Stock" class="form-control" required step="1" min="0"> 
                                        <br>
                                        <br>

                                        <label for="">
                                            Category
                                        </label>
                                        <br>
                                        <select class="admin-sel" name="cat_id" id="">

                                        <?php
                                            $catquery = "SELECT * FROM categories";
                                            $result = mysqli_query($con, $catquery);
                                            
                                            // Check if there are any categories
                                            if (mysqli_num_rows($result) > 0) {
                                                $count = 0;
                                                // Loop through the records and create options
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    if($row['record_status']=="Active"){
                                                        echo '<option value="' . $row['cat_id'] . '">' . htmlspecialchars($row['category']) . '</option>';
                                                    $count++;
                                                    }
                                                }
                                                if($count=== 0){
                                                    echo '<option value="0">No categories available</option>';                                                
                                                }
                                            } else {
                                                // If no categories exist, show a message
                                                echo '<option value="0">No categories available</option>';
                                            }                                    
                                        ?>
                                        
                                        </select>
                                        <br>
                                        <br>

                                        <label for="">
                                            Supplier
                                        </label>
                                        <br>
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
                                        
                                        <label for="">
                                            Item Image
                                        </label>
                                        <input type="file" name="item_img" accept=".jpg,.jpeg,.png,.gif" placeholder="Submit Image File" class="form-control"> 
                                        
                                        <?php

                                    // IF NEW RECORD                                
                                    }else {?>
                                        <label for="">
                                            Item Name
                                        </label>
                                        <input type="text" name="item_name" placeholder="Enter Item Name" class="form-control" required>    
                                        <br>                                      
                                        <label for="">
                                            Item Description
                                        </label>
                                        <textarea name="item_desc" id="item_desc" placeholder="Enter Item Description" class="form-control" required></textarea>
                                        <br>                                      
                                        
                                        <label for="">
                                            Item Stock
                                        </label>
                                        <input type="number" name="item_stock" placeholder="Enter Stock" class="form-control" required step="1" min="0"> 
                                        <br>
                                        <br>
                                        <label for="">
                                            Category
                                        </label>
                                        <br>
                                        <select class="admin-sel" name="cat_id" id="">

                                        <?php
                                            $catquery = "SELECT * FROM categories";
                                            $result = mysqli_query($con, $catquery);

                                            // Check if there are any categories
                                            if (mysqli_num_rows($result) > 0) {
                                                $count = 0;
                                                // Loop through the records and create options
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    if($row['record_status']=="Active"){
                                                        echo '<option value="' . $row['cat_id'] . '">' . htmlspecialchars($row['category_name']) . '</option>';
                                                    $count++;
                                                    }
                                                }
                                                if($count=== 0){
                                                    echo '<option value="0">No categories available</option>';                                                
                                                }
                                            } else {
                                                // If no categories exist, show a message
                                                echo '<option value="0">No categories available</option>';
                                            }                                    
                                        ?>
                                        
                                        </select>
                                        <br>
                                        <br>

                                        <br>

                                        <label for="">
                                            Supplier
                                        </label>
                                        <br>
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
                                        
                                        <label for="">
                                            Item Image
                                        </label>
                                        <input type="file" name="item_img" accept=".jpg,.jpeg,.png,.gif" placeholder="Submit Image File" class="form-control" required> 
                                        <br>
                                        <br>

                                        <?php
                                    }
                                ?>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="cat-label">
                                    Item ID : <?=$item_id?>
                                </label>        
                                <br>
                                <br>
                                <?php 
                                if($isEdit){?> 
                                    <label for="">
                                        Item Status
                                    </label>
                                    <br>
                                    <select class="admin-sel" name="recstat" id="recstat">
                                        <?php
                                        if($item_stat == "Active"){
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
                                <?php
                                }
                                ?>

                                

                            </div>
                            <div>
                                <br>
                                <button type="submit" value="<?= $isEdit ? '1' : '0'; ?>" name="item-confirm-btn">Confirm</button>
                                <button type="submit" name="item-cancel-btn" formnovalidate>Cancel</button>
                            </div>
                        </div>
                    </form>                
                </div>
            </div>
        </div>
    </div>







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