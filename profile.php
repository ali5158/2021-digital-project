<?php
 include_once 'includes/header.php';
 include_once 'includes/login-check.php';
 echo "<h2> Welcome back " . $_SESSION['username'] . "</h2>";
 include_once 'includes/footer.php';
?>