<?php
	/*\
	 | ------------------------------------------------------
	 | @file : Cron.class.php
	 | @author : fab@c++
	 | @description : cron
	 | @version : 3.0 Bêta
	 | ------------------------------------------------------
	\*/
	
	namespace system\Cron;

	use system\General\error;
	use system\General\langs;
	use system\General\facades;
	use system\Exception\MissingConfigException;

	class Cron{
		use error, langs, facades;

		protected $_requestParent     ;
		protected $_xmlValid   =  true;
		protected $_xmlContent =    '';
		protected $_exception  = false;

		/**
		 * constructor
		 * @access public
		 * @param &$profiler \system\Profiler\Profiler
		 * @param &$config \system\Config\Config
		 * @param &$request \system\Request\Request
		 * @param $lang string
		 * @param $file string : file path
		 * @throws \system\Exception\MissingConfigException
		 * @since 3.0
		 * @package system\Cron
		*/

		public function __construct (&$profiler, &$config, &$request, $lang, $file){
			$this->profiler = $profiler;
			$this->config = $config;
			$this->_requestParent = $request;
			$this->lang = $lang;

			if(@fopen($file, 'r+')) {
				if($this->_xmlContent = simplexml_load_file($file)){
					if($this->_exception() == false){
						$crons =  $this->_xmlContent->xpath('//cron');

						foreach ($crons as $key => $value) {
							if ($value['executed'] + $value['time'] < time() || $value['time'] == 0){
								$value['executed'] = time();
								$dom = new \DOMDocument("1.0");
								$dom->preserveWhiteSpace = false;
								$dom->formatOutput = true;
								$dom->loadXML($this->_xmlContent->asXML());
								$dom->save($file);

								$action = explode('.', $value['action']);
								$controller = new engine();
								$controller->initCron($action[0], $action[1], $action[2]);

								ob_start();
									$controller->runCron();
									$output = ob_get_contents();
								ob_get_clean();

								$this->addError('['.$value['action']."]\n[".$output."]",  0, 0, 0, LOG_CRONS);
								$this->addError('CRON '.$value['action'].' called successfully ', __FILE__, __LINE__, ERROR_INFORMATION);
							}
						}
					}
					else{
						$this->addError('CRON : the page is an exception ', __FILE__, __LINE__, ERROR_INFORMATION);
					}
				}
				else{
					$this->_xmlValid = true;
					throw new MissingConfigException('Can\'t open file "'.$file.'"');
				}
			}
		}

		/**
		 * return if the current page which calls crons is an exception
		 * @access protected
		 * @return boolean
		 * @since 3.0
		 * @package system\Cron
		*/

		protected function _exception(){
			$exceptions =  $this->_xmlContent->xpath('//exception');

			foreach ($exceptions as $key => $value) {
				if($value['action'] == $this->request->src.'.'.$this->request->controller.'.'.$this->request->action){
					return true;
				}
			}

			return false;
		}

		/**
		 * destructor
		 * @access public
		 * @since 3.0
		 * @package system\Cron
		*/

		public function __destruct(){
		}
	}