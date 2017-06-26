<?php require_once("includes/connection.php");?>
<?php require_once("includes/functions.php");?>


<?php
    if(intval($_GET['subj'])==0){
        redirect_to("content.php");
    }

    $id = mysql_prep($_GET['subj']);

    if($subject=get_subject_by_id($id)){



    $query = "DELETE FROM subject WHERE id ={$id} LIMIT 1";

    $result =mysqli_query($link,$query);

    if(mysqli_affected_rows($link)==1){
        redirect_to("content.php");
    }else{
        //Deletion failed.
        echo "<p>Subject deletion failed.</p>";
        echo "<p>".mysqli_error($link) ."</p>";
        echo "<a href=\"content.php\">Return to Main Page</a>";
    }

    }else{
        //subject did not exist in the database.
        redirect_to("content.php");
    }
?>



<?php mysqli_close($link); ?>