
<?php
include ('lib/autoload.php');

// Fetch the products from the database
$sql = "SELECT * FROM products WHERE `active` = 'Y'";
$result = mysql_query($sql, $conn);

$products = array();
while ($row = mysql_fetch_assoc($result)) {
	$products[] = $row;
}

// Get the news from the db
$sql = "SELECT `news`.*, `members`.`username` FROM `news` INNER JOIN `members` ON `news`.`user_id`=`members`.`id` ORDER BY `news`.`created_at` DESC LIMIT 1";
$result = mysql_query($sql);
$news = mysql_fetch_assoc($result);

?>
<?php include(LG_ROOT . DS . 'templates' . DS . 'header.php'); ?>
<h1>Welcome to Local Greenery</h1>
<div class="statusbar">
<h4>Latest News</h4>
<p><?php echo $news['text']; ?></p>
<footer>Posted <?php echo ago($news['created_at']); ?> by <?php echo $news['username'];?></footer>
<p><h2>Products:</h2></p>
</div>
<table>
	<?php if (isset($_SESSION['flash'])): ?>
	<tr>
		<td><strong><?php echo $_SESSION['flash']; unset($_SESSION['flash']); ?></strong></td>
	</tr>
	<?php endif; ?>
<?php if (mysql_num_rows($result) > 0): ?>
<?php foreach ($products as $product): ?>
	<tr>
		<td>
			<p>
				<ul>
					<li><h3><?php echo $product['name']?></h3></li>
					<?php if ($product['image_url'] != ''): ?><li>
					<li><a href="<?php echo '/uploads/' . $product['image_url'] ?>"><img src="<?php echo 'uploads/thumbs/tn_' . $product['image_url'] ?>" /></a></li>
					<?php endif; ?>
					<li>Dominant Type: <?php echo $product['type']?></li>
					<li>Weight: <?php echo $product['weight']?></li>
					<li>Price: <?php echo $product['price']?></li>
					<li><button onClick="parent.location='enquire.php?id=<?php echo $product['id']; ?>'">Enquire</button></li>
				</ul>
			</p>
		</td>
	</tr>
<?php endforeach;?>
</table>
<?php else: ?>
	<p>
		<h3>No products available. Please try again later.</h3>
	</p>
<?php endif; ?>

<?php include(LG_ROOT . DS . 'templates' . DS . 'footer.php'); ?>
