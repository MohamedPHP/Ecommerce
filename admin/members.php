<?php
	/*
	==========================================
	== Members page
	==you can EDIT | DELETE | ADD Members page
	==========================================
	*/

	session_start();

	$pageTitle = 'Members';

	if(isset($_SESSION["Username"])){

		include "init.php";

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // Check if the $do is Exixets

		//start manage page

		if ($do == 'Manage') {// if the do is equal manage

			$query = '';

			if (isset($_GET['page']) && $_GET['page'] == 'bending') {
				$query = 'AND RegStatus = 0';
			}

			//select all users exept admin

			$stmt = $conn->prepare("SELECT * FROM users WHERE GroupID != 1 $query");

			//Execute the statment

			$stmt->execute();

			$rows = $stmt->fetchAll();

			?>
			<h1 class="text-center Head">Manage Page</h1>
			<div class="container">
			<?php
			if(!empty($rows)){
			?>
				<div class="table-responsive">
					<table class="table table-bordered main-table text-center">
						<tr>
							<td>ID</td>
							<td>Username</td>
							<td>Email</td>
							<td>Full Name</td>
							<td>Regestration Date</td>
							<td>Control</td>
						</tr>
						<?php foreach ($rows as $row) { ?>
						<tr>
							<td><?php echo $row['UserID'] ?></td>
							<td><?php echo $row['Username'] ?></td>
							<td><?php echo $row['Email'] ?></td>
							<td><?php echo $row['FullName'] ?></td>
							<td><?php echo $row['RegDate'] ?></td>
							<td>
								<a href="members.php?do=Edit&userid= <?php echo $row['UserID'] ?>" class="btn btn-success"><i class='fa fa-edit'></i>Edit</a>
								<a href="members.php?do=Delete&userid= <?php echo $row['UserID'] ?>" class="btn btn-danger confirm"><i class='fa fa-close'></i>Delete</a>
								<?php
									if ($row['RegStatus'] == 0) {
										echo "<a href='members.php?do=Activate&userid= ".$row['UserID']."' class='btn btn-info'><i class='fa fa-check'></i>Activate</a>";
									}
								?>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<?php
				}else {
					echo "<div class='alert alert-info'>There is no Members In The Data Base</div>";
				}
				?>
				<a href='members.php?do=Add' class="btn btn-primary" >
					<i class="fa fa-plus"></i>
					Add New Member
				</a>
			</div>

<?php	}elseif ($do == 'Add') {// Add Members?>

			<h1 class='text-center Head'>Add New Member</h1>
			<div class='container'>
				<form class="form-horizontal" action="?do=Insert" method='POST'>
					<!--Start Username Feiled-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Username</label>
                        <div class="col-sm-10 col-md-6">
                        	<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Enter The Username" />
                        </div>
                    </div>
                    <!--End Username Feiled-->

                    <!--Start password Feiled-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10  col-md-6">
                        	<input type="password" name="password" class="password form-control" autocomplete="off" placeholder="Enter The password" required="required" />
                        	<i class="show-pass fa fa-eye fa-2x"></i>
                        </div>
                    </div>
                    <!--End password Feiled-->

                    <!--Start E-mail Feiled-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">E-mail</label>
                        <div class="col-sm-10  col-md-6">
                        	<input type="email" name="email" class="form-control" autocomplete="off" required="required" placeholder="Your Email Adress" />
                        </div>
                    </div>
                    <!--End E-mail Feiled-->

                    <!--Start Fullname Feiled-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Full Name</label>
                        <div class="col-sm-10  col-md-6">
                        	<input type="text" name="full" class="form-control" autocomplete="off" required="required" placeholder="Full Name Please" />
                        </div>
                    </div>
                    <!--End Fullname Feiled-->

                    <!--Start Submit Feiled-->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                        	<input type="submit" value="Add Member" class="btn btn-primary btn-lg" />
                        </div>
                    </div>
                    <!--End Fullname Feiled-->
				</form>
			</div>

		<?php

		}elseif ($do == 'Insert') {

			echo '<h1 class="text-center Head">Insert page</h1>';

			echo '<div class="container">';

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$username 	= $_POST['username'];
					$pass 		= $_POST['password'];
					$email 		= $_POST['email'];
					$name 		= $_POST['full'];

					$hashedpass = sha1($_POST['password']);

					// Validation

					$formValidation = array();

					if (strlen($username) < 4) {

						$formValidation[] = 'Username is less than <strong>4 chars</strong>';

					}

					if (strlen($username) > 16) {

						$formValidation[] = 'Username is more than 16 chars';

					}

					if (empty($username)) {

						$formValidation[] = 'You Must Enter the Username';

					}

					if (empty($email)) {

						$formValidation[] = 'You Must Enter the Email';

					}

					if (empty($name)) {

						$formValidation[] = 'You Must Enter the Full Name';

					}

					// Loop into Error Array

					foreach ($formValidation as $error) {

						echo '<div class="alert alert-danger">' . $error . '</div>';

					}

					// if there is no errors update the database

					if (empty($formValidation)) {

						// Check If User Exists in database

						$check = checkItems("Username", "users", $username);

						if($check == 1){

							$theMsg = '<div class="alert alert-danger">Sorry This User Is Already Exsests</div>';

							RedirectFunc($theMsg, 'back', 5);

						}else{

							// Insert Into the database

							$stmt= $conn->prepare("INSERT INTO users(Username, Password, Email, FullName, RegStatus,RegDate) VALUES(:name, :pass, :email, :fullname, 1, now())");

							$stmt->execute(array(

								'name' 		=> $username,
								'pass' 		=> $hashedpass,
								'email' 	=> $email,
								'fullname' 	=> $name

								));

							// Sucess Massge

							$theMsg = '<div class = "alert alert-success">' . $stmt->rowCount() . " Record Inserted </div>";

							RedirectFunc($theMsg, 'back', 5);

						}

					}else {

						$theMsg = "Please Check Errors";

						RedirectFunc($theMsg, 'back', 5);

					}

				}else{

					$theMsg = '<div class="alert alert-danger">You Cant browes this page directly</div>';

					RedirectFunc($theMsg, 5);

				}

			echo '</div>';

		}elseif ($do == 'Edit') { // Edit Page

			// Check that the userid is numeric and exesits

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

			// Select all data From the table of users

			$stmt = $conn->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

			// execute the data

			$stmt->execute(array($userid));

			// Fetch all the data of the user id

			$row = $stmt->fetch();

			// Count the rows

			$count = $stmt->rowCount();

			// if there is such id show the form

			if ($count > 0) { ?>

				<h1 class='text-center Head'>Edit Members</h1>

				<div class='container'>
					<form class="form-horizontal" action="?do=Update" method='POST'>
	                	<input type='hidden' name='userid' value='<?php echo $userid; ?>' />
						<!--Start Username Feiled-->
	                    <div class="form-group form-group-lg">
	                        <label class="col-sm-2 control-label">Username</label>
	                        <div class="col-sm-10 col-md-6">
	                        	<input type="text" value="<?php echo $row['Username'] ?>" name="Username" class="form-control" autocomplete="off" required="required" />
	                        </div>
	                    </div>
	                    <!--End Username Feiled-->

	                    <!--Start password Feiled-->
	                    <div class="form-group form-group-lg">
	                        <label class="col-sm-2 control-label">Password</label>
	                        <div class="col-sm-10  col-md-6">
	                        	<input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>" />
	                        	<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Want To Change" />
	                        </div>
	                    </div>
	                    <!--End password Feiled-->

	                    <!--Start E-mail Feiled-->
	                    <div class="form-group form-group-lg">
	                        <label class="col-sm-2 control-label">E-mail</label>
	                        <div class="col-sm-10  col-md-6">
	                        	<input type="email" value="<?php echo $row['Email'] ?>" name="email" class="form-control" autocomplete="off" required="required" />
	                        </div>
	                    </div>
	                    <!--End E-mail Feiled-->

	                    <!--Start Fullname Feiled-->
	                    <div class="form-group form-group-lg">
	                        <label class="col-sm-2 control-label">Full Name</label>
	                        <div class="col-sm-10  col-md-6">
	                        	<input type="text" value="<?php echo $row['FullName'] ?>" name="full" class="form-control" autocomplete="off" required="required" />
	                        </div>
	                    </div>
	                    <!--End Fullname Feiled-->

	                    <!--Start Submit Feiled-->
	                    <div class="form-group form-group-lg">
	                        <div class="col-sm-offset-2 col-sm-10">
	                        	<input type="submit" value="Save" class="btn btn-primary btn-lg" />
	                        </div>
	                    </div>
	                    <!--End Fullname Feiled-->
					</form>
				</div>

  			<?php

			// if there is no such id show the Error massge

			}else{

  				$theMsg = '<div class="alert alert-danger">There is no such id</div>';

				echo "<div class='container'>";

				RedirectFunc($theMsg, 'back', 5);

				echo "</div>";

			}

		}elseif ($do == 'Update') {

			echo '<h1 class="text-center Head">Update page</h1>';
			echo '<div class="container">';
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$id 		= $_POST['userid'];
					$username 	= $_POST['Username'];
					$email 		= $_POST['email'];
					$name 		= $_POST['full'];

					// Password Tric

					$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

					// Validation

					$formValidation = array();

					if (strlen($username) < 4) {

						$formValidation[] = 'Username is less than <strong>4 chars</strong>';

					}

					if (strlen($username) > 16) {

						$formValidation[] = 'Username is more than 16 chars';

					}

					if (empty($username)) {

						$formValidation[] = 'You Must Enter the Username';

					}

					if (empty($email)) {

						$formValidation[] = 'You Must Enter the Email';

					}

					if (empty($name)) {

						$formValidation[] = 'You Must Enter the Full Name';

					}

					// Loop into Error Array

					foreach ($formValidation as $error) {

						echo "<div class='alert alert-danger'>".$error."</div>";

					}

					// if there is no errors update the database

					if (empty($formValidation)) {


						$stmt = $conn->prepare("SELECT * FROM users WHERE Username = ? AND UserID != ?");
						$stmt->execute(array($username, $id));
						$count = $stmt->rowCount();

						if ($count == 1){
							$theMsg = '<div class="alert alert-danger">Sorry This Username Is Used</div>';
							RedirectFunc($theMsg, 'back', 3);
						}else {
							// Update the database

							$stmt = $conn->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, Password = ? WHERE UserID = ?");

							$stmt->execute(array($username, $email, $name, $pass, $id));

							// Sucess

							$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Updated </div>";

							RedirectFunc($theMsg, 'back', 5);
						}
					} else {

						$theMsg = "<div class='alert alert-danger'>Please Check the Errors</div>";

						RedirectFunc($theMsg, 'back', 20);

					}

				}else{

					$theMsg = '<div class="alert alert-danger">You Cant browes this page directly</div>';

					RedirectFunc($theMsg, 'back', 5);

				}

			echo '</div>';

		}elseif ($do == 'Delete') {

			echo '<h1 class="text-center Head">Delete page</h1>';

			echo '<div class="container">';

				// Check that the userid is numeric and exesits

				$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

				// Select all data From the table of users

				$stmt = $conn->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

				// execute the data

				$stmt->execute(array($userid));


				// Count the rows

				$count = $stmt->rowCount();

				// if there is such id show the form

				if ($count > 0) {

						$stmt = $conn->prepare("DELETE FROM users WHERE UserID = ?");

						$stmt->execute(array($userid));

						$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Deleted </div>";

						RedirectFunc($theMsg, 'back', 5);


				}else{


					$theMsg = 'This id is not exesist';

						RedirectFunc($theMsg, 'back', 5);

				}

			echo "</div>";

		} elseif ($do = 'Activate') {

			echo '<h1 class="text-center Head">Activate page</h1>';

			echo '<div class="container">';

			// Check that the userid is numeric and exesits

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

			// Select all data From the table of users

			$stmt = $conn->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

			// execute the data

			$stmt->execute(array($userid));


			// Count the rows

			$count = $stmt->rowCount();

			// if there is such id show the form

			if ($count > 0) {

				$stmt = $conn->prepare("UPDATE users SET RegStatus = 1 WHERE UserID = ?");

				$stmt->execute(array($userid));

				$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Activated </div>";

				echo "<div class='container' style='margin-top: 100px;'>";

				RedirectFunc($theMsg, 'back', 5);

				echo '</div>';

			}else{

				$theMsg = 'This id is not exesist';

				RedirectFunc($theMsg, 'back', 5);

			}

			echo "</div>";

		}

        include $tpl . "footer.php";
	}else{

        header ("Location: index.php");

        exit();

    }
