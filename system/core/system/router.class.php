<?php
/*\
 | ------------------------------------------------------
 | @file : route.class.php
 | @author : fab@c++
 | @description : url rewriting
 | @version : 3.0 Bêta
 | ------------------------------------------------------
\*/

namespace system{
	class router{
		use error;

		/**
		 * contain all the routes
		 * @var array
		 */

		protected $routes = array();

		/**
		 * add route to the instance
		 * @access public
		 * @param $route route : route instance
		 * @return void
		 * @since 3.0
		 * @package system
		 */

		public function addRoute(route $route){
			if (!in_array($route, $this->routes)){
				$this->routes[] = $route;
			}
		}

		/**
		 * after url rewriting, return the right route
		 * @access public
		 * @param $url string
		 * @param $config
		 * @return \system\route
		 * @since 3.0
		 * @package system
		 */

		public function getRoute($url, $config){
			$url2 = substr($url, strlen(FOLDER), strlen($url));

			foreach ($this->routes as $route){
				if (($varsValues = $route->match($url2)) != false && ($route->method() == '*' || $route->method() == strtoupper($_SERVER['REQUEST_METHOD']))){
					// if she has vars
					if ($route->hasVars()){
						$varsNames = $route->varsNames();
						$listVars = array();

						//key : name of the var, value = value
						foreach ($varsValues as $key => $match){
							// the first key contains all the captured string (preg_match)
							if ($key > 0){
								if(array_key_exists($key - 1, $varsNames)){
									$listVars[$varsNames[$key - 1]] = $match;
								}
							}
						}

						$route->setVars($listVars);
					}

					//sometimes, it's possible to have several times the same URL, for example, one when we are logged and one when we are not logged.
					//each url has a different ID, so, when we have an url which her "logged" attribute is not correct,
					//we have to check if there is an other url whith the right "logged" attribute
					$logged = explode('.', $config->config['firewall'][''.$route->src().'']['logged']['name']);
					$role = explode('.', $config->config['firewall'][''.$route->src().'']['roles']['name']);
					$logged = $this->_setFirewallConfigArray($_SESSION, $logged);
					$role = $this->_setFirewallConfigArray($_SESSION, $role);

					switch($route->logged()){
						case 'true' :
							if($logged == true && (in_array($role, array_map('trim', explode(',', $route->access()))) || $route->access() == '*')){
								return $route;
							}
						break;

						case 'false' :
							if($logged == false){
								return $route;
							}
						break;

						case '*' :
							return $route;
						break;
					}
				}
			}

			if($route->match($url2))
				return $route;
		}

		/**
		 * get token, logged and role value from environment
		 * @access public
		 * @param $in array : array which contain the value
		 * @param $array array : "path" to the value in $in
		 * @return mixed
		 * @since 3.0
		 * @package system
		 */

		protected function _setFirewallConfigArray($in, $array){
			if(isset($in[''.$array[0].''])){
				$to = $in[''.$array[0].''];
				array_splice($array, 0, 1);

				foreach ($array as $value) {
					if(isset($to[''.$value.''])){
						$to = $to[''.$value.''];
					}
					else{
						return false;
					}
				}
			}
			else{
				return false;
			}

			return $to;
		}
	}

	class route{
		use error;

		protected $action;
		protected $controller;
		protected $name;
		protected $cache;
		protected $url;
		protected $varsNames;
		protected $vars = array();
		protected $src;
		protected $logged;
		protected $access;
		protected $method;

		/**
		 * each route from route.xml become an instance of this class
		 * @access public
		 * @param $url string
		 * @param $controller string
		 * @param $action string
		 * @param $name string
		 * @param $cache int
		 * @param $varsNames array : list of variable from vars=""
		 * @param $src string : location of the file
		 * @param $logged
		 * @param $access
		 * @param $method
		 * @since 3.0
		 * @package system
		 */

		public function __construct($url, $controller, $action, $name, $cache, $varsNames = array(), $src, $logged, $access, $method){
			$this->setUrl($url);
			$this->setController($controller);
			$this->setAction($action);
			$this->setName($name);
			$this->setCache($cache);
			$this->setVarsNames($varsNames);
			$this->setSrc($src);
			$this->setLogged($logged);
			$this->setAccess($access);
			$this->setMethod($method);
		}

		/**
		 * @return bool
		 * @since 3.0
		 * @package system
		 */

		public function hasVars(){
			return !empty($this->varsNames);
		}

		/**
		 * @param $url
		 * @return bool
		 * @since 3.0
		 * @package system
		 */

		public function match($url){
			if (preg_match('`^'.$this->url.'$`', $url, $matches)){
				return $matches;
			}
			else{
				return false;
			}
		}

		/**
		 * @param $action
		 * @since 3.0
		 * @package system
		 */

		public function setAction($action){
			if (is_string($action)){
				$this->action = $action;
			}
		}

		/**
		 * @param $name
		 * @since 3.0
		 * @package system
		 */

		public function setName($name){
			if (is_string($name)){
				$this->name = $name;
			}
		}

		/**
		 * @param $cache
		 * @since 3.0
		 * @package system
		 */

		public function setCache($cache){
			$this->cache = $cache;
		}

		/**
		 * @param $controller
		 * @since 3.0
		 * @package system
		 */

		public function setController($controller){
			if (is_string($controller)){
				$this->controller = $controller;
			}
		}

		/**
		 * @param $url
		 * @since 3.0
		 * @package system
		 */

		public function setUrl($url){
			if (is_string($url)){
				$this->url = $url;
			}
		}

		/**
		 * @param array $varsNames
		 * @since 3.0
		 * @package system
		 */

		public function setVarsNames(array $varsNames){
			$this->varsNames = $varsNames;
		}

		/**
		 * @param array $vars
		 * @since 3.0
		 * @package system
		 */

		public function setVars(array $vars){
			$this->vars = $vars;
		}

		/**
		 * @param $src
		 * @since 3.0
		 * @package system
		 */

		public function setSrc($src){
			$this->src = $src;
		}

		/**
		 * @param $logged
		 * @since 3.0
		 * @package system
		 */

		public function setLogged($logged){
			$this->logged = $logged;
		}

		/**
		 * @param $access
		 * @since 3.0
		 * @package system
		 */

		public function setAccess($access){
			$this->access = $access;
		}

		/**
		 * @param $method
		 * @since 3.0
		 * @package system
		 */

		public function setMethod($method){
			$this->method = $method;
		}

		/**
		 * @return mixed
		 * @since 3.0
		 * @package system
		 */

		public function action(){
			return $this->action;
		}

		/**
		 * @return mixed
		 * @since 3.0
		 * @package system
		 */

		public function name(){
			return $this->name;
		}

		/**
		 * @return mixed
		 * @since 3.0
		 * @package system
		 */

		public function cache(){
			return $this->cache;
		}

		/**
		 * @return mixed
		 * @since 3.0
		 * @package system
		 */

		public function url(){
			return $this->url;
		}

		/**
		 * @return mixed
		 * @since 3.0
		 * @package system
		 */

		public function controller(){
			return $this->controller;
		}

		/**
		 * @return array
		 * @since 3.0
		 * @package system
		 */

		public function vars(){
			return $this->vars;
		}

		/**
		 * @return mixed
		 * @since 3.0
		 * @package system
		 */

		public function varsNames(){
			return $this->varsNames;
		}

		/**
		 * @return mixed
		 * @since 3.0
		 * @package system
		 */

		public function src(){
			return $this->src;
		}

		/**
		 * @return mixed
		 * @since 3.0
		 * @package system
		 */

		public function logged(){
			return $this->logged;
		}

		/**
		 * @return mixed
		 * @since 3.0
		 * @package system
		 */

		public function access(){
			return $this->access;
		}

		/**
		 * @return mixed
		 * @since 3.0
		 * @package system
		 */

		public function method(){
			return $this->method;
		}

		/**
		 * @since 3.0
		 * @package system
		 */

		public function __destruct(){
		}
	}
}