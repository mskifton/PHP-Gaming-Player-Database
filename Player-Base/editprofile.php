<?php
  // Start the session
require_once('startsession.php');
require_once('controller/Controller.php');
//instantiating controller
$controller = new Controller();

  
// Insert the page header 
$page_title = 'View Profile';
  
//inserting the header,app and connect vars
require_once('header.php');
require_once('appvars.php');
require_once('connectvars.php');

  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['bdo_user_id'])) {
    echo '<p class="login">Please <a href="login.php">Log In</a> to access this page.</p>';
    exit();
  }

// Show the navigation menu
require_once('navmenu.php');
?>
<div id="mainContentArea">
<h1>Edit Profile</h1>
<?php

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST form submission
    $char_name = mysqli_real_escape_string($dbc, trim($_POST['char_name']));
    $bdo_class = mysqli_real_escape_string($dbc, trim($_POST['bdo_class']));
    $level = mysqli_real_escape_string($dbc, trim($_POST['level']));
    $renown = mysqli_real_escape_string($dbc, trim($_POST['renown']));
    $old_picture = mysqli_real_escape_string($dbc, trim($_POST['old_picture']));
    $new_picture = mysqli_real_escape_string($dbc, trim($_FILES['new_picture']['name']));
    $new_picture_type = $_FILES['new_picture']['type'];
    $new_picture_size = $_FILES['new_picture']['size']; 
    $error = false;

    // Validate and move the uploaded picture file, if necessary
    if (!empty($new_picture)) {
      if ((($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') ||
        ($new_picture_type == 'image/png')) && ($new_picture_size > 0) && ($new_picture_size <= MM_MAXFILESIZE) &&
        ($new_picture_width <= MM_MAXIMGWIDTH) && ($new_picture_height <= MM_MAXIMGHEIGHT)) {
        if ($_FILES['file']['error'] == 0) {
          // Move the file to the target upload folder
          $target = MM_UPLOADPATH . basename($new_picture);
          if (move_uploaded_file($_FILES['new_picture']['tmp_name'], $target)) {
            // The new picture file move was successful, now make sure any old picture is deleted
            if (!empty($old_picture) && ($old_picture != $new_picture)) {
              @unlink(MM_UPLOADPATH . $old_picture);
            }
          }
          else {
            // The new picture file move failed, so delete the temporary file and set the error flag
            @unlink($_FILES['new_picture']['tmp_name']);
            $error = true;
            echo '<p class="error">Sorry, there was a problem uploading your picture.</p>';
          }
        }
      }
      else {
        // The new picture file is not valid, so delete the temporary file and set the error flag
        @unlink($_FILES['new_picture']['tmp_name']);
        $error = true;
        echo '<p class="error">Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (MM_MAXFILESIZE / 1024) .
          ' KB and ' . MM_MAXIMGWIDTH . 'x' . MM_MAXIMGHEIGHT . ' pixels in size.</p>';
      }
    } 
      

    // Update the profile data in the database

      if (!$error) {
          //being validation
          
        //checks if character name is empty
        if(empty($char_name)){
            echo '<p class="error">Your character name can not be blank.</p>';
        }
        
        //validates char name is not numeric
        if(is_numeric($char_name)){
            echo '<p class="error">Your character name can not be numbers only.</p>';
        }
        
        //checks if character name string is at least 3 characters but less than 16
        if((strlen($char_name)) > 16 || (strlen($char_name)) < 3 ) {
          echo '<p class="error">Your Character\'s Name must be at least 3 characters long and no longer than 16 characters.</p>';
        } 
    
        
        //checking if level is blank
        if(empty($level)){
            echo '<p class="error">Your character level can not be blank.</p>';
        } 
        
        //checking is level field has anything but numbers
        if(!is_numeric($level)){
            echo '<p class="error">Your character level can only be a number no higher than 64 or lower than 1.</p>';
        }
        
        //checking if character level is longer than 2 characters
        if((strlen($level)) > 2){
            echo '<p class="error">Your character level can only be a maximum of 2 numeric characters long.</p>';
        }
        
        //checks renown score input to see if it is blank
        if(empty($renown)){
            echo '<p class="error">Your character renown score can not be blank.</p>';
            
        }
        
        //checks renown to see if it is anything else but a number
        if(!is_numeric($renown)){
            echo '<p class="error">Your character renown score must be a number.</p>';
        }
        
        //checking if character renown score is greater than 3 characters
        if((strlen($renown)) > 3){
            echo '<p class="error">Your character renown score can only be a maximum of 3 numeric characters long.</p>';
            
        }
        
        //Checking if level is less than 1
        if((intval($level)) < 1){
            echo '<p class="error">Your character level can not be 0 or less than.</p>';
        }
        
        //level cant be greater than 64
        if(intval($level) > 64){
            echo '<p class="error">Your character level can not be higher than 64.</p>';
        }
        
        //level cant be less than 0
        if((intval($renown)) < 0){
            echo '<p class="error">Your character renown score can not be less than 0.</p>';
        }
        
        
        //If the inputs validate continue
      if (!empty($char_name) && !is_numeric($char_name) && !empty($bdo_class) && !empty($level) && !empty($renown) && is_numeric($level) && is_numeric($renown) && ((strlen($level)) > 0 && (strlen($level) < 3)) &&((strlen($renown)) < 4 && ((strlen($renown)) > 0 ) ) && ((intval($level)) > 0 && (intval($level)) < 65) && ((intval($renown)) >= 0 ) && ((strlen($char_name)) > 2 || (strlen($char_name)) < 17 )) {
        // Only set the picture column if there is a new picture
        if (!empty($new_picture)) {
            
            //Controller call to update if no pic
            $controller->updateWithPic($char_name, $bdo_class, $level, $renown, $new_picture);

        } else if(empty($new_picture)) {
            //Controller call to update with pic       
            $controller->updateNoPic($char_name, $bdo_class, $level, $renown);

        }

        // Confirm success redirects back to view profile page after submitting changes
            $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/viewprofile.php';
          header('Location: ' . $home_url);
        mysqli_close($dbc);
        exit();
      }

    }
  } // End of check for form submission
  else {
     //Find profile data 
     $profile_data = $controller->showProfileData();


      //if there is profile data to show then grab and show
    if ($profile_data != NULL) {
      $char_name = $profile_data['char_name'];
      $bdo_class = $profile_data['class'];
      $level = $profile_data['level'];
      $renown = $profile_data['renown']; 
      $old_picture = $profile_data['pic'];
    }
    else {
      echo '<p class="error">No profile information to display.</p>';
    }
  }

  mysqli_close($dbc);
?>

    <table cellpadding="10" align="center" class="editproftable table-dark table-hover table-bordered">
  <form class="edtproform" onsubmit="validateRegistration()" enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />

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
          <label for="bdo_class">Character Class:</label>
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
          <label for="level">Character Level:</label>
          </td>
          
          <td>
      <input type="text" maxlength="2" id="level" name="level" value="<?php if (!empty($level)) echo $level; ?>" />
          </td>
      </tr>
      <tr>
          <td>
          <label for="renown">Renown Score:</label>
          </td>
          <td>
      <input type="text" id="renown" maxlength="3" name="renown" value="<?php if (!empty($renown)) echo $renown;?>" />       
          </td>
      </tr>
        
      <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>" />
      <tr>
          <td>
      <label for="new_picture">Current Gear Score Picture:</label>
              <input type="file" class="form-control-file" id="new_picture" name="new_picture" />
          </td>
          <td>
      <?php if (!empty($old_picture)) {
        echo '<img height="325" width="225" class="profile" src="' . MM_UPLOADPATH . $old_picture . '" alt="Profile Picture" />';
      } ?>
          </td>
      </tr>
      <tr>
          <td>
    <input class="btn btn-primary" type="submit" value="Save Profile" name="submit" />
          </td>
      </tr>
  
        </form>
        
    </table>

</div>
<?php
  // Insert the page footer
  require_once('footer.php');
?>
