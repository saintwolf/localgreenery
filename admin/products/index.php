<?php
include('../adminautoload.php');
// Get list of products
$sql = "SELECT * FROM products";
$result = mysql_query($sql);
$products = array();
while($row = mysql_fetch_assoc($result)) {
	$products[] = $row;
}
?>
<html>
<head>
<title>User List</title>
</head>
<body>
<?php include(LG_ROOT . DS . 'templates' . DS . 'header.php'); ?>
<h1>Product List</h1>
		<?php if (isset($_SESSION['flash'])) : ?>
		<p>
			<?php echo $_SESSION['flash']; unset($_SESSION['flash']); ?>
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