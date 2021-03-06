<!DOCTYPE html>
<html lang="<?php echo Config::get('language'); ?>" >
	<head>
		<meta charset="utf-8">
		<title>Log In - SSManager</title>

		<?php echo Asset::css('bootstrap.css'); ?>
		<?php echo Asset::css('style.css'); ?>
		<?php echo Asset::js('jquery-2.1.1.js'); ?>
		<?php echo Asset::js('bootstrap.js'); ?>

		<base href="<?php echo Uri::base(); ?>" >

	</head>
	<body>
		
		<div id="log-in-modal" class="modal fade" data-backdrop="static" >
			<div class="modal-dialog">
				<div class="modal-content">

					<form class="form-horizontal" role="form" action="<?php echo \Uri::create('login'); ?>" method="post">

						<div class="modal-header">
							<h4 class="modal-title">Please log in</h4>
						</div>
						<div class="modal-body">
							<?php foreach($messages as $error){ echo $error; } ?>					
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
							<button type="submit" class="btn btn-primary">Log In</button>
						</div>

					</form>

				</div>
			</div>
		</div>

		<script type="text/javascript" >$('.modal').modal();</script>
	
	</body>
</html>