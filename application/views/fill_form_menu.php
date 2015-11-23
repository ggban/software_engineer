<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<?php $this->load->view('script_lib')?>
	<style type="text/css">
   		body { background: #eee; }
   		
   		
	</style>

</head>
<body>
	
	<div id='page_devider' style='height: 30px;'></div>
	<div id="container" class="container thumbnail">
		
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th align="center" valign="middle">表單</th>
					
				
					<th align="center" valign="middle">截止時間</th>
						
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
									<td  valign="middle">
										<a href="<?php echo base_url('form/form_fill/'.$row->form_hash)?>"><b><?php echo $row->form_title?></b></a>
									</td>
									
									
									<td  valign="middle"><?php echo $row->expired_date?></td>
									
							</tr>		
							<?php
						}
					}
				?>
			</tbody>
			
	</div>
</body>
</html>