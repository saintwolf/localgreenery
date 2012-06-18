<footer>
	<a href="/index.php">Home</a><?php if($session->user['role'] == "ADMIN") echo ' - <a href="/admin/">Admin Menu</a>'; ?> - <a href="">Help</a>
	<br />Powered by LocalGreenery. <br />
	&copy; 2012 Mash-Heads.
</footer>
</div>
</body>
</html>