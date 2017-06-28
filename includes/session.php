<?php session_start();?>

<?php
function logged_in(){
    return isset($_SESSION['user_id']);
    }


function confirm_logged_in(){
    if(!logged_in()){
        redirect_to("login.php");
    }
}



?>