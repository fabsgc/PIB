<?php
	/**
	 * @file : generalGc.class.php
	 * @author : fab@c++
	 * @description : traits
	 * @version : 2.0 b�ta
	*/

	trait generalGc{
		public function windowInfo($Title, $Content, $Time, $Redirect, $lang="fr"){
			?>
				<link href="asset/css/default.css" rel="stylesheet" type="text/css" media="screen, print, handheld" />
			<?php
			$tpl = new templateGC(GCSYSTEM_PATH.'GCtplGc_windowInfo', 'tplGc_windowInfo', 0, $lang);
			
			$tpl->assign(array(
				'title'=>$Title,
				'content'=>$Content,
				'redirect'=>$Redirect,
				'time'=>$Time,
			));
				
			$tpl->show();
		}
		
		public function blockInfo($Title, $Content, $Time, $Redirect, $lang="fr"){
			$tpl = new templateGC(GCSYSTEM_PATH.'GCtplGc_blockInfo', 'tplGc_blockInfo', 0, $lang);
			
			$tpl->assign(array(
				'title'=>$Title,
				'content'=>$Content,
				'redirect'=>$Redirect,
				'time'=>$Time,
			));
				
			$tpl->show();
		}
		
		public function setErrorLog($file, $message){
			$file = fopen(LOG_PATH.$file.LOG_EXT, "a+");
			fputs($file, date("d/m/Y � H:i:s ! : ",time()).$message."\n");
		}
		
		public function sendMail($email, $message_html, $sujet, $envoyeur){
			if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $email)){
				$passage_ligne = "\r\n";
			}
			else{
				$passage_ligne = "\n";
			}
	 
			//=====Cr�ation de la boundary
			$boundary = "-----=".md5(rand());
			//==========
			
			//=====Cr�ation du header de l'e-mail.
			$header = "From: \"".$envoyeur."\"<contact@legeekcafe.com>".$passage_ligne;
			$header.= "Reply-to: \"".$envoyeur."\" <contact@legeekcafe.com>".$passage_ligne;
			$header.= "MIME-Version: 1.0".$passage_ligne;
			$header.= "Content-Type: multipart/alternative;".$passage_ligne." boundary=\"$boundary\"".$passage_ligne;
			//==========
			 
			//=====Cr�ation du message.
			$message = $passage_ligne.$boundary.$passage_ligne;
			
			$message.= $passage_ligne."--".$boundary.$passage_ligne;
			//=====Ajout du message au format HTML
			$message.= "Content-Type: text/html; charset=\"ISO-8859-1\"".$passage_ligne;
			$message.= "Content-Transfer-Encoding: 8bit".$passage_ligne;
			$message.= $passage_ligne.$message_html.$passage_ligne;
			//==========
			$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
			$message.= $passage_ligne."--".$boundary."--".$passage_ligne;
			//==========
			
			//=====Envoi de l'e-mail.
			return mail($email,$sujet,$message,$header);
			//==========		
		}
		
		public function getIp(){
			return $_SERVER['REMOTE_ADDR'];
		}
	
		public function getQuery(){
			return $_SERVER['QUERY_STRING'];
		}
		
		public function getPhpSelf(){
			return $_SERVER['PHP_SELF'];
		}
		
		public function getHost(){
			return $_SERVER['HTTP_HOST'];
		}
		
		public function getUri(){
			return $_SERVER['REQUEST_URI'];
		}
		
		public function getReferer(){
			return $_SERVER['HTTP_REFERER'];
		}
		
		public function getServerName(){
			return $_SERVER['SERVER_NAME'];
		}
	}
	
	trait errorGc{
		protected $_error              = array() ; //array contenant toutes les erreurs enregistr�es
		
		public function showError(){
			$erreur = "";
			foreach($this->_error as $error){
				$erreur .=$error."<br />";
			}
			return $erreur;
		}
		
		protected function _addError($error){
			array_push($this->_error, $error);
			$file = fopen(LOG_PATH.'system_errors'.LOG_EXT, "a+");
			fputs($file, date("d/m/Y � H:i:s ! : ",time()).' fichier '.__FILE__.' ligne '.__LINE__.' '.$error."\n");
			fclose($file);
		}
    }
	
	trait langInstance{
		protected $_lang                                        ; //gestion des langues via des fichiers XML
		protected $_langInstance                                ; //instance de la class langGc
		
		public function getLangClient(){
			if(!array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER) || !$_SERVER['HTTP_ACCEPT_LANGUAGE'] ) { return DEFAULTLANG; }
			else{
				$langcode = (!empty($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ? $_SERVER['HTTP_ACCEPT_LANGUAGE'] : '';
				$langcode = (!empty($langcode)) ? explode(";", $langcode) : $langcode;
				$langcode = (!empty($langcode['0'])) ? explode(",", $langcode['0']) : $langcode;
				$langcode = (!empty($langcode['0'])) ? explode("-", $langcode['0']) : $langcode;
				return $langcode['0'];
			}
		}
    }
	
	trait urlRegex{
		public function getUrl($id, $var = array()){
			if(REWRITE == true){
				$domXml = new DomDocument('1.0', 'iso-8859-15');
				if($domXml->load(ROUTE)){
					$this->_addError('fichier ouvert : '.ROUTE);
				}
				else{
					$this->_addError('Le fichier '.ROUTE.' n\'a pas pu �tre ouvert');
				}
				
				$nodeXml = $domXml->getElementsByTagName('routes')->item(0);
				$markupXml = $nodeXml->getElementsByTagName('route');
				
				$rubrique = "";
				
				foreach($markupXml as $sentence){	
					if ($sentence->getAttribute("id") == $id){
						$url = preg_replace('#\((.*)\)#isU', '<($1)>',  $sentence->getAttribute("url"));
						$urls = explode('<', $url);
						$i=0;
						foreach($urls as $url){
							if(preg_match('#\)>#', $url)){
								$result.= preg_replace('#\((.*)\)>#U', $var[$i], $url);
								$i++;
							}
							else{
								$result.=$url;
							}
						}
						$result = preg_replace('#\/#U', '', $result);
						$result = preg_replace('#\\\.#U', '.', $result);
						return $result;
					}
				}
			}
			else{
				$url = preg_replace('#\((.*)\)#isU', '<($1)>',  $regex);
				$urls = explode('<', $url);
				$i=0;
				foreach($urls as $url){
					if(preg_match('#\)>#', $url)){
					$result.= preg_replace('#\((.*)\)>#U', $var[$i], $url);
					$i++;
					}
					else{
						$result.=$url;
					}
				}
			  $result = preg_replace('#\/#U', '', $result);
			  $result = preg_replace('#\\\.#U', '.', $result);
			  return $result;
			}
		}
	}
	
	abstract class constMime{
		const EXT_ZIP                   = 'application/gzip'                         ;
		const EXT_GZ                    = 'application/x-gzip'                       ;
		const EXT_PDF                   = 'application/pdf'                          ;
		const EXT_JS                    = 'application/javascript'                   ;
		const EXT_OGG                   = 'application/ogg'                          ;
		const EXT_EXE                   = 'application/octet-stream'                 ;
		const EXT_DOC                   = 'application/msword'                       ;
		const EXT_XLS                   = 'application/vnd.ms-excel'                 ;
		const EXT_PPT                   = 'application/vnd.ms-powerpoint'            ;
		const EXT_DEFAULT               = 'application/force-download'               ;
		const EXT_XML                   = 'application/xml'                          ;
		const EXT_FLASH                 = 'application/x-shockwave-flash'            ;
		const EXT_JSON                  = 'application/json'                         ;
		const EXT_PNG                   = 'image/png'                                ;
		const EXT_GIF                   = 'image/gif'                                ;
		const EXT_JPG                   = 'image/jpeg'                               ;
		const EXT_TIFF                  = 'image/tiff'                               ;
		const EXT_ICO                   = 'image/vnd.microsoft.icon'                 ;
		const EXT_SVG                   = 'image/svg+xml'                            ;
		const EXT_JPEG                  = 'image/jpeg'                               ;
		const EXT_TXT                   = 'text/plain'                               ;
		const EXT_HTM                   = 'text/html'                                ;
		const EXT_HTML                  = 'text/html'                                ;
		const EXT_CSV                   = 'text/csv'                                 ;
		const EXT_MPEGAUDIO             = 'audio/mpeg'                               ;
		const EXT_RPL                   = 'audio/vnd.rn-realaudio'                   ;
		const EXT_WAV                   = 'audio/x-wav'                              ;
		const EXT_MPEG                  = 'video/mpeg'                               ;
		const EXT_MP4                   = 'video/mp4'                                ;
		const EXT_QUICKTIME             = 'video/quicktime'                          ;
		const EXT_WMV                   = 'video/x-ms-wmv'                           ;
		const EXT_AVI                   = 'video/x-msvideo'                          ;
		const EXT_FLV                   = 'video/x-flv'                              ;
		const EXT_ODT                   = 'application/vnd.oasis.opendocument.text'                                     ;
		const EXT_ODTCALC               = 'application/vnd.oasis.opendocument.spreadsheet'                              ;
		const EXT_ODTPRE                = 'application/vnd.oasis.opendocument.presentation'                             ;
		const EXT_ODTGRA                = 'application/vnd.oasis.opendocument.graphics'                                 ;
		const EXT_XLS2007               = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'           ;
		const EXT_DOC2007               = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'     ;
		const XUL                       = 'application/vnd.mozilla.xul+xml'                                             ;
	}