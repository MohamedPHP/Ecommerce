<?php
	function lang($phrase){


			static $lang = array(
				//nav bar links
				"HOME_ADMIN" 	=> "Home",
				"CAT" 			=> "Categores",
				"ITEMS" 		=> "Items",
				"MEMBERS" 		=> "Members",
				"COMMENT" 		=> "Comments",
				"STATISTICS" 	=> "Statistics",
				"LOGS" 			=> "Logs",
				"" => "",
				"" => "",
				"" => "",
				"" => "",
			);

		return $lang[$phrase];

	}
