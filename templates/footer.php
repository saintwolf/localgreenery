
	</div>
    <div class="col-md-12">

		<a href="/index.php">Home</a><?php if($session->user['role'] == "ADMIN") echo ' - <a href="/admin/">Admin Menu</a>'; ?>
		<br />Powered by LocalGreenery &copy; 2012 - <?php echo date('Y'); ?> Mash-Heads.
	
    </div>

	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/js/bootstrap.min.js"></script>
  </body>
</html>