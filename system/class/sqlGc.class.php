<?php
	/*\
	 | ------------------------------------------------------
	 | @file : sqlGc.class.php
	 | @author : fab@c++
	 | @description : class facilitant la gestion des requ�tes SQL
	 | @version : 2.0 b�ta
	 | ------------------------------------------------------
	\*/
	
	class sqlGc{
		protected $var            = array();       //liste des variables
		protected $query          = array();       //liste des requ�tes
		protected $bdd            = array();       //connexion sql
		protected $error          = array();       //erreur
		protected $cache                   ;       //r�f�rence vers un objet de type cache
		protected $time                    ;       //dur�e de mise en cache
		const PARAM_INT                 = 1;       //les param�tres des variables, en relation avec PDO::PARAM_
		const PARAM_BOOL                = 5;
		const PARAM_NULL                = 0;
		const PARAM_STR                 = 2;
		const PARAM_FETCH               = 0;
		const PARAM_FETCHCOLUMN         = 1;
		const PARAM_FETCHINSERT         = 2;
		
		public  function __construct($bdd){
			$this->bdd = $bdd;
		}
		
		public function setVar($var = array()){
			foreach($var as $cle => $valeur){
				$this->var[$cle] = $valeur;
			}
		}
		
		public function query($nom, $query, $time=0){
			$this->query[''.$nom.''] = $query;
			$this->time[''.$nom.''] = $time;
		}

		public function  fetch($nom, $fetch = self::PARAM_FETCH){
			$this->cache = new cacheGc($nom.'.sql', "", $this->time[''.$nom.'']);
			
			if($this->cache->isDie() || $fetch == self::PARAM_FETCHINSERT){
				$query = $this->bdd->prepare(''.$this->query[''.$nom.''].'');
				$GLOBALS['appDevGc']->addSql(''.$this->query[''.$nom.''].'');
				
				foreach($this->var as $cle => $val){
					if(preg_match('#'.$cle.'#', $this->query[''.$nom.''])){
						if(is_array($val)){
							$query->bindValue($cle,$val[0],$val[1]);
							$GLOBALS['appDevGc']->addSql('_'.$cle.' : '.$val[0]);
						}
						else{
							switch(gettype($val)){
								case 'boolean' :
									$query->bindValue(":$cle",$val,self::PARAM_BOOL);
									$GLOBALS['appDevGc']->addSql('_'.$cle.' : '.$val);
								break;
								
								case 'integer' :
									$query->bindValue(":$cle",$val,self::PARAM_INT);
									$GLOBALS['appDevGc']->addSql('_'.$cle.' : '.$val);
								break;
								
								case 'double' :
									$query->bindValue(":$cle",$val,self::PARAM_STR);
									$GLOBALS['appDevGc']->addSql('_'.$cle.' : '.$val);
								break;
								
								case 'string' :
									$query->bindValue(":$cle",$val,self::PARAM_STR);
									$GLOBALS['appDevGc']->addSql('_'.$cle.' : '.$val);
								break;
								
								case 'NULL' :
									$query->bindValue(":$cle",$val,self::PARAM_NULL);
									$GLOBALS['appDevGc']->addSql($cle.' : '.$val);
								break;
								
								default :
									$this->_addError('type non g�r�');
								break;
							}
						}
					}
					
				}
				$GLOBALS['appDevGc']->addSql('####################################');
				$query->execute();
				
				switch($fetch){
					case self::PARAM_FETCH : $data = $query->fetchAll(); break;
					case self::PARAM_FETCHCOLUMN : $data = $query->fetchColumn(); break;
					case self::PARAM_FETCHINSERT : $data = true; break;
					default : $this->_addError('cette constante n\'existe pas'); $data=""; break;
				}
				
				switch($fetch){
					case self::PARAM_FETCH :
						case self::PARAM_FETCHCOLUMN : 
							$this->cache->setVal($data);
							$this->cache->setCache($data);
							return $this->cache->getCache(); break;
					case self::PARAM_FETCHINSERT : return true; break;
					default : $this->_addError('cette constante n\'existe pas'); $data=""; break;
				}
			}
			else{
				return $this->cache->getCache();
			}
		}
		
		private function _showError(){
			foreach($this->error as $error){
				$erreur .=$error."<br />";
			}
			return $erreur;
		}
		
		private function _addError($error){
			array_push($this->error, $error);
		}
	}
?>