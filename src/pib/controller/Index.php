<?php
	namespace Pib;

	use System\Controller\Controller;
	use System\Template\Template;

	/**
	 * Class Index
	 * @package Pib
	 * @Before(class="\Pib\Index", method="init")
	 */

	class Index extends Controller{

		/**
		 * @return string
		 * @Routing(name="index-home", url="(/*)", method="get")
		 */

		public function actionHome(){
			return (new Template('index/home', 'pib-index-home'))
				->assign('title', 'Politically Incorrect Business')
				->show();
		}

		/**
		 * @return string
		 * @Routing(name="index-about", url="/about(/*)", method="get")
		 */

		public function actionAbout(){
			return (new Template('index/about', 'pib-index-about'))
				->assign('title', 'A propos')
				->show();
		}

		/**
		 * @return string
		 * @Routing(name="index-terms", url="/terms(/*)", method="get")
		 */

		public function actionTerms(){
			return (new Template('index/terms', 'pib-index-terms'))
				->assign('title', 'Conditions Générales d\'Utilisation')
				->show();
		}

		/**
		 * @return string
		 * @Routing(name="index-top", url="/top(/*)", method="get")
		 */

		public function actionTop(){
			return (new Template('index/top', 'pib-index-top'))
				->assign('title', 'Meilleures vidéos')
				->show();
		}
	}