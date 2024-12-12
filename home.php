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
            <div>
                <h1>Hello<?=$username?></h1>
                <hr>
            </div>    
            <div>
                <h1>Hello2</h1>
            </div>  
        </div>
    </main>
<footer>
<!-- <?php include('includes/footer.php'); ?> POSSIBLY ILAGAY LANG SA MISMONG HOME PAGE-->

