<!DOCTYPE html>
<html>
<head>

<link rel="stylesheet" type="text/css" href="/css/css.css" />
<link rel="apple-touch-icon" href="/img/Black_Widow.png" />
<meta name="viewport" content="width=device-width; initial-scale = 1.0; maximum-scale=1.0; user-scalable=no" />
<title>LocalGreenery</title>
</head>
<body class="mainbody">
<div class="appcontainer">
Seller is <strong><?php echo $options['status']['value']; ?></strong><br />
You are logged in as <?php echo $_SESSION['user']['username']?><br />
<a href="/Logout.php">Logout</a> - <a href="/changepassword.php">Change Password</a><br />