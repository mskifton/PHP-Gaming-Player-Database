<?php
  // Generate the navigation menu
  
if (isset($_SESSION['bdo_username'])) {
    
    //if user is logged in already then show them these links
    echo '<nav class="navcss fixed-top">';  
    echo '<a class="navbar-brand" href="index.php">Home</a> ';
    echo '<a class="navbar-brand" href="playerdb.php">Player Database </a>';
    echo '<a class="navbar-brand" href="streamtracker.php">Stream Tracker </a>';
    echo '<a class="loginnav navbar-brand" href="logout.php">Log Out (' . $_SESSION['bdo_username'] . ')</a>';
    echo '<a class="editnav navbar-brand" href="editprofile.php">Edit Profile </a>';
    echo '<a class="viewnav navbar-brand" href="viewprofile.php">View Profile </a>'; 
    echo '</nav>';
  
}
  

else {
    //user not logged in display these links
    echo '<nav class="navcss fixed-top">';
    echo '<a class="navbar-brand" href="index.php">Home</a> ';
    echo '<a class="navbar-brand" href="playerdb.php">Player Database </a>';
    echo '<a class="navbar-brand" href="streamtracker.php">Stream Tracker </a>';
    echo '<a class="loginnav navbar-brand" href="login.php">Log In</a> '; 
    echo '<a class="registernav navbar-brand" href="signup.php">Register</a>';
    echo '</nav>';
}
?>
