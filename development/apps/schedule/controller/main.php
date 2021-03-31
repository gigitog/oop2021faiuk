<?php
/**
 * User Controller
 *
 * @author Serhii Shkrabak
 * @global object $CORE
 * @package Controller\Main
 */
namespace Controller;
class Main
{
	use \Library\Shared;

	private $model;

	public function exec():?array {
		$result = null;
		$url = $this->getVar('REQUEST_URI', 'e');
		$path = explode('/', $url);
		
		if (isset($path[2]) && !strpos($path[1], '.')) { // Disallow directory changing
			$file = ROOT . 'model/config/methods/' . $path[1] . '.php';
			if (file_exists($file)) {
				include $file;
				if (isset($methods[$path[2]])) {
					$details = $methods[$path[2]];
					$request = [];

					foreach ($details['params'] as $param) {
						$var = $this->getVar($param['name'], $param['source']);
						
						if($var == null){
							if (!$param['required']) // default
								$var = $param['default']; // set default
							else
								throw new \Exception('NullReqParam', 1);
						} else if ($param['pattern'] != '' && preg_match($param['pattern'], $var) == 0){
							throw new \Exception('InvalidParamPattern'. $param['name'], 2);
						}

						$request[$param['name']] = $var;
					}
					
					if (method_exists($this->model, $path[1] . $path[2])) {
						$method = [$this->model, $path[1] . $path[2]];
						$result = $method($request);
					}

				}

			}
		}

		return $result;
	}

	public function __construct() {
		$domains = [];
		// CORS configuration
		$origin = $this -> getVar('HTTP_ORIGIN', 'e');
		$domains[] = $this->getVar('FRONT', 'e');
		foreach ( $domains as $allowed )
			if ( $origin == "https://$allowed") {
				header( "Access-Control-Allow-Origin: $origin" );
				header( 'Access-Control-Allow-Credentials: true' );
			}
		$this->model = new \Model\Main;
	}
}