<!DOCTYPE html>
<html lang="<?php echo Config::get('language'); ?>" >
<head>
	<meta charset="utf-8">
	<title>SSManager</title>
	<meta name="robots" content="noindex, nofollow">
	
	<?php echo Asset::css('bootstrap.css'); ?>
	<?php echo Asset::css('style.css'); ?>
	<?php echo Asset::js('jquery-2.1.1.js'); ?>
	<?php echo Asset::js('bootstrap.js'); ?>
	<?php echo Asset::js('scripts.js'); ?>
	
	<base href="<?php echo Uri::base(); ?>" >
	
</head>
<body>
	
	<div class="wrapper">
		
		<header>
			<div class="container-fluid">
				<div class="row">				
					<div class="col-md-8 col-sm-8">
						<span id="logo">SSManager</span>
					</div>
					<div class="col-md-4 col-sm-4 right">
						<div class="btn-group">Welcome: <span id="username" ><?php echo Session::get('username'); ?></span></div>
						<div class="btn-group username">						
							<a title="logout" href="<?php echo Uri::create('main/logout'); ?>">
								<button class="btn btn-xs btn-danger" type="button">
									<span class="glyphicon glyphicon-log-out"></span>
								</button>
							</a>
						</div>
						<div class="btn-group">
							<button class="btn btn-xs btn-warning dropdown-toggle" data-toggle="dropdown" type="button">
								<span class="glyphicon glyphicon-cog"></span>
								Settings
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu dropdown-menu-right" role="menu">
								<li>
									<a data-toggle="modal" data-target="#change-password-modal" href="#">Change password</a>
								</li>
								<li>
									<a data-toggle="modal" data-target="#manage-users-modal" href="#">Manage users</a>
								</li>
								<li class="divider" role="presentation"></li>
								<li>
									<a data-toggle="modal" data-target="#manage-accounts-modal" href="#">System settings</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</header>
	
		<div class="container-fluid">
			<div class="row">
				<div id="content" class="col-md-12">

					<!-- Nav tabs -->
					<ul class="nav nav-tabs modules" role="tablist">
						<?php foreach($modules as $module_name => $module){ ?>
						<li><a href="#<?php echo $module_name; ?>" role="tab" data-toggle="tab"><?php echo $module['title']; ?></a></li>
						<?php } ?>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<?php foreach($modules as $module_name => $module){ ?>
						<div class="tab-pane" id="<?php echo $module_name; ?>" >
							<?php echo Request::forge($module_name . '/main', false)->execute(); ?>
						</div>
						<?php } ?>
					</div>

				</div>
			</div>
		</div>
	
	</div>
		
	<footer>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-6 col-sm-6" >
					<p>© SSManager 2014</p>
				</div>
				<div class="col-md-6 col-sm-6" >
					<p class="pull-right">
						Powered by <a href="http://fuelphp.com">FuelPHP</a>
						<!-- Page rendered in {exec_time}s using {mem_usage}mb of memory.-->
					</p>
				</div>
			</div>
		</div>
	</footer>
	
	<div id="manage-users-modal" class="modal fade" >
		<div class="modal-dialog">
			<div class="modal-content">

				<form class="form-horizontal" role="form" method="post" action="<?php echo Uri::create('manageAccounts'); ?>" >

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">Manage users</h4>
					</div>
					<div class="modal-body">					

						<div class="message" ></div>

						<?php echo Request::forge('main/users', false)->execute(); ?>

						<a href="#" class="add-user" data-dismiss="modal" ><span class="glyphicon glyphicon-plus" ></span> Add new user</a>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
					</div>

				</form>

			</div>
		</div>
	</div>
	
	<div id="log-in-modal" class="modal fade" data-backdrop="static" >
		<div class="modal-dialog">
			<div class="modal-content">

				<form class="form-horizontal" role="form" action="<?php echo \Uri::create('login'); ?>" method="post">

					<div class="modal-header">
						<h4 class="modal-title">Please log in</h4>
					</div>
					<div class="modal-body">
						
						<div class="message" ></div>
						
						<div class="form-group">
							<label for="username" class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10">
								<input type="text" class="form-control input-sm" name="username" id="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>" >
							</div>
						</div>
						<div class="form-group">
							<label for="username" class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10">
								<input type="password" class="form-control input-sm" name="password" id="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" >
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary">Log In</button>
					</div>

				</form>

			</div>
		</div>
	</div>
	
	<div id="add-user-modal" class="modal fade" data-backdrop="static" >
		<div class="modal-dialog">
			<div class="modal-content">
		
				<form class="form-horizontal" role="form" method="post" action="<?php echo Uri::create('main/saveUser'); ?>" >

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">Add user</h4>
					</div>
					<div class="modal-body">					

						<div class="message" ></div>
						
						<?php echo Request::forge('main/user', false)->execute(); ?>
						
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" >Add</button>
						<button type="button" class="btn btn-default cancel" data-dismiss="modal" >Cancel</button>
					</div>

				</form>
				
			</div>
		</div>
	</div>
	
	<div id="edit-user-modal" class="modal fade" data-backdrop="static" >
		<div class="modal-dialog">
			<div class="modal-content">
		
				<form class="form-horizontal" role="form" method="post" action="<?php echo Uri::create('main/saveUser'); ?>" >

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">Edit user</h4>
					</div>
					<div class="modal-body">
						<div class="message" ></div>
						<div class="user-form"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" >Save</button>
						<button type="button" class="btn btn-default cancel" data-dismiss="modal" >Cancel</button>
					</div>

				</form>
				
			</div>
		</div>
	</div>
	
	<div id="change-password-modal" class="modal fade" >
		<div class="modal-dialog">
			<div class="modal-content">

				<form class="form-horizontal" role="form" method="post" action="<?php echo Uri::create('main/changePassword'); ?>" >

					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">Change password</h4>
					</div>
					<div class="modal-body">					

						<div class="message" ></div>

						<div class="form-group">
							<label for="password" class="col-sm-4 control-label">Current password</label>
							<div class="col-sm-8">
								<input type="password" class="form-control input-sm" name="password" id="password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" >
							</div>
						</div>
						<div class="form-group">
							<label for="new_password" class="col-sm-4 control-label">New Password</label>
							<div class="col-sm-8">
								<input type="password" class="form-control input-sm" name="new_password" id="new_password" value="<?php echo isset($_POST['new_password']) ? $_POST['new_password'] : ''; ?>" >
							</div>
						</div>	
						<div class="form-group">
							<label for="new_password2" class="col-sm-4 control-label">Confirm New Password</label>
							<div class="col-sm-8">
								<input type="password" class="form-control input-sm" name="new_password2" id="new_password2" value="<?php echo isset($_POST['new_password2']) ? $_POST['new_password2'] : ''; ?>" >
							</div>
						</div>					
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary">Change</button>
						<button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
					</div>

				</form>

			</div>
		</div>
	</div>
	
	<div id="message-modal" class="modal fade" >
		<div class="modal-dialog">
			<div class="modal-content">

				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Message</h4>
				</div>
				
				<div class="modal-body"></div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
				</div>

			</div>
		</div>
	</div>
	
	<?php foreach($modules as $module_name => $module){
			if(Asset::instance($module_name)){
				echo Asset::instance($module_name)->render();
			}
		  } ?>
		
</body>
</html>
