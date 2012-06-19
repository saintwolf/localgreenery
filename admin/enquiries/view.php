<?php 
require_once('../adminautoload.php');
$session->init('ADMIN');

// Check that a valid ID has been sent
if (!isset($_GET['id']) OR !is_numeric($_GET['id'])) {
    $session->setFlash('Did not send a valid ID number for enquiry!');
    header('location:/index.php');
    exit;
} else {
    $enquiryId = $_GET['id'];
}

// Get the enquiry, joining the username and product name
$db = DB::getInstance();
$sql = "SELECT `enquiries`.*, `members`.`username`, `products`.`name` AS `productname` " .
        "FROM `enquiries` " .
        "INNER JOIN `members` ON `enquiries`.`user_id` = `members`.`id` " .
        "INNER JOIN `products` ON `enquiries`.`product_id` = `products`.`id` " .
        "WHERE `enquiries`.`id` = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $enquiryId);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $enquiry = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $session->setFlash('Could not find enquiry id: ' . $enquiryId);
    header('location:index.php');
    exit;
}

require(LG_ROOT . DS . 'templates' . DS . 'header.php');
?>
<h1>View Enquiry</h1>
<table>
    <tr>
        <td><strong>Product:</strong></td>
        <td><?php echo $enquiry['productname']; ?></td>
    </tr>
    <tr>
        <td><strong>Username:</strong></td>
        <td><?php echo $enquiry['username']; ?></td>
    </tr>
    <tr>
        <td><strong>Time:</strong></td>
        <td><?php echo ago($enquiry['time']); ?></td>
    </tr>
    <tr>
        <td colspan="2"><strong>Message</strong></td>
    </tr>
    <tr>
        <td colspan="2"><?php echo $enquiry['message']; ?></td>
    </tr>
</table>
<p><a href="index.php">Back to the Enquiry List</a></p>
<?php require(LG_ROOT . DS . 'templates' . DS . 'footer.php'); ?>