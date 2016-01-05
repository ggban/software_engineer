<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>
	<?php $this->load->view('script_lib')?>
	<script src="<?php echo base_url('/js/excellentexport.min.js')?>"></script>
	<style type="text/css">
   		body { background: #eee; }   		
	</style>
</head>
<body>
	

	
	<h1 id="form_title" align="center"><?php echo $results['title']?></h1>
	<div id='page_devider' style='height: 30px;'></div>
	<div id="container" class="container thumbnail">
		<div id='export_div' align='right'>
			<a download="<?php print_r($results['title']) ?>.xls" href="#" onclick="return ExcellentExport.excel(this, 'result_table', 'Sheet Name Here');"><button class="btn btn-primary" >匯出 Excel</button></a>
			<button type="button" class="btn btn-default" onclick="location.href='<?php echo base_url("/formController/form_menu")?>'">離開</button>
		</div>
		<table class="table  table-striped" id='result_table'>
			<thead>
				<tr>
					<?php

						foreach($results['question'] as $row)
						{ 
								//print_r($row);
					?>
							<th align="center" valign="middle"><?php echo $row?></th>
					<?php
						}
					?>
					
					<th align="center" valign="middle">填寫時間</th>		
				

				</tr>
			</thead>
			<tbody>	
				<?php
						foreach($results['ans'] as $row)
						{ 
				?>			
							<tr>
				<?php
							foreach ($row as $prop) {
				?>
							<td><?php echo $prop?></td>
				<?php
								
							}
				?>
							</tr>
				<?php
						}
					
				?>
			</tbody>
		</table>
			
	</div>

</body>
</html>