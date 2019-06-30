<?php
  //admin login credentials 
require_once('authorize.php');

?>
<?php
//starting session for cookies and header, navmenu, controller instantiation
require_once('startsession.php');  
require_once('header.php'); 
require_once('navmenu.php'); 
require_once('appvars.php');  
require_once('connectvars.php');   
require_once('controller/Controller.php'); 
$controller = new Controller();
?>

<div id="mainContentArea">
    
    <h1>Player Base</h1>
    
<?php 

    $controller->removeProf();

    require_once("footer.php");
    
?>

