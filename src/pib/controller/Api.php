<?php

	namespace Pib;

	use Orm\Entity\Music;
	use Orm\Entity\Subtitle;
	use Orm\Entity\Video;
	use System\Controller\Controller;
	use System\Response\Response;
	use System\Template\Template;

	/**
	 * Class Index
	 * @package Pib
	 * @Before(class="\Pib\Api", method="init")
	 */

	class Api extends Controller{

		/**
		 * @param $id int
		 * @return string
		 * @Routing(name="api-video", url="/api/video/([0-9]+)(/*)", vars="id", method="post")
		 */

		public function actionVideo($id){
			$video = Video::findById($id);

			if($video instanceof Video){
				Response::instance()->contentType('application/json');

				return (new Template('api/video', 'pib-api-video'))
					->assign('video', $video)
					->show();
			}
			else{
				Response::instance()->status(404);
			}
		}

		/**
		 * @param $id int
		 * @return string
		 * @Routing(name="api-subtitle", url="/api/subtitle/([0-9]+)(/*)", vars="id", method="post")
		 */

		public function actionSubtitle($id){
			$subtitle = Subtitle::findById($id);

			if($subtitle instanceof Subtitle){
				Response::instance()->contentType('application/json');

				return (new Template('api/subtitle', 'pib-api-subtitle'))
					->assign('video', $subtitle)
					->show();
			}
			else{
				Response::instance()->status(404);
			}
		}

		/**
		 * @param $id int
		 * @return string
		 * @Routing(name="api-music", url="/api/music/([0-9]+)(/*)", vars="id", method="post")
		 */

		public function actionMusic($id){
			$music = Subtitle::findById($id);

			if($music instanceof Music){
				Response::instance()->contentType('application/json');

				return (new Template('api/music', 'pib-api-music'))
					->assign('music', $music)
					->show();
			}
			else{
				Response::instance()->status(404);
			}
		}
	}