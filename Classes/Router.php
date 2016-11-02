<?php
	
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 31.10.16
	 * Time: 23:07
	 */
	require_once(dirname(__FILE__) . '/Functions.php');
	require_once(dirname(__FILE__) . '/Page.php');
	
	
	class Router
		{
		use Functions;
		
		public
			$pageFrom,
			$pageTo,
			$httpParams,
			$postData,
			$page,
			$loggedin;
		
		
		public function __construct()
		{
			$this->httpParams = Functions::getParamsFromURI();
			$this->postData = Functions::getPOSTparams();
			
			$this->page = new Page();
		}
		
		public function showSite()
		{
			$this->mainRouter();
			$this->page->displayFullPage();
		}
		
		private function mainRouter()
		{
			switch ($this->httpParams['section']) {
				case 'cart': {
					Functions::loadClass('Cart');
					$cartHtml = new Cart($this->httpParams['action'], $this->postData);
					$this->page->setBodyHtml($cartHtml->outHtml);
					break;
				}
				case 'product': {
					Functions::loadClass('Product');
					Functions::loadClass('Cart');
					$productHtml = new Product($this->httpParams['action'], $this->postData);
					$this->page->bodyHtml = $productHtml->outHtml;
					
					break;
				}
				case 'error': {
					Functions::loadClass('Error');
					new Error($this->httpParams['action']);
					break;
				}
				default: {
					self::reRoute('error', '404');
				}
					
					Echo 'oops ugly Error';
			}
			
		}
		
		public static function reRoute($section, $action)
		{
			$route = "\"/$section/$action/\"";
			Echo "<script> location.replace($route); </script>";
		}
			
		}