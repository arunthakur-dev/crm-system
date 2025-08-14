<?php
session_start();

// Unset all session variables
$_SESSION = []; // Clear manually
session_unset(); // For extra safety

// Destroy session
if (session_destroy()) {
    // Verify session is destroyed
    if (empty($_SESSION)) {
        header('Location: login.php');
        exit();
    } else {
        echo "Error: Session could not be destroyed completely.";
    }
} else {
    echo "Error: Session destruction failed.";
}
