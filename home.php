<?php 

include('includes/header.php'); 
include('dbcon.php'); 

$query = "SELECT * FROM administrators WHERE admin_id = ". $_SESSION['uid'];
$stmt = $con->prepare($query);
// $stmt->bind_param("i", $start, $limit);
$stmt->execute();
$result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $username = $row['admin_firstname'];
            } else {
                echo "No user_credentials record found for userinfo_id: $userinfo_id";
                exit();
            }

function TableRowCount(string $table, $con)
{
    $query = "SELECT COUNT(*) AS total FROM " . $table;
    $count = 0;

    if ($results = mysqli_query($con, $query)) {
        $row = mysqli_fetch_assoc($results);
        $count = $row['total'];
    } else {
        $count = "Nothing to see yet";
    }

    return $count;
}  

function TableRowConditionCount(string $table, $con, $condition, $condition_field)
{
    $query = "SELECT COUNT(*) AS total FROM " . $table . " WHERE ". $condition_field . "= '". $condition. "'";
    $count = 0;

    if ($results = mysqli_query($con, $query)) {
        $row = mysqli_fetch_assoc($results);
        $count = $row['total'];
    } else {
        $count = "Nothing to see yet";
    }

    return $count;
}     


function LeastOrdered($con)
{
    $query = "SELECT * FROM items i WHERE record_status = 'Active' ORDER BY stock  LIMIT 1";
    $count = 0;

    if ($results = mysqli_query($con, $query)) {
        $row = mysqli_fetch_assoc($results);
        $item_name = $row['item_name'];
        $item_stock = $row['stock'];
        $sum = $item_name . ' : ' . strval($item_stock);
    } else {
        $sum = "No products yet";
    }
    return $sum;

}   

?>


        <div class="page-container">
            <div class="hello-username">
                <h1>Welcome back to your Dashboard, <?=$username?>!</h1>
            
                <div class="dashboard-container">
        <!-- Overview Panel -->
        <div class="box overview-panel total-products" style="max-width:100%; display: inline-block">
            
            <div style="display: inline-flex; width: 100%; max-width:fit-content ; padding: 3px 5px; align-items: top">
                
                <div>
                    <h3>Total Products</h3>
                    <p><?=TableRowCount("items",$con);?></p>
                </div>
                <div>
                    <h3>Total Categories</h3>
                    <p><?=TableRowCount("categories",$con);?></p>
                    
                </div>
                <div>
                    <h3>Total Suppliers</h3>
                    <p><?=TableRowCount("supplier",$con);?></p>

                </div>
                <div>
                    <h3>Total Orders</h3>
                    <p><?=TableRowCount("orders",$con);?></p>
                </div>

            </div>


        </div>

        <!-- Stock & Alerts Panel -->
        <div class="box alerts">
            <h3>Product with Least Stocks:</h3>
            <div class="alert-item">
                <!-- <span><strong>Including only with complete deliveries</strong></span> -->
            </div>
            <br>
            <h4><?=LeastOrdered($con)?></h4>
        </div>

        <!-- Order & Sales Summary -->
        <div class="box">
            <h3>Order Summary:</h3>
            <div>
                <h4>Pending Orders</h4>
                <p><?=TableRowConditionCount("orders",$con,'Pending',"order_status");?></p>
                </div>
            <div>
                <h4>Completed</h4>
            </div>
        </div>

        <style>
            .box p {
                font-size: 20px !important;

            }
        </style>

        <!-- Quick Actions -->
        <div class="boxopt quick-actions" style="display: block">
            <div>
            <h3>Quick Actions: </h3>

            </div>
            <br>
            <div>
                <div class="buttons" style="display: inline-block">
                    <button onclick="window.location.href='view_product.php'">Add New Product</button> 
                    <button onclick="window.location.href='view_order.php'">Create New Order</button> 
                    <button onclick="window.location.href='view_category.php'">Add New Category</button>


                </div>
            </div>
            
        </div>
                </div>
            </div>

</div>
            </div>
            

                <!-- <hr> -->
            </div>    
        </div>
        </div>
        </main>
<footer>
<?php include('includes/footer.php'); ?>

