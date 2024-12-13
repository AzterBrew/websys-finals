<?php 

include('includes/header.php'); 
include('dbcon.php'); 

$query = "SELECT * FROM administrators WHERE admin_id = 1";
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


?>
        <div class="page-container">
            <div class="hello-username">
                <h1>Welcome back to your Dashboard, <?=$username?>!</h1>
            
                <div class="dashboard-container">
        <!-- Overview Panel -->
        <div class="box overview-panel total-products">
            <div>
                <h3>Total Products</h3>
                <p>1,245</p>
            </div>
            <div>
                <h3>Total Categories</h3>
                <p>12</p>
            </div>
            <div>
                <h3>Total Orders</h3>
                <p>430</p>
            </div>
            <div>
                <h3>Total Suppliers</h3>
                <p>23</p>
            </div>
        </div>

        <!-- Stock & Alerts Panel -->
        <div class="box alerts">
            <h3>Stock & Alerts:</h3>
            <div class="alert-item">
                <span><strong>Low Stock Alert:</strong> Product "ABC" is running low.</span>
            </div>
        </div>

        <!-- Order & Sales Summary -->
        <div class="box">
            <h3>Order & Sales Summary:</h3>
            <div>
                <h4>Ongoing Orders</h4>
                <p>10 Orders Processing</p>
            </div>
            <div>
                <h4>Sales Performance</h4>
                <p>$4,500 (Last 7 Days)</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="boxopt quick-actions">
            <h3>Quick Actions: </h3>
            <div class="buttons">
                <button>Add New Product</button> 
                <button>Create New Order</button> 
                <button>Add New Category</button>


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
    </main>
<footer>
<?php include('includes/footer.php'); ?>

