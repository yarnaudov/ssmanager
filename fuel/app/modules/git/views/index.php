<div class="row">
	
	<div class="col-lg-3 col-md-4" >
		
				<div id="repositories" class="list-group"></div>				
				<a href="#" class="btn btn-success" data-toggle="modal" data-target="#new-repository-modal" ><span class="glyphicon glyphicon-plus"></span> New repository</a>
		
				
	</div>
	
	<div class="col-lg-9 col-md-8" >
		<div id="repository-details" ></div>
	</div>
	
</div>

<div id="new-repository-modal" class="modal fade" data-backdrop="static" >
	<div class="modal-dialog">
		<div class="modal-content">
						
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Create new repository</h4>
			</div>
			<div class="modal-body">					
				
				<div class="message" ></div>
				
				<div class="form-horizontal form" >
					
					<div class="form-group">
						<label for="url" class="col-sm-2 control-label">URL</label>
						<div class="col-sm-10">
							<input type="text" name="url" id="url" class="form-control input-sm" > 
						</div>
					</div>
					
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">Name</label>
						<div class="col-sm-10">
							
							<div class="input-group">
								<div class="input-group-addon"><?php echo realpath(DOCROOT . '../../') . '/'; ?></div>
								<input type="text" name="name" id="name"  class="form-control input-sm" > 
							</div>
						</div>
					</div>
					
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
				<button type="button" class="btn btn-primary btn-create-repo" >Create</button>				
			</div>
			
		</div>
	</div>
</div>

<div id="switch-branch-modal" class="modal fade" data-backdrop="static" >
	<div class="modal-dialog">
		<div class="modal-content">
						
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Switch to branch</h4>
			</div>
			<div class="modal-body">					
				
				<p class="message" ></p>
				<p class="text" >
					<br/>You will switch from branch <b class="active-branch" ></b> to <b class="switch-branch" ></b><br/>
					Are you sure?
				</p>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
				<button type="button" class="btn btn-primary btn-switch" >Switch</button>				
			</div>
			
		</div>
	</div>
</div>

<div id="pull-branch-modal" class="modal fade" data-backdrop="static" >
	<div class="modal-dialog">
		<div class="modal-content">
						
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Pull branch</h4>
			</div>
			<div class="modal-body">					
				
				<p class="message" ></p>
				<p class="text" >
					<br/>Branch <b class="pull-branch" ></b> will be merged into the current branch <b class="active-branch" ></b>
					<br/>Are you sure?
				</p>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>
				<button type="button" class="btn btn-primary btn-pull" >Pull</button>				
			</div>
			
		</div>
	</div>
</div>

<div id="commit-details-modal" class="modal fade" >
	<div class="modal-dialog">
		<div class="modal-content">
						
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Commit details</h4>
			</div>
			<div class="modal-body">					
								
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal" >Close</button>			
			</div>
			
		</div>
	</div>
</div>