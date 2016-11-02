<?php
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 31.10.16
	 * Time: 17:58
	 */
	
	session_start();
	
	require_once('config.php');            // Config File
	
	require_once(dirname(__FILE__) . '/Classes/Database.php');  // DB Class
	require_once(dirname(__FILE__) . '/Classes/Page.php');      //Page controller class1
	require_once(dirname(__FILE__) . '/Classes/Router.php');   //Product controller class

