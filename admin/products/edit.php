<?php
require('../adminautoload.php');

// Check if form was sent
if (isset($_POST['createproduct']) && ($_POST['createproduct'] == 'Modify Product')) {
	$name = mysql_real_escape_string($_POST['name']);
	$type = mysql_real_escape_string($_POST['type']);
	$weight = mysql_real_escape_string($_POST['weight']);
	$price = mysql_real_escape_string($_POST['price']);
	$active = mysql_real_escape_string($_POST['active']);
	$imageUrl = mysql_real_escape_string($_POST['image_url']);
	$productId = mysql_real_escape_string($_GET['id']);

		$sql = "UPDATE products SET "
				. ($name != '' ? "`name` = '$name', " : '')
				. ($type != '' ? "`type` = '$type', " : '')
				. ($weight != '' ? "`weight` = '$weight', " : '')
				. ($price != '' ? "`price` = '$price', " : '')
				. ("`image_url` = '$imageUrl', ")
				. ($active != '' ? "`active` = '$active' " : '')
				. "WHERE `id` = '$productId'";
		$result = mysql_query($sql);
		if (mysql_affected_rows() > 0) {
			$_SESSION['flash'] = 'User Modified';
			header('location:index.php');
			exit;
		} else {
			$_SESSION['flash'] = 'User not added for some reason.';
			echo $sql;
		}


}
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
	// Get the details from the db
	$id = mysql_real_escape_string($_GET['id']);
	$sql = "SELECT * FROM products WHERE id = '$id'";
	$result = mysql_query($sql);
	if (mysql_num_rows($result) > 0) {
		$product = mysql_fetch_assoc($result);
	} else {
		$_SESSION['flash'] = 'User not found';
		header('location:index.php');
		exit;
	}
} else {
	$_SESSION['flash'] = 'User edit form not submitted properly';

}
?>
<?php include(LG_ROOT . DS . 'templates' . DS . 'header.php'); ?>
		<h1>Modify product</h1>
		<strong>WARNING: THIS FORM IS NOT VALIDATED. ANYTHING YOU INPUT WILL BE SENT!</strong>
		<form action="<?php echo $_SERVER['PHP_SELF'] . '?id=' . $_GET['id']; ?>" method="post">
			<fieldset>
				<table>
					<?php if (isset($_SESSION['flash'])
		&& is_array($_SESSION['flash'])) :
					?>
					<ul>
						<?php foreach ($_SESSION['flash'] as $error) : ?>
						<li><?php echo $error; ?></li>
						<?php endforeach; ?>
						<?php unset($_SESSION['flash']); ?>
					</ul>
					<?php elseif (isset($_SESSION['flash'])) : ?>
					<tr>
						<td colspan="2"><?php echo $_SESSION['flash'];
	unset($_SESSION['flash']);
										?></td>
					</tr>
					<?php endif; ?>
					<tr>
						<td><label for="name">Name: </label></td>
						<td><input type="text" name="name"  value="<?php echo $product['name']; ?>" /></td>
					</tr>
					<tr>
						<td><label for="type">Type: </label></td>
						<td><input type="text" name="type" value="<?php echo $product['type']; ?>" /></td>
					</tr>
					<tr>
						<td><label for="weight">Weight: </label></td>
						<td><input type="text" name="weight" value="<?php echo $product['weight']; ?>" /></td>
					</tr>
					<tr>
						<td><label for="price">Price: </label></td>
						<td><input type="text" name="price" value="<?php echo $product['price']; ?>" /></td>
					</tr>
					<tr>
						<td><label for="active">Active: </label></td>
						<td>
							<input type="radio" name="active" value="Y" <?php if ($product['active'] == 'Y') echo 'checked="checked"'?> /> Y<br />
							<input type="radio" name="active" value="N" <?php if ($product['active'] == 'N') echo 'checked="checked"'?> /> N
						</td>
					</tr>
					<tr>
						<td><label for="image_url">Image URL: </label></td>
						<td><input type="text" name="image_url" value="<?php echo $product['image_url']; ?>"/></td>
					</tr>
				</table>
			</fieldset>
			<input type="submit" name="createproduct" value="Modify Product" />
		</form>
<?php include(LG_ROOT . DS . 'templates' . DS . 'footer.php'); ?>