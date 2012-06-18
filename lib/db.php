<?php
	require_once(__DIR__ . '/config.php');
	
	class DB
	{
	    private static $pdo;
	    
	    private function __construct()
	    {
	    }
	    
	    public static function getInstance()
	    {
	        if (!is_object(self::$pdo)) {
	            $dsn = "mysql:host=" . db_host . ";dbname=" . db_name;
	            self::$pdo = new PDO($dsn, db_user, db_pass);
	        }
	        return self::$pdo;
	    }
	}
?>
