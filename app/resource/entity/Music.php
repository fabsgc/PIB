<?php
    namespace Orm\Entity;

    use System\Orm\Entity\Entity;

    /**
     * Class Music
     * @Table(name="music")
     * @Form(name="form-music")
     * @property int $id
     * @property string $title
     * @property int $duration
     * @package Orm\Entity
     */

    class Music extends Entity {

        /**
         * @var int
         * @Column(type="INCREMENT", primary="true")
         */

        protected $id;

        /**
         * @var string
         * @Column(type="STRING", size="255")
         */

        protected $title;

        /**
         * @var int
         * @Column(type="INT")
         */

        protected $duration;

        /**
         * @var string
         * @Column(type="STRING", size="255")
         */

        protected $path;
    }