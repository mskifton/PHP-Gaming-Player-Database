<?php 
//starting session and inlcuding header and navmenu
require_once('startsession.php');
require_once('header.php');
require_once('navmenu.php');
    
//instantiating controller 	
include_once('controller/Controller.php');

$controller = new Controller();
    ?>
<div id="mainContentArea">
    <h1>Player Space</h1>
    
    <div id="mainspacer">
        
        <p>Welcome to Player Space!<br/>A place for Black Desert Online players to connect.<br/> To be apart of our community, please Register.</p>
        
    </div>

    
    <video id="intro_video" width="600" height="450" class="inner_video" autoplay="autoplay" loop="loop" muted="muted">
        
        <source type="video/webm" src="https://akamai-webcdn.kgstatic.net/renewal/static/video/archer_teaser.webm">
        
    </video>
    

</div>

<?php 
require_once('footer.php');
?>