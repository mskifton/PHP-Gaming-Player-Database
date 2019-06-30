<?php
        require_once('startsession.php');
        require_once("connectvars.php");
   //     include_once("model/Model.php");


class Controller {

	
	public function invoke()
	{
		if (!isset($_GET['book']))
		{
			// no special book is requested, we'll show a list of all available books
			$books = $this->model->getBookList();
			include 'view/booklist.php';
		}
		else
		{
			// show the requested book
			$book = $this->model->getBook($_GET['book']);
			include 'view/viewbook.php';
		}
	}
    
    
    public function userLogIn($user_username, $user_password)
    {
              // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        
        $query = "SELECT bdo_user_id, bdo_username FROM bdo_player WHERE isactive = 1 AND bdo_username = '$user_username' AND bdo_password = SHA('$user_password')";
        $data = mysqli_query($dbc, $query);
        
        
        //if there is a 
        if (mysqli_num_rows($data) == 1) {
          // The log-in is OK so set the user ID and username session vars (and cookies), and redirect to the home page
            
          $row = mysqli_fetch_array($data);
          $_SESSION['bdo_user_id'] = $row['bdo_user_id'];
          $_SESSION['bdo_username'] = $row['bdo_username'];
          setcookie('bdo_user_id', $row['bdo_user_id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
          setcookie('bdo_username', $row['bdo_username'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
          $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
          header('Location: ' . $home_url);
        
        } 
    }
    
    
    
    public function userSignUp($username, $password, $char_name, $bdo_class, $level, $renown){
        
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
              // Make sure someone isn't already registered using this username
      $query = "SELECT * FROM bdo_player WHERE bdo_username = '$username'";
      $data = mysqli_query($dbc, $query);
      if (mysqli_num_rows($data) == 0) {
        // The username is unique, so insert the data into the database
        $query = "INSERT INTO bdo_player (bdo_user_id, bdo_username, bdo_password, char_name, class, level, renown, pic, joined_date, isactive)VALUES (NULL,'$username', SHA('$password'),'$char_name', '$bdo_class', '$level', '$renown', NULL, NOW(), 1)";
        mysqli_query($dbc, $query);

          return true;
        // Confirm success with the user
        

          
     //   mysqli_close($dbc);
     //   exit();
      }
      else if (mysqli_num_rows($data) > 0) {
        // An account already exists for this username, return false
         
          return false;
      }
    }
    
    
    public function updateWithPic($char_name, $bdo_class, $level, $renown, $new_picture){
                  
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = "UPDATE bdo_player SET char_name = '$char_name', class = '$bdo_class', level = '$level', renown = '$renown',  pic = '$new_picture' WHERE bdo_user_id = '" . $_SESSION['bdo_user_id'] . "'";
        mysqli_query($dbc, $query);
        
    }
    
    
    public function updateNoPic($char_name, $bdo_class, $level, $renown){
        
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = "UPDATE bdo_player SET char_name = '$char_name', class = '$bdo_class', level = '$level', renown = '$renown' WHERE bdo_user_id = '" . $_SESSION['bdo_user_id'] . "'";
        mysqli_query($dbc, $query);
    }
    
    public function showProfileData(){
        
           
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        $query = "SELECT char_name, class, level, renown, pic FROM bdo_player WHERE bdo_user_id = '" . $_SESSION['bdo_user_id'] . "'";
        $data = mysqli_query($dbc, $query);
        $row = mysqli_fetch_array($data);
        
        return $row;
        
    }
    
    public function viewProfileData(){
        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
          
        if (!isset($_GET['bdo_user_id'])) {
    
            $query = "SELECT char_name, class, level, renown, pic FROM bdo_player WHERE bdo_user_id = '" . $_SESSION['bdo_user_id'] . "'";
  
        } else {
    
            $query = "SELECT char_name, class, level, renown, pic FROM bdo_player WHERE bdo_user_id = '" . $_GET['bdo_user_id'] . "'";
  
        }
        
        $data = mysqli_query($dbc, $query);
        if (mysqli_num_rows($data) == 1){
    // The user row was found so display the user data
    $row = mysqli_fetch_array($data);
    echo '<table align="center" class="table table-hover proftable table-dark table-bordered">';
    if (!empty($row['char_name'])) {
      echo '<tr><td class="label">Character Name:</td><td>' . $row['char_name'] . '</td></tr>';
    }
    if (!empty($row['class'])) {
      echo '<tr><td class="label">Character Class:</td><td>' . $row['class'] . '</td></tr>';
    }
    if (!empty($row['level'])) {
      echo '<tr><td class="label">Character Level:</td><td>' . $row['level'] . '</td></tr>';
    }
    if (!empty($row['renown'])) {
      echo '<tr><td class="label">Renown Score:</td><td>' . $row['renown'] . '</td></tr>';
      
    }
    if (!empty($row['pic'])) {
      echo '<tr><td class="label">Gear Pic:</td><td><img height="325" width="225" src="' . MM_UPLOADPATH . $row['pic'] .
        '" alt="Gear Pic" /></td></tr>';
    }
    echo '</table>';

   // End of check for a single row of user results

  mysqli_close($dbc);
            
        }  else {
            echo '<p class="error">Unable to display Profile info. Please refresh the page or contact site support. Thanks!</p>';
  
        }
        
    
    }
    
    
    public function generate_sort_links($sort) {
    
    $sort_links = '';
      
      
    switch ($sort) {
        case 1:
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=2">Character Name</a></td>';
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=3">Character Class</a></td>';
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=5">Character Level</a></td>';
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=7">Renown Score</a></td>';
              break;

        case 3:
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=1">Character Name</a></td>';
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=4">Character Class</a></td>';
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=5">Character Level</a></td>';
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=7">Renown Score</a></td>';
              break;
            
        case 5:
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=1">Character Name</a></td>';
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=3">Character Class</a></td>';
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=6">Character Level</a></td>';
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=7">Renown Score</a></td>';
              break;
              
        case 7:
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=1">Character Name</a></td>';
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=3">Character Class</a></td>';
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=5">Character Level</a></td>';
              $sort_links .= '<td><a class="dbheader" href = "' . $_SERVER['PHP_SELF'] . '?sort=8">Renown Score</a></td>';
              break;
              
        default:
            $sort_links .= '<td class="dbheader"><a href="' . $_SERVER['PHP_SELF'] . '?sort=1">Character Name</a></td>';
            $sort_links .= '<td class="dbheader"><a href="' . $_SERVER['PHP_SELF'] . '?sort=3">Character Class</a></td>';
            $sort_links .= '<td class="dbheader"><a href="' . $_SERVER['PHP_SELF'] . '?sort=5">Character Level</a></td>';
            $sort_links .= '<td class="dbheader"><a href="' . $_SERVER['PHP_SELF'] . '?sort=7">Renown Score</a></td>';
    }

    return $sort_links;
  }
    
public function build_query($sort) {

            $search_query = "SELECT * FROM bdo_player WHERE isactive = 1";
    
            // Sort the search query using the sort setting
            switch ($sort) {
                    // Ascending by character name
                case 1:
                    $search_query .= " ORDER BY char_name ASC ";
                    break;
                    // Descending by character name
                case 2:
                    $search_query .= " ORDER BY char_name DESC";
                    break;
                    // Ascending by class
                case 3:
                    $search_query .= " ORDER BY class ASC";
                    break;
                    // Descending by class
                case 4:
                    $search_query .= " ORDER BY class DESC";
                    break;
                    // Ascending by level
                case 5:
                    $search_query .= " ORDER BY level ASC";
                    break;
                    // Descending by level
                case 6:
                    $search_query .= " ORDER BY level DESC";
                    break;     
                    //ascending by renown score
                case 7:
                    $search_query .= " ORDER BY renown ASC";
                    break;
                    //descending by renown score
        case 8:
            $search_query .= " ORDER BY renown DESC";
      break;
    default:
      // No sort setting provided, so don't sort the query
    }

    return $search_query;
  }
    
    public function adminLogin(){
        
  // Connect to the database 
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  // Retrieve the score data from MySQL
  $query = "SELECT * FROM bdo_player WHERE isactive = 1 ORDER BY joined_date ASC";
  $data = mysqli_query($dbc, $query);

  // Loop through the array of score data, formatting it as HTML 
  echo '<table cellpadding="10" class="table proftable table-bordered" align="center">';
  echo '<tr><th>Character Name</th><th>Class</th><th>Level</th><th>Renown</th><th>Remove Profile</th></tr>';
  while ($row = mysqli_fetch_array($data)) { 
    // Display the score data
      echo '<tr class="scorerow"><td><strong>' . $row['char_name'] . '</strong></td>';
      echo '<td>' . $row['class'] . '</td>';
      echo '<td>' . $row['level'] . '</td>';
      echo '<td>' . $row['renown'] . '</td>';
      echo '<td><a href="removescore.php?userid=' . $row['bdo_user_id'] . '&amp;joindate=' . $row['joined_date'] .
      '&amp;charname=' . $row['char_name'] . '&amp;class=' . $row['class'] .
      '&amp;level=' . $row['level'] . '&amp;renown=' . $row['renown'] . '">Remove</a>';
    echo '</td></tr>';
  }
  echo '</table>';

  mysqli_close($dbc);
        
    }
    
    public function removeProf(){
        
         if (isset($_GET['userid']) && isset($_GET['joindate']) && isset($_GET['charname']) && isset($_GET['class']) && isset($_GET['level']) && isset($_GET['renown'])) {
    // Grab the score data from the GET
    $id = $_GET['userid'];
    $date = $_GET['joindate'];
    $char_name = $_GET['charname'];
    $class = $_GET['class'];
    $level = $_GET['level'];
    $renown = $_GET['renown'];
  }
  else if (isset($_POST['bdouserid']) && isset($_POST['charname'])) {
    // Grab the score data from the POST
    $id = $_POST['bdouserid'];
  }
  else {
    echo '<p class="error">Please click the "Remove Character link to remove character.</p>';
  }

  if (isset($_POST['submit'])) {
    if ($_POST['confirm'] == 'Yes') {

      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME); 

      // Delete the score data from the database
      $query = "UPDATE bdo_player SET isactive = 0 WHERE bdo_user_id = $id LIMIT 1";
      mysqli_query($dbc, $query);
      mysqli_close($dbc);

      // Confirm success with the user
      echo '<p align="center" class="confirmmsg">Player profile has been deactivated.</p>';
    }
    else if ($_POST['confirm'] == 'No') {
        $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/admin.php';
      header('Location: ' . $home_url);
    }
  }
  else if (isset($id) && isset($char_name) && isset($date)) {
      echo'<div id="confirmdiv>"';
    echo '<p class="confirmmsg" align="center">Are you sure you want to deactivate this player\'s profile?</p>';
    echo '<p class="confirmmsg" align="center"><strong>Character Name: </strong>' . $char_name . '<br /><strong>Class: </strong>' . $class .
      '<br /><strong>Level: </strong>' . $level . '<br/></p>';
    echo '<form align="center" method="post" action="removescore.php">';
    echo '<input type="radio" name="confirm" value="Yes" /> Yes ';
    echo '<input type="radio" name="confirm" value="No" checked="checked" /> No <br />';
    echo '<input type="submit" value="Submit" name="submit" />';
    echo '<input type="hidden" name="bdouserid" value="' . $id . '" />';
    echo '<input type="hidden" name="charname" value="' . $char_name . '" />';
    echo '</form>';
    echo '</div>';
    }
    }

}

?>