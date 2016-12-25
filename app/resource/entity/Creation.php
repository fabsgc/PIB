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
     * @property Collection video
     * @property integer subtitle
     * @property float score
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
         * @var Collection
         * @ManyToOne(to="Video.id")
         */
        protected $video;
    
        /**
         * @var integer
         * @Column(type="INT", null="false")
         */
        protected $subtitle;
    
        /**
         * @var float
         * @Column(type="FLOAT", null="false", precision="10,0")
         */
        protected $score;

		/**
		 * Find creation by id
		 * @param $id int
		 * @return Creation
		 */
		public static function findById($id){
			return Creation::find()
				->where('Creation.id = :id')
				->vars('id', $id)
				->fetch();
		}

		/**
		 * Find top best rated creation
		 * @param $number int
		 * @return Collection
		 */
		public static function findByScoreAsc($number){
			return Creation::find()
				->orderBy('Creation.score ASC')
				->limit(0, $number)
				->fetch();
		}
    }