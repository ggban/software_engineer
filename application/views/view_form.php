<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>表單</title>

	<?php $this->load->view('script_lib')?>
	<style type="text/css">
   		body { background: #eee; }	
	</style>
</head>
<body bgcolor="#E6E6FA">
	<div id='page_devider' style='height: 30px;'></div>
<div class="container thumbnail   col-sm-offset-3 col-sm-6">
	<form role="form" id="form_index" action=<?php echo base_url("formController/form_fill/".$hash);?>>
		<input type='hidden' id='fill_data'>
	
	<div id='page_devider' style='height: 30px;'></div>
	<div class="">
 		  	
	  	<div id='form_title_div' class=' col-md-12'>
		  	<div class="form-group">
		  	 
				<h1 id="form_title" align="center"></h1>
		  	 </div>
		  	 <div class="form-group" >
		  	 	
		  	 	<p id="form_remark" align="center"></p>
		  	 </div>
		</div>
		<div id='form_body'>
			<div class='container col-md-12'><span style="color:red;font-size:17px">*為必填欄位</span><p></p></div>

		 	<div id='question_area'>
		 		
				
		 	</div>	
		</div>	

	</div>
	<!--
	<div class='container col-md-12' id="subdiv">
		<div class="form-group">
			
			<p for="question" class="control-label"><b>E-mail<span style="color:red;font-size:17px">*</span></b></p>	
			<input type="email" id="email" required >
			<p></p>
			<input type="checkbox" id="sub_confirm" checked><span>訂閱電子報</span>
		</div>

	</div>
	-->
	<div >
		<button  id="submit"   class="btn btn-info" <?php if(!$submit_able)echo 'disabled="disabled"'?>>送出</button> 
	</div>	

  
  	</form>
</div>
</div>
	<script>
var question_type_ary=[];
function isNumber(n) { return /^-?[\d.]+(?:e-?\d+)?$/.test(n); } 	

$(document).ready(function(){

	var form_data=<?php  if($form_data)print_r($form_data);else echo "''"?>;

	
	if(form_data!='')
	{	
		$(form_title).html(form_data.title);
		$(form_remark).html(form_data.remark);
		for(var key in form_data)
		{ 
       		//content +="屬性名稱："+ key+" ; 值： "+myobj[key]+"\n"; 
	       if (isNumber(key)) 
	       {

	       		var obj = form_data[key];
	       		add_question(obj);

	       		
	    	}
		}
		console.log(form_data[0]);
	}
	console.log(question_type_ary);
	/*
	window.onbeforeunload = function() {
  		return "刷新頁面會失去目前的資料";
		};
	*/
	
   
})

	function submit_click(){
		console.log("s");
		var hash= <?php echo "'".$hash."'"?>;
		var da=new Object();

		da['hash']=hash;
		da['email']=$("#email").val();
	         $("#question_area").find(".question").each(function(i){
	         	
	         	switch (question_type_ary[i])
				{
					case "1":
						ans=$(this).find("input").val();
						break;
					case "2":
						ans=$(this).find("textarea").val();
						break;	
					case "3":
						ans=$(this).find("input:checked").val();
						break;
					case "4":	
						$('input:checked').each(function(i){
					          if(i==0)
					         	 ans = $(this).val();
					         else 
					         	ans+=","+$(this).val();	

					        });
					case "5":
						ans=$(this).find('select').val()	
						//console.log(ans[0])
						break;
				}

	        
	         	//da["question_content"][i]
	         	da[i]= {};
	         	da[i]["ans"]=ans;
	         
	         

	         

	         });
	//console.log(da);
	        
	       <?php if($submit_able){?>
		        $.post( $("form").attr('action'), da, function(result) {
		             //alert(result);
		        });
		       
	       <?php } ?>

	}
	

	
	function add_question(data)
	{
		if (typeof data === 'undefined') { data = ''; }
		else{
			//console.log(data);
			var question="<b style='font-size:17px'>" + data.question+"</b>";
			var remark="<p><font >"+data.qremark+"</font></p>";
			var required="<span style='color:red;font-size:17px'>*</span>";
			var required_string="";
			if(data.required=='true'){
				question=question+required;
				required_string="required";
			}
			var qcontent="";
			question_type_ary.push(data.type);
			switch (data.type){
				case '1':
					qcontent='<input type="text" '+required_string+'>';
					//qcontent.prop('required');
					break;
				case '2':
					qcontent='<textarea '+required_string+' ></textarea>';
					break;
				case '3':	
				case '4':
					if (data.type=="4"&&data.required=='true')required_string+=" onchange='checkboxvalidate(this)' ";
					if(data.type=="3")htmlbox="radio";
					else htmlbox="checkbox";
					for (var prop in data) 
					{
						if(isNumber(prop))
						{		          	
							qcontent+='<input type="'+htmlbox+'" value="'+data[prop]+'" name="'+$("div.question").length+'" '+required_string+'>'+data[prop]+'<br/>'
								           
						}
					}	
					break;

				case '5':
					qcontent='<option value="" name="list_choose"></option>';
					for (var prop in data) 
					{
						if(isNumber(prop))
						{		          	
							qcontent+='<option value="'+data[prop]+'" name="list_choose">'+data[prop]+'</option>'
								           
						}
					}

					qcontent='<select '+required_string+'>'+qcontent+'</select><br/>';	
					break;	
				case '6':
					qcontent='<input type="file" class="col-md-2 " '+required_string+'>'
					break;
			
			}
			//console.log();
			var ap="<div  class='col-md-12 form-group question' >"+question+remark+qcontent+"</div><div id='page_devider' class='col-md-12 form-group'  style='height: 5px;'></div>";
			$( "#question_area" ).append(ap);

			
		
		}
	}

	function checkboxvalidate(dom)
	{
		var cb=$(dom).parents( ".form-group" ).find("input[type='checkbox']");
		console.log(cb);
		if(cb.is(':checked')) {
            cb.removeAttr('required');
        }

        else {
            cb.attr('required', 'required');
        }

	}
	$(function() {
     $('form').submit( function() {
        var $form = $(this);
         
		var hash= <?php echo "'".$hash."'"?>;
		var da=new Object();

		da['hash']=hash;
		//da['email']=$("#email").val();
		//da['sub']=$("#sub_confirm").prop("checked");
	         $("#question_area").find(".question").each(function(i){
	         	
	         	switch (question_type_ary[i])
				{
					case "1":
						ans=$(this).find("input").val();
						break;
					case "2":
						ans=$(this).find("textarea").val();
						break;	
					case "3":
						ans=$(this).find("input:checked").val();
						break;
					case "4":	
						$(this).find('input:checked').each(function(i){
							
					          if(i==0)
					         	 ans = $(this).val();
					         else 
					         	ans +=","+$(this).val();	
					      
					        });
						break;
					case "5":
						ans=$(this).find('select').val()	
						//console.log(ans[0])
						break;
				}

	        
	         	//da["question_content"][i]
	         	da[i]= {};
	         	da[i]["ans"]=ans;
	         
	         

	         

	         });
         $.post( "<?php echo base_url("formController/form_fill/".$hash);?>", {da : da}, function(result) {
              alert("感謝你把問卷填好，資料已上傳了！");
             
         }).done(function( data ) {
		    //alert(data);
		    window.location.href = "<?php echo base_url('formController/fill_form_menu')?>";
		  });;
         return false; //cancel original submit
     });
});
	</script>

</body>
</html>