<?php
require('../adminautoload.php');
$session->init('ADMIN');

// Get list of users
$db = DB::getInstance();
$sql = "SELECT * FROM members";
$stmt = $db->prepare($sql);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<head>
<title>User List</title>
</head>
<body>
<?php include(LG_ROOT . DS . 'templates' . DS . 'header.php'); ?>
<h1>User List</h1>
		<?php if ($session->hasFlash()) : ?>
		<p>
			<?php echo $session->getFlash(); ?>
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