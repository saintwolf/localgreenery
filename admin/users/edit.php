<?php
require('../adminautoload.php');
$session->init('ADMIN');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Get the details from the db
    $db = DB::getInstance();
    $sql = "SELECT * FROM members WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $session->setFlash('User not found');
        header('location:index.php');
        exit;
    }
} else {
    $session->setFlash('No user specified');
    header('location:index.php');
    exit;
}

// Check if form was sent
if (isset($_POST['createuser']) && ($_POST['createuser'] == 'Modify User')) {
	$username = trim($_POST['username']) == '' ? $user['username'] : $_POST['username'];
	$password = trim($_POST['password']) == '' ? $user['password'] : md5($_POST['password']);
	$role = trim($_POST['role']) == '' ? $user['role'] : $_POST['role'];
	$banned = trim($_POST['banned']) == '' ? $user['banned'] : $_POST['banned'];
	$userId = $_GET['id'];
	
	// See if there is a conflicting username
	$db = DB::getInstance();
	$sql = "SELECT * FROM members WHERE username = '$username'";
	$stmt = $db->prepare($sql);
	$stmt->execute();

	if ($stmt->rowCount() == 0 || $username == $user['username']) {
		$sql = "UPDATE `members` SET `username` = :username, `password` = :password, `role` = :role, `banned` = :banned WHERE `id` = :userId";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':username', $username);
		$stmt->bindParam(':password', $password);
		$stmt->bindParam(':role', $role);
		$stmt->bindParam(':banned', $banned);
		$stmt->bindParam(':userId', $userId);
		$stmt->execute();
		
		if ($stmt->rowCount() > 0) {
			$session->setFlash('User Modified');
			header('location:index.php');
			exit;
		}
	} else {
		$session->setFlash('Username in use');
	}

} else {
	$session->setFlash('User edit form not submitted properly');
}
?>
<?php require(LG_ROOT . DS . 'templates' . DS . 'header.php'); ?>
    <h1>Edit User</h1>
		<form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_GET['id']; ?>" method="post">
			<fieldset>
				<table>
					<?php if ($session->hasFlash() && is_array($session->getFlash())) : ?>
					<ul>
						<?php foreach ($session->getFlash() as $error) : ?>
						<li><?php echo $error; ?></li>
						<?php endforeach; ?>
					</ul>
					<?php elseif ($session->hasFlash()) : ?>
					<tr>
						<td colspan="2"><?php echo $session->getFlash(); ?></td>
					</tr>
					<?php endif; ?>
					<tr>
						<td><label for="username">Username: </label></td>
						<td><input type="text" name="username" value=<?php echo $user['username']; ?> /></td>
					</tr>
					<tr>
						<td><label for="password">Password: </label></td>
						<td><input type="text" name="password" /></td>
					</tr>
					<tr>
						<td>Role: </td>
						<td>
							<input type="radio" name="role" value="user" <?php if ($user['role']
		== 'USER')
	echo 'checked="checked"' ?>
 /> User<br />
							<input type="radio" name="role" value="admin" <?php if ($user['role']
		== 'ADMIN')
	echo 'checked="checked"' ?>
 /> Admin
						</td>
					</tr>
					<tr>
						<td><label for="active">Banned: </label></td>
						<td>
							<input type="radio" name="banned" value="Y" <?php if ($user['banned']
		== 'Y')
	echo 'checked="checked"' ?>
 /> Y<br />
							<input type="radio" name="banned" value="N" <?php if ($user['banned']
		== 'N')
	echo 'checked="checked"' ?>
" /> N
						</td>
					</tr>
				</table>
			</fieldset>
			<input type="submit" name="createuser" value="Modify User" />
		</form>
<?php require(LG_ROOT . DS . 'templates' . DS . 'footer.php'); ?>