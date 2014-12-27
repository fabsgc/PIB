<?php
	/*\
	 | ------------------------------------------------------
	 | @file : Lang.class.php
	 | @author : fab@c++
	 | @description : allow to use translation in the application
	 | @version : 3.0 bêta
	 | ------------------------------------------------------
	\*/
	
	namespace system\Lang;

	use system\General\error;
	use system\General\facades;
	use system\General\resolve;
	use system\Template\Template;

    class Lang{
		use error, facades, resolve;

		const USE_NOT_TPL    = 0;
		const USE_TPL        = 1;
		
		/**
		 * init Lang class
		 * @access public
		 * @param &$profiler \system\Profiler\Profiler
		 * @param &$config \system\Config\Config
		 * @param &$request \system\Request\Request
		 * @param &$response \system\Response\Response
		 * @param $lang string
		 * @since 3.0
		 * @package system\Lang
		*/
		
		public function __construct(&$profiler, &$config, &$request, &$response, $lang){
			$this->profiler = $profiler;
			$this->config   =   $config;
			$this->request  =  $request;
			$this->response = $response;
			$this->lang     =     $lang;
		}

		/**
		 * load a sentence from config instance
		 * @access public
		 * @param $name string : name of the sentence
		 * @param $vars array : vars
		 * @param $template bool|int : use template syntax or not
		 * @return string
		 * @since 3.0
		 * @package system\Lang
		*/
		
		public function lang($name, $vars = array(), $template = self::USE_NOT_TPL){
			$config = $this->resolve(RESOLVE_LANG, $name);
			$name = $config[1];
			$config = $config[0];

			if(isset($config[$this->lang][$name])){
				if($template == self::USE_NOT_TPL){
					if(count($vars) == 0){
						return $config[$this->lang][$name];
					}
					else{
						$content = $config[$this->lang][$name];
								
						foreach($vars as $key => $value){
							$content = preg_replace('#\{'.$key.'\}#isU', $value, $content);
						}

						return $content;
					}
				}
				else{
					$tpl = $this->template($config[$this->lang][$name], $name, 0, Template::TPL_STRING);
					$tpl->assign($vars);
					return $tpl->show(Template::TPL_COMPILE_TO_STRING, Template::TPL_COMPILE_LANG);
				}
			}
			else{
				$this->addError('lang '.$name.'/'.$this->lang.' not found', __FILE__, __LINE__, ERROR_WARNING);
				return 'lang not found ('.$name.','.$this->lang.')';
			}
		}

		/**
		 * Destructor
		 * @access public
		 * @since 3.0
		 * @package system\Lang
		*/
		
		public function __destruct(){
		}
	}