<?php
session_start();

// Unset all of the session variables.
session_unset();

// Finally, destroy the session.
session_destroy();

// Redirect to login page
header('Location: ../../public/index.php');
exit();
