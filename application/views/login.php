
<div class='container' >
    <div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<div class="modal-header">
			<h1 class="form-signin-heading">登入系統</h1>
		</div>
		<div class="modal-body">
			<?php
				$attributes = array('class' => 'form-horizontal', 'id' => '' , 'class'=>"form-signin" , 'role'=>'form');
				echo form_open('login/login_validation',$attributes);
				$error_box=array('<div class="glyphicon glyphicon-remove form-control-feedback" >','</div>')
				?>
	
				<div class="form-group row <?php if (form_error('id')){echo "has-error has-feedback";}?>"> 
					<div class="col-sm-9">
						<input type="text" class="form-control " id="id" placeholder="學號" name="id">
					</div>
					<label for="inputEmail3" class="col-sm-6 control-label"><?php echo form_error('id',$error_box[0],$error_box[1]);?></label>
				</div>
				<div class="form-group row  <?php if (form_error('id')){echo "has-error has-feedback";}?>">
					<div class="col-sm-9">
						<input type="password" class="form-control" id="password" name="password" placeholder="密碼">
					</div>
					<span for="inputEmail3" class="col-sm-6 control-label"><?php echo form_error('password',$error_box[0],$error_box[1]);?></span>
				</div>
				<div class="col-md-2"></div>
		</div>
 
<?php
		echo"<p>";	
		$data= array(
				'name' => 'login_submit',
				'class' => 'col-sm-offset-9 btn btn-primary',
				'value' => 'Login',
				'id' => 'login_submit',
				
				
			);
	echo form_submit($data);
	echo"<p>";
	


	//echo base_url();
?><!--<a href='<?php echo base_url()."login/signup";?>'>Sign up here!</a>-->
	</div>
	
</div>
<?php 	echo form_close();?>



</div>
</div>
</body>


