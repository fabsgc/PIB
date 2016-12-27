<?php
	namespace Orm\Entity;

	
	use System\Collection\Collection;
    use System\Orm\Entity\Entity;

	/**
	 * Class Creation
	 * @Table(name="creation")
	 * @Form(name="form-creation")
	 * @property integer id
	 * @property string title
	 * @property Video video
	 * @property Subtitle subtitle
	 * @property Music music
	 * @property float score
	 * @property integer count
     * @property float sum
	 * @package Orm\Entity
	 */

	class Creation extends Entity {
	
		/**
		 * @var integer
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
		 * @var Subtitle
		 * @ManyToOne(to="Subtitle.id")
		 */
		protected $subtitle;
	
		/**
		 * @var Music
		 * @ManyToOne(to="Music.id")
		 */
		protected $music;
	
		/**
		 * @var float
		 * @Column(type="FLOAT", null="false", precision="10,0", default="0")
		 */
		protected $score;
	
		/**
		 * @var integer
		 * @Column(type="INT", null="false", default="0")
		 */
		protected $count;

        /**
         * @var float
         * @Column(type="FLOAT", null="false", precision="10,0", default="0")
         */
        protected $sum;

        /**
         * Find creation by id
         * @param $id int
         * @return Creation
         */
        public static function findById($id){
            return Creation::find()
                ->where('Creation.id = :id')
                ->vars('id', $id)
                ->fetch()
                ->first();
        }

        /**
         * Find top best rated creation
         * @param $number int
         * @return Collection
         */
        public static function findByScoreAsc($number){
            return Creation::find()
                ->orderBy('Creation.score DESC')
                ->limit(0, $number)
                ->fetch();
        }
	}