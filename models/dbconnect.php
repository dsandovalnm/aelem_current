<?php
	
	require_once('config.php');

	class Connect{

		public static function connection() {
			try {
				$pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset='.DB_CHARSET,DB_USERNAME,DB_PASSWORD);
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES,TRUE);
				
				return $pdo;
			} catch (PDOException $e) {
				$pdo = $e.getMessage();
				return $pdo;
			}
		}
	}