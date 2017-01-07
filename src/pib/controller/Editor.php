<?php

namespace Pib;

use Helper\Mail\Mail;
use Orm\Entity\Creation;
use Orm\Entity\Music;
use Orm\Entity\Subelement;
use Orm\Entity\Subtitle;
use Orm\Entity\Video;
use System\Controller\Controller;
use System\Exception\MissingEntityException;
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
        return (new Template('editor/home', 'pib-editor-home'))
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
            try {
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
                        $subElement = new Subelement();
                        $subElement->content = $element['content'];
                        $subElement->time = $element['begin'] * 100;
                        $subElement->duration = $element['end'] * 100 - $element['begin'] * 100;
                        $subElement->subtitle = $subtitle;
                        $subElement->insert();
                    }

                    $creation->subtitle = $subtitle;
                }

                $creation->insert();

                Response::instance()->header('Location:' . Url::get('editor-encode', [$creation->id]));
            }
            catch(MissingEntityException $e){
                Response::instance()->header('Location:' . Url::get('editor-home'));
                $_SESSION['flash'] = 'Une erreur est survenir pendant l\'enregistrement';
            }
        }
        else{
            Response::instance()->header('Location:' . Url::get('editor-home'));
        }
    }

    /**
     * @param $id int
     * @return string
     * @Routing(name="editor-encode", url="/encode/([0-9]+)(/*)", vars="id", method="get")
     */

    public function actionEncode($id){
        /** @var Creation $creation */
        $creation = Creation::findById($id);

        if($creation instanceof Creation) {
            return (new Template('editor/encode', 'pib-editor-encode'))
                ->assign('id', $id)
                ->show();
        }
        else{
            Response::instance()->status(404);
        }
    }

    /**
     * @param $id int
     * @return void
     * @Routing(name="editor-encode-ajax", url="/encode/([0-9]+)(/*)", vars="id", method="post")
     */

    public function actionEncodeAjax($id){
        /** @var Creation $creation */
        $creation = Creation::findById($id);

        if($creation instanceof Creation){
            $creation->path = 'creation/' . $id . '.mp4';
            $creation->update();

            /** @var Subtitle $subtitle */
            $subtitle = Subtitle::findById($creation->subtitle->id);
            $data = '';

            /**
             * @var int $key
             * @var Subelement $subelement
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

            //$directory = str_replace('/src/pib/controller', '', realpath(dirname(__FILE__)));
            $directory = '/var/www/html';
            $directoryCreation = '/web/pib/file/creation/';

            $shell = '#!/bin/bash'."\n";

            $shell .= 'ffmpeg -i ' . $directory . '/web/pib/file/' . $creation->video->path . ' -i ' . $directory . '/web/pib/file/' . $creation->music->path . ' -filter_complex "[0:a][1:a]amerge=inputs=2[a]" -map 0:v -map "[a]" -c:v copy -c:a libvorbis -ac 2 -shortest ' . $directory . $directoryCreation . $id . '.1.temp.mp4'."\n";
            $shell .= 'ffmpeg -i ' . $directory . $directoryCreation . $id . '.1.temp.mp4 -i ' . $directory . $directoryCreation . $id . '.srt -c copy -c:s mov_text ' . $directory . $directoryCreation . $id . '.2.temp.mp4'."\n";
            $shell .= 'HandBrakeCLI -i ' . $directory . $directoryCreation . $id . '.2.temp.mp4 -o ' . $directory . $directoryCreation . $id . '.mp4 -s 1 --subtitle-burned';

            file_put_contents('web/pib/file/creation/' . $id . '.sh', $shell);

            shell_exec('bash '.$directory . $directoryCreation . $id . '.sh');
        }
        else{
            Response::instance()->status(404);
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