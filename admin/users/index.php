<?php
require('../adminautoload.php');
// Get list of users
$sql = "SELECT * FROM members";
$result = mysql_query($sql);
$users = array();
while($row = mysql_fetch_assoc($result)) {
	$users[] = $row;
}
?>
<html>
<head>
<title>User List</title>
</head>
<body>
<?php include(LG_ROOT . DS . 'templates' . DS . 'header.php'); ?>
<h1>User List</h1>
		<?php if (isset($_SESSION['flash'])) : ?>
		<p>
			<?php echo $_SESSION['flash']; unset($_SESSION['flash']); ?>
		</p>
		<?php endif; ?>
<a href="create.php">Create New User</a>
<table>
	<thead>
		<tr>
			<td>Id</td>
			<td>Username</td>
			<td>Role</td>
			<td>Banned?</td>
			<td>Edit</td>
			<td>Delete</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach($users as $user): ?>
			<tr>
				<td><?php echo $user['id']; ?></td>
				<td><?php echo $user['username']; ?></td>
				<td><?php echo $user['role']; ?></td>
				<td><?php echo $user['banned']; ?></td>
				<td><button onClick="parent.location='edit.php?id=<?php echo $user['id'];?>'">Edit</button>
				<td><button onClick="parent.location='delete.php?id=<?php echo $user['id'];?>'">Delete</button>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php include(LG_ROOT . DS . 'templates' . DS . 'footer.php'); ?>
</body>
</html>