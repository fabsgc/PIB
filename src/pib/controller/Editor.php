<?php

	namespace Pib;

	use Orm\Entity\Creation;
    use Orm\Entity\Music;
    use Orm\Entity\SubElement;
    use Orm\Entity\Subtitle;
    use Orm\Entity\Video;
    use System\Controller\Controller;
    use System\Response\Response;
    use System\Template\Template;
    use System\Url\Url;

    /**
	 * Class Index
	 * @package Pib
	 * @Before(class="\Pib\Editor", method="init")
	 */

	class Editor extends Controller{

		/**
		 * @return string
		 * @Routing(name="editor-home", url="/editor(/*)", method="get")
		 */

		public function actionHome(){
			return (new Template('editor/home', 'pib-index-home'))
				->assign('title', 'Editeur')
                ->assign('videos', Video::findAll())
                ->assign('musics', Music::findAll())
				->show();
		}

        /**
         * @return void
         * @Routing(name="editor-save", url="/editor(/*)", method="post")
         */

        public function actionSave(){
            $video = Video::findById($_POST['video-editor-video']);
            $music = Music::findById($_POST['video-editor-musics']);
            $title = $_POST['video-title'];
            $email = $_POST['email'];

            if($video instanceof Video && $music instanceof Music) {
                $creation = new Creation();
                $creation->video = $video;
                $creation->music = $music;
                $creation->title = $title;
                $creation->email = $email;

                if ($_POST['video-editor-subtitles'] != 0) {
                    $creation->subtitle = Subtitle::findById($_POST['video-editor-subtitles']);
                } else {
                    $subtitle = new Subtitle();
                    $subtitle->title = $_POST['subtitle-title'];
                    $subtitle->video = $video;
                    $subtitle->insert();

                    foreach ($_POST['subtitle-elements'] as $element) {
                        $subElement = new SubElement();
                        $subElement->content = $element['content'];
                        $subElement->time = $element['begin'] * 100;
                        $subElement->duration = $element['end'] * 100 - $element['begin'] * 100;
                        $subElement->subtitle = $subtitle;
                        $subElement->insert();
                    }

                    $creation->subtitle = $subtitle;
                }

                $creation->insert();
            }

            Response::instance()->header('Location:' . Url::get('editor-home'));
        }
	}