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
                    if($page["id"]==$sel_pages) {
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
            <br/>
            <a href="new_subject.php ">+Add a new subject</a>
        </td>
        <td id="page">

            <?php if(!is_null($sel_subject)){//subject selected ?>
            <h2><?php echo $sel_subject['menu_name']; ?></h2>
            <?php }elseif(!is_null($sel_pages)){//page selected ?>
            <h2><?php echo $sel_pages['menu_name']; ?></h2>
                <div class="page-content">
                    <?php echo $sel_pages['content']; ?>
                </div>
            <?php }else {//nothing selected ?>
            <h2>Select a subject or page to edit</h2>
            <?php } ?>

        </td>
    </tr>
</table>





<?php include("includes/footer.php");?>
