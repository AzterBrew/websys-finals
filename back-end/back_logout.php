<?php

session_start();
echo $_SESSION['uid'];
session_unset();
session_destroy();

header("Location: ../index.php");
