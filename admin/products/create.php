<?php
require('../adminautoload.php');
$session->init('ADMIN');

// Check if form was sent
if (isset($_POST['createproduct']) && ($_POST['createproduct'] == 'Create Product')) {
	$name = trim($_POST['name']);
	$type = trim($_POST['type']);
	$weight = trim($_POST['weight']);
	$price = trim($_POST['price']);
	$active = ($_POST['active'] == 'Y') ? trim($_POST['active']):'N';
	$imageUrl = trim($_POST['image_url']);

	// Some small validation+
	$errorCount = 0;
	$errors = array();
	foreach ($_POST as $key => $value) {
	    if ($value == '' && ($key != 'image_url')) {
	        $errors[] = $key . ' is empty.';
	        $errorCount++;
	    }
	}
	if ($errorCount == 0) {
	    $db = DB::getInstance();
		$sql = "INSERT INTO products VALUES ('', :name, :type, :weight, :price, :active, :imageUrl)";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':type', $type);
		$stmt->bindParam(':weight', $weight);
		$stmt->bindParam(':price', $price);
		$stmt->bindParam(':imageUrl', $imageUrl);
		$stmt->bindParam(':active', $active);
	
		if ($stmt->execute()) {
			$session->setFlash('Product Added');
			header('location:index.php');
			exit;
		} else {
			$session->setFlash('Product not added for some reason.');
			header('location:index.php');
			exit;
		}
	} else {
	    $session->setFlash($errors);
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
					<?php if ($session->hasFlash() && is_array($session->getFlash())) : ?>
					<ul>
						<?php foreach ($session->getFlash() as $error) : ?>
						<li class="bg-warning"><?php echo $error; ?></li>
						<?php endforeach; ?>
					</ul>
					<?php elseif ($session->hasFlash()) : ?>
					<tr>
						<td colspan="2"><?php echo $session->getFlash(); ?></td>
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
							<input type="checkbox" value="Y" name="active" />
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