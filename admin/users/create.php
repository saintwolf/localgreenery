<?php
require('../adminautoload.php');
$session->init('ADMIN');

// Check if form was sent
if (isset($_POST['createuser']) && ($_POST['createuser'] == 'Create User')) {
	$username = trim($_POST['username']);
	$password = md5($_POST['password']);
	$role = trim($_POST['role']);
	$banned = trim($_POST['banned']);

	// Some small validation+
	$errorCount = 0;
	$errors = array();
	foreach ($_POST as $key => $value) {
		if ($value == '') {
			$errors[] = $key . ' is empty.';
			$errorCount++;
		}
	}
	
	if ($errorCount == 0) {
		// See if there is a conflicting username
		$db = DB::getInstance();
		$sql = "SELECT * FROM members WHERE username = :username";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':username', $username);
		$stmt->execute();
		if ($stmt->rowCount() == 0) {
			$sql = "INSERT INTO members VALUES ('', :username, :password, :role, :banned, '')";
			$stmt = $db->prepare($sql);
			$stmt->bindParam(':username', $username);
			$stmt->bindParam(':password', $password);
			$stmt->bindParam(':role', $role);
			$stmt->bindParam(':banned', $banned);
			$stmt->execute();
			
			if ($stmt->rowCount() > 0) {
				$session->setFlash('User Added');
				header('location:index.php');
				exit;
			} else {
				$session->setFlash('User not added for some reason.');
			}
		} else {
			$session->setFlash('Username in use');
		}
	} else {
	    $session->setFlash($errors);
		header('location:' . $_SERVER['PHP_SELF']);
		exit;
	}

}
?>
	<?php require(LG_ROOT . DS . 'templates' . DS . 'header.php'); ?>
		<h1>Create new user</h1>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
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
						<td><input type="text" name="username" /></td>
					</tr>
					<tr>
						<td><label for="password">Password: </label></td>
						<td><input type="text" name="password" /></td>
					</tr>
					<tr>
						<td>Role: </td>
						<td>
							<input type="radio" name="role" value="user" checked="checked" /> User<br />
							<input type="radio" name="role" value="admin" /> Admin
						</td>
					</tr>
					<tr>
						<td><label for="active">Banned: </label></td>
						<td>
							<input type="radio" name="banned" value="Y" /> Y<br />
							<input type="radio" name="banned" value="N" checked="checked" /> N
						</td>
					</tr>
				</table>
			</fieldset>
			<input type="submit" name="createuser" value="Create User" />
		</form>
	<?php require(LG_ROOT . DS . 'templates' . DS . 'footer.php'); ?>