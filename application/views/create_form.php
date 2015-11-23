<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>自製表單</title>

	<?php $this->load->view('script_lib')?>
	<style type="text/css">
   		body { background: #eee; }   		
	</style>
</head>
<body bgcolor="#E6E6FA">
<div class="container">
	<form role="form" id="form_index" class="form-horizontal" action=<?php echo base_url("form/form_submit");?>>
	<div id='page_devider' style='height: 30px;'></div>
	<div class="thumbnail">
 		<div id="hidden_question" style="display:none" class="hiddenque">
 			<?php echo $this->load->view('question_temp')?>
 		</div>	
  	
	  	<div id='form_title_div' class='container col-md-12'>
		  	<div class="form-group">
		  	 	<input type="text" class="form-control  input-lg" id="form_title" placeholder="表單名稱">
		  	 </div>
		  	 <div class="form-group">
		  	 	<input type="text" class="form-control input-sm" id="form_remark" placeholder="表單敘述">
		  	 </div>
		</div>
		<div id='form_body'>
		 	<div id='question_area'>
		 		<?php $this->load->view('question_temp')?>
				
		 	</div>	
		</div>	
		<div id="add_section">
		 		<button type='button' id='add_question'>新增問題</button>
				
		</div>
	</div>
	<div id='page_devider' style='height: 30px;'></div>
	<div >
		<button  id="submit" type="button" class="btn btn-info" onclick="submit_click()">存儲</button>
		<button type="button" class="btn btn-default" onclick="location.href='<?php echo base_url("/form/form_menu")?>'">離開</button> 
	</div>	

  </form>
  	
</div>
</div>
	<script>
function isNumber(n) { return /^-?[\d.]+(?:e-?\d+)?$/.test(n); } 	

$(document).ready(function(){
	$("#queastion_area").sortable();
	$("#queastion_area").disableSelection();






	/*
	window.onbeforeunload = function() {
  		return "刷新頁面會失去目前的資料";
		};
	*/
   
})

	function submit_click(){
		//var  a = typeof a !== 'undefined' ? a : 42;
		var	title = $("#form_title").val();
		var	remark=	$("#form_remark").val() ;

		
		var da=new Object();
		da['title']=title;
		da['remark']=remark;

		
	         $("#question_area").find(".question").each(function(i){
	         	
	         	question=$(this).find("#question-input").val();
	         	qremark=$(this).find("#remark-input").val();
	         	type=$(this).find("#type-val").val();
	         	required=$(this).find("#required").prop('checked');
	         	//da["question_content"][i]
	         	da[i]= {};
	         	da[i]["question"]=question;
	         	da[i]["qremark"]=qremark;
	         	da[i]["required"]=required;
	         	da[i]["type"]=type;
	         	switch(type){
	         		case "1":
	         		case "2":
	         		case "6":
	         			break;
	         			
	         		case "3":
	         		case "4":
	         		case "5":
	         			$(this).find("#sq>input").each(function(a){
	         				da[i][a]=$(this).val();
	         				console.log($(this).val());

	         			});
	         			break;



	         	}

	         	//console.log(type);

	         });
			console.log(da);
	      
			alert(JSON.stringify(da));
	    //     $.post( $("form").attr('action'), da, function(result) {
	    //          // alert(result);

	    //     }).done(function( data ) {
		   //  	//alert(data);
		   //  	window.location.href = "<?php echo base_url('form/form_menu')?>";
		  	// });
	        

	}
	
	function remove_question(dom) {
		var classes = $(dom).parents( ".question" );
		classes.remove();
	}

	function question_type(dom){
		console.log(dom);
		var type = dom.options[dom.selectedIndex].value;
		var s=$(dom).parents(".qtype");
		var td=$(dom).parents("#tool");
		$(td).find(".que").remove();
		switch (type){
			case '1':
				
				$(td).find(".showq").append('<div id="que" class="que  container control-label col-md-offset-1"><input type="text" class="col-md-2 " disabled ></div>');
				console.log("a");
				break;
			case '2':
				
				$(td).find(".showq").append('<div id="que" class="que  container control-label col-md-offset-1"><textarea class="col-md-2 " disabled ></textarea></div>');
				console.log("s");
				break;
			case '3':
			case '4':
			case '5':
				
				var ap='<div id="que" class="que"></div>';
				$(td).find(".showq").append(ap);
				
				//$(td).find(".sque").append('aaasdasd');
				$(td).find(".que").append('<div class="btndiv "><a id="add_btn" class="btn btn-success btn-xs col-sm-offset-1" onclick="add_btn(this)"><span class="glyphicon glyphicon-plus"></span></a></div>');
				$($(td).find(".que")).sortable();
				$($(td).find(".que")).disableSelection();
				
				single_add($(td).find(".btndiv"));
				break;	

			case '6':
				$(td).find(".showq").append('<div id="que" class="que  container control-label col-md-offset-1"><input type="file" class="col-md-2 " disabled ></div>');
				break;
			default:
				console.log('a');
				break;

		}
	}
	
	function single_add(dom){
		$(dom).before('<div class="row form-group qrow"><div id="sq" class="sque col-sm-5 col-sm-offset-1"><input type="text" class=" choices" >&nbsp;<a id="minus_btn" class="btn btn-danger btn-xs" onclick="remove_btn(this)"><span class="glyphicon glyphicon-minus"></span></a></div></div>');
	}
	
	$("#add_question").click(function() {
		var ap=$( "div.hiddenque" ).html();
		$( "#question_area" ).append(ap);
		
		 $('html, body').animate({scrollTop:$("#question").offset().top + 700}, 'slow');
		 $("#question-input ").focus();
	});
	
	function add_btn(dom){
		var newd=$(dom).parents(".que").find(".btndiv");
		single_add(newd);
		
	}
	
	
	function remove_btn(dom){
		//console.log(dom);
		var newd=$(dom).parents(".qrow");
		newd.remove();
		//console.log(newd);
		//single_add(newd);
		
	}
	
	function ok_btn(dom){
	 q=$(dom).parents(".question");
	 tool=q.find("#tool");
	 var type=tool.find('#type-val').val();
	 var allVal = [];
	 allVal.push(tool.find('#required').prop('checked'));
	 $(tool).find("input").each(function() {
			//allVal += $(this).val();
			allVal.push($(this).val());
	
		});
	 //tool.find('#required').prop('checked')
	 
	 console.log(allVal);

	if(type=='1'||type=='6')allVal.pop();
	 create_preview(q,type,allVal);
	 
	} 
	
function copy_question(dom) {
	$("#queastion_area").sortable();
	$("#queastion_area").disableSelection();
		var allVal=[];
		var classes = $(dom).parents( ".question" );
		var tool = classes.find("#tool");
		
		console.log();
		
		var ap='<div id="question" class="question col-sm-12">'+classes.html()+'</div>';
		var ss= $("#question-input").val();
		var type=classes.find('#type-val').val();
		var required=classes.find("#required").prop('checked');
		
		$(tool).find("input").each(function() {
			allVal.push($(this).val());
	
		});
		console.log(allVal);
		classes.after(ap);
		classes.next().find('#type-val').val(type);
		
		$(classes).next().find("#tool").find("input").each(function(i) {
			$(this).val(allVal[i]);
		});
		
		$(classes).next().find(".que").sortable();
		$(classes).next().find(".que").disableSelection();
		//$('html, body').animate({scrollTop:$("#question").offset().top + 100}, 'slow');
		if(!required){classes.next().find("#required").prop("checked", false);console.log("d")}
			
		allVal.unshift(required);
		create_preview(classes,type,allVal);
		$(classes).next().find("#question-input").focus();
	}
	
	function edit_question(dom){
		var classes = $(dom).parents( ".question" );
		console.log($("#show"));
		classes.find("#show").hide();
		classes.find("#tool").fadeIn();
	
	}
	
	function create_preview(dom,type,arydata){
		var question="<b>" + arydata[1]+" </b>";
		var remark="<p>"+arydata[2]+"</p>";
		var required="<span style='color:red'>*</span>";
		if(arydata[0])
			question=question+required;
		var qcontent="";
		switch (type){
			case '1':
				qcontent='<input type="text" class="col-md-2 " disabled>';
				break;
			case '2':
				qcontent='<textarea class="col-md-2 " disabled ></textarea>';
				break;
			case '3':	
			case '4':
				qcontent='';
				if(type=="3")htmlbox="radio";
				else htmlbox="checkbox";
				for(i=3;i<arydata.length-1;i++){
					console.log(i);
					qcontent+='<input type="'+htmlbox+'" value="'+arydata[i]+'" name="radio_choose">'+arydata[i]+'<br/>'
				}	
				break;
			case '5':
				qcontent='<option value="" name="list_choose"></option>';
				
				for(i=3;i<arydata.length-1;i++){
					console.log(i);
					
					qcontent+='<option value="'+arydata[i]+'" name="list_choose">'+arydata[i]+'</option>'
				}
				qcontent='<select>'+qcontent+'</select><br/>';	
				break;	
			case '6':
				qcontent='<input type="file" class="col-md-2 " disabled >'
				break;
		
		}

		$(dom).find("#show").html("<div  class='col-md-10'>"+question+remark+qcontent+"</div>");
		
		$(dom).find("#tool").hide();
		$(dom).find("#show").fadeIn();
		console.log(arydata);
		
		
	
	
	}
	
	</script>

</body>
</html>