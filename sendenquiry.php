<?php
include ('lib/autoload.php');
$session->init('USER');

// Check that a valid ID has been sent
if (!isset($_GET['id']) OR !is_numeric($_GET['id'])) {
    $session->setFlash('Did not send a valid ID number for enquiry!');
    header('location:/index.php');
    exit;
} else {
    $productId = $_GET['id'];
}

// Check the form has been submitted, return error otherwise
if ($_POST['enquirysubmit'] != 'Submit Enquiry') {
	$session->setFlash("Fill in the form you cunt");
	header('location:/enquire.php?id=' . $productId);
	exit;
} else {
    // Put the enquiry into the database
    $db = DB::getInstance();
    $sql = "INSERT INTO `enquiries` VALUES ('', :enquiry, :user_id, :product_id, :time)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':enquiry', $_POST['message']);
    $stmt->bindParam(':user_id', $session->user['id']);
    $stmt->bindParam(':product_id', $_GET['id']);
    $stmt->bindValue(':time', time());
    $stmt->execute();
    
    // Send the email
	$to = selleremail;
	$subject = "New enquiry from " . $session->user['username'];
	$message = 'New enquiry from ' . $session->user['username'] . "\n\n";
	$message .= $_POST['message'];
	$headers = 'From: ' . fromemail;
	if (mail($to, $subject, $message, $headers)) {
		$session->setFlash('Enquiry Sent Successfully!');
		header('location:/index.php');
	} else {
		$session->setFlash('Failed to send mail!');
		header('location:/index.php');
		exit;
	}
}
?>
<br /> <a href="index.php">Go back to homepage</a>
