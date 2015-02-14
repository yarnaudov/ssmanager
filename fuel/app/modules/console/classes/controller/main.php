<?php

namespace Console;
use \Response;
use \View;
use \Asset;

class Controller_Main extends \Controller_Main
{

	public function before()
	{
		
		parent::before();
		
		if(!isset($_COOKIE['wd'])){
			new \Shell();
		}
		
	}
	
	public function action_index()
	{
		
		//Asset::add_path('assets/console');
		
		$asset = Asset::forge('console', array('paths' => array('assets/console'), 'auto_render' => false));
		$asset->js('scripts.js');
		$asset->js('http://ace.c9.io/build/src-min-noconflict/ace.js');
		$asset->css('style.css');
				
		return Response::forge(View::forge('index'));
		
	}
	
	public function action_exec()
	{
		
		$cmd = trim($_POST['cmd']);
		$shell = new \Shell();
		$cmd_output = $shell->exec($cmd);
		
		$cmd_output = preg_replace('/(d[rwx-]{9}.*([0-9]{2}:[0-9]{2}|[0-9]{4}) )(.*)('.PHP_EOL.'|$)/', '$1<span class="dir" >$3</span>'.PHP_EOL, $cmd_output);
		$cmd_output = preg_replace('/(l[rwx-]{9}.*([0-9]{2}:[0-9]{2}|[0-9]{4}) )(.*)('.PHP_EOL.'|$)/', '$1<span class="link" >$3</span>'.PHP_EOL, $cmd_output);
		$cmd_output = preg_replace('/(-[rwx-]{9}.*([0-9]{2}:[0-9]{2}|[0-9]{4}) )(.*)('.PHP_EOL.'|$)/', '$1<span class="file" >$3</span>'.PHP_EOL, $cmd_output);
			
		echo $cmd_output;
		exit;
		
		
	}
	
	public function action_savefile()
	{
		
		$file = trim($_POST['file']);
		$data = $_POST['data'];
		
		if(is_writable($file)){
			echo file_put_contents($file, $data);
		}
		else{
			echo "no-permission";
		}
		exit;
	
	}
	
}
