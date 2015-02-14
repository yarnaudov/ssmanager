<div id="edit-account-modal" class="modal fade" data-backdrop="static" >
	<div class="modal-dialog">
		<div class="modal-content">
			
			<form class="form-horizontal" role="form" method="post" action="<?php echo Uri::create('manageAccounts'); ?>" >
			
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Change account</h4>
				</div>
				<div class="modal-body">					
					
					<div class="message" ></div>
					
					<input type="hidden" class="form-control input-sm" name="org_username" id="org_username" >
						
					<div class="form-group">
						<label for="password" class="col-sm-3 control-label">Username</label>
						<div class="col-sm-9">
							<input type="text" class="form-control input-sm" name="username" id="username" >
						</div>
					</div>
					<div class="form-group">
						<label for="password" class="col-sm-3 control-label">* Password</label>
						<div class="col-sm-9">
							<input type="password" class="form-control input-sm" name="password" id="password" >
						</div>
					</div>
					<div class="form-group">
						<label for="new_password2" class="col-sm-3 control-label">* Confirm Password</label>
						<div class="col-sm-9">
							<input type="password" class="form-control input-sm" name="password2" id="password2" >
						</div>
					</div>	
					<div class="form-group access">
						<label for="password" class="col-sm-3 control-label">Access</label>
						<div class="col-sm-9 rights">
							<?php foreach($app->config['access'] as $key => $access){ ?>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="access[<?php echo $key; ?>]" value="1" >
									<?php echo $access; ?>
								</label>
							</div>
							<?php } ?>
							<?php foreach($app->modules as $key => $module){ ?>
							<div class="separator" ><span><?php echo $module['title']; ?></span></div>
							<?php foreach($module['access'] as $key => $access){ ?>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="access[<?php echo $key; ?>]" value="1" >
									<?php echo $access; ?>
								</label>
							</div>
							<?php } ?>
							<?php } ?>
						</div>
						<div class="col-md-9 full" >* This account has full access</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-12" >* Only if you want to change user password</div>
					</div>
								
				</div>
				<div class="modal-footer">
					<a href="#" class="pull-left" data-target="#manage-accounts-modal" data-toggle="modal" data-dismiss="modal" >Back to accounts</a>
					<button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
			
			</form>
			
		</div>
	</div>
</div>
