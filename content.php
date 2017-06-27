<?php include("includes/connection.php");?>
<?php include("includes/header.php"); ?>
<?php require_once("includes/functions.php");?>
<?php find_selected_page();?>

<table id="structure">
    <tr>

    <!--Left pane menu-->
        <td id="navigation">
            <?php echo navigation($sel_subject,$sel_page); ?>
            <br/>
            <a href="new_subject.php ">+ Add a new subject</a>
        </td>


    <!--Right pane display    -->
        <td id="page">
            <?php if(!is_null($sel_subject)){//subject selected ?>
            <h2><?php echo $sel_subject['menu_name']; ?></h2>
            <?php }elseif(!is_null($sel_page)){//page selected ?>
            <h2><?php echo $sel_page['menu_name']; ?></h2>
                <div class="page-content">
                    <?php echo $sel_page['content']; ?>
                </div>
            <?php }else {//nothing selected ?>
            <h2>Select a subject or page to edit</h2>
            <?php } ?>
            <br/><br>
            <a href="edit_page.php?page=<?php echo$sel_page["id"]?>">Edit Page</a>
        </td>

    </tr>
</table>

<?php include("includes/footer.php");?>
