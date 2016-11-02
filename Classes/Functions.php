<?php
	
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 31.10.16
	 * Time: 23:12
	 */
	trait Functions
		{
		static function getParamsFromURI($start = 1)
		{
			
			$params = explode('/', $_SERVER['REQUEST_URI']);
			
			$returnParams = array(
				'section' => Functions::sanitizeString($params[$start]),
				'action'  => Functions::sanitizeString($params[$start + 1]),
			);
			
			$i = $start + 2;
			foreach ($params as &$value) {
				
				if ($params[$i + 1]) {
					$varName = Functions::sanitizeString($params[$i]);
					$varValue = Functions::sanitizeString($params[$i + 1]);
					$returnParams[$varName] = $varValue;
				}
				$i += 2;
				
			}
			unset($params);
			
			return $returnParams;
		}
		
		static function sanitizeString($var)
		{
			if ($var) {
				$var = strip_tags($var);
				$var = htmlentities($var, ENT_QUOTES, 'UTF-8');
				$var = stripslashes($var);
				return $var;
			} else
				return '';
		}
		
		static function showMeTheValue($a)
		{
			echo '<pre>' . print_r($a, 1) . '</pre>';
		}
		
		static function getPOSTparams()
		{
			$outputArray = array();
			if (isset($_POST)) {
				foreach ($_POST as $key => $value) {
					if (is_array($value)) {
						$secondArray = array();
						
						foreach ($value as $secondKey => $secondValue) {
							$secondKey = self::sanitizeString($secondKey);
							$secondValue = self::sanitizeString($secondValue);
							$secondArray[$secondKey] = $secondValue;
						}
						$key = self::sanitizeString($key);
						$outputArray[$key] = $secondArray;
					} else {
						$key = self::sanitizeString($key);
						$value = self::sanitizeString($value);
						$outputArray[$key] = $value;
					}
				}
			}
			
			return $outputArray;
			
		}
		
		static function loadClass($className)
		{
			$className = ltrim($className, '\\');
			$fileName = '';
			
			if ($lastNsPos = strripos($className, '\\')) {
				$namespace = substr($className, 0, $lastNsPos);
				$className = substr($className, $lastNsPos + 1);
				$fileName = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
			}
			$fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
			
			require_once $fileName;
			
		}
		}