<?php 
require_once('../adminautoload.php');
$session->init('ADMIN');

// Get the enquiries, joining the username and product name
$db = DB::getInstance();
$sql = "SELECT `enquiries`.*, `members`.`username`, `products`.`name` AS `productname` " .
       "FROM `enquiries` " .
       "INNER JOIN `members` ON `enquiries`.`user_id` = `members`.`id` " .
       "INNER JOIN `products` ON `enquiries`.`product_id` = `products`.`id` " . 
       "ORDER BY `time` DESC";
$stmt = $db->prepare($sql);
$stmt->execute();
$enquiries = $stmt->fetchAll(PDO::FETCH_ASSOC);

require(LG_ROOT . DS . 'templates' . DS . 'header.php');
?>
<h1>Enquiry List</h1>
<?php if ($session->hasFlash()) :?>
<p><?php echo $session->getFlash(); ?></p>
<?php endif;?>
<table>
    <thead>
        <tr>
            <td>ID</td>
            <td>Product</td>
            <td>Username</td>
            <td>Time</td>
        </tr>            
    </thead>
    <tbody>
        <?php foreach($enquiries as $enquiry): ?>
        <tr>
            <td><a href="view.php?id=<?php echo $enquiry['id']; ?>"><?php echo $enquiry['id']; ?></a></td>
            <td><?php echo $enquiry['productname']; ?></td>
            <td><?php echo $enquiry['username']; ?></td>
            <td><?php echo ago($enquiry['time']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php require(LG_ROOT . DS . 'templates' . DS . 'footer.php'); ?>