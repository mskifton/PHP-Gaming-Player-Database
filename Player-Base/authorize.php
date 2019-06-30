<?php
  // User name and password for authentication
  $bdo_admin_username = 'bdoadmin';
  $bdo_admin_password = 'bdoadmin';

  if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
    ($_SERVER['PHP_AUTH_USER'] != $bdo_admin_username) || ($_SERVER['PHP_AUTH_PW'] != $bdo_admin_password)) {
    // The user name/password are incorrect so send the authentication headers
    header('HTTP/1.1 401 Unauthorized');
    header('WWW-Authenticate: Basic realm="Player Space"');
    exit('<h1>Player Space</h1>Invalid Admin Login.');
  }
?>
