<?php
    namespace Pib;

    use System\Controller\Controller;

    /**
     * Class Index
     * @package Gcs
     * @Before(class="\Pib\Index", method="init")
     */

    class Index extends Controller{

        /**
         * @Routing(name="default", url="/'.pib.'/default(/*)", method="*")
         */

        public function actionDefault(){
            return $this->showDefault();
        }
    }