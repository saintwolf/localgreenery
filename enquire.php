<?php
include ('autoload.php');
$session->init('USER');


if (!isset($_GET['id']) OR !is_numeric($_GET['id'])) {
	$session->setFlash('Did not send a valid ID number for enquiry!');
	header('location:/index.php');
	exit;
}
$productId = $_GET['id'];
$db = DB::getInstance();
$sql = "SELECT * FROM products WHERE id = :productId AND `active` = 'Y'";
$stmt = $db->prepare($sql);
$stmt->bindParam(':productId', $productId);
$stmt->execute();
if ($stmt->rowCount() < 1) {
	$session->setFlash("Invalid or inactive Product specified for enquiry!");
	header('location:/index.php');
	exit;
}
$product = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<?php include(LG_ROOT . DS . 'templates' . DS . 'header.php'); ?>
		<h1>Enquiry for <?php echo $product['name'] ?></h1>
		<form action="sendenquiry.php?id=<?php echo $productId;?>" method="post">
			<fieldset>
			    <?php if ($session->hasFlash()): ?>
			    <p><?php echo $session->getFlash(); ?></p>
			    <?php endif; ?>
				<label for="message">Message (Optional):</label><br />
				<textarea name="message" >Enter an optional message to the seller here.</textarea>
			</fieldset>
			<input type="submit" name="enquirysubmit" value="Submit Enquiry" />
		</form>
<?php include(LG_ROOT . DS . 'templates' . DS . 'footer.php'); ?>