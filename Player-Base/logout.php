<?php
  // log out user if logged in
  session_start();
  if (isset($_SESSION['bdo_user_id'])) {
    // Delete the session vars by clearing the $_SESSION array
    $_SESSION = array();

    // expiration set to one hour ago, deletes
    if (isset($_COOKIE[session_name()])) {
      setcookie(session_name(), '', time() - 3600);
    }

    // Destroy session
    session_destroy();
  }

  // Delete the user ID and username cookies, set expire hour ago
  setcookie('bdo_user_id', '', time() - 3600);
  setcookie('username', '', time() - 3600);

  // Redirect to the home page
  $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
  header('Location: ' . $home_url);
?>
