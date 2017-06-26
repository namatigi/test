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
                    echo "><a href=\"content.php?subj=" .urlencode($subject["id"])."\">
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

            <h2>Add Page</h2>
            <form action="create_subject.php" method="post">
                <p>Page name:
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

                <p><textarea name="content" rows="10" cols="50">

                    </textarea></p>
                <input type="submit" value="Add page"/>
            </form>

            <br/>

            <a href="content.php">Cancel</a>&nbsp;&nbsp;



        </td>
    </tr>
</table>





<?php include("includes/footer.php");?>
