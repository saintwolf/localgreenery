<?php
include('adminautoload.php');
$session->init('ADMIN');
// Get the seller status
$db = DB::getInstance();
$sql = "SELECT `value` FROM options WHERE `option` = 'status'";
$stmt = $db->prepare($sql);
$stmt->execute();
$sellerStatus = $stmt->fetchColumn(0);

// Get a list of active users
$sql = "SELECT * FROM `members` WHERE `last_active` > UNIX_TIMESTAMP() - 600";
$stmt = $db->prepare($sql);
$stmt->execute();
$activeUsers = $stmt->fetchAll();
?>
<?php require(LG_ROOT . DS . 'templates' . DS . 'header.php'); ?>
<h1>LocalGreenery - Admin Menu</h1>
<ul>
    <li><a href="enquiries/">Enquiries</a></li>
	<li><a href="users/">Users</a></li>
	<li><a href="products/">Products</a></li>
	<li>Current Status: <a href="changestatus.php"><?php echo $sellerStatus; ?></a></li>
</ul>
<form class="newsform" action="updatenews.php" method="post">
	<table>
	<?php if (isset($_SESSION['flash'])): ?>
		<tr><td><?php echo $_SESSION['flash']; unset($_SESSION['flash']); ?>
	<?php endif; ?>
		<tr><td>Post news:</td></tr>
		<tr><td><input type="text" name="newstext" /></td></tr>
		<tr><td><input type="submit" name="submit" value="Post News" />
	</table>
</form>
<br />
<table>
	<thead>
		<tr>
			<td colspan="2">Online Users (Active in the last 10 min)</td>
		</tr>
		<tr>
			<td>User</td>
			<td>Last Active</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($activeUsers as $user): ?>
		<tr>
			<td><?php echo $user['username'];?></td>
			<td><?php echo ago($user['last_active']);?></td>
		</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<br />
<?php require(LG_ROOT . DS . 'templates' . DS . 'footer.php'); ?>
</body>
</html>