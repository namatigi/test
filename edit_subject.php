<?php include("includes/connection.php");?>
<?php include("includes/header.php"); ?>
<?php require_once("includes/functions.php");?>
<?php find_selected_page();?>

<?php
    if(intval($_GET['subj'])==0){
        redirect_to("content.php");
    }

    if(isset($_POST['submit'])){
        $errors = array();

        $required_fields = array('menu_name','position','visible');
        foreach($required_fields as $fieldname){
            if(!isset($_POST[$fieldname])||empty($_POST[$fieldname]) && $_POST[$fieldname]!=0){
                $errors[]=$fieldname;
            }
        }

        $field_with_length = array('menu_name'=>30);
        foreach($field_with_length as $fieldname=>$maxlength){
            if(strlen(trim(mysql_prep($_POST[$fieldname])))>$maxlength){
                $errors[]=$fieldname;
            }
        }

        if(empty($errors)){
            $id =mysql_prep($_GET['subj']);
            $menu_name = mysql_prep($_POST['menu_name']);
            $position = mysql_prep($_POST['position']);
            $visible = mysql_prep($_POST['visible']);

            $query = "UPDATE subject SET menu_name ='{$menu_name}',position={$position},visible={$visible} WHERE id ={$id}";
            $result = mysqli_query($link,$query);
            if(mysqli_affected_rows($link)==1){
                //Success.
                $message ="The subject was successfully updated";
            }else{
                $message = "The subject failed to update.";
                $message .="<br/>".mysqli_error($link);
            }
        }else{
                //Errors occurred.
            $message = "There were ".count($errors) ." errors in the form.";
        }



    }#end of isset $POST.

?>

<table id="structure">
    <tr>
        <td id="navigation">
            <?php echo navigation($sel_subject,$sel_page); ?>
        </td>
        <td id="page">

            <h2>Edit Subject:<?php echo $sel_subject['menu_name']; ?></h2>
            <?php if(!empty($message)){echo "<p class=\"message\">" .$message ."</p>";}?>
            <?php
                //output a list of the fields that had errors.
            if(!empty($errors)){
                echo "<p class=\"error\">";
                echo "Please review the following fields: <br/>";
                foreach($errors as $error){
                    echo " - ".$error. "<br/>";
                }

                echo "</p>";
            }
            ?>
            <form action="edit_subject.php?subj=<?php echo urlencode($sel_subject['id']);?>" method="post">
                <p>Subject name:
                    <input type="text" name="menu_name" value="<?php echo $sel_subject['menu_name'];?>" id="menu_name"/>
                </p>
                <p>Position:
                    <select name="position">
                        <?php
                                    echo "<option value=\"{$sel_subject['position']}\">{$sel_subject['position']}</option>";
                        ?>

                    </select>
                </p>
                <p>Visible:
                    <?php
                        if($sel_subject['visible']==0){
                            echo "<input type=\"radio\" name=\"visible\" value=\"0\" checked/>No &nbsp;";
                            echo "<input type=\"radio\" name=\"visible\" value=\"1\"/>Yes";
                        }else{
                            echo "<input type=\"radio\" name=\"visible\" value=\"0\"/>No &nbsp;";
                            echo "<input type=\"radio\" name=\"visible\" value=\"1\" checked/>Yes";
                        }
                    ?>


                </p>
                <input type="submit"  name ="submit" value="Edit Subject"/>&nbsp;&nbsp;&nbsp;
                <a href="delete_subject.php?subj=<?php echo urlencode($sel_subject['id']);?>" onclick="return confirm('Are you sure?');">Delete Subject</a>
            </form>

            <br/>
            <a href="new_page.php">+Add Page</a>&nbsp;&nbsp;

            <a href="content.php">Cancel</a>

        </td>
    </tr>
</table>





<?php include("includes/footer.php");?>
 