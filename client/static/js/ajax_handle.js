function submitAjax(self,message="")
{
	if(message !=""){
		var confirm_result=confirm(message);
		if(!confirm_result)
			return false;
	}

	var parentForm=$(self).closest("form");
	var formData = new FormData(parentForm[0]);
	var data=parentForm.serializeArray();
	var controller="";
	var task="";	
	var is_reload=0;
	$.each(data, function(i, field) {
		if(field.name=="controller")
			controller=field.value;
		if(field.name=="task")
			task=field.value;
		if(field.name=="is_reload")
			is_reload=field.value;
	});
	formData.append("postAjax","1");

	if(controller == "" || task == "")
	{	parentForm.children(".ajax_response").removeClass('alert-success').addClass("alert-error");
		parentForm.children(".ajax_response").html("Function not found.");
		parentForm.children(".ajax_response").show();
		return false;	
	}

	var URL=baseURL+controller+"/"+task;

		$.ajax({
			url: URL,
			type: "post",
			data: formData,
			mimeType: "multipart/form-data",
			contentType: false,
			processData: false,
			success: function (response) {
			   var obj = $.parseJSON(response);
			   //console.log(parentForm.children);
				if(obj.Response=='Error')
				{
					parentForm.children(".ajax_response").removeClass('alert-success').addClass("alert-error");
					parentForm.children(".ajax_response").html(obj.Error);
					parentForm.children(".ajax_response").show();
				}else{
					$(obj.delete_item_vandon).remove();
					$(".list_vandon"+obj.sid+" ul").append(obj.list_shipid);
					parentForm.children(".ajax_response").removeClass('alert-error').addClass("alert-success");
					parentForm.children(".ajax_response").html(obj.Message);
					parentForm.children(".ajax_response").show();
					
					if(is_reload == 1)
					{
						setTimeout(function() {
							window.location.reload();
						}, 500);

					}
				}
				
			},
			error: function(jqXHR, textStatus, errorThrown) {
			   console.log(textStatus, errorThrown);
			}
		});
	return false;
}

function submitAjax1(self,message="")
{
	if (confirm("Are you sure?")) {
        // your deletion code
    
	if(message !=""){
		var confirm_result=confirm(message);
		if(!confirm_result)
			return false;
	}

	var parentForm=$(self).closest("form");
	var formData = new FormData(parentForm[0]);
	var data=parentForm.serializeArray();
	var controller="";
	var task="";	
	var is_reload=0;
	$.each(data, function(i, field) {
		if(field.name=="controller")
			controller=field.value;
		if(field.name=="task")
			task=field.value;
		if(field.name=="is_reload")
			is_reload=field.value;
	});
	formData.append("postAjax","1");

	if(controller == "" || task == "")
	{	parentForm.children(".ajax_response").removeClass('alert-success').addClass("alert-error");
		parentForm.children(".ajax_response").html("Function not found.");
		parentForm.children(".ajax_response").show();
		return false;	
	}

	var URL=baseURL+controller+"/"+task;

		$.ajax({
			url: URL,
			type: "post",
			data: formData,
			mimeType: "multipart/form-data",
			contentType: false,
			processData: false,
			success: function (response) {
			   var obj = $.parseJSON(response);
			   //console.log(parentForm.children);
				if(obj.Response=='Error')
				{
					parentForm.children(".ajax_response").removeClass('alert-success').addClass("alert-error");
					parentForm.children(".ajax_response").html(obj.Error);
					parentForm.children(".ajax_response").show();
				}else{
					$(obj.delete_item_vandon).remove();
					$(".list_vandon"+obj.sid+" ul").append(obj.list_shipid);
					parentForm.children(".ajax_response").removeClass('alert-error').addClass("alert-success");
					parentForm.children(".ajax_response").html(obj.Message);
					parentForm.children(".ajax_response").show();
					
					if(is_reload)
					{
						setTimeout(function() {
							window.location.reload();
						}, 500);

					}
				}
				
			},
			error: function(jqXHR, textStatus, errorThrown) {
			   console.log(textStatus, errorThrown);
			}
		});
	}	
	return false;
}


$("#my_form").keydown(function(event){
    if(event.keyCode == 13){
        $( "#my_form #submit_note" ).click();
    }
});

function submitAjaxCheckShip(self,message="")
{
	if(message !=""){
		var confirm_result=confirm(message);
		if(!confirm_result)
			return false;
	}

	var parentForm=$(self).closest("form");
	var formData = new FormData(parentForm[0]);
	var data=parentForm.serializeArray();
	var controller="";
	var task="";	
	$.each(data, function(i, field) {
		if(field.name=="controller")
			controller=field.value;
		if(field.name=="task")
			task=field.value;
	});
	formData.append("postAjax","1");

	if(controller == "" || task == "")
	{	parentForm.children(".ajax_response").removeClass('alert-success').addClass("alert-error");
		parentForm.children(".ajax_response").html("Function not found.");
		parentForm.children(".ajax_response").show();
		return false;	
	}

	var URL=baseURL+controller+"/"+task;

		$.ajax({
			url: URL,
			type: "post",
			data: formData,
			mimeType: "multipart/form-data",
			contentType: false,
			processData: false,
			success: function (response) {
			   var obj = $.parseJSON(response);
			   if(obj.Response=='Error')
			   {
					$("#not_found").removeClass('hidden');
					$("#not_found").addClass('last');
					
					$("#cn_is_received").addClass('hidden');
					$("#cn_is_sent").addClass('hidden');	
					$("#vn_is_received").addClass('hidden');
			   }else{
						 $("#not_found").removeClass('last');
					   $("#not_found").addClass('hidden');
				   if(obj.shipstatus.cn_is_received)
				   {
					   
					   $("#cn_is_received .date").html(obj.shipstatus.cn_is_received);
					   $("#cn_is_received").removeClass('hidden');
					   $("#cn_is_received").addClass('last');
					  
				   }else{
					   $("#cn_is_received").addClass('hidden');
				   }
				   
				   if(obj.shipstatus.cn_is_sent)
				   {
					    $("#cn_is_sent .date").html(obj.shipstatus.cn_is_sent);
					   $("#cn_is_sent").removeClass('hidden');
					   $("#cn_is_received").removeClass('last');
					   $("#cn_is_sent").addClass('last');
				   }else{
					   $("#cn_is_sent").addClass('hidden');
				   }
				   
					if(obj.shipstatus.vn_is_received)
				   {
					   $("#vn_is_received .date").html(obj.shipstatus.vn_is_received);
					   $("#vn_is_received").removeClass('hidden');
					   $("#cn_is_sent").removeClass('last');
					   $("#cn_is_received").removeClass('last');
				   }else{
					   $("#vn_is_received").addClass('hidden');
				   }
			   }			   
			   
			},
			error: function(jqXHR, textStatus, errorThrown) {
			   console.log(textStatus, errorThrown);
			}
		});
	return false;
}

jQuery(document).ready(function($){
		$("#checkAll").change(function () {
			$("input:checkbox").prop('checked', $(this).prop("checked"));
		});
		
		
		$(".ajaxForm").submit(function(event){
		var data = $(this).serializeArray();
		data.push({name: 'postAjax', value: 1});
		var controller=$("input[name=controller]").val();
		var task=$("input[name=task]").val();
		var URL=baseURL+controller+"/"+task;
		$.ajax({
			url: URL,
			type: "post",
			data: data,
			success: function (response) {
			   // you will get response from your php page (what you echo or print)                 
			   var obj = $.parseJSON(response);
				if(obj.Response=='Error')
				{
					$(".w2ui-msg-body #response_ajax").removeClass('alert-success').addClass("alert-error");
					$(".w2ui-msg-body #response_ajax").html(obj.Error);
					$(".w2ui-msg-body #response_ajax").show();
				}else{
					$(".w2ui-msg-body #response_ajax").removeClass('alert-error').addClass("alert-success");
					$(".w2ui-msg-body #response_ajax").html(obj.Message);
					$(".w2ui-msg-body #response_ajax").show();
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
			   console.log(textStatus, errorThrown);
			}
		});
		return false;
	});
	
});

function calWeightPrice(self)
{
	var weight=$(self).val();
	if (isNaN($(self).val() / 1) == true) {
		$(".weight-result").addClass("alert-error");
	    $(".weight-result").html('Khối lượng phải là số');
	}else{
		$(".weight-result").remove();
		var fee_weight_rate=$("#fee_weight_rate").val();
		$("#total_price").val(weight*fee_weight_rate);
	}
	
}

function checkCustomer(self){
	var username=$(self).val();
	var URL=baseURL+"ships"+"/ajaxcheckUsername";
	$.ajax({
			url: URL,
			type: "post",
			data: {"username":username,"postAjax":1},
			success: function (response) {
			   // you will get response from your php page (what you echo or print)                 
			   var obj = $.parseJSON(response);
				if(obj.Response=='Error')
				{
					$(".user-result").removeClass('alert-success').addClass("alert-error");
					$(".user-result").html(obj.Message);
					$(".user-result").show();
				}else{
					$("#fee_weight_rate").val(obj.fee_weight_rate);
					$("#cid").val(obj.cid);
					$(".user-result").remove();
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
			   console.log(textStatus, errorThrown);
			}
	});
}


