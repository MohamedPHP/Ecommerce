<?php
	/*
	==========================================
	== Items page
	== you can EDIT | DELETE | ADD [pagename] page
	==========================================
	*/

	session_start();

	$pageTitle = 'Items';

	if(isset($_SESSION["Username"])){
		include "init.php";
		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // Check if the $do is Exixets
		//start [pagename] page
		if ($do == 'Manage') {// if the do is equal manage
			//select all users exept admin
			$stmt = $conn->prepare("SELECT items.*, categouries.Name AS cat_name, users.Username FROM items INNER JOIN categouries ON categouries.ID = items.Cat_ID INNER JOIN users ON users.UserID = items.Member_ID");
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
							<td>Name</td>
							<td>Describtion</td>
							<td>Price</td>
							<td>Addition Date</td>
							<td>Country</td>
							<td>Categoury Name</td>
							<td>Username</td>
							<td>Actions</td>
						</tr>
						<?php foreach ($rows as $row) { ?>
						<tr>
							<td><?php echo $row['item_ID'] ?></td>
							<td><?php echo $row['Name'] ?></td>
							<td><?php echo $row['Describtion'] ?></td>
							<td><?php echo $row['Price'] ?></td>
							<td><?php echo $row['Add_Date'] ?></td>
							<td><?php echo $row['Country_Made'] ?></td>
							<td><?php echo $row['cat_name'] ?></td>
							<td><?php echo $row['Username'] ?></td>
							<td>
								<a href="?do=Edit&itemid= <?php echo $row['item_ID'] ?>" class="btn btn-success"><i class='fa fa-edit'></i>Edit</a>
								<a href="?do=Delete&itemid= <?php echo $row['item_ID'] ?>" class="btn btn-danger confirm"><i class='fa fa-close'></i>Delete</a>
								<?php
									if ($row['Approve'] == 0) {
										echo "<a href='?do=Approve&itemid= ".$row['item_ID']."' class='btn btn-info'><i class='fa fa-check'></i>Approve</a>";
									}
								?>
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>
				<?php
				}else {
					echo "<div class='alert alert-info'>There is no Items In The Data Base</div>";
				}
				?>
				<a href='?do=Add' class="btn btn-primary" >
					<i class="fa fa-plus"></i>
					Add New Item
				</a>
			</div>
		<?php
		}elseif ($do == 'Add') {// Add Page ?>
			<h1 class='text-center Head'>Add New Item</h1>
			<div class='container'>
				<form class="form-horizontal" action="?do=Insert" method='POST'>
					<!--Start name Feiled-->
		            <div class="form-group form-group-lg">
		                <label class="col-sm-2 control-label">Name</label>
		                <div class="col-sm-10 col-md-6">
							<input
								type="text"
								name="name"
								class="form-control"
								autocomplete="off"
								required="required"
								placeholder="Item Name" />
		                </div>
		            </div>
		            <!--End name Feiled-->

					<!--Start Describtion Feiled-->
		            <div class="form-group form-group-lg">
		                <label class="col-sm-2 control-label">Describtion</label>
		                <div class="col-sm-10 col-md-6">
							<textarea
								style="resize:none;"
								type="text"
								name="Describtion"
								class="form-control"
								autocomplete="off"
								required="required"
								placeholder="Item Describtion" /></textarea>
		                </div>
		            </div>
		            <!--End Describtion Feiled-->

					<!--Start Price Feiled-->
		            <div class="form-group form-group-lg">
		                <label class="col-sm-2 control-label">Price</label>
		                <div class="col-sm-10 col-md-6">
							<input
								type="text"
								name="Price"
								class="form-control"
								autocomplete="off"
								required="required"
								placeholder="Item Price" />
		                </div>
		            </div>
		            <!--End Price Feiled-->

					<!--Start Country Feiled-->
		            <div class="form-group form-group-lg">
		                <label class="col-sm-2 control-label">Country</label>
		                <div class="col-sm-10 col-md-6">
							<input
								type="text"
								name="Country"
								class="form-control"
								autocomplete="off"
								required="required"
								placeholder="Item Country" />
		                </div>
		            </div>
		            <!--End Country Feiled-->

					<!--Start status Feiled-->
		            <div class="form-group form-group-lg">
		                <label class="col-sm-2 control-label">status</label>
		                <div class="col-sm-10 col-md-6">
							<select name="status" required="required">
								<option value="0">..Select Status..</option>
								<option value="1">New</option>
								<option value="2">Like New</option>
								<option value="3">Used</option>
								<option value="4">Old</option>
							</select>
						</div>
		            </div>
		            <!--End status Feiled-->

					<!--Start Members Feiled-->
		            <div class="form-group form-group-lg">
		                <label class="col-sm-2 control-label">Members</label>
		                <div class="col-sm-10 col-md-6">
							<select name="Members" required="required">
								<option value="0">..Select Member..</option>
								<?php
								$stmt = $conn->prepare("SELECT * FROM users");
								$stmt->execute();
								$users = $stmt->fetchAll();
								foreach ($users as $user) {
									echo "<option value='".$user['UserID']."'>".$user['Username']."</option>";
								}
								?>
							</select>
						</div>
		            </div>
		            <!--End Members Feiled-->

					<!--Start Categouries Feiled-->
		            <div class="form-group form-group-lg">
		                <label class="col-sm-2 control-label">Categouries</label>
		                <div class="col-sm-10 col-md-6">
							<select name="Categouries" required="required">
								<option value="0">..Select Categoury..</option>
								<?php
								$stmt = $conn->prepare("SELECT * FROM categouries");
								$stmt->execute();
								$cats = $stmt->fetchAll();
								foreach ($cats as $cat) {
									echo "<option value=".$cat['ID'].">".$cat['Name']."</option>";
								}
								?>
							</select>
						</div>
		            </div>
		            <!--End Members Feiled-->

		            <!--Start Submit Feiled-->
		            <div class="form-group form-group-lg">
		                <div class="col-sm-offset-2 col-sm-10">
		                	<input
								type="submit"
								value="Add Item"
								class="btn btn-primary btn-md" />
		                </div>
		            </div>
		            <!--End Fullname Feiled-->
				</form>
			</div>
		<?php
		}elseif ($do == 'Insert') { // Insert Page
			echo '<h1 class="text-center Head">Insert page</h1>';
			echo '<div class="container">';
				if ($_SERVER['REQUEST_METHOD'] == 'POST') {
					$name			= $_POST['name'];
					$Describtion	= $_POST['Describtion'];
					$Price 			= $_POST['Price'];
					$Country		= $_POST['Country'];
					$status 		= $_POST['status'];
					$members 		= $_POST['Members'];
					$cat 			= $_POST['Categouries'];
					// Validation
					$formValidation = array();
					if (empty($name)) {
						$formValidation[] = 'You Must Enter the Item Name';
					}
					if (empty($Describtion)) {
						$formValidation[] = 'You Must Enter the Item Describtion';
					}
					if (empty($Price)) {
						$formValidation[] = 'You Must Enter the Item Price';
					}
					if (empty($Country)) {
						$formValidation[] = 'You Must Enter the Item Country';
					}
					if ($status == 0) {
						$formValidation[] = 'You Must Choose The Status';
					}
					if ($members == 0) {
						$formValidation[] = 'You Must Choose Member';
					}
					if ($cat == 0) {
						$formValidation[] = 'You Must Choose Categoury';
					}
					// Loop into Error Array
					foreach ($formValidation as $error) {
						$theMsg = '<div class="alert alert-danger">' . $error . '</div>';
						RedirectFunc($theMsg, 'back', 7);
					}
					// if there is no errors update the database
					if (empty($formValidation)) {
						// Insert Into the database
						$stmt= $conn->prepare("INSERT INTO `items`(`Name`, `Describtion`, `Price`, `Add_Date`, `Country_Made`, `Status`, `Cat_ID`, `Member_ID`) VALUES (:Iname, :Idesc, :Iprice, now(), :Icountry, :Istatus, :Icat, :Imember)");
						$stmt->execute(array(
							'Iname' 		=> $name,
							'Idesc' 		=> $Describtion,
							'Iprice' 		=> $Price,
							'Icountry' 		=> $Country,
							'Istatus' 		=> $status,
							'Icat'			=> $cat,
							'Imember'		=> $members
							));
						// Sucess Massge
						$theMsg = '<div class = "alert alert-success">' . $stmt->rowCount() . " Record Inserted </div>";
						RedirectFunc($theMsg, 'back', 5);
					}
				}else{
					$theMsg = '<div class="alert alert-danger">You Cant browes this page directly</div>';
					RedirectFunc($theMsg, 'back', 5);
				}
			echo '</div>';
		}elseif ($do == 'Edit') { // Edit Page
			// Check that the catid is numeric and exesits
			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
			// Select all data From the table of categouries
			$stmt = $conn->prepare("SELECT * FROM items WHERE item_ID = ?");
			// execute the data
			$stmt->execute(array($itemid));
			// Fetch all the data of the catid
			$item = $stmt->fetch();
			// Count the rows
			$count = $stmt->rowCount();
			// if there is such id show the form
			echo "<div class='container'>";
			echo "<h1 class='text-center Head'>Edit Item Page</h1>";
				if ($count > 0) { ?>
					<form class="form-horizontal" action="?do=Update" method='POST'>
						<input type="Hidden" value="<?php echo $item['item_ID'] ?>" name="ID"/>
						<!--Start name Feiled-->
			            <div class="form-group form-group-lg">
			                <label class="col-sm-2 control-label">Name</label>
			                <div class="col-sm-10 col-md-6">
								<input value="<?php echo $item['Name'] ?>" type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Item Name" />
			                </div>
			            </div>
			            <!--End name Feiled-->
						<!--Start Describtion Feiled-->
			            <div class="form-group form-group-lg">
			                <label class="col-sm-2 control-label">Describtion</label>
			                <div class="col-sm-10 col-md-6">
								<textarea style="resize:none;" type="text" name="Describtion" class="form-control" autocomplete="off" required="required" placeholder="Item Describtion" /><?php echo $item['Describtion'] ?></textarea>
			                </div>
			            </div>
			            <!--End Describtion Feiled-->
						<!--Start Price Feiled-->
			            <div class="form-group form-group-lg">
			                <label class="col-sm-2 control-label">Price</label>
			                <div class="col-sm-10 col-md-6">
								<input value="<?php echo $item['Price'] ?>" type="text" name="Price" class="form-control" autocomplete="off" required="required" placeholder="Item Price" />
			                </div>
			            </div>
			            <!--End Price Feiled-->
						<!--Start Country Feiled-->
			            <div class="form-group form-group-lg">
			                <label class="col-sm-2 control-label">Country</label>
			                <div class="col-sm-10 col-md-6">
								<input value="<?php echo $item['Country_Made'] ?>" type="text" name="Country" class="form-control" autocomplete="off" required="required" placeholder="Item Country" />
			                </div>
			            </div>
			            <!--End Country Feiled-->
						<!--Start status Feiled-->
			            <div class="form-group form-group-lg">
			                <label class="col-sm-2 control-label">status</label>
			                <div class="col-sm-10 col-md-6">
								<select name="status" required="required">
									<option value="0">..Select Status..</option>
									<option value="1" <?php if($item['Status'] == 1){echo 'selected';} ?>>New</option>
									<option value="2" <?php if($item['Status'] == 2){echo 'selected';} ?>>Like New</option>
									<option value="3" <?php if($item['Status'] == 3){echo 'selected';} ?>>Used</option>
									<option value="4" <?php if($item['Status'] == 4){echo 'selected';} ?>>Old</option>
								</select>
							</div>
			            </div>
			            <!--End status Feiled-->
						<!--Start Members Feiled-->
			            <div class="form-group form-group-lg">
			                <label class="col-sm-2 control-label">Members</label>
			                <div class="col-sm-10 col-md-6">
								<select name="Members" required="required">
									<option value="0">..Select Member..</option>
									<?php
									$stmt = $conn->prepare("SELECT * FROM users");
									$stmt->execute();
									$users = $stmt->fetchAll();
									foreach ($users as $user) {
										echo "<option value='".$user['UserID']."'";
										if ($item['Member_ID'] == $user['UserID']) {echo "selected";}
										echo ">".$user['Username']."</option>";
									}
									?>
								</select>
							</div>
			            </div>
			            <!--End Members Feiled-->
						<!--Start Categouries Feiled-->
			            <div class="form-group form-group-lg">
			                <label class="col-sm-2 control-label">Categouries</label>
			                <div class="col-sm-10 col-md-6">
								<select name="Categouries" required="required">
									<option value="0">..Select Categoury..</option>
									<?php
									$stmt = $conn->prepare("SELECT * FROM categouries");
									$stmt->execute();
									$cats = $stmt->fetchAll();
									foreach ($cats as $cat) {
										echo "<option value='".$cat['ID']."'";
										if ($item['Cat_ID'] == $cat['ID']) {echo "selected";}
										echo ">".$cat['Name']."</option>";
									}
									?>
								</select>
							</div>
			            </div>
			            <!--End Categouries Feiled-->
			            <!--Start Submit Feiled-->
			            <div class="form-group form-group-lg">
			                <div class="col-sm-offset-2 col-sm-10">
			                	<input type="submit" value="Edit Item" class="btn btn-primary btn-md" />
			                </div>
			            </div>
			            <!--End Fullname Feiled-->
					</form>
					<?php
					//select all users exept admin

					$stmt = $conn->prepare("SELECT comments.*, users.Username FROM comments INNER JOIN users ON users.UserID = comments.user_id WHERE item_id = ?");

					//Execute the statment

					$stmt->execute(array($itemid));

					$rows = $stmt->fetchAll();

					$count = $stmt->rowCount();

					?>
					<?php if ($count > 0){ ?>
					<h4 class="text-center Head">Manage Comments For [ <?php echo $item['Name'] ?> ] Item</h4>
					<div class="table-responsive">
						<table class="table table-bordered main-table text-center">
							<tr>
								<td>Comment</td>
								<td>Date</td>
								<td>Addition User</td>
	                            <td>Actions</td>
							</tr>
							<?php foreach ($rows as $row) { ?>
							<tr>
								<td><?php echo $row['comment'] ?></td>
								<td><?php echo $row['comment_date'] ?></td>
								<td><?php echo $row['Username'] ?></td>
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
				 echo "<h2 class='text-center'>No Comments For This Item</h2>";
				}
				?>
				<?php
				// if there is no such id show the Error massge
				}else{
					$theMsg = '<div class="alert alert-danger">There is no such id</div>';
					RedirectFunc($theMsg, 'back', 5);
				}
			echo "</div>";
		}elseif ($do == 'Update') { // Update Page
			echo '<h1 class="text-center Head">Update Items page</h1>';
			echo '<div class="container">';
			if ($_SERVER['REQUEST_METHOD'] == 'POST') {
				// get the data from the form
				$id 			= $_POST['ID'];
				$name			= $_POST['name'];
				$Describtion	= $_POST['Describtion'];
				$Price 			= $_POST['Price'];
				$Country		= $_POST['Country'];
				$status 		= $_POST['status'];
				$members 		= $_POST['Members'];
				$cat 			= $_POST['Categouries'];
				// Validation
				$formValidation = array();
				if (empty($name)) {
					$formValidation[] = 'You Must Enter the Item Name';
				}
				if (empty($Describtion)) {
					$formValidation[] = 'You Must Enter the Item Describtion';
				}
				if (empty($Price)) {
					$formValidation[] = 'You Must Enter the Item Price';
				}
				if (empty($Country)) {
					$formValidation[] = 'You Must Enter the Item Country';
				}
				if ($status == 0) {
					$formValidation[] = 'You Must Choose The Status';
				}
				if ($members == 0) {
					$formValidation[] = 'You Must Choose Member';
				}
				if ($cat == 0) {
					$formValidation[] = 'You Must Choose Categoury';
				}
				// Loop into Error Array
				foreach ($formValidation as $error) {
					echo '<div class="alert alert-danger">' . $error . '</div>';
				}
				// if there is no errors update the database
				if (empty($formValidation)) {
					// Update the database
					$stmt = $conn->prepare("UPDATE `items` SET `Name`= ?,`Describtion`= ?, `Price`= ?, `Country_Made`= ?, `Status`= ?, `Cat_ID`= ?, `Member_ID`= ? WHERE item_ID = ?");
					$stmt->execute(array($name, $Describtion, $Price, $Country, $status, $cat, $members, $id));
					// Sucess
					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Updated </div>";
					RedirectFunc($theMsg, 'back', 5);
				}else {
					$theMsg = 'Please Check the Errors';
					RedirectFunc($theMsg, 'back');
				}
			}else{
				$theMsg = '<div class="alert alert-danger">You Cant browes this page directly</div>';
				RedirectFunc($theMsg, 'back', 5);
			}
			echo '</div>';
		}elseif ($do == 'Delete') { // Delete Page
			echo '<h1 class="text-center Head">Delete items page</h1>';
			echo '<div class="container">';
				// Check that the catid is numeric and exesits
				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
				// Select all data From the table of users
				$stmt = $conn->prepare("SELECT * FROM items WHERE item_ID = ? LIMIT 1");
				// execute the data
				$stmt->execute(array($itemid));
				// Count the rows
				$count = $stmt->rowCount();
				if ($count > 0) {
						$stmt = $conn->prepare("DELETE FROM items WHERE item_ID = ?");
						$stmt->execute(array($itemid));
						$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Deleted </div>";
						RedirectFunc($theMsg, 'back', 5);
				}else{
					$theMsg = 'This id is not exesist';
					RedirectFunc($theMsg, 'back', 5);
				}
			echo "</div>";
		}elseif ($do == 'Approve') {
			echo "<div class='container'>";
				echo '<h1 class="text-center Head">Activate page</h1>';
				// Check that the itemid is numeric and exesits
				$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;
				$check = checkItems('item_ID', 'items', $itemid);
				// if there is such id show the form
				if ($check > 0) {
					$stmt = $conn->prepare("UPDATE items SET Approve = 1 WHERE item_ID = ?");
					$stmt->execute(array($itemid));
					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Approved </div>";
					RedirectFunc($theMsg, 'back', 5);
				}else{
					$theMsg = '<div class="alert alert-danger">This id is not exesist</div>';
					RedirectFunc($theMsg, 'back', 5);
				}
			echo '</div>';
		}
		include $tpl . "footer.php";
	}else{
		header("Location: index.php");
		exit();
	}
