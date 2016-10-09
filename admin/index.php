<?php
	session_start();
	$noNavbar = "";
	$pageTitle = "Login";
	if(isset($_SESSION["Username"])){
		header("Location: dashboard.php");
		}
	include "init.php";

	// check the request method
	if($_SERVER["REQUEST_METHOD"] == "POST"){

		$username = $_POST["username"];

		$password = $_POST["password"];

		$hashedpass = sha1($password);

		// check if user exsit in the data base

		$stmt = $conn->prepare("SELECT
										UserID, Username, Password
									FROM
										users
									WHERE
										Username = ?
									AND
										Password = ?
									AND
										GroupID = 1
									LIMIT 1");

		$stmt->execute(array($username, $hashedpass));

		$row = $stmt->fetch();

		$count = $stmt->rowCount();

		// if count > 0 means database contains information

		if($count > 0){

			$_SESSION["Username"] = $username; //Register the sission name

			$_SESSION["ID"] = $row["UserID"]; //Register the sission ID

			header("Location: dashboard.php");//Redirect the user to the dashboard

			exit();

			}

		}

	?>
<link href="Layout/css/bootstrap.min.css" rel="stylesheet" type="text/css">

    <form class="login" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
        <h4 class="text-center">Admin Login</h4>
        <input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off" />
        <input class="form-control" type="password" name="password" placeholder="Password" autocomplete="off" />
        <input class="btn btn-primary btn-block" type="submit" value="LogIn" />
    </form>






<?php include $tpl . "footer.php";?>
