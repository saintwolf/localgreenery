<?php
require('../adminautoload.php');
$session->init('ADMIN');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Get the details from the db
    $db = DB::getInstance();
    $sql = "SELECT * FROM products WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        $session->setFlash('User not found');
        header('location:index.php');
        exit;
    }
} else {
    $session->setFlash('No product specified');
    header('location:index.php');
    exit;
}

// Check if form was sent
if (isset($_POST['createproduct']) && ($_POST['createproduct'] == 'Modify Product')) {
	$name = trim($_POST['name']) == '' ? $product['name'] : $_POST['name'];
	$type = trim($_POST['type']) == '' ? $product['type'] : $_POST['type'];
	$weight = trim($_POST['weight']) == '' ? $product['weight'] : $_POST['weight'];
	$price = trim($_POST['price']) == '' ? $product['price'] : $_POST['price'];
	$active = trim($_POST['active']) == '' ? $product['active'] : $_POST['active'];
	$imageUrl = trim($_POST['image_url']) == '' ? $product['image_url'] : $_POST['image_url'];
	$productId = $_GET['id'];
	
	// Don't care about conflicting names here.
        $db = DB::getInstance();
		$sql = "UPDATE `products` SET `name` = :name, `type` = :type, `weight` = :weight, `price` = :price, `image_url` = :imageUrl, `active` = :active WHERE `id` = :productId";
		$stmt = $db->prepare($sql);
		$stmt->bindParam(':name', $name);
		$stmt->bindParam(':type', $type);
		$stmt->bindParam(':weight', $weight);
		$stmt->bindParam(':price', $price);
		$stmt->bindParam(':imageUrl', $imageUrl);
		$stmt->bindParam(':active', $active);
		$stmt->bindParam(':productId', $productId);
		$stmt->execute();
		
		if ($stmt->rowCount() > 0) {
			$session->setFlash('User Modified');
			header('location:index.php');
			exit;
		}
}
?>
<?php include(LG_ROOT . DS . 'templates' . DS . 'header.php'); ?>
		<h1>Modify product</h1>
		<strong>WARNING: THIS FORM IS NOT VALIDATED. ANYTHING YOU INPUT WILL BE SENT!</strong>
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
					<?php if ($product['image_url'] != '') :?>
					<tr>
					    <td colspan="2"><img src="/uploads/thumbs/tn_<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>" /></td>
					</tr>
					<?php endif; ?>
				</table>
			</fieldset>
			<input type="submit" name="createproduct" value="Modify Product" />
		</form>
<?php include(LG_ROOT . DS . 'templates' . DS . 'footer.php'); ?>