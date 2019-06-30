
<?php
  // Starts the session
require_once('startsession.php');
require_once('controller/Controller.php');
//Instantiates controller to use for functions    
$controller = new Controller();
// inserting the header, app and connectvars
require_once('header.php');
require_once('appvars.php');
require_once('connectvars.php');
// Show the navigation menu
require_once('navmenu.php');

?>

<!-- This div is the main area for content for the whole webpage -->
<div id="mainContentArea">
    <h1>Profile Data</h1>
<?php
    // Calls the controller to show the profile info.
    $controller->viewProfileData();  
?>
</div>
<?php
  // Insert the page footer
  require_once('footer.php');
?>
