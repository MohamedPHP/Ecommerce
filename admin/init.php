<?php
	include "connect.php";

	//Routs

	$tpl = 'includes/templates/'; //template directory

	$lang = "includes/languages/";//Languages directory

	$func = "includes/functions/";//functions directory

	$css = 'layout/css/'; //css directory

	$js = 'layout/js/'; //js directory

	//Important
	include $func . "functions.php";

	include $lang . "english.php";

	include $tpl . "header.php";



	// check the navbar

	if (!isset($noNavbar)){
		include $tpl . "navbar.php";
		}
