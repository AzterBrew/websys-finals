<?php

session_start();

require "../dbcon.php";

//THIS IS FOR CONFIRMING AND INSERTING / UPDAITNG CATEGORY RECORD
if(isset($_POST['cat-confirm-btn'])){
    $isEdit = $_POST['cat-confirm-btn'];
    $catname = $_POST['catname']; // Fetch category name from input

    if($isEdit === "1"){
        // UPDATE
        
        $catid = $_POST['catid'];
        $cat_recstat = $_POST['recstat'];
        $query = "UPDATE categories SET category = ?, record_status = ? WHERE cat_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sss", $catname,$cat_recstat, $catid);

        if ($stmt->execute()) {
            header("Location: ../view_category.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else if($isEdit === "0") {
        $catid = TableRowCount("categories", $con) + 1;
        $admin_id = $_SESSION['uid'];

        $query = "INSERT INTO categories (cat_id, category, admin_creator, date_created, record_status) 
                  VALUES (?, ?, ?, NOW(), 'Active')";
        $stmt = $con->prepare($query);
        $stmt->bind_param("isi", $catid, $catname, $admin_id);

        if ($stmt->execute()) {
            header("Location: ../view_category.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Invalid action.";
    }

} else if (isset($_POST['cat-cancel-btn'])){
    header("Location: ../view_category.php");

}


//THIS IS FOR CONFIRMING AND INSERTING / UPDAITNG ITEM RECORD


else if(isset($_POST['item-confirm-btn'])){   //FOR ITEM PROCESSING
    $isEdit = $_POST['item-confirm-btn'];
    $item_name = $_POST['item_name'];
    $item_desc = htmlspecialchars($_POST['item_desc']);
    $item_stock = $_POST['item_stock'];
    $supplier_id = $_POST['supplier_id'];
    $cat_id = $_POST['cat_id']; 
    
    
    if($isEdit === "1"){
        $item_id = $_POST['item_id'];
        $item_recstat = $_POST['recstat'];
        $init_img = $_POST['init_img'];


        if (!empty($_FILES['item_img']['name'])) {
            // New image uploaded
            $item_img = $_FILES['item_img']['name'];
            $path = "record_images/item_images/";
            $item_img_ext = pathinfo($item_img, PATHINFO_EXTENSION);
            $imgfile_name = $item_id . "_" . time() . '.' . $item_img_ext;
            move_uploaded_file($_FILES['item_img']['tmp_name'], $path . $imgfile_name);
        } else {
            // No new image uploaded, retain the existing one
            $imgfile_name = $init_img;

            $query = "SELECT item_img FROM items WHERE item_id = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("i", $item_id);
            if($stmt->execute()){
                $imgres = $stmt->get_result();
                $qrow = $imgres->fetch_assoc(); // Adjusted fetch method
                $imgfile_name = $qrow['item_img'];
            }
        }
        

        $query = "UPDATE items SET item_name = ?, item_desc=?, stock=?, supplier_id = ?, cat_id=?, item_img=?, record_status = ? WHERE item_id = ?";
        // 
        $stmt = $con->prepare($query);
        $stmt->bind_param("ssiiissi", $item_name, $item_desc, $item_stock, $supplier_id, $cat_id, $imgfile_name, $item_recstat, $item_id);

        if ($stmt->execute()) {
            header("Location: ../view_product.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

    } else if($isEdit === "0") {
        $item_id = TableRowCount("items",$con)+1;
        $admin_id = $_SESSION['uid'];

        $item_img = $_FILES['item_img']['name'];
            $path = "record_images/item_images/";
            $item_img_ext = pathinfo($item_img,PATHINFO_EXTENSION);
            $imgfile_name = $item_id."_".time(). '.' . $item_img_ext;
            move_uploaded_file($_FILES['item_img']['tmp_name'], $path . $imgfile_name);
            echo $imgfile_name;

        $query = "INSERT INTO items(item_id, item_name, item_desc, stock, supplier_id, cat_id, item_img, admin_creator, date_created, record_status)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";

        $stmt = $con->prepare($query);
        $date_created = date("Y-m-d H:i:s"); 
        $record_status = 'Active'; 
        $stmt->bind_param("issiiisiss", $item_id, $item_name, $item_desc, $item_stock, $supplier_id, $cat_id, $imgfile_name, $admin_id, $date_created, $record_status);

        if ($stmt->execute()) {
            header("Location: ../view_product.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }


    } else {
        echo "Invalid action.";
    } 

} else if (isset($_POST['item-cancel-btn'])){
    header("Location: ../view_product.php");
}













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