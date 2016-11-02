<?php
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 31.10.16
	 * Time: 17:55
	 */
	
	require_once('header.php');
	
	$site = new Router();
	
	
	$site->showSite();
	
	
	//
	//if(DEBUG)
	//{
	//	if ($site->httpParams) Functions::showMeTheValue($site->httpParams);
	//	if($site->postData) Functions::showMeTheValue($site->postData);
	//	Functions::showMeTheValue($_SESSION);
	//	//Functions::showMeTheValue(urlencode($url='http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']));
	//}