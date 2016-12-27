<?php
    namespace Orm\Entity;

    use System\Collection\Collection;
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
         * @Column(type="STRING", size="255", null="false")
         */

        protected $title;

        /**
         * @var int
         * @Column(type="INT", null="false")
         */

        protected $duration;

        /**
         * @var string
         * @Column(type="STRING", size="255", null="false")
         */

        protected $path;

		/**
		 * @param $id int
		 * @return Music
		 */
		public static function findById($id){
			return Music::find()
				->where('Subtitle.id = :id')
				->vars('id', $id)
				->fetch()
                ->first();
		}

		/**
		 * @return Collection
		 */
		public static function findAll(){
			return Music::find()
				->fetch();
		}
    }