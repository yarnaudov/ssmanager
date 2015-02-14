<div class="row info" >	
	
	<div class="col-md-12 " >
		
		<div class="row" >
			<label class="col-md-3" >On branch: </label>
			<div class="col-md-9" id="active-branch"><?php echo $branches['active']; ?></div>
		</div>

		<div class="row" >
			<label class="col-md-3" >Status: </label>
			<div class="col-md-9" id="branches_status">
				<?php echo $branches['status']; ?>
			</div>
		</div>
		
		<div class="row" >
			<label class="col-md-3" >Remote: </label>
			<div class="col-md-9" id="remote">			
				<?php echo $remote['fetch'] . "<br/>" . $remote['push']; ?>
			</div>
		</div>

		<div class="row" >
			<label class="col-md-3" >Pull from branch: </label>
			<div class="col-md-9 form-inline" >	
				<div class="form-group">
					<select class="form-control input-sm" >
						<?php foreach($branches['remotes'] as $branch){ ?>
						<option <?php echo preg_match('/' . $branches['active'] . '$/', $branch) ? "selected" : ""; ?> ><?php echo $branch; ?></option>
						<?php } ?>
					</select>
					<button class="btn btn-sm btn-warning" id="pull-branch" >Pull</button>
				</div>
			</div>
		</div>

		<div class="row" >
			<label class="col-md-3" >Switch to branch: </label>
			<div class="col-md-9 form-inline" >
				<div class="form-group">
					<select name="switchBranch" class="form-control input-sm" >
						<?php foreach($branches as $type => $sub_branches){ 
								if($type == "active" || $type == "status"){continue;} ?>
						<optgroup label="<?php echo $type; ?>" >				
							<?php foreach($sub_branches as $branch){ ?>
							<option><?php echo $branch; ?></option>
							<?php } ?>
						</optgroup>
						<?php } ?>
					</select>
					<button class="btn btn-sm btn-warning" id="switch-branch" >Switch</button>
				</div>
			</div>
		</div>

		<div class="row" >
			<div class="col-md-9 col-md-offset-3" >
				<button class="btn btn-sm btn-info" id="fetch-branches" data-loading-text="Fetching branches..." >Fetch remote branches</button>
			</div>
		</div>

	</div>

</div>

<div class="row log" >	
	
	<div class="col-md-12" >
		<label>Revision Log</label>
		<div id="git-revision-log" >
			<?php 
				$commits = explode('commit', $log); 
				unset($commits[0]);				
				
				foreach($commits as $commit){
					$commit = trim($commit);
					$is_message = false;
					
					$details = explode(PHP_EOL, $commit);
					
					echo '<div class="commit" >';
					
					foreach($details as $key => $detail){						
						$detail = trim($detail);
						if(empty($detail)){continue;}
						
						
						if(preg_match('/^([a-z0-9]{40})$/', $detail)){
							$detail = 'Commit:<a title="Commit details" class="commit-details" >' . $detail . '</a>';
						}
						elseif(preg_match('/^Author: /', $detail)){
							$detail = htmlspecialchars($detail);
						}
						
						$detail = preg_replace('/^([a-zA-Z]*:)/', '<span>$1</span>', $detail);
						
						if(!empty($detail)){
							echo '<div>' . $detail . '</div>';
						}
						
						
					}
					
					echo '</div>';
					
				}				
			?>
		</div>
	</div>

</div>