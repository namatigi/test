<?php include("includes/connection.php");?>
<?php include("includes/header.php"); ?>

<?php require_once("includes/functions.php");?>
<?php
if(isset($_GET['subj'])){
    $sel_subj =$_GET['subj'];
    $sel_subject= get_subject_by_id($sel_subj);
    $sel_pages=NULL;
    $sel_pg=0;
}elseif(isset($_GET['page'])){
    $sel_subj=0;
    $sel_subject=NULL;
    $sel_pages = $_GET['page'];
    $sel_pages = get_page_by_id($sel_pages);
}else{
    $sel_pages=NULL;
    $sel_subject=NULL;
    $sel_pg=0;
    $sel_subj=0;
}

?>

<?php
    if(intval($_GET['subj'])==0){
        redirect_to("content.php");
    }

    if(isset($_POST['submit'])){
        $errors = array();

        $required_fields = array('menu_name','position','visible');
        foreach($required_fields as $fieldname){
            if(!isset($_POST[$fieldname])||empty($_POST[$fieldname])){
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
            $id=mysql_prep($_GET['subj']);
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
            <ul class="subjects">
                <?php

                #subject database query
                $subject_set=get_all_subjects();

                #use returned subjects
                while($subject=mysqli_fetch_array($subject_set)) {
                    echo "<li ";
                    if($subject["id"]==$sel_subj) {
                        echo "class=\"selected\"";
                    }
                    echo "><a href=\"edit_subject.php?subj=" .urlencode($subject["id"])."\">
                 {$subject['menu_name']}
                </a></li>";

                    #pages database query.
                    $page_set=get_pages_for_subject($subject["id"]);

                    #use returned pages
                    echo "<ul class=\"pages\">";
                    while ($page = mysqli_fetch_array($page_set)) {
                        echo "<li ";
                        if($page["id"]==$sel_pages ) {
                            echo "class=\"selected\"";
                        }
                        echo "><a href=\"content.php?page=" .urlencode($page["id"])."\">
                    {$page['menu_name']}
                    </a></li>";
                    }

                    echo "</ul>";

                }

                ?>
            </ul>



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

            <a href="content.php">Cancel</a>

        </td>
    </tr>
</table>





<?php include("includes/footer.php");?>
 