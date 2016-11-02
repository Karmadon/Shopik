<?php
	
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 31.10.16
	 * Time: 17:58
	 */
	class Product
		{
		public
			$id,
			$price,
			$quantity,
			$name,
			$description,
			$rating,
			$review_id,
			$outHtml;
		
		
		public function __construct($action, $postData = '')
		{
			$this->price = 0.00;
			$this->quantity = 1;
			$this->name = '';
			$this->description = '';
			$this->objectFilled = 0;
			$this->action = $action;
			$this->postData = $postData;
			
			$this->getAction($action);
			
		}
		
		
		private function getAction($action)
		{
			switch ($action) {
				case 'new': {
					$this->newRecordHandler();
					break;
				}
				case 'list': {
					$this->listRecordHandler();
					break;
				}
				case 'view': {
					$this->viewRecordHandler();
					break;
				}
				default: {
					Echo "<script> location.replace('/error/404/'); </script>";
				}
			}
		}
		
		private function newRecordHandler()
		{
			
			if (!$this->postData) {
				$this->htmlHeader = 'New Product';
			} else {
				$this->htmlHeader = 'Product aded';
			}
			
			return 0;
		}
		
		private function listRecordHandler()
		{
			
			if (!$this->postData) {
				$this->htmlHeader = 'No POST';
				
			} else {
				$this->htmlHeader = 'POST is present';
				
				if ($this->postData['type'] === 'add') {
					Functions::loadClass('Cart');
					Cart::updateCart('add', $this->postData);
				}
			}
			
			$products_item = '<div class="products">';
			
			$results = Database::queryMysql("SELECT * FROM products ORDER BY id ASC");
			
			if ($results) {
				
				$products_item .= '<ul class="products">';
				
				while ($record = $results->fetch_object()) {
					$products_item .= <<<HTML
    <li class="product">
    <form method="post" action="">
    <div class="product-content"><h3>$record->NAME</h3>
    <div class="product-desc">$record->DESCRIPTION</div>
    <div class="product-info">
    Price - \$ $record->PRICE
    
    <fieldset>
    <label>
        <span>Quantity</span>
        <input type="text" size="2" maxlength="2" name="productQuantity" value="1">
    </label>
    </fieldset>
   
    	<input type="hidden" name="product_id" value="$record->ID">
    	<input type="hidden" name="type" value="add">

    <div align="center"><button type="submit" class="to_cart_btn">Add to cart</button></div>
    </div></div>
    </form>
    </li>
HTML;
				}
				$products_item .= '</ul>';
				
			}
			$this->outHtml = $products_item .= '</div>';
			
		}
		
		private function viewRecordHandler()
		{
			
			if (!$this->postData) {
				$this->htmlHeader = 'Product';
			} else {
				$this->htmlHeader = 'Product detail';
			}
			
			
			return 0;
		}
			
			
		}