<?php 
require_once(__DIR__ . '/autoload.php');
$session->init();

// Get seller status from db
$db = DB::getInstance();
$stmt = $db->prepare("SELECT `value` FROM `options` WHERE `option` = 'status'");
$stmt->execute();
$status = $stmt->fetchColumn(0);

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/css.css" />
<link rel="apple-touch-icon" href="/img/Black_Widow.png" />
<meta name="viewport" content="width=320" />
<title>Login</title>
</head> 
<body class="mainbody">

<table>
	<tr class="logowrapper">
	<?php if ($status == 'Available'): ?>
		<td><img src="img/Black_Widow.png" alt="Greening your Local" width="300" height="220" /></td>
	<?php endif; ?>
	</tr>
	<tr>
		<form name="form1" method="post" action="checklogin.php">
			<td>
				<table>
					<tr>
						<td colspan="3"><strong>Member Login </strong></td>
					</tr>
					<?php if ($session->hasFlash()): ?>
					<tr>
						<td colspan="3"><?php echo $session->getFlash(); ?></td>
					</tr>
					<?php endif; ?>
					<tr>
						<td>Username</td>
						<td>:</td>
						<td><input name="myusername" type="text" id="myusername"></td>
					</tr>
					<tr>
						<td>Password</td>
						<td>:</td>
						<td><input name="mypassword" type="password" id="mypassword"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td><input type="submit" name="Submit" value="Login"></td>
					</tr>
				</table>
			</td>
		</form>
  </tr>
</table>
</body>
</html>