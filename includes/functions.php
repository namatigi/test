<?php
/**
 * Created by PhpStorm.
 * User: xnet1872
 * Date: 24/06/2017
 * Time: 08:16
 */
#require_once("includes/connection.php");
#This file is the place to store all basic function.


    function mysql_prep($value){
        $magic_quotes_active = get_magic_quotes_gpc();

        $new_enough_php =function_exists("mysql_real_escape_string"); // PHP >=4.3.0

        if($new_enough_php){
            #PHP higher than v4.3.0
            if($magic_quotes_active){$value = stripslashes($value);}
            $value = mysqli_real_escape_string($value);
        } else{
                if(!$magic_quotes_active){$value=addslashes($value);}
            }
        return $value;

    }

    function redirect_to($location=NULL){
        if($location!=NULL){
            header("Location:{$location}");
            exit;
        }

    }

    function confirm_query($result_set){
        if(!$result_set){
            die("Database query failed: ".mysqli_connect_error());
        }
    }


    function get_all_subjects(){
        global $link;
        $query = "SELECT *  FROM subject ORDER BY position ASC";

        $subject_set=mysqli_query($link,$query);
        confirm_query($subject_set);

        return $subject_set;
    }


    function get_pages_for_subject($subject_id){
        global $link;
        $query="SELECT * FROM pages WHERE subject_id={$subject_id} ORDER BY position ASC";

        $page_set = mysqli_query($link,$query);
        confirm_query($page_set);
        return $page_set;
    }


    function get_subject_by_id($subject_id){
        global $link;
        $query="SELECT * ";
        $query .="FROM subject ";
        $query .="WHERE id=".$subject_id." ";
        $query .="LIMIT 1";

        $result_set =mysqli_query($link,$query);
        confirm_query($result_set);
        // if no rows are returned,fetch_array will return false
        if($subject = mysqli_fetch_array($result_set)){
            return $subject;
        }else{
            return NULL;
        }
    }

    function get_page_by_id($page_id){
        global $link;
        $query = "SELECT * ";
        $query .="FROM pages ";
        $query .="WHERE id=" .$page_id. " ";
        $query .="LIMIT 1";

        $result_set = mysqli_query($link,$query);

        confirm_query($result_set);

        if($page = mysqli_fetch_array($result_set)){
            return $page;
        }else{
            return NULL;
        }
    }


    function find_selected_page(){
        global $sel_subject;
        global $sel_pages;
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
    }
?>