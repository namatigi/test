<?php include("includes/connection.php");?>
<?php include("includes/header.php"); ?>

<?php require_once("includes/functions.php");?>
<?php find_selected_page();?>

<table id="structure">
    <tr>
        <td id="navigation">
            <?php echo navigation($sel_subject,$sel_page,$public=false); ?>
        </td>
        <td id="page">

            <h2>Adding new page</h2>
        <?php if(!empty($message)){echo "<p class=\"message\">" .$message."</p>";}?>

        <?php if(!empty($errors)){display_errors($errors);} ?>

        <form action="new_page.php?subj=<?php ?>" method="post">
            <?php $new_page =true; ?>
            <?php include "page_form.php" ?>

            <input type="submit" name="submit" value=""Create Page" />
        </form>
        <br/>
            <a href="edit_subject.php?subj<?php echo $sel_subject['id'];?>">Cancel</a><br/>
        </td>
    </tr>
</table>

<?php include("includes/footer.php");?>
