<?php
	
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 31.10.16
	 * Time: 23:34
	 */
	class Error
		{
		public function __construct($errcode)
		{
			$this->action = $errcode;
			$this->showError($errcode);
		}
		
		private function showError($errcode)
		{
			switch ($errcode) {
				case '404': {
					$this->showError404();
					break;
				}
				case '400': {
					$this->showError400();
					break;
				}
				case 'destroySession': {
					session_destroy();
					Router::reRoute('product', 'list');
					break;
				}
				default: {
					$this->unknownError();
				}
			}
		}
		
		private function showError404()
		{
			echo <<<HTML
<H1>ERROR 404</H1>
HTML;
		}
		
		private function showError400()
		{
			echo <<<HTML
<H1>ERROR 400</H1>
HTML;
		}
		
		private function unknownError()
		{
			echo 'something terrible was called this error';
		}
			
		}