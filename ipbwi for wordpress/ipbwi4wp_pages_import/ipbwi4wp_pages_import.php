<?php
	/*
	Plugin Name: IPBWI for WordPress v4 - Pages Import
	Plugin URI: https://ipbwi.com
	Description: Bulk import pages from IP.pages to WordPress
	Version: 4.0.1
	Author: Matthias Reuter
	Author URI: https://straightvisions.com
	*/

	class ipbwi4wp_pages_import extends ipbwi4wp{
		public $ipbwi				= NULL;
		public $ipbwi4wp			= NULL;
		public $path				= false;
		public $basename			= false;
		public $url					= false;
		public $version				= false;
		/**
		 * @desc			Load's requested libraries dynamicly
		 * @param	string	$name library-name
		 * @return			class object of the requested library
		 * @author			Matthias Reuter
		 * @since			4.0
		 * @ignore
		 */
		public function __get($name){
			if(file_exists($this->path.'lib/modules/'.$name.'.php')){
				require_once($this->path.'lib/modules/'.$name.'.php');
				$classname			= 'ipbwi4wp_pages_import_'.$name;
				$this->$name		= new $classname($this);
				return $this->$name;
			}else{
				throw new Exception('Class '.$name.' could not be loaded (tried to load class-file '.$this->path.'lib/'.$name.'.php'.')');
			}
		}
		/**
		 * @desc			initialize plugin
		 * @author			Matthias Reuter
		 * @since			4.0
		 * @ignore
		 */
		public function __construct(){
			$this->path				= WP_PLUGIN_DIR.'/'.dirname(plugin_basename(__FILE__)).'/';
			$this->basename			= plugin_basename(__FILE__);
			$this->url				= plugins_url( '' , __FILE__ ).'/';
			$this->version			= 4001;
			
			$this->ipbwi4wp			= $GLOBALS['ipbwi4wp'];
			
			// language settings
			load_textdomain('ipbwi4wp_pages_import', WP_LANG_DIR.'/plugins/ipbwi4wp_pages_import-'.apply_filters('plugin_locale', get_locale(), 'ipbwi4wp_pages_import').'.mo');
			load_plugin_textdomain('ipbwi4wp_pages_import', false, dirname(plugin_basename(__FILE__)).'/lib/assets/lang/');
			
			$this->settings->init();							// load settings
			$this->hooks->init();								// load hooks
		}
	}
	
	add_action('plugins_loaded','ipbwi4wp_pages_import');
	function ipbwi4wp_pages_import(){
		if(class_exists('ipbwi4wp')){
			$GLOBALS['ipbwi4wp_pages_import']			= new ipbwi4wp_pages_import();
		}
	}
?>