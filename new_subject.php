<?php include("includes/connection.php");?>
<?php include("includes/header.php"); ?>
<?php require_once("includes/functions.php");?>
<?php find_selected_page();?>

<table id="structure">
    <tr>
        <td id="navigation">
            <?php echo navigation($sel_subject,$sel_page); ?>
            <br/>
            <a href="new_subject.php ">+ Add a new subject</a>
        </td>
        <td id="page">

            <h2>Add Subject</h2>
            <form action="create_subject.php" method="post">
                <p>Subject name:
                    <input type="text" name="menu_name" value="" id="menu_name"/>
                </p>
                <p>Position:
                    <select name="position">
                        <?php  $subject_set = get_all_subjects();
                                $subject_count = mysqli_num_rows($subject_set);
                                for($count=1;$count<=$subject_count+1;$count++){
                                    echo "<option value=\"{$count}\">{$count}</option>";
                                }
                        ?>

                    </select>
                </p>
                <p>Visible:
                    <input type="radio" name="visible" value="0"/>No &nbsp;
                    <input type="radio" name="visible" value="1"/>Yes
                </p>
                <input type="submit" value="Add Subject"/>
            </form>

            <br/>

            <a href="content.php">Cancel</a>&nbsp;&nbsp;



        </td>
    </tr>
</table>





<?php include("includes/footer.php");?>
