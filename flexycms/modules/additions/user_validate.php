<?php
global $link;

// has not been defined yet
define("AFIXI_ROOT", $_SERVER['DOCUMENT_ROOT']."/flexycms/");

$_SESSION['site_used'] = !empty($_SESSION['site_used'])?$_SESSION['site_used']:$_SERVER["HTTP_HOST"];

$_SESSION['site_used'] = preg_replace("/www./","",$_SESSION['site_used']);

if(!defined("SITE_USED") || $_SESSION['site_used'] != SITE_USED ){

	define("SITE_USED",$_SESSION['site_used']);

}

include_once(AFIXI_ROOT."configs/".SITE_USED."/constants.php");

$link = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_DB);

//end

$myusername = mysql_real_escape_string(stripslashes(trim($_POST['username'])));

if (!preg_match("/^[a-z0-9_-]{4,20}$/i", $myusername))   {
	echo 'specific_character_error';
} else if (preg_match("/[&<>%\*\,\.]/i", $myusername)) {
	echo 'specific_character_error';	
}else {
	$check_table="SELECT COUNT(*) FROM ".TABLE_PREFIX."user WHERE username='".$myusername."'";
	//var_dump($check_table);			
	$result = mysqli_query($link, $check_table) or die(mysqli_error());
		
	$row = mysqli_fetch_assoc($result); 
		
	//var_dump($row['COUNT(*)']);
	
	if ( $row['COUNT(*)'] != 0 ) {
	    echo 'already_exists';
	} else {
		echo 'continue';
	}
}

?>
