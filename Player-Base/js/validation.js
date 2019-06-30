
//Function that will validate the registration information
function validateRegistration(){
    var a = document.forms["registerform"]["bdo_username"].value;
    var b = document.forms["registerform"]["bdo_password"].value;
    var c = document.forms["registerform"]["bdo_password2"].value;
    var d = document.forms["registerform"]["char_name"].value;
    var e = document.forms["registerform"]["level"].value;
    var f = document.forms["registerform"]["bdo_class"].value;
    var g = document.forms["registerform"]["renown"].value;
    var errors = document.getElementById["registererrors"];
    
    if(a.length < 1){
        errors.innerHTML += '<p class="error">Please enter a username to register.</p>';
        return false;
    } else if(b.length < 1){
        errors.innerHTML += '<p class="error">Please enter a password to register.</p>';
        return false;
    } else if(c.length < 1){
        errors.innerHTML += '<p class="error">Please confirm your password.</p>';
        return false;
    } else if(d.length < 3){
        errors.innerHTML += '<p class="error">Character name must be at least 3 characters long.</p>';
        return false;
    } else if(d.length > 16){
        errors.innerHTML += '<p class="error">Character name can not be longer than 16 characters.</p>';
        return false;
    } else if(e.length < 1){
        errors.innerHTML += '<p class="error">Character level can not be 0.</p>';
        return false;
    } else if(parseInt(e) > 64){
        errors.innerHTML += '<p class="error">Character level can not be greater than 64.</p>';
        return false;
    } else if(parseInt(e) < 1){
        errors.innerHTML += '<p class="error">Character level must be at least level 1.</p>';
        return false;
    } else if(g.length < 1){
        errors.innerHTML += '<p class="error">Renown can\'t be blank, if renown is 0 put 0.</p>';
        return false;
    } else if(g.length > 3){
        errors.innerHTML += '<p class="error">Renown score can only be 3 numeric charactes long.</p>';
        return false;      
              
    } else{
        return true;
    }
    
    
    
    
}

//Function that will validate login information
function validateLogin(){
    
    var x = document.forms["loginform"]["bdo_username"].value;
    var y = document.forms["loginform"]["bdo_password"].value;
    var z = document.getElementById("loginerrors");
    
    
    //checking if username is not empty
    if(x.length < 1){
        z.innerHTML += '<p class="error">Please enter a username to login.</p>';
        return false;
    } else if(y.length <1){
        z.innerHTML += '<p class="error">Please enter a password to login.</p>';
        return false;   
    } else{
        return true;
    }
    
    
    
    
}


function getTwitchstuff()
{
    curl -H 'Client-ID: w0wrpo7g51ewsm6afydijhhvma29xv' \
-X GET 'https://api.twitch.tv/helix/streams?game_id=33214'
    
    
}
