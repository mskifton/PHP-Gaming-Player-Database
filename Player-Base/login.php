<?php

//controller inclusion here, navmenu and header are down lower towards html form
include_once('controller/Controller.php');
require_once('connectvars.php');

  // Starting the session
  //session_start();

    //instatiating the controller for invoking methods
    $controller = new Controller();

  // Clear the error message
  $error_msg = "";

  // If the user isn't logged in, try to log them in
  if (!isset($_SESSION['bdo_user_id'])) {
    if (isset($_POST['submit'])) {
        

      // Connect to the database
      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

      // Grab the user-entered log-in data real escape string to secure
      $user_username = mysqli_real_escape_string($dbc, trim($_POST['bdo_username']));
      $user_password = mysqli_real_escape_string($dbc, trim($_POST['bdo_password']));
        
        //check if username is empty only
        if(empty($user_username) && !empty($user_password)){
            $error_msg = 'Please enter a username to login.';
        }
        
        //checks if username consists of special characters
        if (!preg_match("/([A-Za-z0-9]+)/", $user_username)){
            echo '<p class="error">Username can only consist of letters and numbers.</p>';
        }
        
        //check is only password is empty
        if(empty($user_password) && !empty($user_username)){
            $error_msg = 'Please enter a password to login.';
        }
        
        //checks is both username and pw is empty
        if((empty($user_username) && empty($user_password))){
            $error_msg = 'Please enter a username and password to login.';
        }
                

        //if username and pw fields are filled and user has no special characters
      if (!empty($user_username) && !empty($user_password) && preg_match("/([A-Za-z0-9]+)/", $user_username)) {
          //Call the controller to logon if the user entered a username and password into the inputs
         $checking = $controller->userLogIn($user_username, $user_password);
          
          //method from controller will return false if error finding any records.
          if(!$checking){
          // The username/password are incorrect so set an error message
          $error_msg = 'That Username and Password combination does not match any login credentials in our records.';
        } 
      }
    }
  }


//including the header and navmenu here. was having some weird styling issues if i didnt do this.
    require_once('header.php');
    require_once('navmenu.php');
?>
<div id="mainContentArea">
    <h1 class="loginHeader">Log In to Player Space</h1>
<?php
  // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
  if (empty($_SESSION['bdo_user_id'])) {
      
      
    echo '<p class="error">' . $error_msg . '</p>';
?>

    
    
    <table cellpadding="10" align="center" class="loginTable">
  <form onsubmit="validateLogin()" name="loginform" id="loginFormId" class="form-group" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <tr><td><label for="bdo_username">Username:</label></td>
          
      <td><input type="text" id="bdo_username" name="bdo_username" value="<?php if (!empty($user_username)) echo $user_username; ?>" /></td></tr>
          
          
      <tr><td><label for="bdo_password">Password:</label></td>
          <td><input type="password" id="bdo_password" name="bdo_password" /></td></tr>
      
      <tr><td><input class="btn btn-primary" type="submit" value="Log In" name="submit" /></td></tr>
          
    
  </form>
        </table>
    
</div>
<div id="loginerrors"></div>
<?php
  }
  else {
    // Confirm the successful log-in, welcome back user
    echo('<p class="login">Welcome Back, ' . $_SESSION['bdo_username'] . '.</p>');
  }
?>


<?php
  // Insert the page footer
  require_once('footer.php');
?>
