<?php
	namespace Pib;

	use Orm\Entity\Creation;
    use System\Controller\Controller;
    use System\Request\Data;
    use System\Response\Response;
    use System\Template\Template;
    use System\Url\Url;

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
		 * @Routing(name="index-contact", url="/contact(/*)", method="get,post")
		 */

		public function actionContact(){
			return (new Template('index/contact', 'pib-index-contact'))
				->assign('title', 'Contactez-nous')
				->show();
		}

		/**
		 * @return string
		 * @Routing(name="index-top", url="/top(/*)", method="get")
		 */

		public function actionTop(){
			return (new Template('index/top', 'pib-index-top'))
				->assign('title', 'Meilleures vidéos')
                ->assign('creations', Creation::findByScoreAsc(5))
				->show();
		}

        /**
         * @param $id int
         * @param $vote float
         * @return string
         * @Routing(name="index-vote", url="/vote/([0-9]+)/([0-9]*\.?[0-9]*)(/*)", vars="id,vote", method="get")
         */

        public function actionVote($id, $vote){
            $creation = Creation::findById($id);

            if($creation instanceof Creation){
                if($creation->path != ''){
                    if(empty($_SESSION[Data::instance()->env('REMOTE_ADDR')][$id])) {
                        $creation->count++;
                        $creation->sum += $vote;
                        $creation->score = ($creation->sum) / floatval($creation->count);
                        $creation->update();

                        $_SESSION[Data::instance()->env('REMOTE_ADDR')][$id] = true;
                    }

                    Response::instance()->header('Location:' . Url::get('index-top'). '#video-' . $creation->id);
                }
                else{
                    Response::instance()->status(404);
                }
            }
            else{
                Response::instance()->status(404);
            }
        }

        /**
         * @param $id int
         * @return string
         * @Routing(name="index-video", url="/video/([0-9]+)(/*)", vars="id", method="get")
         */

        public function actionVideo($id){
            $creation = Creation::findById($id);

            if($creation instanceof Creation){
                if($creation->path != '') {
                    return (new Template('index/video', 'pib-index-video'))
                        ->assign('title', $creation->title)
                        ->assign('creation', $creation)
                        ->show();
                }
                else{
                    Response::instance()->status(404);
                }
            }
            else{
                Response::instance()->status(404);
            }
        }
	}