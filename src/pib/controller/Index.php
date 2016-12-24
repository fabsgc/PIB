<?php
    namespace Pib;

    use System\Controller\Controller;
	use System\Template\Template;

	/**
     * Class Index
     * @package Gcs
     * @Before(class="\Pib\Index", method="init")
     */

    class Index extends Controller{

		/**
		 * @Routing(name="index", url="(/*)", method="*")
		 */

		public function actionHome(){
			return (new Template('index/home', 'pib-index-home'))
				->assign('title', 'Home')
				->show();
		}
    }