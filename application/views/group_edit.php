<?php // Change the css classes to suit your needs    

foreach($group_row->result() as $row){
		//$student_id=$row->student_id;
		$id=$row->group_index;
		$name=$row->group_name;
		$group_detial=$row->group_detial;
		//$year=$row->event_year;
        //$content=$row->event_content;
		}
?>

		<script type="text/javascript">
		
		
		</script>
<style>
fieldset {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}
</style>
<div class="col-md-9 col-sm-6 col-xs-12">
	

	<form role="form" id="form_index" class="form-horizontal" method="post" action=<?php echo base_url("accountController/edit_group");?> onSubmit="alert('編輯資料已上傳');" >
		<div id='page_devider' style='height: 30px;'></div>
		<input type='hidden' value="<?php echo $id?>" name='id' />
		<div>		
		        <label for="group_name">群組名稱</label>
				 <input id="group_name" class="span3" type="text"  size="40" name="group_name" value="<?php echo $name ?>" required />
					  
		</div>
	   	<div>		
		        <label for="group_name">群組敘述</label>
				  <textarea id='group_detial' name='group_detial'  class="form-control" rows="3" required><?php echo $group_detial?></textarea>
					  
		</div>
		<div id='page_devider' style='height: 30px;'></div>

		<div >
			<input  id="submit" type="submit" class="btn btn-info" value="儲存"> 
			<button type="button" class="btn btn-default" onclick="location.href='<?php echo base_url("/accountController/group_table")?>'">離開</button>
		</div>	
	</form>
  	
</div>

