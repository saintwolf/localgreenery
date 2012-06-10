<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/css.css" />
</head> 
<body>

<table width="300" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
	<tr class="logowrapper">
		<td colspan="3"><img src="img/Black_Widow.png" alt="AC" width="328" height="249" /></td>
	</tr>
	<tr>
		<form name="form1" method="post" action="checklogin.php">
			<td>
				<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
					<tr>
						<td colspan="3"><strong>Member Login </strong></td>
					</tr>
					<?php if (isset($_SESSION['login-flash'])): ?>
					<tr>
						<td colspan="3"><?php echo $_SESSION['login-flash']; unset($_SESSION['login-flash']); ?></td>
					</tr>
					<?php endif; ?>
					<tr>
						<td width="78">Username</td>
						<td width="6">:</td>
						<td width="294"><input name="myusername" type="text" id="myusername"></td>
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