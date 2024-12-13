<?php
include 'includes/header.php';
include 'middleware.php';
include 'dbcon.php';


if(isset($_POST['ad-edit-btn'])){ //IF EDITING RECORD
    if (isset($_GET['adidlabel'])) {
        $admin_id = $_GET['adidlabel'];

        $getnamequery = "SELECT * FROM administrators WHERE admin_id = ?";
        $stmt = $con->prepare($getnamequery);
        $stmt->bind_param("i",$admin_id);
        if ($stmt->execute()) {
            $results = $stmt->get_result(); // Always return the result object        
            $item_row = mysqli_fetch_assoc($results);            
            $admin_firstname = $item_row['admin_firstname']; 
            $admin_surname = $item_row['admin_surname'];
            $admin_email= $item_row['admin_email'];
            $admin_contact = $item_row['admin_contact'];
            $admin_priv = $item_row['admin_priv'];
            $admin_status = $item_row['admin_status'];
            
        } else {
            echo "Error: " . $stmt->error;
            echo "Order might have been deleted";
        }
        $isEdit = True;

    }                                     
} else if (isset($_POST['ad-add-btn'])){ //IF NEW RECORD
    $admin_id = TableRowCount("administrators",$con)+1;
    $isEdit = False;

}

?>

<!-- CONTENTS -->
<div class="logo-bg-2"></div>
<div class="admin-container" style="max-width: 50%">

    <div class="row admin-mod-text">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2 style="font-family: 'Inter', sans-serif; font-size: 40px; font-weight: bold;">
                        Account Assignation
                    </h2>
                </div>
                <div class="card-body">
                    <form action="back-end/back_proc.php" method="POST" enctype="multipart/form-data">
                        <div class="row supplier-order">
                            <?php if($isEdit){?> 
                                    <?php }?>
                                <input type="hidden" name="admin_id" value="<?= $admin_id; ?>"> <!-- Pass the category ID -->
                                <input type="hidden" name="oldpass" value="<?= $password; ?>"> <!-- Pass the category ID -->
                                <?php
                                    // IF EDIT RECORD
                                    if($isEdit){?> 
                                    <!-- <div class="col-md-6"> -->
                                    <label for="" class="cat-label">
                                        User ID : <?=$admin_id?>
                                    </label>        
                                    <br>
                                    <br>
                                        <label for="">
                                            Current Username :
                                        </label>
                                        <input type="text" disabled value="<?= $admin_firstname . ' ' . $admin_surname ?>" name="admin_full" placeholder="Enter Category Name" class="form-control" required>
                                        <br> 
                                        <br> 
                                        <label for="">
                                            First Name
                                        </label>
                                        <input type="text" value="<?=$admin_firstname?>" name="admin_firstname" placeholder="Enter First Name" class="form-control" required>  
                                        <br>                                      
                                        <label for="">
                                            Last Name
                                        </label>
                                        <input type="text" value="<?=$admin_surname?>" name="admin_surname" placeholder="Enter Last Name" class="form-control" required>  
                                        <br>                                      
                                        <label for="">
                                            Mobile Number
                                        </label>
                                        <input type="tel" value="<?=$admin_contact?>" name="admin_contact" placeholder="Enter mobile number" class="form-control" required>                                          
                                        <br>                                      
                                        <label for="">
                                            Email
                                        </label>
                                        <input type="email" value="<?=$admin_email?>" name="admin_email" placeholder="Enter Email" class="form-control" required>
                                        <br>                                      
                                        
                                        <label for="password">Password:</label>
                                        <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control" required><br>
                                        
                                        <p id="passwarning"><b>Password does NOT match</b></p>
                                        <label for="confirm_password">Confirm Password:</label>
                                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" class="form-control" onkeyup="confirmPass();" required><br><br>

                       
                                        <br> 
                                        <hr>                                     
                                                                          
                                        <br>  
                                        

                                        <?php
                                    // IF NEW RECORD                                
                                    }else {?>
                                    <div>
                                        <label for="" class="cat-label">
                                            User ID : <?=$admin_id?>
                                        </label>        
                                        <br>
                                        <br>                                      
                                        <label for="">
                                            First Name
                                        </label>
                                        <input type="text" name="admin_firstname" placeholder="Enter First Name" class="form-control" required>  
                                        <br>                                      
                                        <label for="">
                                            Last Name
                                        </label>
                                        <input type="text" name="admin_surname" placeholder="Enter Last Name" class="form-control" required>  
                                        <br>                                      
                                        <label for="">
                                            Mobile Number
                                        </label>
                                        <input type="tel" name="admin_contact" placeholder="Enter mobile number" class="form-control" required>                                          
                                        <br>                                      
                                        <label for="">
                                            Email
                                        </label>
                                        <input type="email" name="admin_email" placeholder="Enter Email" class="form-control" required>
                                        <br>                                      
                                        
                                        <label for="password">Password:</label>
                                        <input type="password" id="password" name="password" placeholder="Enter your password" class="form-control" required><br>
                                        
                                        <p id="passwarning"><b>Password does NOT match</b></p>
                                        <label for="confirm_password">Confirm Password:</label>
                                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your password" class="form-control" onkeyup="confirmPass();" required><br><br>


                                        
                                          
                                        </div>
                                        <br>
                                        <br>
                                        </div>
                                        <?php
                                    }
                                ?>

                                        <br>

                                        <label for="">
                                            User Database Access
                                        </label>
                                        <br>
                                        <select class="admin-sel" name="ad_priv" id="recstat">
                                            <?php
                                                if($admin_priv == "Authorized"){
                                                    ?>
                                                        <option value="Authorized">Authorize</option>
                                                        <option value="Unauthorized">Unauthorize</option>
                                                    <?php
                                                } else {
                                                    ?>
                                                        <option value="Unauthorized">Unauthorize</option>
                                                        <option value="Authorized">Authorize</option>
                                                    <?php
                                                }
                                            ?>                                    
                                        </select>
                                        <br>

                            
                            
                                <?php 
                                if($isEdit){?> 
                                    
                                    <br>
                                        
                                        <label style="margin-top: 5%" for="">
                                            Administrator Status
                                        </label>
                                        <br>
                                        <select class="admin-sel" name="recstat" id="recstat">
                                            <?php
                                                if($ad_stat == "Active"){
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
                                        <br>
                                <?php
                                }
                                ?>                                

                            
                                <br>
                                <?php 
                                    if($isEdit){ ?>
                                    <div style="margin-top: 5%">
                                        <button type="submit" value="<?= $isEdit ? '1' : '0'; ?>" name="ad-confirm-btn">Confirm Order</button>
                                        <button type="submit" name="ad-cancel-btn" formnovalidate>Cancel</button>
                                    </div>
                                    <?php } else {
                                        ?>
                                    <div style="margin-left:auto; margin-right:auto">
                                        <button style="align-items: center" type="submit" value="<?= $isEdit ? '1' : '0'; ?>" name="ad-confirm-btn">Confirm Order</button>
                                        <button type="submit" name="ad-cancel-btn" formnovalidate>Cancel</button>
                                    </div>
                                    <?php
                                    }
                                ?>
                                </form>                
                                
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    // JavaScript for handling the quantity increment and decrement
    document.getElementById('plus').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantity');
        let value = parseInt(quantityInput.value);
        let maxaddition = <?=$q_ordered - $q_received?>;
        if(value < maxaddition){
            quantityInput.value = value + 1;
        }
    });

    document.getElementById('minus').addEventListener('click', function() {
        let quantityInput = document.getElementById('quantity');
        let value = parseInt(quantityInput.value);
        if (value > 0) {
            quantityInput.value = value - 1;
        }
    });

    
//  const firstpass = document.getElementById('password');
//  const confirmpass = document.getElementById('confirm_password');
//  const passwarning = document.getElementById('passwarning');

//  // Function to toggle the input field

//  function confirmPass(){
//     if(firstpass.value != confirmpass.value){
//         console.log('not match')
//         passwarning.style.visibility = 'visible';
//     } else {
//         console.log('match')
//         passwarning.style.visibility = 'hidden';
//     }
//  }

//  document.getElementById('passwarning').addEventListener('onkeyup', function () {
//     confirmPass();
//   });

//  // Add event listener to the select element
//  typeSelect.addEventListener('change', toggleInput);
// //  confirmpass.addEventListener('change',confirmPass);

//  // Call the function once to set the initial state
//  toggleInput();
// //  confirmPass();


</script>





<!-- END OF CONTENTS -->
</div>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="reg.js" type="text/javascript"></script>
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