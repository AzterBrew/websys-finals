<?php
include 'includes/header.php';
include 'middleware.php';
include 'dbcon.php';


if(isset($_POST['sup-edit-btn'])){ //IF EDITING RECORD
    if (isset($_GET['supidlabel'])) {
        $sup_id = $_GET['supidlabel'];

        $getnamequery = "SELECT * FROM supplier WHERE supplier_id = ?";
        $stmt = $con->prepare($getnamequery);
        $stmt->bind_param("s",$sup_id);
        if ($stmt->execute()) {
            $results = $stmt->get_result(); // Always return the result object        
            $item_row = mysqli_fetch_assoc($results);            
            $sup_name = $item_row['supplier_name'];
            $sup_location = $item_row['supplier_location'];
            $sup_contact = $item_row['supplier_contact'];
            $sup_email = $item_row['supplier_email'];
            $sup_stat = $item_row['record_status'];

        } else {
            echo "Error: " . $stmt->error;
        }
        $isEdit = True;

    }                                     
} else if (isset($_POST['sup-add-btn'])){ //IF NEW RECORD
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
                        Modify Item
                    </h2>
                </div>
                <div class="card-body">
                    <form action="back-end/back_proc.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
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
                                            Supplier Name
                                        </label>
                                        <input type="text" name="sup_name" placeholder="Enter Supplier Name" class="form-control" required>                                          
                                        <br>                                      
                                        <label for="">
                                            Supplier Location
                                        </label>
                                        <input type="text" name="sup_location" placeholder="Enter Supplier Location" class="form-control" required>                                          
                                        <br>  
                                        <label for="">
                                            Supplier Contact
                                        </label>
                                        <input type="tel" name="sup_contact" placeholder="Enter their  Contact Number" class="form-control" required>                                          
                                        <br>  
                                        <label for="">
                                            Supplier Email
                                        </label>
                                        <input type="email" name="sup_email" placeholder="Enter Supplier Email" class="form-control" required>                                          
                                        <br>                                    
                                        <br>

                                        <?php
                                    }
                                ?>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="cat-label">
                                    Supplier ID : <?=$sup_id?>
                                </label>        
                                <br>
                                <br>
                                <?php 
                                if($isEdit){?> 
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
                                <?php
                                }
                                ?>

                                

                            </div>
                            <div>
                                <br>
                                <button type="submit" value="<?= $isEdit ? '1' : '0'; ?>" name="sup-confirm-btn">Confirm</button>
                                <button type="submit" name="sup-cancel-btn" formnovalidate>Cancel</button>
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