<?php
/**
 * Fuel is a fast, lightweight, community driven PHP5 framework.
 *
 * @package    Fuel
 * @version    1.7
 * @author     Fuel Development Team
 * @license    MIT License
 * @copyright  2010 - 2014 Fuel Development Team
 * @link       http://fuelphp.com
 */

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Controller_Main extends Controller
{

	private $jsonDB;
	
	public function before(){
				
		if(Session::get('username') === null && Request::active()->action !== 'login'){
			header("HTTP/1.0 401");
			if(Input::is_ajax() || (Request::active()->controller !== 'Controller_Main' && Request::active()->action !== 'index') ){				
				exit();
			}			
		}
		
		$this->jsonDB = new JsonDB(APPPATH .  'data/');
	}

	public function action_index()
	{
		$always_load = Config::get('always_load');
		
		foreach($always_load['modules'] as $module){
			$modules[$module] = Config::load($module . '::config');
		}
		
		return Response::forge(View::forge('main/index', array('modules' => $modules)));
	}

	public function action_login()
	{
		
		if(Session::get('username') !== null){
			Response::redirect_back('');
		}
		
		if (Input::post()){
			
			$user = $this->jsonDB->select('users', 'username', Input::post('username'));

			$password = Crypt::encode(Input::post('password'));
			
			if(!empty($user) && $user[0]['password'] === $password){
				Session::set('username', $user[0]['username']);
				echo json_encode(array('success' => true, 'user' => $user[0]));
			}
			else{
				header("HTTP/1.0 202");
				echo json_encode(array('errors' => array('Wrong username/password combo. Try again')));
			}
		}
		
		exit;
		
	}
	
	public function action_logout()
	{
		
		Session::delete('username');
		\Response::redirect('');
		
	}

	public function action_users()
	{
		
		$users = $this->jsonDB->selectAll('users');				
		return Response::forge(View::forge('main/users', array('users' => $users)));
		
	}
	
	public function action_user($username = false)
	{
		
		$view = View::forge('main/user');
		
		if($username !== false){
			$user = $this->jsonDB->select('users', 'username', $username);
			if(!empty($user)){
				$view->user = $user[0];
			}
		}
		return Response::forge($view);
		
	}
	
	public function action_changePassword()
	{
		
		$user = $this->jsonDB->select('users', 'username', Session::get('username'));
		if(empty($user)){ return false; }
		
		$val = Validation::forge();
		
		$val->add_field('password', 'Password', 'required|match_value[' . Crypt::decode($user[0]['password']) . ']');		
		$val->add_field('new_password', 'New Password', 'required');
		$val->add_field('new_password2', 'Confirm new password', 'required|match_field[new_password]');
		
		$val->set_message('match_value', 'Current password not match');
		$val->set_message('required', 'This field is required.');
		
		if ($val->run()){			
			$user[0]['password'] = Crypt::encode(Input::post('new_password'));;
			$this->jsonDB->update('users', 'username', $user[0]['username'], $user[0]);
			echo json_encode(array('success' => true, 'message' => 'Password successfuly changes'));
		}
		else{
			echo json_encode(array('errors' => $val->error_message()));
		}
		exit;
		
	}
	
	public function action_saveUser()
	{
		$username = Input::post('org_username');
		
		if($username !== false){
			$user = $this->jsonDB->select('users', 'username', $username);
			if(empty($user)){ return false; }
		}
		
		$val = Validation::forge();
		
		$val->add_field('username', 'Username', 'required|min_length[3]|max_length[10]');
		
		if($username !== false){
			$val->add_field('password', 'Password', 'match_field[password]');
			$val->add_field('password2', 'Confirm password', 'match_field[password]');
		}
		else{
			$val->add_field('password', 'Password', 'required');
			$val->add_field('password2', 'Confirm password', 'required|match_field[password]');
		}
		
		$val->set_message('required', 'This field is required.');
		$val->set_message('min_length', 'This field has to contain at least 3 characters.');
		$val->set_message('max_length', 'This field may not contain more than 10 characters.');
		
		if ($val->run()){
			
			$user[0] = array(
				'username' => Input::post('username'),				
				'permissions' => '*'
			);
			
			if($username === false || Input::post('password')){
				$user[0]['password'] = Crypt::encode(Input::post('password'));
			}
			
			if($username !== false){
				$this->jsonDB->update('users', 'username', $username, $user[0]);
			}
			else{
				$this->jsonDB->insert('users', $user);
			}
			
			echo json_encode(array('success' => true, 'user' => $user[0]));
			
		}
		else{
			echo json_encode(array('errors' => $val->error_message()));
		}
		exit;
		
	}
	
	/**
	 * The 404 action for the application.
	 *
	 * @access  public
	 * @return  Response
	 */
	public function action_404()
	{
		return Response::forge(Presenter::forge('main/404'), 404);
	}
}
