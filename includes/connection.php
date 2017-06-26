<?php
/**
 * Created by PhpStorm.
 * User: xnet1872
 * Date: 24/06/2017
 * Time: 22:45
 */

require("constants.php");
#Create a database connection.

    $link = mysqli_connect(DB_SERVER,DB_USER,DB_PASS);

    if(!$link){
        die("Connection to database failed: " .mysqli_connect_error());
    }

#select database

    $db_select = mysqli_select_db($link,DB_NAME);

    if(!$db_select){
        die("Database selection failed: ".mysqli_connect_error());
    }