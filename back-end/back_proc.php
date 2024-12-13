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
            $path = "../record_images/item_images/";
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
            $path = "../record_images/item_images/";
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





//THIS IS FOR CONFIRMING AND INSERTING / UPDAITNG SUPPLIER RECORD


else if(isset($_POST['sup-confirm-btn'])){   //FOR ITEM PROCESSING
    $isEdit = $_POST['sup-confirm-btn'];
    $sup_name = $_POST['sup_name'];
    $sup_location = $_POST['sup_location'];
    $sup_contact = $_POST['sup_contact'];
    $sup_email = $_POST['sup_email'];
    
    
    if($isEdit === "1"){
        $sup_id = $_POST['sup_id'];
        $sup_recstat = $_POST['recstat'];

        $query = "UPDATE supplier SET supplier_name = ?, supplier_location=?, supplier_contact = ?, supplier_email = ?, record_status = ? WHERE supplier_id = ?";
        // 
        $stmt = $con->prepare($query);
        $stmt->bind_param("sssssi", $sup_name, $sup_location, $sup_contact, $sup_email, $sup_recstat, $sup_id);

        if ($stmt->execute()) {
            // echo $sup_recstat ;
            header("Location: ../view_supplier.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

    } else if($isEdit === "0") {
        $sup_id = TableRowCount("supplier",$con)+1;
        $admin_id = $_SESSION['uid'];

        $query = "INSERT INTO supplier(supplier_id, supplier_name, supplier_location, supplier_contact, supplier_email, admin_creator, date_created, record_status)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?);";

        $stmt = $con->prepare($query);
        $date_created = date("Y-m-d H:i:s"); 
        $record_status = 'Active'; 
        $stmt->bind_param("issssiss", $sup_id, $sup_name, $sup_location, $sup_contact, $sup_email, $admin_id, $date_created, $record_status);

        if ($stmt->execute()) {
            header("Location: ../view_supplier.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }


    } else {
        echo "Invalid action.";
    } 

} else if (isset($_POST['sup-cancel-btn'])){
    header("Location: ../view_supplier.php");
}


//THIS IS FOR CONFIRMING AND INSERTING / UPDAITNG ITEM RECORD


else if(isset($_POST['ord-confirm-btn'])){   //FOR ITEM PROCESSING
    $isEdit = $_POST['ord-confirm-btn'];
    $item_id = $_POST['item_id']; 
    // $item_name = $_POST['item_name'];
    // $item_desc = htmlspecialchars($_POST['item_desc']);
    // $item_stock = $_POST['item_stock'];
    
    echo $item_id;
    
    if($isEdit === "1"){
        $query = "SELECT * FROM items WHERE item_id = " . $item_id ; // Use LIMIT with placeholders for pagination

        $stmt = $con->prepare($query);
        $stmt->execute();
        $results = $stmt->get_result();
        while ($item = $results->fetch_assoc()) {
            $item_stock = $item['stock'];
        }

        $order_id = $_POST['order_id'];
        $order_status = $_POST['order_status'];
        $q_initreceived = $_POST['q_received'];
        $quantity_received = $_POST['q_delivered'];
        $quantity_received += $q_initreceived;
        echo $q_initreceived; 

        $query = "UPDATE orders SET quantity_received = ?, last_update_date = ?, order_status = ? WHERE order_id = ?";
        // 
        $stmt = $con->prepare($query);
        $date_created = date("Y-m-d H:i:s"); 
        $stmt->bind_param("issi", $quantity_received,$date_created, $order_status, $order_id);
        $stmt->execute();
        //UPDATE ITEMS TABLE
        $query = "UPDATE items SET stock = ? WHERE item_id = ?";
        // 
        $stock = $item_stock + $quantity_received;
        echo $stock;

        $stmt = $con->prepare($query);
        $stmt->bind_param("ii", $stock, $item_id);
        $stmt->execute();

        if ($stmt->execute()) {
            header("Location: ../view_order.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

    } else if($isEdit === "0") {
        $supplier_id = $_POST['supplier_id'];
        $quantity_ordered = $_POST['quantity'];
        $order_id = TableRowCount("orders",$con)+1;
        $admin_id = $_SESSION['uid'];

        $query = "INSERT INTO orders(order_id, item_id, quantity_ordered, supplier_id, order_status, admin_order, order_date, record_status)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?);";

        $stmt = $con->prepare($query);
        $date_created = date("Y-m-d H:i:s"); 
        $record_status = 'Active'; 
        $order_status = 'Pending'; //pending, incomplete, complete 
        $stmt->bind_param("iiiisiss", $order_id, $item_id,$quantity_ordered, $supplier_id, $order_status, $admin_id, $date_created, $record_status);

        if ($stmt->execute()) {
            // echo $order_id . $quantity_ordered . $supplier_id . $order_status . $admin_id . $date_created . $record_status ;
            header("Location: ../view_order.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }


    } else {
        echo "Invalid action.";
    } 

} else if (isset($_POST['ord-cancel-btn'])){
    header("Location: ../view_order.php");

} else if (isset($_GET['delete-order'])){
    $order_id = $_GET['delete-order'];

    $query = "UPDATE orders SET record_status = ? WHERE order_id = ?";
    // 
    $stmt = $con->prepare($query);
    $date_created = date("Y-m-d H:i:s"); 
    $stmt->bind_param("issi", $quantity_received,$date_created, $order_status, $order_id);

    if ($stmt->execute()) {
        header("Location: ../view_order.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}




//THIS IS FOR CONFIRMING AND INSERTING / UPDAITNG ITEM RECORD


else if(isset($_POST['ad-confirm-btn'])){   //FOR ITEM PROCESSING
    $isEdit = $_POST['ad-confirm-btn'];
    // $item_name = $_POST['item_name'];
    // $item_desc = htmlspecialchars($_POST['item_desc']);
    // $item_stock = $_POST['item_stock'];
    $admin_firstname = $_POST['admin_firstname'];
    $admin_surname = $_POST['admin_surname'];
    $admin_contact = $_POST['admin_contact'];
    $admin_email = $_POST['admin_email'];
    $password = $_POST['password'];
    $admin_priv = $_POST['ad_priv'];
    
    
    if($isEdit === "1"){
        $admin_id = $_POST['admin_id'];
        $admin_status = $_POST['recstat'];

        if($password == ""){
            $password = $_POST['oldpass'];
        } 
        // else {
        //     // $password = password_hash($password, PASSWORD_DEFAULT);
        // }

        $query = "UPDATE administrators SET admin_firstname = ?, admin_surname = ?, admin_contact = ?, admin_email=?, admin_pass=?, admin_priv= ?, admin_status =? WHERE admin_id = ?";
        // 
        $stmt = $con->prepare($query);
        // $date_created = date("Y-m-d H:i:s"); 
        $stmt->bind_param("sssssssi", $admin_firstname,$admin_surname, $admin_contact, $admin_email, $password, $admin_priv, $admin_status, $admin_id);
        if ($stmt->execute()) {
            header("Location: ../view_admin.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }

    } else if($isEdit === "0") {
        // $supplier_id = $_POST['supplier_id'];
        // $item_id = $_POST['item_id']; 
        // $quantity_ordered = $_POST['quantity'];
        $admin_id = TableRowCount("administrators",$con)+1;

        $query = "INSERT INTO administrators(admin_id, admin_firstname, admin_surname, admin_email, admin_contact, admin_pass, admin_created, admin_status, admin_priv) 
                VALUES (?, ?, ?, ?, ?, ?, NOW(), 'Active', ?);";

        $stmt = $con->prepare($query);
        $date_created = date("Y-m-d H:i:s"); 
        $record_status = 'Active'; 
        $stmt->bind_param("issssss", $admin_id, $admin_firstname, $admin_surname, $admin_email, $admin_contact, $password, $admin_priv);

        if ($stmt->execute()) {
            // echo $order_id . $quantity_ordered . $supplier_id . $order_status . $admin_id . $date_created . $record_status ;
            header("Location: ../view_admin.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }


    } else {
        echo "Invalid action.";
    } 

} else if (isset($_POST['ad-cancel-btn'])){
    header("Location: ../view_admin.php");

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