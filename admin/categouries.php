<?php
	/*
	==========================================
	== Categouries page
	== you can EDIT | DELETE | ADD [pagename] page
	==========================================
	*/

	session_start();

	$pageTitle = 'Categouries';

	if(isset($_SESSION["Username"])){

		include "init.php";

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage'; // Check if the $do is Exixets

		//start [pagename] page

		if ($do == 'Manage') {// if the do is equal manage

			$sort = "ASC";

			$sort_array = array("ASC", "DESC");

			if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)){

				$sort = $_GET['sort'];

			}

			$stmt = $conn->prepare("SELECT * FROM `categouries` ORDER BY Ordering $sort");

			$stmt->execute();

			$cats = $stmt->fetchAll(); ?>

			<h1 class="text-center Head"><i class="fa fa-edit" style="position:relative;top:1px;"></i> Manage Categouries</h1>
			<div class="container categouries">
				<?php
				if(!empty($cats)){
				?>
				<div class="panel panel-default">
					<div class="panel-heading">
                    	<i class="fa fa-edit" style="position:relative;top:1px;"></i> Manage Categouries
                        <div class="option pull-right">
                        	<i class="fa fa-sort"></i> Ordering: [
                            <a class="<?php if($sort == "ASC"){ echo "active"; } ?>" href="?sort=ASC">ASC</a>
                             |
                            <a class="<?php if($sort == "DESC"){ echo "active"; } ?>" href="?sort=DESC">DESC</a> ] ,
							<i class="fa fa-eye"></i> View:
							 [ <span class="active" data-view="full">Full</span>
                             |
                            <span data-view="classic">Classic</span> ]
                        </div>
                    </div>
					<div class="panel-body">
						<?php foreach ($cats as $cat) { ?>
						<div class="cat">
                        	<div class="hidden-btns">
                            	<a href="categouries.php?do=Edit&catid=<?php echo $cat['ID']; ?>" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i>Edit</a>
                                <a href="categouries.php?do=Delete&catid=<?php echo $cat['ID']; ?>" class="btn btn-xs btn-danger confirm"><i class="fa fa-close"></i>Delete</a>
                            </div>
							<h3><?php echo $cat['Name']; ?></h3>
                            <div class="full-view">
                                <p><?php if ($cat['Describtion'] == '') {echo "this cat has no describtion";}else{echo $cat['Describtion'];} ?></p>
                                <?php if($cat['Visibility'] == 1){ echo "<span class='Visibility'><i class='fa fa-eye'></i> Visibility Hidden</span>"; } ?>
                                <?php if($cat['Allow_Comment'] == 1){ echo "<span class='Commenting'><i class='fa fa-close'></i> Comment Disabled</span>"; } ?>
                                <?php if($cat['Allow_Ads'] == 1){ echo "<span class='Ads'><i class='fa fa-eye'></i> Ads Disabled</span>"; } ?>
							</div>
                        </div>
						<hr />
						<?php } ?>
					</div>
				</div>
				<?php
				}else {
					echo "<div class='alert alert-info'>There is no Members In The Data Base</div>";
				}
				?>
                <a style="margin-bottom:20px;" href="?do=Add" class="btn btn-primary"><i class="fa fa-plus" style="margin-right: 5px;"></i>Add New Categoury</a>
			</div>

<?php	}elseif ($do == 'Add') { // Add Page ?>

			<h1 class='text-center Head'>Add New Categoury</h1>
			<div class='container'>
				<form class="form-horizontal" action="?do=Insert" method='POST'>
					<!--Start name Feiled-->
		            <div class="form-group form-group-lg">
		                <label class="col-sm-2 control-label">Name</label>
		                <div class="col-sm-10 col-md-6">
		                	<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Categoury Name" />
		                </div>
		            </div>
		            <!--End name Feiled-->

		            <!--Start Describtion Feiled-->
		            <div class="form-group form-group-lg">
		                <label class="col-sm-2 control-label">Describtion</label>
		                <div class="col-sm-10  col-md-6">
		                	<input type="text" name="describtion" class="form-control" placeholder="Describe the categoury" />
		                </div>
		            </div>
		            <!--End Describtion Feiled-->

		            <!--Start Ordering Feiled-->
		            <div class="form-group form-group-lg">
		                <label class="col-sm-2 control-label">Ordering</label>
		                <div class="col-sm-10  col-md-6">
		                	<input type="text" name="ordering" class="form-control" autocomplete="off" placeholder="number to arrange the categouries" />
		                </div>
		            </div>
		            <!--End Ordering Feiled-->

		            <!--Start Visibilty Feiled-->
		            <div class="form-group form-group-lg">
		                <label class="col-sm-2 control-label">Visibility</label>
		                <div class="col-sm-10  col-md-6">
		                	<div>
		                		<input id="vis-yes" type="radio" name="visibility" value="0" checked />
		                		<label for="vis-yes">Yes</label>
		                	</div>
		                	<div>
		                		<input id="vis-no" type="radio" name="visibility" value="1" />
		                		<label for="vis-no">No</label>
		                	</div>
		                </div>
		            </div>
		            <!--End Visibilty Feiled-->

		            <!--Start Commenting Feiled-->
		            <div class="form-group form-group-lg">
		                <label class="col-sm-2 control-label">Allow Commenting</label>
		                <div class="col-sm-10  col-md-6">
		                	<div>
		                		<input id="com-yes" type="radio" name="commenting" value="0" checked />
		                		<label for="com-yes">Yes</label>
		                	</div>
		                	<div>
		                		<input id="com-no" type="radio" name="commenting" value="1" />
		                		<label for="com-no">No</label>
		                	</div>
		                </div>
		            </div>
		            <!--End Commenting Feiled-->

		            <!--Start Ads Feiled-->
		            <div class="form-group form-group-lg">
		                <label class="col-sm-2 control-label">Allow Ads</label>
		                <div class="col-sm-10  col-md-6">
		                	<div>
		                		<input id="ads-yes" type="radio" name="ads" value="0" checked />
		                		<label for="ads-yes">Yes</label>
		                	</div>
		                	<div>
		                		<input id="ads-no" type="radio" name="ads" value="1" />
		                		<label for="ads-no">No</label>
		                	</div>
		                </div>
		            </div>
		            <!--End Ads Feiled-->

		            <!--Start Submit Feiled-->
		            <div class="form-group form-group-lg">
		                <div class="col-sm-offset-2 col-sm-10">
		                	<input type="submit" value="Add Categoury" class="btn btn-primary btn-lg" />
		                </div>
		            </div>
		            <!--End Fullname Feiled-->
				</form>
			</div>

<?php	}elseif ($do == 'Insert') { // Insert Page

			echo '<div class="container">';

			echo '<h1 class="text-center Head">Insert page</h1>';

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

						$catname 		= $_POST['name'];
						$describtion 	= $_POST['describtion'];
						$ordering 		= $_POST['ordering'];
						$visibility 	= $_POST['visibility'];
						$commenting 	= $_POST['commenting'];
						$ads 			= $_POST['ads'];

						if (!empty($catname)) {

							// Check If Categoury Exists in database

							$check = checkItems("Name", "categouries", $catname);

							if($check == 1){
								$theMsg = '<div class="alert alert-danger">Sorry This categoury Is Already Exsests</div>';
								RedirectFunc($theMsg, 'back', 5);
							}else{

								// Insert Into the database

								$stmt= $conn->prepare("INSERT INTO `categouries`(`Name`, `Describtion`, `Ordering`, `Visibility`, `Allow_Comment`, `Allow_Ads`)
									VALUES (:Cname, :Cdesc, :Corder, :Cvisible, :Ccomment, :Cads)");

								$stmt->execute(array(

									'Cname' 	=> $catname ,
									'Cdesc' 	=> $describtion,
									'Corder' 	=> $ordering,
									'Cvisible' 	=> $visibility,
									'Ccomment' 	=> $commenting,
									'Cads'	 	=> $ads

									));

								// Sucess Massge

								$theMsg = '<div class = "alert alert-success">' . $stmt->rowCount() . " Catergory Inserted </div>";

								echo "<div class='container' style='margin-top: 100px;'>";
									RedirectFunc($theMsg, 'back', 5);
								echo '</div>';

							}
						}else{

							$theMsg = '<div class="alert alert-danger">You Did not Enter The Cat Name</div>';

							RedirectFunc($theMsg, 'back', 3);

						}

				}else{

					$theMsg = '<div class="alert alert-danger">You Cant browes this page directly</div>';

					RedirectFunc($theMsg, 'back', 5);

				}

			echo '</div>';

		}elseif ($do == 'Edit') { // Edit Page

			echo "<div class='container'>";

			echo "<h1 class='text-center Head'>Edit Categoury</h1>";

				// Check that the catid is numeric and exesits

				$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

				// Select all data From the table of categouries

				$stmt = $conn->prepare("SELECT * FROM categouries WHERE ID = ? LIMIT 1");

				// execute the data

				$stmt->execute(array($catid));

				// Fetch all the data of the catid

				$cat = $stmt->fetch();

				// Count the rows

				$count = $stmt->rowCount();

				// if there is such id show the form

				if ($count > 0) { ?>

                	<form class="form-horizontal" action="?do=Update" method='POST'>
                    	<input type='hidden' name='catid' value='<?php echo $catid; ?>' />
                        <!--Start name Feiled-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input value="<?php echo $cat['Name']; ?>" type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Categoury Name" />
                            </div>
                        </div>
                        <!--End name Feiled-->

                        <!--Start Describtion Feiled-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Describtion</label>
                            <div class="col-sm-10  col-md-6">
                                <input value="<?php echo $cat['Describtion']; ?>" type="text" name="describtion" class="form-control" placeholder="Describe the categoury" />
                            </div>
                        </div>
                        <!--End Describtion Feiled-->

                        <!--Start Ordering Feiled-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Ordering</label>
                            <div class="col-sm-10  col-md-6">
                                <input value="<?php echo $cat['Ordering']; ?>" type="text" name="ordering" class="form-control" autocomplete="off" placeholder="number to arrange the categouries" />
                            </div>
                        </div>
                        <!--End Ordering Feiled-->

                        <!--Start Visibilty Feiled-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Visibility</label>
                            <div class="col-sm-10  col-md-6">
                                <div>
                                    <input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility'] == 0){ echo "checked"; } ?>/>
                                    <label for="vis-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility'] == 1){ echo "checked"; } ?>/>
                                    <label for="vis-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!--End Visibilty Feiled-->

                        <!--Start Commenting Feiled-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Commenting</label>
                            <div class="col-sm-10  col-md-6">
                                <div>
                                    <input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment'] == 0){ echo "checked"; } ?>/>
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 1){ echo "checked"; } ?>/>
                                    <label for="com-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!--End Commenting Feiled-->

                        <!--Start Ads Feiled-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Allow Ads</label>
                            <div class="col-sm-10  col-md-6">
                                <div>
                                    <input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0){ echo "checked"; } ?>/>
                                    <label for="ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads'] == 1){ echo "checked"; } ?>/>
                                    <label for="ads-no">No</label>
                                </div>
                            </div>
                        </div>
                        <!--End Ads Feiled-->

                        <!--Start Submit Feiled-->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Update Categoury" class="btn btn-primary btn-lg" />
                            </div>
                        </div>
                        <!--End Fullname Feiled-->
                    </form>
	  			<?php
				// if there is no such id show the Error massge
				}else{

	  				$theMsg = '<div class="alert alert-danger">There is no such id</div>';

					RedirectFunc($theMsg, 'back', 5);

				}

			echo '</div>';

		}elseif ($do == 'Update') { // Update Page

			echo '<h1 class="text-center Head">Update Cat page</h1>';
			echo '<div class="container">';

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					$id 			= $_POST['catid'];
					$catname 		= $_POST['name'];
					$describtion 	= $_POST['describtion'];
					$ordering 		= $_POST['ordering'];
					$visibility 	= $_POST['visibility'];
					$commenting 	= $_POST['commenting'];
					$ads 			= $_POST['ads'];


					// Update the database

					$stmt = $conn->prepare("UPDATE `categouries` SET `Name`= ?, `Describtion`= ?, `Ordering`= ?, `Visibility`= ?, `Allow_Comment`= ?, `Allow_Ads`= ? WHERE `ID` = ?");

					$stmt->execute(array($catname, $describtion, $ordering, $visibility, $commenting, $ads, $id));

					// Sucess

					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Updated </div>";

					RedirectFunc($theMsg, 'back', 5);

				}else{

					$theMsg = '<div class="alert alert-danger">You Cant browes this page directly</div>';

					RedirectFunc($theMsg, 'back', 5);

				}

			echo '</div>';

		}elseif ($do == 'Delete') { // Delete Page

			echo '<h1 class="text-center Head">Delete Categoury page</h1>';

			echo '<div class="container">';

			// Check that the catid is numeric and exesits

			$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

			// Select all data From the table of users

			$stmt = $conn->prepare("SELECT * FROM categouries WHERE ID = ? LIMIT 1");

			// execute the data

			$stmt->execute(array($catid));

			// Count the rows

			$count = $stmt->rowCount();

			if ($count > 0) {

					$stmt = $conn->prepare("DELETE FROM categouries WHERE ID = ?");

					$stmt->execute(array($catid));

					$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . " Record Deleted </div>";

					RedirectFunc($theMsg, 'back', 5);

			}else{

				$theMsg = 'This id is not exesist';

				RedirectFunc($theMsg, 'back', 5);

			}

			echo "</div>";

		}

		include $tpl . "footer.php";

	}else{

		header("Location: index.php");

		exit();

	}
