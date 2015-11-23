<div id="question" class="question col-sm-12">
		 		<div id="tool_button" class="col-md-2 col-md-offset-10">
						<button type="button" class="btn btn-default" aria-label="Left Align"onclick="edit_question(this)">
	  						<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-default copy" aria-label="Left Align" onclick="copy_question(this)" >
	  						<span class="glyphicon glyphicon-paste" aria-hidden="true"></span>
						</button>
						<button type="button" class="btn btn-default" aria-label="Left Align" onclick="remove_question(this)">
	  						<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
						</button>
					
				</div>
				<div id="tool" class="form-group">
		 			
		 			
		 			<div class="form-group">
				      <p for="question" class="col-sm-1 control-label">題目:</p>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="question-input" >
					    </div>

				    </div>
				    <div class="form-group">
				    	<p for="remark" class="col-sm-1 control-label">敘述:</p>
					    <div class="col-sm-9">
					      <input type="text" class="form-control" id="remark-input" >
					    </div>
				    </div>
				    <div class="form-group qtype">
				    	<p for="type" class="col-sm-1 control-label">作答方式:</p>
					    <div class="col-sm-2">
					     	<select id="type-val" class="form-control selection" onchange="question_type(this)">
							  <option value="1">文字輸入</option>
							  <option value="2">文字輸入（長）</option>
							  <option value="3">單選題</option>
							  <option value="4">複選題</option>
							  <option value="5">檔案上傳</option>
							  
							</select>
						
					    </div>
				    </div>
				    <div class="form-group showq ">
						<div id="que" class="que  container control-label col-md-offset-1">
							<input type="text" class="col-md-2 " disabled>
						</div>
				    </div>
				   	<button type="button" class="btn btn-info col-md-offset-1" onclick="ok_btn(this)" >ok</button> 
		 		</div>
		 		<div id="show" class='preview col-sm-12 ' >
		 		</div>
		 	</div>	