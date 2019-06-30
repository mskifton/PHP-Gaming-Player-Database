<?php
  require_once('authorize.php');
?>

<?php
//starting session for cookies
//header, navmenu
require_once('startsession.php');
require_once('header.php');
require_once('navmenu.php');
require_once('appvars.php');
require_once('connectvars.php');
//instantiating controller 	
include_once('controller/Controller.php');

$controller = new Controller();
?>

<div id="mainContentArea">
    <h1>Admin Area</h1>
<?php

    $controller->adminLogin();
    ?>
</div>
    <?php

require_once("footer.php");
?>


