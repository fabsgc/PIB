<?php
    namespace Orm\Entity;

    use System\Orm\Entity\Entity;

    /**
     * Class Subelement
     * @Table(name="subelement")
     * @Form(name="form-subelement")
     * @property int $id
     * @property int $time
     * @property int $duration
     * @property string $content
     * @property Subtitle $subtitle
     * @package Orm\Entity
     */

    class Subelement extends Entity {

        /**
         * @var int
         * @Column(type="INCREMENT", primary="true")
         */

        protected $id;

        /**
         * @var int
         * @Column(type="INT", size="255", null="false", default="0")
         */

        protected $time;

        /**
         * @var int
         * @Column(type="INT", size="255", null="false", default="0")
         */

        protected $duration;

        /**
         * @var string
         * @Column(type="STRING", size="255", null="false")
         */

        protected $content;

        /**
         * @var Subtitle
         * @ManyToOne(to="Subtitle.id")
         */

        protected $subtitle;
    }