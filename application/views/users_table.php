<script>
	function delete_click(id)
		{
			if(confirm('確定要刪除資料？'))
			{
				//console.log(cc_or_cp);
				$.ajax({
				type: "POST", 
				url: "./delete_user",
				data:{
					id:id
				},
				success: function(){
					document.location.reload(true);
				},
				error: function(){
					alert("刪除失敗");
				}
							
				});
			}
		}

	function edit_click(id)
		{
  			$('#id').val(id);
  			document.forms["edit_form"].submit();
		}

</script>
		<?php // Change the css classes to suit your needs    
			$attributes = array( 'id' => 'edit_form');
			echo form_open('accountController/edit_user',$attributes);
		?>
			
		 	<input type="hidden" name="id" id="id">
		<?php echo form_close();?>
<div class="col-sm-9"> 
		<a href="<?php echo base_url('accountController/create_user')?>" class="btn btn-info" role="button">新增使用者</a>
		<div id='page_devider container' style='height: 15px;'></div>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th align="center" valign="middle">使用者ID</th>
					<th align="center" valign="middle">顯示名稱</th>
					<th align="center" valign="middle">功能</th>
					
					
						
				</tr>
			</thead>
			<tbody>	
				<?php
					if(!empty($results))
					{
						foreach($results->result() as $row)
						{
							?>
							<tr>
									<td  valign="middle"><?php echo $row->user_id?></td>
									<td  valign="middle"><?php echo $row->display_name?></td>
									
									
									<td  valign="middle">
										<?php if($row->user_index!='1'){ ?>
											<img src="<?php echo base_url('/images/file_edit.png')?>" width="15px" height="15px" style="cursor:pointer;" title="編輯" onclick="edit_click(<?php echo "'".$row->user_index."'"?>)">&#160 
											<img src="<?php echo base_url('/images/file_delete.png')?>" width="15px" height="15px" style="cursor:pointer;" title="刪除" type="button" onclick="delete_click(<?php echo "'".$row->user_index."'"?>)">&#160 
										<?php }else { ?>
											最高使用者
										<?php } ?>

									</td>
									
									
									
							</tr>		
							<?php
						}
					}
				?>
			</tbody>
		</table>	

</div>
