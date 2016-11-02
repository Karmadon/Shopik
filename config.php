<?php
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 31.10.16
	 * Time: 17:55
	 */
	
	if (!defined('ABSPATH')) define('ABSPATH', dirname(__FILE__) . '/');
	
	define('DEBUG', '1');                                   // Debug mode
	
	define('DB_NAME', 'products');
	define('DB_USER', 'root');
	define('DB_PASSWORD', 'mysql');
	define('DB_HOST', 'localhost'); // Only for testing
	define('DB_CHARSET', 'utf8');   // For cyr chars

// ---- lines above needed for cyr support
	setlocale(LC_ALL, 'uk_UK.UTF-8');
	mb_internal_encoding("UTF-8");
	mb_http_input("UTF-8");
	mb_http_output("UTF-8");
	date_default_timezone_set('Europe/Kiev');
	
	
	//if(DEBUG) echo 'config.php loaded';