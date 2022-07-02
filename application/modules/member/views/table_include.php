	<table id="example" class="table table-bordered">

			                <thead>

			                    <tr>

			                        <th>Memberid</th>
			                    </tr>

			                </thead>
			                <tbody>
			                	<?php foreach($test as $val)
			                	{?>
			                		<tr>
			                			<td><?php echo $val->entrydate;?></td>
			                		</tr>
			                	<?php }?>	

			                </tbody>

			              	

			                <tfoot>

			                    <tr>

			                        <th>Name</th>

			                        
								 </tr>

			                </tfoot>

		            	</table>
		            	<div id='pagination'></div>	