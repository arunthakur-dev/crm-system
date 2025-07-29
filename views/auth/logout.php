<?php
session_start();

// Unset all session variables
$_SESSION = []; // Clear manually
session_unset(); // Extra safety

// Destroy session
if (session_destroy()) {
    // Verify session is destroyed
    if (empty($_SESSION)) {
        header('Location: ../../public/index.php');
        exit();
    } else {
        echo "Error: Session could not be destroyed completely.";
    }
} else {
    echo "Error: Session destruction failed.";
}
