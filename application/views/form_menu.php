	<script>
		function delete_click(hash)
		{
			if(confirm('確定要刪除資料？'))
			{
				//console.log(cc_or_cp);
				$.ajax({
				type: "POST", 
				url: "./delete_form",
				data:{
					hash:hash
				},
				success: function(data){
					document.location.reload(true);
				},
				error: function(){
					alert("刪除失敗");
				}
							
				});
			}
		}

		function edit_view(type,hash)
		{
			$('#ev_type').val(type);
  			$('#hash').val(hash);
  			document.forms["edit_view"].submit();
		}

		function submit_click(hash,title)
		{
			 $('#submitModalLabel').text(title);
			 $('#submit_form_hash').val(hash);
			
		}

		function submit_form()
		{
			
			 //alert($('#start_date').val());
			 if($('#start_date').val()==''||$('#expired_date').val()==''){
			 	alert("必須填妥所有欄位");
			 	return false;
			 }
			 
	
			$.ajax({
				type: "POST", 
				url: "./form_date_update",
				data:{
					hash:$('#submit_form_hash').val(),
					start:$('#start_date').val(),
					expired:$('#expired_date').val()
				},
				success: function(){
					document.location.reload(true);
				},
				error: function(){
					//alert("刪除失敗");
				}
							
				});

			 //$('#submitModel').modal('hide');;
			// console.log("ss");
			// location.reload();
			
		}
		function disable_submit(hash)
		{
			if(confirm('確定要取消發布？（之前填寫的資料將會遺失）'))
			{	
				//console.log("ss");
				$.ajax({
				type: "POST", 
				url: "./form_date_update",
				data:{
					hash: hash,
					start: null,
					expired: null
				},
				success: function(){
					document.location.reload(true);
				},
				error: function(){
					//alert("刪除失敗");
				}
							
				});

			}
			

			 //$('#submitModel').modal('hide');;
			// console.log("ss");
			// location.reload();
			
		}
	</script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/js/bootstrap-datetimepicker.min.js"></script>

	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.css" />

	
	<div id='page_devider' style='height: 30px;'></div>
	<div id="container" class=" ">
		<?php // Change the css classes to suit your needs    
			$attributes = array( 'id' => 'edit_view');
			echo form_open('formController/edit_view_form',$attributes);
		?>
			<input type="hidden" name="ev_type" id="ev_type">
		 	<input type="hidden" name="hash" id="hash">
		<?php echo form_close();?>	

		<a href="<?php echo base_url("/formController/create_form")?>" class="btn btn-info" role="button">建立新表單</a>
		<table class="table table-bordered table-striped">
			<thead>
				<tr>
					<th align="center" valign="middle">表單</th>
					<th align="center" valign="middle">功能</th>
					<th align="center" valign="middle">開始發布時間</th>
					<th align="center" valign="middle">結束時間</th>
					<th align="center" valign="middle">建立時間</th>		
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
									<td  valign="middle"><?php echo $row->form_title?></td>
									<td  valign="middle" >
												<?php if(($row->start_date==''|| $row->start_date=='0000-00-00 00:00:00') && ($row->expired_date==''||$row->expired_date=='0000-00-00 00:00:00')){ ?>
													<img src="<?php echo base_url('/images/file_edit.png')?>" width="15px" height="15px" style="cursor:pointer;" title="編輯" onclick="edit_view('edit',<?php echo "'".$row->form_hash."'"?>)">&#160 
													<img src="<?php echo base_url('/images/file_view.png')?>" width="15px" height="15px" style="cursor:pointer;" title="檢視" type="button" onclick="edit_view('view',<?php echo "'".$row->form_hash."'"?>)" >&#160 
													<!--<img src="<?php echo base_url('/images/copy_icon.png')?>" width="15px" height="15px" style="cursor:pointer;" title="複製" type="button" onclick="copy_click(<?php echo "'".$row->form_hash."'"?>)" >&#160 -->													
													<img src="<?php echo base_url('/images/file_submit.png')?>" width="15px" height="15px" style="cursor:pointer;" title="發布" type="button" data-toggle="modal" data-target="#submitModel" onclick="submit_click(<?php echo "'".$row->form_hash."','".$row->form_title."','".$row->start_date."','".$row->expired_date."'"?>)">&#160 													
													<img src="<?php echo base_url('/images/file_delete.png')?>" width="15px" height="15px" style="cursor:pointer;" title="刪除" type="button" onclick="delete_click(<?php echo "'".$row->form_hash."'"?>)">&#160 

											 	<?php }else{ ?>
											 			<img src="<?php echo base_url('/images/file_view.png')?>" width="15px" height="15px" style="cursor:pointer;" title="檢視" type="button" onclick="edit_view('view',<?php echo "'".$row->form_hash."'"?>)" >&#160 	
													<!--	<img src="<?php echo base_url('/images/copy_icon.png')?>" width="15px" height="15px" style="cursor:pointer;" title="複製" type="button" onclick="copy_click(<?php echo "'".$row->form_hash."'"?>)" >&#160 -->																									 			
														<img src="<?php echo base_url('/images/result_view.png')?>" width="15px" height="15px" style="cursor:pointer;" title="結果" onclick="javascript:location.href='<?php echo base_url("/reportController/form_check/".$row->form_hash)?>'">&#160 
														<img src="<?php echo base_url('/images/file_submit.png')?>" width="15px" height="15px" style="cursor:pointer;" title="發布" type="button" data-toggle="modal" data-target="#submitModel" onclick="submit_click(<?php echo "'".$row->form_hash."','".$row->form_title."','".$row->start_date."','".$row->expired_date."'"?>)">&#160 
														<img src="<?php echo base_url('/images/file_delete.png')?>" width="15px" height="15px" style="cursor:pointer;" title="刪除" type="button" onclick="delete_click(<?php echo "'".$row->form_hash."'"?>)">&#160 
														<img src="<?php echo base_url('/images/disable_bor.png')?>" width="15px" height="15px" style="cursor:pointer;" title="取消發布" type="button" onclick="disable_submit(<?php echo "'".$row->form_hash."'"?>)">&#160 
													
													<?php } 
													date_default_timezone_set('Asia/Taipei');
														$date=date_create($row->expired_date);
														$now = new DateTime("now");
														if($date>$now)
														{ 	
															?>
															<?php 
														}
													?>				
										</td>
									<td  valign="middle"><?php echo $row->start_date?></td>
									<td  valign="middle"><?php echo $row->expired_date?></td>
									<td  valign="middle"><?php echo $row->create_date?></td>
							</tr>		
							<?php
						}
					}
				?>
			</tbody>
			
	</div>
	<div class="modal fade" id="submitModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
		    <div class="modal-content">
		    	
			    <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="submitModalLabel"></h4>
			    </div>
			    <div class="modal-body ">

			        <input type="hidden" id="submit_form_hash">
			        <div class="form-group  ">
			        	<label>發布時間</label>
		                <div class='input-group date col-sm-4 ' >
		                    <input type='text' class="form-control datetimepicker" id='start_date' />		                   
		                </div>
		            </div>
		            <div class="form-group  ">
			        	<label>截止時間</label>
		                <div class='input-group date col-sm-4 ' >
		                    <input type='text' class="form-control datetimepicker" id='expired_date' />
		                </div>
		            </div>

			    </div>
			    <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">離開</button>
			         <button type="button" class="btn btn-primary" onclick="submit_form()">發布</button>
			       
			    </div>
			
		    </div>
	  	</div>
	</div>

          <script type="text/javascript">
            $(function () {
            	var nowDate = new Date();
            	//var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
                $('.datetimepicker').datetimepicker({
                	format: 'YYYY-MM-DD HH:mm',
                	minDate: nowDate ,
                });

                $("#start_date").on("dp.change", function (e) {
			            $('#expired_date').data("DateTimePicker").minDate(e.date);
			    });
			        $("#expired_date").on("dp.change", function (e) {
			            $('#start_date').data("DateTimePicker").maxDate(e.date);
			        });

            });
        </script>
