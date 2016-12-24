<?php
    namespace Orm\Entity;

    use System\Collection\Collection;
    use System\Orm\Entity\Entity;

    /**
     * Class Subtitle
     * @Table(name="subtitle")
     * @Form(name="form-subtitle")
     * @property int $id
     * @property string $title
     * @property Video $video
     * @property Collection $subElements
     * @package Orm\Entity
     */

    class Subtitle extends Entity {

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
         * @var Video
         * @ManyToOne(to="Video.id")
         */

        protected $video;

        /**
         * @var Collection
         * @OneToMany(from="Subtitle.id", to="SubElement.subtitle", belong="COMPOSITION", join="JOIN_LEFT")
         */

        protected $subElements;
    }