<?php
	/*
	==========================================
	== [pagename] page
	== you can EDIT | DELETE | ADD [pagename] page
	==========================================
	*/

	session_start();

	$pageTitle = '';

	if(isset($_SESSION["Username"])){

		include "init.php";

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // Check if the $do is Exixets

		//start [pagename] page

		if ($do == 'Manage') {// if the do is equal manage



		}elseif ($do == 'Add') { // Add Page



		}elseif ($do == 'Insert') { // Insert Page



		}elseif ($do == 'Edit') { // Edit Page



		}elseif ($do == 'Update') { // Update Page



		}elseif ($do == 'Delete') { // Delete Page



		}

		include $tpl . "footer.php";

	} else {

		header("Location: index.php");

		exit();

	}
