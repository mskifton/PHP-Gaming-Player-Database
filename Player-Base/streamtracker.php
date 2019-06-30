<?php
require_once('startsession.php');
?>
<!DOCTYPE html>
<html lang="en" >
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="css/style1.css">
        <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">     
        <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
        <script  src="js/twitchapi.js"></script>
    </head>
    <body>
        <?php
        require_once('navmenu.php');
        
        ?>
        <div id="mainContentArea">
        <div class="container">
            
            
            <ul>
                <li data-stat="streamers">Popular BDO Streamers</li>
                <li data-stat="online">Online</li>
                <li data-stat="offline">Offline</li>
            </ul>
            
            <div id="streamers" class="row">
                <div class="add"><input class="addstreamer" type="text" placeholder="Add user"><i class="fa fa-plus-circle"></i></div>
            </div>
            
            <div id="online" class="row">
            </div>
            
            <div id="offline" class="row">
            </div>
        </div>
            </div>
<?php
        
        require_once('footer.php');
        
        ?>
