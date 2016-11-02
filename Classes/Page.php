<?php
	
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 31.10.16
	 * Time: 17:58
	 */
	class Page
		{
		public
			$headTitle,
			$headName,
			$language,
			$charset,
			$siteDir,
			$pageHeader,
			$bodyHtml;
		
		public function __construct()
		{
			$this->headTitle = 'Test Page';
			$this->headName = 'All Right';
			$this->language = 'en';
			$this->charset = "utf-8";
			$this->siteDir = '';
			$this->pageHeader = '';
			$this->bodyHtml = '';
		}
		
		public function setBodyHtml($bodyHtml)
		{
			$this->bodyHtml = $bodyHtml;
		}
		
		public function displayFullPage()
		{
			echo
				$this->showHeader() .
				$this->showMenu() .
				$this->getBodyHtml() .
				$this->showFooter();
		}
		
		public function showHeader()
		{
			$html = <<<HTML
<!DOCTYPE html>
<html lang="$this->language">
  <head>
    <meta charset="$this->charset">
	<link rel="stylesheet" type="text/css" href="/Assets/css/style.css">
</head>
<div class="cart-view-table-back"> 
HTML;
			
			return $html;
		}
		
		public function showMenu()
		{
			count($_SESSION["cartList"]) > 0 ? $carnNum = ' (' . count($_SESSION["cartList"]) . ')' : $carnNum = '';
			
			$html = <<<HTML
<div class="menu_container">
<nav id="primary_nav_wrap">
<ul>
  <li class="current-menu-item"><a href="/product/list/">Home</a></li>
  <li><a href="/product/list/">Products</a></li>
  <li><a href="/cart/show/">Cart$carnNum</a></li>
  <li><a href="/error/destroySession/">New Session</a></li>
</ul>
</nav>
</div>
HTML;
			
			return $html;
			
		}
		
		public function getBodyHtml()
		{
			return $this->bodyHtml;
		}
		
		public function showFooter()
		{
			$html = <<<HTML
		</div>
		<div class="footer">
</div>
</HTML>
HTML;
			return $html;
		}
			
			
		}

