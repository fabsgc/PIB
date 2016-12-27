<?php
    namespace Orm\Entity;

    use System\Collection\Collection;
    use System\Orm\Entity\Entity;

    /**
     * Class Video
     * @Table(name="video")
     * @Form(name="form-video")
     * @property int $id
     * @property string $title
     * @property string $poster
     * @property int $duration
     * @property string $path
     * @property Collection $subtitles
     * @package Orm\Entity
     */

    class Video extends Entity {

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
		 * @var string
		 * @Column(type="STRING", size="255")
		 */

		protected $poster;

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

        /**
         * @var Collection
         * @OneToMany(from="Video.id", to="Subtitle.video", belong="COMPOSITION", join="JOIN_LEFT")
         */

        protected $subtitles;

		/**
		 * @param $id int
		 * @return Video
		 */
		public static function findById($id){
			return Video::find()
				->where('Video.id = :id')
				->vars('id', $id)
				->fetch()
                ->first();
		}

		/**
		 * @return Collection
		 */
		public static function findAll(){
			return Video::find()
				->fetch();
		}
    }