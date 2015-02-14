<?php

class Uri extends Fuel\Core\Uri
{

	private static $_language_in_uri = false;
	
	public function __construct($uri = NULL){
		parent::__construct($uri);
		$this->_detect_language();
	}

	private function _detect_language(){
		
		if(!count($this->segments)){
			return false;
		}

		$language = $this->segments[0];
		$locales = Config::get('locales');

		if(array_key_exists($language, $locales)){
			
			array_shift($this->segments);
			$this->uri = implode('/', $this->segments);

			if($language !== Config::get('language')){
				self::$_language_in_uri = true;
			}
			
			Config::set('language', $language);
			Config::set('locale', $locales[$language]);
			
		}
		
	}
	
	public static function create($uri = null, $variables = array(), $get_variables = array(), $secure = null){

		if(self::$_language_in_uri != false){
			$uri = Config::get('language').'/'.$uri;
		}
		
		return parent::create($uri, $variables, $get_variables, $secure);
		
	}
	
}
