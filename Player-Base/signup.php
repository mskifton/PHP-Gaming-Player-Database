<?php
  // insert header, nav menu
require_once('header.php');
require_once('navmenu.php');
include_once('controller/Controller.php');
//   require_once('appvars.php');
require_once('connectvars.php');
    
//instantiate controller
$controller = new Controller();
?>
<div id="mainContentArea">
    <h1>Register to Login</h1>
<?php 
    // connect to the database
    $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (isset($_POST['submit'])) {
        // Grab the profile data from the POST using real escape string to secure statements
        $username = mysqli_real_escape_string($dbc, trim($_POST['bdo_username']));  
        $password = mysqli_real_escape_string($dbc, trim($_POST['bdo_password']));
        $password_confirm = mysqli_real_escape_string($dbc, trim($_POST['bdo_password2']));
        $char_name = mysqli_real_escape_string($dbc, trim($_POST['char_name']));
        $bdo_class = mysqli_real_escape_string($dbc, trim($_POST['bdo_class']));
        $level = mysqli_real_escape_string($dbc, trim($_POST['level']));
        $renown = mysqli_real_escape_string($dbc, trim($_POST['renown']));

        
        /* 
        
        PHP validation. $char_name doesn't have as extensive as this relies more on the 
        user's character name in-game.
        For my app, we just need to make sure it isn't empty or longer than 16 character lengths can inlcude special characters.
        
        Checking if Renown Score and also if Level are numbers. These must only be a number cant be letters or special characters and also
        checking the length of each.

        Checking if password and username is valid, no longer than 16 characters.
        */
      
    
        //checks is username field is empty
        if (empty($username)){ 
            echo '<p class="error">Please enter a Username to register.</p>';
        } 
        
        //checks if username field has any special characters
        if (!preg_match("/([A-Za-z0-9]+)/", $username)){
            echo '<p class="error">Username can only consist of letters and numbers.</p>';
        }
    
   
        //checks is pw field is empty
    
        if(empty($password)){   
            echo '<p class="error">Please enter a Password to register.</p>';
        } 
    
    
        //checks if pw confirm field is empty
        if(empty($password_confirm)){
            echo '<p class="error">Please confirm your Password to register.</p>';
        }
    
        //checks if pw and pw confirm match
        if($password != $password_confirm){    
            echo '<p class="error">Your Password and Password Confirm do not match.</p>';
        } 
    
        //checks if character name field is empty
        if(empty($char_name)){
            echo '<p class="error">You must enter your Character\'s Name to register.</p>';
        }
    
        //checks if class field is empty
        if(empty($bdo_class)){
            echo '<p class="error">Please select a Class.</p>'; 
        } 
    
        //chekcs if level is empty    
        if(empty($level)){
            echo '<p class="error">You must enter your Character\'s Level.</p>';
        } 
    

        //checks if renown field is empty
        if(empty($renown)){
            echo '<p class="error">You must enter your Character\'s Renown Score.</p>';
        } 
    
        //checks if level isnt numeric
        if(!is_numeric($level)){   
            echo '<p class="error">Your Renown score must be a number only.</p>';
        } 
    
        //checks if the length of level is more than 2
        if(strlen($level) > 2){
            echo '<p class="error">Your level can only be 2 numeric characters long.</p>';
        } 
    
        //checks if level is between 1 and 64
        if((intval($level)) > 64 || (intval($level)) < 1 ){
            echo '<p class="error">Your level must be at least 1 and no higher than 64.</p>';
        } 
    
        //checks if renown isnt numeric
        if((!is_numeric($renown))){
            echo '<p class="error">Your Renown Score can only be a number.</p>';
        }
    
        //checks if renown score is bigger than 3 digits
        if((strlen($renown)) > 3 ){
            echo '<p class="error">Your Renown can only be 3 numeric characters long.</p>';
        }
    
        //checks if character name string is at least 3 characters but less than 16
        if((strlen($char_name)) > 16 || (strlen($char_name)) < 3 ) {
            echo '<p class="error">Your Character\'s Name must be at least 3 characters long and no longer than 16 characters.</p>';
        } 
    
        //checks if username is bigger than 16 characters
        if((strlen($username)) > 16){ 
            echo '<p class="error">Your Username can only be 16 characters long.</p>';
        } 
    
        //checks if pw is bigger than 16 characters
        if((strlen($password)) > 16){ 
            echo '<p class="error">Your Password can only be 16 characters long.</p>';
        } 
    
        else if (!empty($username) && !empty($password) && !empty($password_confirm) && ($password == $password_confirm) && ((intval($level) < 65) && (intval($level) > 0)) && strlen($char_name) > 3 && (preg_match("/([A-Za-z0-9]+)/", $username)) && is_numeric($renown) && is_numeric($level) && ((strlen($char_name)) > 2 || (strlen($char_name)) < 17 )) {
        
          //sign up user through controller
          $query_result = $controller->userSignUp($username, $password, $char_name, $bdo_class, $level, $renown);
          if($query_result == false)
        
          {
           
              echo '<p class="error">Username taken. Please enter another one.</p>';
              $username = "";
              
          } else if($query_result){
              echo'<div id="loginsuccess">';
              echo '<p>SUCCESS and WELCOME! You\'re now ready to <a href="login.php">log in</a>.</p>';
              echo '</div>';
              mysqli_close($dbc);    
              exit();
              
          } 
      }
}

  mysqli_close($dbc);
?>
    <table cellpadding="10" align="center" class="registertable table-dark table-hover table-bordered">
  <form name="registerform" class="signupform" align="center" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <tr>
              <td>
      <label for="bdo_username">Username:</label>  
              </td>
              <td>
      <input type="text" maxlength="16" id="bdo_username" name="bdo_username" value="<?php if (!empty($username)) echo $username; ?>" />
              </td>
      </tr>
      <tr>
              <td>
      <label for="bdo_password">Password:</label>
              </td>
              <td>
      <input type="password" maxlength="16" id="bdo_password" name="bdo_password" />
              </td>
      </tr>
      <tr>
                  <td>
      <label for="bdo_password2">Confirm Password:</label>
              </td>
              <td>
      <input type="password" maxlength="16" id="bdo_password2" name="bdo_password2" />
                  </td>
      </tr>
              
      <tr>
                  <td>
      <label for="char_name">Character Name:</label>
                  </td>
                  <td>
      <input type="text" maxlength="16" id="char_name" name="char_name" value="<?php if (!empty($char_name)) echo $char_name; ?>" />
                      </td>
      </tr>
      <tr>
                  <td>
      <label class="levellabel" for="level">Level:</label>
                  </td>
                  <td>
      <input  class="levelinput" type="text" maxlength="2" id="level" name="level" value="<?php if (!empty($level)) echo $level; ?>" />
                  </td>
              </tr>
          
          <tr>
              <td>
      <label class="classlabel"  for="bdo_class">Class:</label>
                  </td>
              <td>
      <select class="classinput" id="bdo_class" name="bdo_class">
          <option value="Musa"<?php if (!empty($bdo_class) && $bdo_class == 'Musa') echo 'selected = "selected"'; ?>>Musa</option>
          
          <option value="Maehwa" <?php if (!empty($bdo_class) && $bdo_class == 'Maehwa') echo 'selected = "selected"'; ?>>Maehwa</option>
          
          <option value="Wizard" <?php if (!empty($bdo_class) && $bdo_class == 'Wizard') echo 'selected = "selected"'; ?>>Wizard</option>
          
          <option value="Witch" <?php if (!empty($bdo_class) && $bdo_class == 'Witch') echo 'selected = "selected"'; ?>>Witch</option>
          
          <option value="Berserker" <?php if (!empty($bdo_class) && $bdo_class == 'Berserker') echo 'selected = "selected"'; ?>>Berserker</option>
          
          <option value="Warrior" <?php if (!empty($bdo_class) && $bdo_class == 'Warrior') echo 'selected = "selected"'; ?>>Warrior</option>
          
          <option value="Sorceress" <?php if (!empty($bdo_class) && $bdo_class == 'Sorceress') echo 'selected = "selected"'; ?>>Sorceress</option>
          
          <option value="Ranger" <?php if (!empty($bdo_class) && $bdo_class == 'Ranger') echo 'selected = "selected"'; ?>>Ranger</option>
          
          <option value="Striker" <?php if (!empty($bdo_class) && $bdo_class == 'Striker') echo 'selected = "selected"'; ?>>Striker</option>
          
          <option value="Mystic" <?php if (!empty($bdo_class) && $bdo_class == 'Mystic') echo 'selected = "selected"'; ?>>Mystic</option>
          
          <option value="Dark Knight" <?php if (!empty($bdo_class) && $bdo_class == 'Dark Knight') echo 'selected = "selected"'; ?>>Dark Knight</option>
          
          <option value="Tamer" <?php if (!empty($bdo_class) && $bdo_class == 'Tamer') echo 'selected = "selected"'; ?>>Tamer</option>
          
      </select>
                  </td>
      </tr>
      <tr>
              
              <td>
      <label class="renownlabel" for="renown">Renown Score:</label>
              </td>
              <td>
      <input type="text" maxlength="3" id="renown" name="renown" value="<?php if (!empty($renown)) echo $renown; ?>" />    
              </td>        
      </tr>
      
      <tr>
          <td>
      <input id="signupsubmit" class="btn btn-primary" type="submit" value="Sign Up" name="submit" />    
          </td>
      </tr>
  </form>
        </table>
</div>
<div id="registererrors"></div>
<?php
  // Insert the page footer
  require_once('footer.php');
?>
