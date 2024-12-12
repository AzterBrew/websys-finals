<?php

session_start();

require "../vscode/dbcon.php";

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
            header("Location: view_category.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else if($isEdit === "0") {
        $catid = TableRowCount("categories", $con) + 1;
        $admin_id = $_SESSION['admin_id'];

        $query = "INSERT INTO categories (cat_id, category_name, admin_creator, date_created, record_status) 
                  VALUES (?, ?, ?, NOW(), 'Active')";
        $stmt = $con->prepare($query);
        $stmt->bind_param("isi", $catid, $catname, $admin_id);

        if ($stmt->execute()) {
            header("Location: view_category.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "Invalid action.";
    }

} else if (isset($_POST['cat-cancel-btn'])){
    header("Location: view_category.php");

}
