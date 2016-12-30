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

        /**
         * @param $id int
         * @return void
         * @Routing(name="editor-encode", url="/encode/([0-9]+)(/*)", vars="id", method="get")
         */

        public function actionEncode($id){
            /** @var Creation $creation */
            $creation = Creation::findById($id);

            if($creation instanceof Creation){
                $creation->path = 'web/pib/file/creation/' . $id . '.mp4';
                $creation->update();

                /** @var Subtitle $subtitle */
                $subtitle = Subtitle::findById($creation->subtitle->id);
                $data = '';

                /**
                 * @var int $key
                 * @var SubElement $subelement
                 */
                foreach ($subtitle->subElements as $key => $subelement){
                    $data .= ($key + 1) . "\n";
                    $data .= Editor::seconds2SRT($subelement->time/1000) . ' --> ' . Editor::seconds2SRT(($subelement->time + $subelement->duration)/1000) . "\n";
                    $data .= $subelement->content;

                    if($key < $subtitle->subElements->count() - 1){
                        $data .= "\n\n";
                    }
                }

                file_put_contents('web/pib/file/creation/' . $id . '.srt', $data);

                $directory = str_replace('\src\pib\controller', '', realpath(dirname(__FILE__)));
                //$directory = 'C:\wamp64\www\EFREI\PIB';

                $shell = '';

                $shell .= 'ffmpeg -i ' . $directory . str_replace('/', '\\', $creation->video->path) . ' -i ' . $directory . str_replace('/', '\\', $creation->music->path) . ' -filter_complex "[0:a][1:a]amerge=inputs=2[a]" -map 0:v -map "[a]" -c:v copy -c:a libvorbis -ac 2 -shortest ' . $directory . '\web\pib\file\creation\\' . $id . '.1.temp.mp4'."\n";
                $shell .= 'ffmpeg -i ' . $directory . '\web\pib\file\creation\\' . $id . '.1.temp.mp4 -i ' . $directory . '\web\pib\file\creation\\' . $id . '.srt -c copy -c:s mov_text ' . $directory . '\web\pib\file\creation\\' . $id . '.2.temp.mp4'."\n";
                $shell .= 'HandBrakeCLI -i ' . $directory . '\web\pib\file\creation\\' . $id . '.2.temp.mp4 -o ' . $directory . '\web\pib\file\creation\\' . $id . '.mp4 -s 1 --subtitle-burned';

                file_put_contents('web/pib/file/creation/' . $id . '.bat', $shell);

                echo 'ffmpeg -i ' . $directory . str_replace('/', '\\', $creation->video->path) . ' -i ' . $directory . str_replace('/', '\\', $creation->music->path) . ' -filter_complex "[0:a][1:a]amerge=inputs=2[a]" -map 0:v -map "[a]" -c:v copy -c:a libvorbis -ac 2 -shortest ' . $directory . '\web\pib\file\creation\\' . $id . '.1.temp.mp4';
                echo '<br /><br />';
                echo 'ffmpeg -i ' . $directory . '\web\pib\file\creation\\' . $id . '.1.temp.mp4 -i ' . $directory . '\web\pib\file\creation\\' . $id . '.srt -c copy -c:s mov_text ' . $directory . '\web\pib\file\creation\\' . $id . '.temp.mp4';
                echo '<br /><br />';
                echo 'HandBrakeCLI -i ' . $directory . '\web\pib\file\creation\\' . $id . '.2.temp.mp4 -o ' . $directory . '\web\pib\file\creation\\' . $id . '.mp4 -s 1 --subtitle-burned';

                //exec('ffmpeg -i ' . $directory . str_replace('/', '\\', $creation->video->path) . ' -i ' . $directory . str_replace('/', '\\', $creation->music->path) . ' -filter_complex "[0:a][1:a]amerge=inputs=2[a]" -map 0:v -map "[a]" -c:v copy -c:a libvorbis -ac 2 -shortest ' . $directory . '\web\pib\file\creation\\' . $id . '.1.temp.mp4');
                //exec('ffmpeg -i ' . $directory . '\web\pib\file\creation\\' . $id . '.1.temp.mp4 -i ' . $directory . '\web\pib\file\creation\\' . $id . '.srt -c copy -c:s mov_text ' . $directory . '\web\pib\file\creation\\' . $id . '.2.temp.mp4');
                //exec('HandBrakeCLI -i ' . $directory . '\web\pib\file\creation\\' . $id . '.2.temp.mp4 -o ' . $directory . '\web\pib\file\creation\\' . $id . '.mp4 -s 1 --subtitle-burned');

                //ffmpeg -i video.mp4 -i music.output.mp3  -filter_complex "[0:a][1:a]amerge=inputs=2[a]" -map 0:v -map "[a]" -c:v copy -c:a libvorbis -ac 2 -shortest output.music.mp4
                //ffmpeg -i video.mp4 -i subtitle.srt -c copy -c:s mov_text outfile.mp4
                //HandBrakeCLI -i outfile.mp4 -o output.mp4 -s 1 --subtitle-burned

                shell_exec($directory . '\web\pib\file\creation\\' . $id . '.bat');
            }
            else{
                Response::instance()->status(404);
            }
        }

        /**
         * @return void
         * @Routing(name="editor-encode-all", url="/encode(/*)", method="get")
         */

        public function actionEncodeAll(){
            $creations = Creation::find()->where("Creation.path = ''")->fetch();

            foreach ($creations as $creation){
                $this->actionEncode($creation->id);
            }
        }

        private static function seconds2SRT($seconds){
            $hours = 0;
            $milliseconds = str_replace( "0.", '', $seconds - floor( $seconds ) );

            if ( $seconds > 3600 ) {
                $hours = floor( $seconds / 3600 );
            }
            $seconds = $seconds % 3600;

            $milliseconds = substr($milliseconds, 0, 3);

            if(strlen($milliseconds) == 2){
                $milliseconds .= '0';
            }
            else if(strlen($milliseconds) == 1){
                $milliseconds .= '00';
            }
            else if(strlen($milliseconds) == 0){
                $milliseconds = '000';
            }

            return str_pad( $hours, 2, '0', STR_PAD_LEFT )
            . gmdate( ':i:s', $seconds )
            . ($milliseconds ? "," . $milliseconds : '');
        }
	}