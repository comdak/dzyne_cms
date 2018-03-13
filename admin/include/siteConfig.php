<?php

// Database conection && Site Configuration Variables - siteConfig.php
// Written by: Jeff Caldwell (jeff@dzyne.ca)

$httphost = $_SERVER['HTTP_HOST'];
$cleanHost = str_ireplace("www.", "", $httphost);
$dbaddr = "localhost";
$dbuser = "USER_GOES_HERE";
$dbpass = "PASS_GOES_HERE";

mysql_connect($dbaddr, $dbuser, $dbpass)
	or die(mysql_error());

$dbname = "DBNAME_GOES_HERE";

mysql_select_db($dbname)
	or die(mysql_error());

$sql = "SELECT homedir,sitename,imgpath,filepath,mainpage,mainnav,metakeywords,metadesc FROM siteconfig WHERE id='1'";
$result = mysql_query($sql);

$homedir 				= mysql_result($result, 0, "homedir");
$sitename				= mysql_result($result, 0, "sitename");
$imgpath				= mysql_result($result, 0, "imgpath");
$filepath				= mysql_result($result, 0, "filepath");
$mainpage				= mysql_result($result, 0, "mainpage");
$mainnav				= mysql_result($result, 0, "mainnav");
$metakeywords			= mysql_result($result, 0, "metakeywords");
$metadesc				= mysql_result($result, 0, "metadesc");
?>
