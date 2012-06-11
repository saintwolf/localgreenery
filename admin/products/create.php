<?php
require('../adminautoload.php');

// Check if form was sent
if (isset($_POST['createproduct']) && ($_POST['createproduct'] == 'Create Product')) {
	$name = trim(mysql_real_escape_string($_POST['name']));
	$type = trim(mysql_real_escape_string($_POST['type']));
	$weight = trim(mysql_real_escape_string($_POST['weight']));
	$price = trim(mysql_real_escape_string($_POST['price']));
	$active = trim(mysql_real_escape_string($_POST['active']));
	$imageUrl = trim(mysql_real_escape_string($_POST['image_url']));

	// Some small validation+
	$errors = 0;
	foreach ($_POST as $key => $value) {
		if ($value == '' && ($key != 'image_url')) {
			$_SESSION['flash'][] = $key . ' is empty.';
			$errors++;
		}
	}
	if ($errors == 0) {
		$sql = "INSERT INTO products VALUES ('', '$name', '$type', '$weight', '$price', '$active', '$imageUrl')";
		print $sql;
		$result = mysql_query($sql);
		if (mysql_affected_rows() > 0) {
			$_SESSION['flash'] = 'Product Added';
			header('location:index.php');
		} else {
			$_SESSION['flash'] = 'Product not added for some reason.';
		}
	} else {
		header('location:' . $_SERVER['PHP_SELF']);
		exit;
	}

}
?>
<?php include(LG_ROOT . DS . 'templates' . DS . 'header.php'); ?>
		<h1>Create new product</h1>
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
			<fieldset>
				<table>
					<?php if (isset($_SESSION['flash'])
		&& is_array($_SESSION['flash'])) : ?>
					<ul>
						<?php foreach ($_SESSION['flash'] as $error) : ?>
						<li><?php echo $error; ?></li>
						<?php endforeach; ?>
						<?php unset($_SESSION['flash']); ?>
					</ul>
					<?php elseif (isset($_SESSION['flash'])) : ?>
					<tr>
						<td colspan="2"><?php echo $_SESSION['flash'];
	unset($_SESSION['flash']); ?></td>
					</tr>
					<?php endif; ?>
					<tr>
						<td><label for="name">Name: </label></td>
						<td><input type="text" name="name" /></td>
					</tr>
					<tr>
						<td><label for="type">Type: </label></td>
						<td><input type="text" name="type" /></td>
					</tr>
					<tr>
						<td><label for="weight">Weight: </label></td>
						<td><input type="text" name="weight" /></td>
					</tr>
					<tr>
						<td><label for="price">Price: </label></td>
						<td><input type="text" name="price" /></td>
					</tr>
					<tr>
						<td><label for="active">Active: </label></td>
						<td>
							<input type="radio" name="active" value="Y" checked="checked" /> Y<br />
							<input type="radio" name="active" value="N" /> N
						</td>
					</tr>
					<tr>
						<td><label for="image_url">Image URL: </label></td>
						<td><input type="text" name="image_url" /></td>
					</tr>
				</table>
			</fieldset>
			<input type="submit" name="createproduct" value="Create Product" />
		</form>
<?php include(LG_ROOT . DS . 'templates' . DS . 'footer.php'); ?>