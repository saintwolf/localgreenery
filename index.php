
<?php
include ('lib/autoload.php');
$session->init('USER');

// Fetch the products from the database
$sql = "SELECT * FROM products WHERE `active` = 'Y'";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the news from the db
$sql = "SELECT `news`.*, `members`.`username` FROM `news` INNER JOIN `members` ON `news`.`user_id`=`members`.`id` ORDER BY `news`.`created_at` DESC LIMIT 1";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$news = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<?php include(LG_ROOT . DS . 'templates' . DS . 'header.php'); ?>
<h1>Welcome to Local Greenery</h1>
<div class="newsbar">
<ul>
    <li><h4>Latest News</h4></li>
    <li><p><?php echo $news['text']; ?></p></li>
    <li id="newsfooter">Posted <?php echo ago($news['created_at']); ?> by <?php echo $news['username'];?></li>
</ul>
</div>
<?php if ($session->hasFlash()): ?>
<ul>
	<li><strong><?php echo $session->getFlash(); ?></strong></li>
</ul>
<?php endif; ?>
<div class="products">
<h2>Products</h2>
<?php if (mysql_num_rows($result) > 0): ?>
<?php foreach ($products as $product): ?>
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
<?php endforeach;?>
<?php else: ?>
	<p>
		<h3>No products available. Please try again later.</h3>
	</p>
<?php endif; ?>
</div>

<?php include(LG_ROOT . DS . 'templates' . DS . 'footer.php'); ?>
