<?php
  // connect to database with connectvars
  // require controller, header and navbar
require_once('connectvars.php');
require_once('controller/Controller.php'); 
require_once('header.php');
require_once('navmenu.php');
//instantiating controller
$controller = new Controller();

?> 
<div id="mainContentArea"> 
    <h1>Connect With Other Players</h1>
    <?php 
    //$user_search = $_GET['usersearch'];    
    $sort = $_GET['sort']; 
    echo '<table class="table proftable table-bordered" align="center" cellpadding="2">';
    // Generate the search result headings  
    echo '<tr class="playerdbth">';    
    echo $controller->generate_sort_links($sort);
    echo '</tr>';
    // Query to get the total results 
    //left this connection here to DB, couldn't get it to work otherwise
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
    if(isset($_GET['sort'])){
        $query = $controller->build_query($sort);
    } else {    
        $query = "SELECT * FROM bdo_player where isactive = 1";    
    }
    $result = mysqli_query($dbc, $query);
    //$total = mysqli_num_rows($result);
    $varsnar = '?bdo_user_id=';
    while ($row = mysqli_fetch_array($result)) {
        echo '<tr>';
        echo '<td class="playerproflink" valign="top"><a href="viewprofile.php' . $varsnar . $row['bdo_user_id'] . '">' .  $row['char_name'] . '</a></td>';
        echo '<td valign="top">' . $row['class'] . '</td>';
        echo '<td valign="top">' . $row['level'] . '</td>';
        echo '<td valign="top">' . $row['renown'] . '</td>';
        echo '</tr>';
  
    } 
    echo '</table>'; 
    mysqli_close($dbc);
    ?>

</div>


<?php
require_once('footer.php');
?>


