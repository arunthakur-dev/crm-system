<?php
require_once __DIR__ . '/../../config/session-config.php';

$fieldErrors = $_SESSION['field_errors'] ?? [];
unset($_SESSION['field_errors']);

$loginData = $_SESSION['login_data'] ?? [];
unset($_SESSION['login_data']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <h2>Login to CRM</h2>
        <form action="../../includes/login-inc.php" method="post">
            <div class="form-group">
                <label for="usernameOrEmail"><strong>Username or Email</strong></label>
                <input type="text" name="usernameOrEmail" id="usernameOrEmail"
                       value="<?php echo htmlspecialchars($loginData['usernameOrEmail'] ?? ''); ?>" >
                <?php if (!empty($fieldErrors['user'])): ?>
                    <p class="field-error"><?php echo htmlspecialchars($fieldErrors['user']); ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="pwd"><strong>Password</strong></label>
                <input type="password" name="pwd" id="pwd" >
                <?php if (!empty($fieldErrors['pwd'])): ?>
                    <p class="field-error"><?php echo htmlspecialchars($fieldErrors['pwd']); ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn-submit">Login</button>
        </form>
        <p class="switch-form">Don't have an account? <a href="register.php">Register here</a>.</p>
    </div>
</body>
</html>