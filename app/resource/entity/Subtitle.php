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
         * @Column(type="STRING", size="255", null="false")
         */

        protected $title;

        /**
         * @var Video
         * @ManyToOne(to="Video.id")
         */

        protected $video;

        /**
         * @var Collection
         * @OneToMany(from="Subtitle.id", to="Subelement.subtitle", belong="COMPOSITION", join="JOIN_LEFT")
         */

        protected $subElements;

		/**
		 * @param $id int
		 * @return Subtitle
		 */
		public static function findById($id){
			return Subtitle::find()
				->where('Subtitle.id = :id')
				->vars('id', $id)
				->fetch()
                ->first();
		}

		/**
		 * @return Collection
		 */
		public static function findAll(){
			return Subtitle::find()
				->fetch();
		}
    }