<?php

	namespace Pib;

	use System\Controller\Controller;
	use System\Template\Template;

	/**
	 * Class Index
	 * @package Pib
	 * @Before(class="\Pib\Editor", method="init")
	 */

	class Editor extends Controller{

		/**
		 * @return string
		 * @Routing(name="editor-home", url="/editor(/*)", method="get,post")
		 */

		public function actionHome(){
			return (new Template('editor/home', 'pib-index-home'))
				->assign('title', 'Editeur')
				->show();
		}
	}