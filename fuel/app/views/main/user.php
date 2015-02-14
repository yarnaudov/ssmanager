
<div class="user-form">
	
	<?php if(isset($user)){ ?>
	<input type="hidden" name="org_username" value="<?php echo isset($user) ? $user['username'] : ''; ?>" >
	<?php } ?>
	
	<div class="form-group">
		<label for="password" class="col-sm-4 control-label">Username</label>
		<div class="col-sm-8">
			<input type="text" class="form-control input-sm" name="username" value="<?php echo isset($user) ? $user['username'] : ''; ?>" >
		</div>
	</div>
	<div class="form-group">
		<label for="password" class="col-sm-4 control-label"><?php echo isset($user) ? '* ' : ''; ?>Password</label>
		<div class="col-sm-8">
			<input type="password" class="form-control input-sm" name="password" id="password" >
		</div>
	</div>
	<div class="form-group">
		<label for="new_password2" class="col-sm-4 control-label"><?php echo isset($user) ? '* ' : ''; ?>Confirm Password</label>
		<div class="col-sm-8">
			<input type="password" class="form-control input-sm" name="password2" id="password2" >
		</div>
	</div>	
	<div class="form-group access">
		<label for="password" class="col-sm-3 control-label">Access</label>
		<div class="col-sm-9 rights">
			<?php /*foreach($app->config['access'] as $key => $access){ ?>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="access[<?php echo $key; ?>]" value="1" >
					<?php echo $access; ?>
				</label>
			</div>
			<?php }*/ ?>
			<?php /*foreach($app->modules as $key => $module){ ?>
			<div class="separator" ><span><?php echo $module['title']; ?></span></div>
			<?php foreach($module['access'] as $key => $access){ ?>
			<div class="checkbox">
				<label>
					<input type="checkbox" name="access[<?php echo $key; ?>]" value="1" >
					<?php echo $access; ?>
				</label>
			</div>
			<?php } ?>
			<?php }*/ ?>
		</div>
		<div class="col-md-9 full" >* This account has full access</div>
	</div>
	
	<?php if(isset($user)){ ?>
	<div class="form-group">
		<div class="col-md-12" >* Only if you want to change user password</div>
	</div>
	<?php } ?>
	
</div>