<div id="change-password-modal" class="modal fade" >
	<div class="modal-dialog">
		<div class="modal-content">
			
			<form class="form-horizontal" role="form" method="post" action="<?php echo Uri::create('manageAccounts'); ?>" >
			
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
					<button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
					<button type="submit" class="btn btn-primary">Change</button>
				</div>
			
			</form>
			
		</div>
	</div>
</div>
