<?php
/**
 * Session Configuration
 *
 * This file centralizes session management. It should be included at the
 * very top of any PHP script that needs to access session data.
 *
 * It configures session settings for better security and then starts
 * the session if it hasn't been started already.
 */

// Detect if HTTPS is used
$is_https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on';

// Forces sessions to only use cookies, preventing session fixation attacks.
ini_set('session.use_only_cookies', 1);

// Ensures that session cookies are only accessible via the HTTP protocol.
// This prevents client-side scripts from accessing the cookie (mitigating XSS).
ini_set('session.cookie_httponly', 1);

// Sets the SameSite attribute of the session cookie to 'Lax'.
// This provides protection against Cross-Site Request Forgery (CSRF) attacks.
ini_set('session.cookie_samesite', 'Lax');

// Ensures the session cookie is only sent over secure (HTTPS) connections.
if ($is_https) {
    ini_set('session.cookie_secure', 1);
}

// Check if a session has already been started before starting a new one.
// This prevents "session has already been started" notices.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Regenerate session ID every 30 minutes to prevent session fixation attacks.
$regenerate_time = 30 * 60; // 30 minutes in seconds
if (!isset($_SESSION['last_regenerate'])) {
    $_SESSION['last_regenerate'] = time();
} elseif (time() - $_SESSION['last_regenerate'] > $regenerate_time) {
    session_regenerate_id(true);
    $_SESSION['last_regenerate'] = time();
}
