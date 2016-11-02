<?php
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 31.10.16
	 * Time: 17:56
	 */
	
	require_once(dirname(__FILE__) . '/../config.php');
	
	global $connection;
	
	class Database
		{
		public static $connection;
		
		static function queryMysql($query)
		{
			self::connect();
			global $insertID;
			
			$result = self::$connection->query($query);
			$insertID = self::$connection->insert_id;
			
			
			if (!$result) {
				Echo 'SQL Error<br>';
				die (self::$connection->error);
			}
			
			return $result;
		}
		
		public function connect()
		{
			if (!self::$connection) {
				self::$connection = new mysqli (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
				
				if (self::$connection->connect_error) {
					echo 'Database connection failed...' . 'Error: ' . self::$connection->connect_errno . ' ' . self::$connection->connect_error;
					exit;
				} else {
					self::$connection->set_charset('utf8');
				}
			}
		}
		}