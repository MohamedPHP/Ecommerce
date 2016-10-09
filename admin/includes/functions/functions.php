<?php
	/*
		set the page title
	*/
	function getTitle(){

		global $pageTitle;

		if(isset($pageTitle)){

			echo $pageTitle;

			}
		else{

			echo "Defult";

			}

		}

		/*
		** Redirect Function v2.0
		** Redirect Function
		** This Function Accept Parameters
		** $url => the redirect link [ home, back , ect... ]
		** $theMsg , $Seconds => [ Error, Success, alert ]
		*/

		function RedirectFunc($theMsg, $url = null, $Seconds = 3)
		{
			if($url === null){

				$url = 'index.php';

				$link = "Home Page";

			} else {

				if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){

					$url = $_SERVER['HTTP_REFERER'];

					$link = "Prevuios Page";

				}else{

					$url = 'index.php';

					$link = "Home Page";

				}

			}

			echo $theMsg;

			echo "<div class='alert alert-info'>You Will Redirected To $link After $Seconds Seconds</div>";

			header("refresh:$Seconds;url=$url");
		}

		/*
		** Function To Chek Items In Data Base v1.0
		** Function To Chek Items In Data Base [ Function Accept Parameter ]
		** $select Item To Select [ user, item, anything, cat ]
		** $from The table to select from [  ]
		** $value = the val of select ex [ "mohamed", 'box', 'electronics' ]
		*/
		function checkItems($select, $from, $value){
			global $conn;

			$statment = $conn->prepare("SELECT $select FROM $from WHERE $select = ?");

			$statment->execute(array($value));

			$count = $statment->rowCount();

			return $count;

		}

		/*
		** count number of items v1.0
		** funtion to count nuber of items
		** $item = the selected item
		** $table = the table to select from
		*/

		function countItems($item, $table) {

			global $conn;

			$stmt2 = $conn->prepare("SELECT COUNT($item) FROM $table");

			$stmt2->execute();

			return $stmt2->fetchColumn();
		}


		/*
		** get latest record func v1.0
		** function to get latest items from database [ Users | items ]
		** $select = the item that will be selected
		** $from = the table to select from
		** $order the ordring method [ Userid ]
		** $limit the limit of selection
		*/

		function getlatest($select, $from, $order, $limit = 5) {
			global $conn;

			$stmt = $conn->prepare("SELECT $select FROM $from ORDER BY $order DESC LIMIT $limit");

			$stmt->execute();

			$rows = $stmt->fetchAll();

			return $rows;
		}
