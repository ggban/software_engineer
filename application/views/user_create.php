
<div class="col-md-9 col-sm-6 col-xs-12">

	<form role="form" id="form_index" class="form-horizontal" method="post" action=<?php echo base_url("user/create_user");?>  >
		<div id='page_devider' style='height: 30px;'></div>
		<div class="form-group">		
		        <label for="user_id">帳號</label>
				 <input id="user_id" class="span3" type="text"  size="20" name="user_id"  required />
					  
		</div>
	    <div class="form-group">        
	                <label for="display_name">顯示名稱</label>
	                 <input id="display_name" class="span3" type="text"  name="display_name"  required />
	                
	    </div>
	    <div class="form-group">        
	                <label for="group_id">群組</label>
						<select class="" id="group_id" name='group_id'>
							<?php foreach ($group_data->result() as $row){ ?>
								
								<option value="<?php echo $row->group_index ?>"><?php echo $row->group_name ?></option>
							<?php } ?>
							
						</select>
	                
	    </div>
	    <div class="form-group">        
	                <label for="password">密碼</label>
	                 <input id="password" class="span3" type="password"  name="password"  required />
	                
	    </div>
		<div id='page_devider' style='height: 30px;'></div>
		<div >
			<input  id="submit" type="submit" class="btn btn-info" value="儲存"> 
			<button type="button" class="btn btn-default" onclick="location.href='<?php echo base_url("/user/users_table")?>'">離開</button>
		</div>	
	</form>
  	
</div>

