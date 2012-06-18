<?php
require_once('autoload.php');
$session->init('USER');

// Check if form has been submitted
if (isset($_POST['changepassword'])
		&& ($_POST['changepassword']) == 'Change Password') {
	// Process the form
	$currentPass = md5($_POST['currentpass']);
	$newPass = ($_POST['newpass'] != '') ? md5($_POST['newpass']) : '';
	$newPassConfirm = ($_POST['newpassconfirm'] != '') ? md5($_POST['newpassconfirm']) : '';
	if ($currentPass == $_SESSION['user']['password']) {
		if ($newPass == $newPassConfirm) {
			if ($newPass != '') {
			    $db = DB::getInstance();
			    $sql = "UPDATE `members` SET `password`=:newPass WHERE `id` = :userId";
				$stmt = $db->prepare($sql);
				$stmt->bindParam(':newPass', $newPass);
				$stmt->bindParam(':userId', $session->user['id']);
				$stmt->execute();
				if ($stmt->rowCount() > 0) {
					// Now that the password is changed, kill the session and force relogin.
					$session->setFlash('Password changed successfully, please relogin.');
					unset($_SESSION['user']);
					header('location:main_login.php');
					exit;
				} else {
					$session->setFlash('Unable to find member');
					header('location:changepassword.php');
					exit;
				}
			} else {
				$session->setFlash('New Password cannot be blank');
				header('location:changepassword.php');
				exit;
			}
		} else {
			$session->setFlash('New Passwords do not match');
			header('location:changepassword.php');
			exit;
		}
	} else {
		$session->setFlash('Current Password is incorrect');
		header('location:changepassword.php');
		exit;
	}
}
?>
		<?php include(LG_ROOT . DS . 'templates' . DS . 'header.php'); ?>
		<h1>Change Password</h1>
		<form action=<?php echo $_SERVER['PHP_SELF']; ?> method="post">
				<table>
					<?php if ($session->hasFlash()) : ?>
					<tr>
						<td><?php echo $session->getFlash(); ?></td>
					</tr>
					<?php endif; ?>
					<tr>
						<td><label for="currentpass">Current Password:</label></td>
						<td><input type="password" name="currentpass" /></td>
					</tr>
					<tr>
						<td><label for="newpass">New Password:</label></td>
						<td><input type="password" name="newpass" /></td>
					</tr>
					<tr>
						<td><label for="newpassconfirm">Confirm New Password:</label></td>
						<td><input type="password" name="newpassconfirm" /></td>
					</tr>
				</table>
			<input type="submit" name="changepassword" value="Change Password" />
		</form>
		<?php include(LG_ROOT . DS . 'templates' . DS . 'footer.php'); ?>
	</body>
</html>