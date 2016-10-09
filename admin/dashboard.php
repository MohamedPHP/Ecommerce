<?php
	session_start();
	if(isset($_SESSION["Username"])){

		$pageTitle = "Dashboard";

		include "init.php";

		/*Start Dashboard Page*/
		?>

		<div class="container home-stats text-center">
			<h1>Dashboard</h1>
			<div class="row">
				<div class="col-md-3">
					<div class="stats st-members">
						<i class="fa fa-users"></i>
						<div class="info">
							Total Members
							<span><a href="members.php"><?php echo countItems('UserID', 'users') ?></a></span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="stats st-bending">
						<i class="fa fa-user-plus"></i>
						<div class="info">
							Bending Members
							<span><a href="members.php?do=Manage&page=bending"><?php echo checkItems("RegStatus", "users", 0) ?></a></span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="stats st-items">
						<i class="fa fa-tag"></i>
						<div class="info">
							Total Items
							<span><a href="items.php"><?php echo countItems('Item_ID', 'items') ?></a></span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="stats st-comments">
						<i class="fa fa-comments"></i>
						<div class="info">
							Total Comments
							<span><a href="comments.php"><?php echo countItems('c_id', 'comments') ?></a></span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="container lastest">
			<div class="row">
				<!--Start Latest Users-->
				<div class="col-sm-6">
					<div class="panel panel-default">
						<?php $numUsers = 5; ?>
						<div class="panel-heading">
							<i class="fa fa-users"></i> last <?php echo $numUsers; ?> users
							<span class="pull-right toggle-info">
								<i class="fa fa-plus fa-lg"></i>
							</span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled lastest-users">
							<?php
								$theLast = getlatest("*", "users", "UserID", $numUsers);
								if(!empty($theLast)){
									foreach ($theLast as $user) {

										echo "<li>";
											echo $user['Username'];
											echo "<a href='members.php?do=Edit&userid=".$user['UserID']."'>";
												echo "<span class='btn btn-success pull-right'>";
													echo "<i class='fa fa-edit'></i> Edit";
												echo "</span>";
											echo "</a>";
										echo "</li>";

									}
								}else {
									echo "there\'s nothing to show";
								}
							?>
							</ul>
						</div>
					</div>
				</div>
				<!--End Latest Users-->
				<!--Start Latest Items-->
				<div class="col-sm-6">
					<div class="panel panel-default">
						<?php $numItems = 5; ?>
						<div class="panel-heading">
							<i class="fa fa-users"></i> last <?php echo $numItems; ?> Items
							<span class="pull-right toggle-info">
								<i class="fa fa-plus fa-lg"></i>
							</span>
						</div>
						<div class="panel-body">
							<ul class="list-unstyled lastest-users">
							<?php
								$theLast = getlatest("*", "items", "item_ID", $numItems);
								if (!empty($theLast)) {
									foreach ($theLast as $item) {

										echo "<li>";
											echo $item['Name'];
											echo "<a href='items.php?do=Edit&itemid=".$item['item_ID']."'>";
												echo "<span class='btn btn-success pull-right'>";
													echo "<i class='fa fa-edit'></i> Edit";
												echo "</span>";
											echo "</a>";
										echo "</li>";

									}
								}else {
									echo "there\'s nothing to show";
								}
							?>
							</ul>
						</div>
					</div>
				</div>
				<!--End Latest Items-->
			</div>
			<!--Start Latest Comments-->
			<div class="row">
				<div class="col-sm-6">
					<div class="panel panel-default">
						<?php $numcomments = 5; ?>
						<div class="panel-heading">
							<i class="fa fa-comments-o"></i> Latest <?php echo $numcomments; ?> Comments
							<span class="pull-right toggle-info">
								<i class="fa fa-plus fa-lg"></i>
							</span>
						</div>
						<div class="panel-body">
							<?php
							$stmt = $conn->prepare("SELECT comments.*, users.Username FROM comments INNER JOIN users ON users.UserID = comments.user_id ORDER BY c_id DESC LIMIT $numcomments");

							//Execute the statment

							$stmt->execute();

							$comments = $stmt->fetchAll();
							if(!empty($comments)){
								foreach ($comments as $comment) {
							?>
									<div class="comment-box">
										<a href="members.php?do=Edit&userid=<?php echo $comment['user_id']; ?>"><span class="member-n"><?php echo $comment['Username']; ?></span></a>
										<p class="member-c"><?php echo $comment['comment']; ?></p>
									</div>
							<?php
								}
							}else {
								echo "there\'s nothing to show";
							}
							?>
						</div>
					</div>
				</div>
			</div>
			<!--End Latest Comments-->
		</div>

<?php	/*End Dashboard Page*/

		include $tpl . "footer.php";

		}else{

			header ("Location: index.php");

			exit();

	}
