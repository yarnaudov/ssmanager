
<div id="console-output" ></div>

<div class="row console-custom-commands">
	<div class="col-md-10 col-sm-10">
		<div id="wd"><?php echo $_COOKIE['wd']; ?></div>
		<div class="input-group input-group-sm">
			<span class="input-group-btn dropup">
				<button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
					<span class="caret"></span>
				</button>
				<ul id="console-commands-history" class="dropdown-menu" role="menu"></ul>
			</span>
			<input id="console-command" class="form-control" type="text">
			<span class="input-group-btn">
				<button id="console-exec-command" class="btn btn-danger" type="button">Run</button>
			</span>
		</div>
	</div>
	<div class="col-md-2 col-sm-2 text-right">
		<div>&nbsp;</div>
		<button id="console-opened-files" class="btn btn-sm btn-warning" disabled="disabled" data-toggle="modal" data-target="#console-editor-modal">
			<span class="glyphicon glyphicon-file"></span>
			File editor
		</button>
	</div>
</div>

<div id="console-editor-modal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">	
			
			<div class="modal-header">
				<!--<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>-->
				<h4 class="modal-title">
					File editor
					<span class="message" ></span>
				</h4>
			</div>
					
			<div class="modal-body">	
				<ul class="nav nav-tabs" role="tablist"></ul>
				<div class="tab-content"></div>			
			</div>
			
			<div class="modal-footer">
				<button class="btn btn-default" data-dismiss="modal" aria-hidden="true">Close</button>
				<button class="btn btn-primary saveFileBtn" >Save</button>
			</div>
		
		</div>
		
	</div>
</div>
