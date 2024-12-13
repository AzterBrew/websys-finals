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
                <h1>Welcome back to your dashboard, <?=$username?>!</h1>
            
        <div class="dashboard">

            <h1>dashboard</h1>




        </div>

            

                <!-- <hr> -->
            </div>    
        </div>
    </main>
<footer>
<?php include('includes/footer.php'); ?>

