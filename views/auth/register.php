<?php
require_once __DIR__ . '/../../config/session-config.php';

// Get registration errors from session and then clear them
$fieldErrors = $_SESSION['field_errors'] ?? [];
unset($_SESSION['field_errors']);

// Get form data from session to repopulate fields, then clear it
$formData = $_SESSION['form_data'] ?? [];
unset($_SESSION['form_data']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="/../../public/assets/css/auth.css">
</head>
<body>
    <div class="auth-container">
        <h2>Register for CRM</h2>
        <form action="../../includes/register-inc.php" method="post">
            <div class="form-group">
                <label for="username"><strong>Username</strong></label>
                <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($formData['username'] ?? ''); ?>" >
                <?php if (!empty($fieldErrors['username'])): ?>
                    <p class="field-error"><?php echo htmlspecialchars($fieldErrors['username']); ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="email"><strong>Email</strong></label>
                <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($formData['email'] ?? ''); ?>" >
                <?php if (!empty($fieldErrors['email'])): ?>
                    <p class="field-error"><?php echo htmlspecialchars($fieldErrors['email']); ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="company_name"><strong>Company name (Optional)</strong></label>
                <input type="text" name="company_name" id="company_name" value="<?php echo htmlspecialchars($formData['company_name'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label for="pwd"><strong>Password</strong></label>
                <input type="password" name="pwd" id="pwd" >
                <?php if (!empty($fieldErrors['pwd'])): ?>
                    <p class="field-error"><?php echo htmlspecialchars($fieldErrors['pwd']); ?></p>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label for="confirmpwd"><strong>Confirm Password</strong></label>
                <input type="password" name="confirmpwd" id="confirmpwd" >
                <?php if (!empty($fieldErrors['confirmpwd'])): ?>
                    <p class="field-error"><?php echo htmlspecialchars($fieldErrors['confirmpwd']); ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn-submit">Register</button>
        </form>
        <p class="switch-form">Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
