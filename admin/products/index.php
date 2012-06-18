<?php
include('../adminautoload.php');
$session->init('ADMIN');

// Get list of products
$db = DB::getInstance();
$sql = "SELECT * FROM products";
$stmt = $db->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<html>
<head>
<title>User List</title>
</head>
<body>
<?php include(LG_ROOT . DS . 'templates' . DS . 'header.php'); ?>
<h1>Product List</h1>
		<?php if ($session->hasFlash()) : ?>
		<p>
			<?php echo $session->getFlash(); ?>
		</p>
		<?php endif; ?>
<a href="create.php">Create New Product</a>
<table>
	<thead>
		<tr>
			<td>Id</td>
			<td>Name</td>
			<td>Type</td>
			<td>Weight</td>
			<td>Price</td>
			<td>Active</td>
			<td>Image</td>
			<td>Edit</td>
			<td>Delete</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach($products as $product): ?>
			<tr>
				<td><?php echo $product['id']; ?></td>
				<td><?php echo $product['name']; ?></td>
				<td><?php echo $product['type']; ?></td>
				<td><?php echo $product['weight']; ?></td>
				<td><?php echo $product['price']; ?></td>
				<td><?php echo $product['active']; ?></td>
				<td><?php echo ($product['image_url'] == '') ? 'N' : '<img src="/uploads/thumbs/tn_' . $product['image_url'] . '" alt="' . $product['name'] .  '" />';?></td>
				<td><button onClick="parent.location='edit.php?id=<?php echo $product['id'];?>'">Edit</button>
				<td><button onClick="parent.location='delete.php?id=<?php echo $product['id'];?>'">Delete</button>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
<?php include(LG_ROOT . DS . 'templates' . DS . 'footer.php'); ?>
</body>
</html>