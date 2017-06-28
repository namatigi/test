<?php require_once("includes/session.php"); ?>
<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php"); ?>

<?php
       if(logged_in()){
           redirect_to("staff.php");
       }
include_once("includes/form_functions.php");

//START FORM PROCESSING.
if(isset($_POST['submit'])){
    //Form has been submitted.

    $errors = array();


    $required_field=array("username","password");
    $errors =array_merge($errors,check_required_fields($required_field));


    $field_with_length=array("username"=>40);
    $errors = array_merge($errors,check_max_field_lengths($field_with_length));

    $username = trim(mysql_prep($_POST['username']));
    $password = trim(mysql_prep($_POST['password']));
    $hashed_password = sha1($password);


    if(empty($errors)){
        $query = "SELECT id,username FROM users WHERE username='{$username}' AND hashed_password = '{$hashed_password}' LIMIT 1";

        $user = mysqli_query($link,$query);
//        $users = mysqli_fetch_array($result);
//        var_dump($users);die();
//        var_dump($users);die();
//        foreach($users as $user){
//            if($user['username']==$username && $user['hashed_password']==$hashed_password){
            if(mysqli_num_rows($user)==1){
                $found_user = mysqli_fetch_array($user);
                $_SESSION['user_id']=$found_user['id'];
                $_SESSION['username']=$found_user['username'];
                redirect_to("staff.php");
            }else{
                $message = "Wrong credentials";
                $message .="<br/>". mysqli_error($link);
            }
        } else{
        if(count($errors)==1){
            $message ="There was 1 error in the form";
        }else{
            $message ="There were " . count($errors) . " errors in the form.";
        }
    }
}else{
    if(isset($_GET['logout'])&&$_GET['logout']==1){
        $message = "You are now logged out";
    }
    $username = "";
    $password = "";
}

?>

<?php include("includes/header.php"); ?>
    <table id="structure">
        <tr>
            <td id="navigation">
                <a href="staff.php">Return to Menu</a><br/>
            </td>
            <td id="page">
                <h2>Create New User</h2>
                <?php if(!empty($message)){echo "<p class=\"message\">" .$message . "</p>";} ?>
                <?php if(!empty($errors)){display_errors($errors);} ?>

                <form action="login.php" method="post">

                    <table>
                        <tr>
                            <td>Username:</td>
                            <td><input type="text" name="username" maxlength="40" value="<?php echo htmlentities($username);?>" </td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type="password" name="password" maxlength="40" value="<?php echo htmlentities($password);?>" </td>
                        </tr>
                        <tr>
                            <td colspan="2"><input type="submit" name="submit" value="Login"/></td>
                        </tr>
                    </table>
                </form>
            </td>
        </tr>
    </table>


<?php include("includes/footer.php"); ?>