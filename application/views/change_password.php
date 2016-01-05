
<div >	
	<div class="col-md-4">
		<div >
			<?php
				$attributes = array('class' => 'form-horizontal', 'id' => '' , 'class'=>"form-signin" , 'role'=>'form');
				echo form_open('formController/change_passwd',$attributes);
				$error_box=array('<div class="glyphicon glyphicon-remove form-control-feedback" >','</div>')
				?>
				<p><?php if(validation_errors()){echo "修改密碼失敗";}?></p>
				<div class="form-group row <?php if (form_error('id')){echo "has-error has-feedback";}?>"> 
					<div class="col-sm-9">
						<input type="hidden" class="form-control " id="id" placeholder="帳號" name="id" value='<?php echo $this->session->userdata('id')?>'>
						<input type="password" class="form-control " id="password" placeholder="舊密碼" name="password">
						<p><?php echo form_error('password');?></p>
					</div>
					
				</div>
				<div class="form-group row  <?php if (form_error('id')){echo "has-error has-feedback";}?>">
					<div class="col-sm-9">
						<input type="password" class="form-control" id="new_password" name="new_password" placeholder="新密碼">
						<p><?php echo form_error('new_password');?></p>
					</div>
					
				</div>
				<div class="form-group row  <?php if (form_error('id')){echo "has-error has-feedback";}?>">
					<div class="col-sm-9">
						<input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="確認密碼">
						<p><?php echo form_error('confirm_password');?></p>
					</div>
					
				</div>
				<p>
				<input type="submit" name="login_submit" value="提交" class=" btn btn-primary" id="login_submit">
				</p>
			<?php 	echo form_close();?>
		</div>

	</div>

	
</div>




</div>



