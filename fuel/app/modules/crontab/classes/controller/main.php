<?php

namespace Crontab;
use \Response;
use \View;
use \Asset;

class Controller_Main extends \Controller_Main
{

	private $shell;
	
	public function before()
	{
		parent::before();
		
		$this->shell = new \Shell();
		$this->shell->save_wd = false;
		
	}
	
	public function action_index()
	{				
	
		$asset = Asset::forge('crontab', array('paths' => array('assets/crontab'), 'auto_render' => false));
		$asset->js('scripts.js');
		$asset->css('style.css');

		return Response::forge(View::forge('index'));
		
	}
	
	public function action_jobs(){
		
		$jobs = $this->shell->exec('crontab -l');
		//echo $jobs . "<-------<br>";
		$jobs = explode(PHP_EOL, $jobs);
				
		$jobsArr = array();
		
		foreach($jobs as $job){
			
			if(preg_match('/^MAILTO="([a-z0-9@\.]*)"/', $job, $match)){
				$jobsArr['mailto'] = $match[1];
				continue;
			}
			
			$job = explode(" ", $job);
			if(count($job) >= 5){
			
				$jobArr = array(
					'min' => $job[0],
					'hour' => $job[1],
					'day' => $job[2],
					'month' => $job[3],
					'weekday' => $job[4],
				);
				unset($job[0], $job[1], $job[2], $job[3], $job[4]);

				$jobArr['command'] = implode(' ', $job);
				
				$jobsArr['jobs'][] = $jobArr;
			}
			
		}
		
		echo json_encode($jobsArr);
	}
	
	public function action_save(){
		
		$data = \Input::post('data');
		$crontab = '';
		
		if(isset($data['mailto']) && !empty($data['mailto'])){
			$crontab .= 'MAILTO="' . $data['mailto'] . '"' . PHP_EOL;
		}
		
		if(isset($data['jobs'])){
			foreach($data['jobs'] as $job){
				$crontab .= implode(" ", $job) . PHP_EOL;
			}
		}
		
		$tmpfname = tempnam(sys_get_temp_dir(), 'CRON');	
		if(is_writable($tmpfname)){
			file_put_contents($tmpfname, $crontab);
		}
		
		echo json_encode(array('result' => $this->shell->exec('crontab ' . $tmpfname)));
		 		
	}
	
}
