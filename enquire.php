<?php
include ('autoload.php');
$session->init('USER');


if (!isset($_GET['id']) OR !is_numeric($_GET['id'])) {
	die('id is not set or not a number!');
}
$productId = $_GET['id'];
$db = DB::getInstance();
$sql = "SELECT * FROM products WHERE id = :productId";
$stmt = $db->prepare($sql);
$stmt->bindParam(':productId', $productId);
$stmt->execute();
if ($stmt->rowCount() < 1) {
	$session->setFlash("Invalid Product specified for enquiry!");
	header('location:/index.php');
	exit;
}
$product = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<?php include(LG_ROOT . DS . 'templates' . DS . 'header.php'); ?>
		<h1>Enquiry for <?php echo $product['name'] ?></h1>
		<form action="sendenquiry.php" method="post">
			<fieldset>
				<label for="enquiry">Message (Optional):</label><br />
				<textarea name="enquiry" >Enter an optional message to the seller here.</textarea>
			</fieldset>
			<input type="submit" name="enquirysubmit" value="Submit Enquiry" />
		</form>
<?php include(LG_ROOT . DS . 'templates' . DS . 'footer.php'); ?>