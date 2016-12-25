<?php
	namespace Orm\Entity;

	
	use System\Orm\Entity\Entity;

	/**
	 * Class Test
	 * @Table(name="test")
	 * @Form(name="form-test")
	 * @property integer id
	 * @property string title
	 * @property string content
	 * @package Orm\Entity
	 */

	class Test extends Entity {
	
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
		 * @var string
		 * @Column(type="TEXT", size="65535", null="false")
		 */
		protected $content;
	
	}