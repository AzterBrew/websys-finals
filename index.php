
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/Keepy Logo.png"alt="Site Logo" style="width:100px;height:auto;">
    <title> Keepy | Login </title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<header>
    <img src="images/Keepy Logo.png" alt="Keepy Logo"  style="width:100px;height:auto;">
    <h1>LOGIN</h1>
</header>
<body class="login-bg">
    <div class="keepy">
        <img src="images/Keepy Logo.png" alt="Keepy Logo" style="width: 250px;height:auto;">
        <h1 style="text-align: center">Inventory Management System</h1>
    </div>
        <div class="login-container">
         <h2>Log In</h2>

            <?php
                if (isset($_GET['error'])) {
                    echo '<p style="color: #CEDFE3;" class="error-login" align="center">' . $_GET['error'] . '</p>';
                }            
            ?> 
         <form action="back-end/back_login.php" method="post">
            <div class="form-group">
                <label for="username">Email:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>

            <button type="submit" id="logintype" name="logintype" value="1">LOG IN</button>
            <br>
            <button type="button" onclick="window.location.href='register.php'">CREATE ACCOUNT</button>
            <!-- FORGOR PASS ADMEN BUTON -->
            <!-- <button type="button" onclick="window.location.href='forgotpassword.html'">FORGOT PASSWORD</button>
            <button type="button" onclick="window.location.href='admin.html'">ADMIN</button> -->
            </form>
        </div>
</body>
</html>