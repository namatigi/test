<?php require_once("includes/connection.php"); ?>
<?php include("includes/header.php");?>
<?php require_once("includes/functions.php");?>



<?php find_selected_page() ?>

<table id="structure">
    <tr>
        <td id="navigation">
            <?php echo public_navigation($sel_subject,$sel_page); ?>
        </td>

        <td id="page">
            <?php if($sel_page){ ?>
            <h2><?php echo htmlentities($sel_page['menu_name']); ?></h2>
            <div class="page-content">
                <?php echo strip_tags($sel_page['content'],"<b><br><p><a>"); ?>
            </div>
            <?php }else{ ?>
                <h2>Welcome to Osim101</h2>
            <?php } ?>
        </td>
    </tr>
</table>

<?php include("includes/footer.php") ?>
