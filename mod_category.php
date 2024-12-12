<?php
include 'includes/header.php';
include 'middleware.php';
include 'dbcon.php';


if(isset($_POST['cat-edit-btn'])){ //IF EDITING RECORD
    if (isset($_GET['catidlabel'])) {
        $catid = $_GET['catidlabel'];

        $getnamequery = "SELECT * FROM categories WHERE cat_id = ?";
        $stmt = $con->prepare($getnamequery);
        $stmt->bind_param("s",$catid);
        if ($stmt->execute()) {
            $results = $stmt->get_result(); // Always return the result object        
            $cat_row = mysqli_fetch_assoc($results);            
            $cat_name = $cat_row['category_name'];
            $cat_stat = $cat_row['record_status'];
        } else {
            echo "Error: " . $stmt->error;
        }
        $isEdit = True;

    }                                     
} else if (isset($_POST['cat-add-btn'])){ //IF NEW RECORD
    $catid = TableRowCount("categories",$con)+1;
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
                        Modify Category
                    </h2>
                </div>
                <div class="card-body">
                    <form action="admin_proc.php" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="catid" value="<?= $catid; ?>"> <!-- Pass the category ID -->
                                <?php
                                    
                                    if($isEdit){?> 
                                        <label for="">
                                            Current Category Name
                                        </label>
                                        <input type="text" disabled value="<?= $cat_name ?> "name="oldcatname" placeholder="Enter Category Name" class="form-control" required>
                                        <label for="">
                                            New Category Name
                                        </label>
                                        <input type="text" value="<?= $cat_name ?>" name="catname" placeholder="Enter Category Name" class="form-control" required>
                                        
                                        

                                        <?php
                                    }else {?>
                                        <label for="">
                                            Category Name
                                        </label>
                                        <input type="text"  name="catname" placeholder="Enter Category Name" class="form-control" required>                                
                                        <?php
                                    }
                                ?>
                            </div>
                            <div class="col-md-6">
                                <label for="" class="cat-label">
                                    Category ID : <?=$catid?>
                                </label>        
                                <br>
                                <br>
                                <?php 
                                
                                if($isEdit){?> 
                                    <label for="">
                                        Category Status
                                    </label>
                                    <br>
                                    <select class="admin-sel" name="recstat" id="recstat">
                                        <?php
                                        if($cat_stat == "Active"){
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
                                <button type="submit" value="<?= $isEdit ? '1' : '0'; ?>" name="cat-confirm-btn">Confirm</button>
                                <button type="submit" name="cat-cancel-btn" formnovalidate>Cancel</button>
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