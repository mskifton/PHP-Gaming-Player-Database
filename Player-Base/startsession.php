<?php
  session_start();

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['bdo_user_id'])) {
    if (isset($_COOKIE['bdo_user_id']) && isset($_COOKIE['bdo_username'])) {
      $_SESSION['bdo_user_id'] = $_COOKIE['bdo_user_id'];
      $_SESSION['bdo_username'] = $_COOKIE['bdo_username'];
    }
  }
?>
