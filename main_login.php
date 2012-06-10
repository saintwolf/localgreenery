<?php session_start();?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="/css/css.css" />
<link rel="apple-touch-icon" href="/img/Black_Widow.png" />
<meta name="viewport" content="width=320" />
</head> 
<body class="mainbody">

<table>
	<tr class="logowrapper">
		<td><img src="img/Black_Widow.png" alt="Greening your Local" width="300" height="220" /></td>
	</tr>
	<tr>
		<form name="form1" method="post" action="checklogin.php">
			<td>
				<table>
					<tr>
						<td colspan="3"><strong>Member Login </strong></td>
					</tr>
					<?php if (isset($_SESSION['flash'])): ?>
					<tr>
						<td colspan="3"><?php echo $_SESSION['flash']; unset($_SESSION['flash']); ?></td>
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