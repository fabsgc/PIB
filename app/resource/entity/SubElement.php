<?php
    namespace Orm\Entity;

    use System\Orm\Entity\Entity;

    /**
     * Class SubElement
     * @Table(name="subelement")
     * @Form(name="form-subelement")
     * @property int $id
     * @property int $time
     * @property string $content
     * @package Orm\Entity
     */

    class SubElement extends Entity {

        /**
         * @var int
         * @Column(type="INCREMENT", primary="true")
         */

        protected $id;

        /**
         * @var int
         * @Column(type="INT", size="255", null="false")
         */

        protected $time;

        /**
         * @var string
         * @Column(type="STRING", size="255", null="false")
         */

        protected $content;

        /**
         * @var Subtitle
         * @ManyToOne(to="SubTitle.id")
         */

        protected $subtitle;
    }