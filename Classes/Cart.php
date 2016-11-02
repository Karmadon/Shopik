<?php
	
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 31.10.16
	 * Time: 17:56
	 */
	class Cart
		{
		public
			$total,
			$subtotal,
			$action,
			$postData,
			$outHtml;
		
		public function __construct($action, $postData = '')
		{
			$this->action = $action;
			$this->postData = $postData;
			
			$this->getAction($action);
		}
		
		private function getAction($action)
		{
			switch ($action) {
				case 'add': {
					//$this->addRecordHandler();
					break;
				}
				case 'show': {
					$this->outHtml .= self::showRecordHandler($this->postData);
					break;
				}
				case 'checkout': {
					$this->outHtml .= $this->showCheckout($this->postData);
					break;
				}
				default: {
					//Router::reRoute('error', '404');
				}
			}
		}
		
		public static function showRecordHandler($postData)
		{
			$html = '';
			
			if ($postData) {
				self::updateCart($postData['type'], $postData);
			}
			
			if (isset($_SESSION["cartList"]) && count($_SESSION["cartList"]) > 0) {
				
				$b = 0;
				
				$html .= <<<HTML
			<div class="cart-view-table-back" id="view-cart">
			<h3>Shopping Cart</h3>
			<form method="post" action="">
			<table width="100%"  cellpadding="6" cellspacing="0">
			<tbody>
HTML;
				foreach ($_SESSION["cartList"] as $item) {
					$product_name = $item["product_name"];
					$product_qty = $item["productQuantity"];
					$product_code = $item["product_id"];
					$bg_color = ($b++ % 2 == 1) ? 'odd' : 'even';
					
					$html .= <<<HTML
				<tr class="$bg_color">
				<td>Qty <input type="text" size="2" maxlength="2" name="productQuantity[$product_code]" value="$product_qty"></td>
				<td>$product_name</td>
				<td><input type="checkbox" name="idToRemove[1]" value="$product_code" > Remove</td>
				</tr>
HTML;
				}
				
				$html .= <<<HTML
			<td colspan="4">
			<button type="submit">Update</button><a href="/cart/checkout/" class="button">Checkout</a>
			</td>
			</tbody>
			</table>
			</form>
			</div>
			</div>
HTML;
			}
			return $html;
		}
		
		public static function updateCart($type, $postData)
		{
			if (isset($type) && $type == 'add' && $postData["productQuantity"] > 0) {
				$product = array();
				
				foreach ($postData as $key => $value) {
					$product[$key] = filter_var($value, FILTER_SANITIZE_STRING);
				}
				
				$results = Database::queryMysql('SELECT * FROM products WHERE ID = \'' . $product['product_id'] . '\'');
				
				while ($record = $results->fetch_object()) {
					
					$product["product_name"] = $record->NAME;
					$product["product_price"] = $record->PRICE;
					$product["productQuantity"] =
						(int)$_SESSION["cartList"][$product['product_id']]['productQuantity'] + $product["productQuantity"];
					
					if (isset($_SESSION["cartList"])) {
						if (isset($_SESSION["cartList"][$product['product_id']])) {
							unset($_SESSION["cartList"][$product['product_id']]);
						}
					}
					
					$_SESSION["cartList"][$product['product_id']] = $product;
				}
			}
			
			if (isset($postData["productQuantity"]) || isset($postData["idToRemove"])) {
				if (isset($postData["productQuantity"]) && is_array($postData["productQuantity"])) {
					foreach ($postData["productQuantity"] as $key => $value) {
						if (is_numeric($value)) {
							$_SESSION["cartList"][$key]["productQuantity"] = $value;
						}
					}
				}
				if (isset($postData["idToRemove"]) && is_array($postData["idToRemove"])) {
					foreach ($postData["idToRemove"] as $key) {
						unset($_SESSION["cartList"][$key]);
					}
				}
			}
			
		}
		
		private function showCheckout($postData)
		{
			
			if ($postData) {
				self::updateCart($postData['type'], $postData);
			}
			
			$html = <<<HTML
		<div class="cart-view-table-back">
		<form method="post" action="">
		<table width="100%"  cellpadding="6" cellspacing="0"><thead><tr><th>Quantity</th><th>Name</th><th>Price</th><th>Total</th><th>Remove</th></tr></thead>
		<tbody>
HTML;
			
			
			if (isset($_SESSION["cartList"])) {
				$total = 0;
				$b = 0;
				foreach ($_SESSION["cartList"] as $item) {
					$shipping_cost = 0;
					$product_name = $item["product_name"];
					$product_qty = $item["productQuantity"];
					$product_price = sprintf("%01.2f", $item["product_price"]);
					$product_code = $item["product_id"];
					
					$subtotal = sprintf("%01.2f", ($product_price * $product_qty));
					
					$bg_color = ($b++ % 2 == 1) ? 'odd' : 'even';
					
					$html .= <<<HTML
				<tr class="$bg_color">
				<td><input type="text" size="2" maxlength="2" name="productQuantity[$product_code]" value="$product_qty" onchange="submit()"></td>
				<td>$product_name</td>
				<td>$product_price</td>
				<td>$subtotal</td>
				<td><button type="submit" name="idToRemove[1]" value="$product_code">Delete from Checkout</button></td>

				</tr>
HTML;
					$total = ($total + $subtotal);
				}
				
				$grand_total = $total + $shipping_cost;
				
			}
			$grand_total = sprintf("%01.2f", $grand_total);
			$html .= <<<HTML
		<tr><td colspan="5"><span style="float:right;text-align: right;"> Amount Payable : $grand_total </span></td></tr>
		<tr><td colspan="5"><a href="/product/list/" class="button">Add More Items</a><button type="submit">Update</button><a href="/product/list/" class="button">Pay</a></td></tr>
HTML;
			return $html;
		}
			
		}