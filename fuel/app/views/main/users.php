
<table class="table table-hover table-bordered" >
						
	<thead>
		<tr>
			<th style="width:20px;" >#</th>
			<th>User</th>
			<th>Actions</th>
			<th style="width:50px;" ></th>
		</tr>
	</thead>

	<?php $numb = 1;
		  foreach($users as $user){ ?>

	<tr>
		<td><?php echo ($numb++); ?></td>
		<td><?php echo $user['username']; ?></td>
		<td>								
				<?php 
				if(is_array($user['permissions'])){	
					echo '<ul>';
					foreach($user['permissions'] as $access => $value){
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
					echo $user['permissions'];
				}
				?>
			</ul>
		</td>
		<td>								
			<a href="" class="edit-user" data-username="<?php echo $user['username']; ?>" data-dismiss="modal" ><span class="glyphicon glyphicon-edit"></span></a>
			<a href="" class="delete-user" data-username="<?php echo $user['username']; ?>" ><span class="glyphicon glyphicon-remove"></span></a>
		</td>
	</tr>

	<?php } ?>
</table>
							
				