
<table class="table table-hover table-bordered" >
						
	<thead>
		<tr>
			<th style="width:20px;" >#</th>
			<th>Account</th>
			<th>Actions</th>
			<th style="width:50px;" ></th>
		</tr>
	</thead>

	<?php $numb = 1;
		  foreach($users as $account){ ?>

	<tr>
		<td><?php echo ($numb++); ?></td>
		<td><?php echo $account['username']; ?></td>
		<td>								
				<?php 
				if(is_array($account['permissions'])){	
					echo '<ul>';
					foreach($account['permissions'] as $access => $value){
						echo '<li>';
						if(array_key_exists($access, $app->config['access'])){
							echo $app->config['access'][$access];	
						}
						else{

							foreach($app->modules as $key => $module){													
								if(array_key_exists($access, $module['access'])){
									echo $module['access'][$access];
									continue;
								}
							}

							echo $access;
						}
						echo '</li>';
					}
					echo '</ul>';
				}
				else{
					echo $account['permissions'];
				}
				?>
			</ul>
		</td>
		<td>								
			<a href="" class="edit-account" data-username="<?php echo $account['username']; ?>" ><span class="glyphicon glyphicon-edit"></span></a>
			<a href="" class="delete-account" data-username="<?php echo $account['username']; ?>" ><span class="glyphicon glyphicon-remove"></span></a>
		</td>
	</tr>

	<?php } ?>
</table>
							
				