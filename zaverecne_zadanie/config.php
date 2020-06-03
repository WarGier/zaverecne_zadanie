<?php
session_start();

if(!isset($_SESSION['lang'])){
    $_SESSION['lang'] = 'sk';
} else if(isset($_GET['lang']) && $_SESSION['lang'] != $_GET['lang'] && !empty($_GET['lang'])){
    if($_GET['lang'] == 'sk'){
        $_SESSION['lang'] = 'sk';
    }else{
        $_SESSION['lang'] = 'en';
    }
}

require_once "languages/" . $_SESSION['lang'] . ".php";

define("HOSTNAME", "localhost");
define("USERNAME", "xtrcalek");
define("PASSWORD", "maslovka_nefonovali");
define("DBNAME", "LoginData");


$link = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DBNAME);
if (!$link) {
    die('Connect Error (' . mysqli_connect_errno() . ')' . mysqli_connect_error());
}
//echo mysqli_get_host_info($link);
if (!mysqli_set_charset($link, "utf8")) {
    printf("Error loading character set utf8: %s\n", mysqli_error($link));
    exit();
}