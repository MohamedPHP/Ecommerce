<?php
	/*
	==========================================
	== Comments page
	==you can EDIT | DELETE | Approve Comments
	==========================================
	*/

	session_start();

	$pageTitle = 'Comments';

	if(isset($_SESSION["Username"])){

		include "init.php";

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // Check if the $do is Exixets

		//start manage page

		if ($do == 'Manage') {// if the do is equal manage

			//select all users exept admin

			$stmt = $conn->prepare("SELECT comments.*, items.Name, users.Username FROM comments INNER JOIN items ON items.item_ID = comments.item_id INNER JOIN users ON users.UserID = comments.user_id");

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
							<td>Comment</td>
							<td>Date</td>
							<td>Addition User</td>
							<td>Item Comment</td>
                            <td>Actions</td>
						</tr>
						<?php foreach ($rows as $row) { ?>
						<tr>
							<td><?php echo $row['c_id'] ?></td>
							<td><?php echo $row['comment'] ?></td>
							<td><?php echo $row['comment_date'] ?></td>
							<td><?php echo $row['Username'] ?></td>
                            <td><?php echo $row['Name'] ?></td>
							<td>
								<a href="comments.php?do=Edit&comid= <?php echo $row['c_id'] ?>" class="btn btn-success"><i class='fa fa-edit'></i>Edit</a>
								<a href="comments.php?do=Delete&comid= <?php echo $row['c_id'] ?>" class="btn btn-danger confirm"><i class='fa fa-close'></i>Delete</a>
								<?php
									if ($row['status'] == 0) {
										echo "<a href='comments.php?do=Approve&comid= ".$row['c_id']."' class='btn btn-info'><i class='fa fa-check'></i>Approve</a>";
									}
								?>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<?php
				}else {
					echo "<div class='alert alert-info'>There is no Comments In The Data Base</div>";
				}
				?>
			</div>



<?php	}elseif ($do == 'Edit') { // Edit Page

			// Check that the comid is numeric and exesits

			$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

			// Select all data From the table of users

			$stmt = $conn->prepare("SELECT * FROM comments WHERE c_id = ?");

			// execute the data

			$stmt->execute(array($comid));

			// Fetch all the data of the user id

			$row = $stmt->fetch();

			// Count the rows

			$count = $stmt->rowCount();

			// if there is such id show the form

			if ($count > 0) { ?>

				<h1 class='text-center Head'>Edit Comments</h1>

				<div class='container'>
					<form class="form-horizontal" action="?do=Update" method='POST'>
	                	<input type='hidden' name='comid' value='<?php echo $comid; ?>' />
						<!--Start comment Feiled-->
	                    <div class="form-group form-group-lg">
	                        <label class="col-sm-2 control-label">comment</label>
	                        <div class="col-sm-10 col-md-6">
	                        	<textarea type="text" name="comment" class="form-control" autocomplete="off" required="required"><?php echo $row['comment'] ?></textarea>
	                        </div>
	                    </div>
	                    <!--End comment Feiled-->
	                    <!--Start Submit Feiled-->
	                    <div class="form-group form-group-lg">
	                        <div class="col-sm-offset-2 col-sm-10">
	                        	<input type="submit" value="Save" class="btn btn-primary btn-lg" />
	                        </div>
	                    </div>
	                    <!--End Submit Feiled-->
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

					$id 		= $_POST['comid'];
					$comment 	= $_POST['comment'];

					// Validation

					$formValidation = array();

					if (strlen($comment) < 4) {

						$formValidation[] = 'comment is less than <strong>4 chars</strong>';

					}

					if (empty($comment)) {

						$formValidation[] = 'You Must Enter the comment';

					}
					// Loop into Error Array

					foreach ($formValidation as $error) {

						echo "<div class='alert alert-danger'>".$error."</div>";

					}

					// if there is no errors update the database

					if (empty($formValidation)) {

						// Update the database

						$stmt = $conn->prepare("UPDATE comments SET comment = ? WHERE c_id = ?");

						$stmt->execute(array($comment, $id));

						// Sucess

						$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Updated </div>";

						RedirectFunc($theMsg, 'back', 5);

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

                // Check that the comid is numeric and exesits

    			$comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

				// Select all data From the table of users

				$stmt = $conn->prepare("SELECT * FROM comments WHERE c_id = ?");

				// execute the data

				$stmt->execute(array($comid));


				// Count the rows

				$count = $stmt->rowCount();

				// if there is such id show the form

				if ($count > 0) {

						$stmt = $conn->prepare("DELETE FROM comments WHERE c_id = ?");

						$stmt->execute(array($comid));

						$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Deleted </div>";

						RedirectFunc($theMsg, 'back', 5);


				}else{

					$theMsg = 'This id is not exesist';

						RedirectFunc($theMsg, 'back', 5);

				}

			echo "</div>";

		} elseif ($do = 'Approve') {

			echo '<h1 class="text-center Head">Approve page</h1>';

			echo '<div class="container">';

            // Check that the comid is numeric and exesits

            $comid = isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

			// Select all data From the table of users

			$stmt = $conn->prepare("SELECT * FROM comments WHERE c_id = ?");

			// execute the data

			$stmt->execute(array($comid));


			// Count the rows

			$count = $stmt->rowCount();

			// if there is such id show the form

			if ($count > 0) {

				$stmt = $conn->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");

				$stmt->execute(array($comid));

				$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Approved </div>";

				RedirectFunc($theMsg, 'back', 5);

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
