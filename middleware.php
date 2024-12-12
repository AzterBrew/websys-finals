<?php
if (!isset($_SESSION['uid'])) {
    echo "SESSION UID IS NOT SET";
    $_SESSION['message'] = "Login to continue";
    header("Location: index.php?error=Login to continue.");
}
