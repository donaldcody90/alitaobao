jQuery(document).ready(function($){
	$(".ajaxForm").submit(function(event){
		var data = $(this).serializeArray();
		data.push({name: 'postAjax', value: 1});
		var task=$("input[name=task]").val();
		var URL=baseURL+"ajax/"+task;
		$.ajax({
			url: URL,
			type: "post",
			data: data,
			success: function (response) {
			   // you will get response from your php page (what you echo or print)                 
			   var obj = $.parseJSON(response);
				if(obj.Response=='Error')
				{
					$(".w2ui-msg-body #response_ajax").addClass("alert-error");
					$(".w2ui-msg-body #response_ajax").html(obj.Error);
					$(".w2ui-msg-body #response_ajax").show();
				}else{
					$(".w2ui-msg-body #response_ajax").addClass("alert-success");
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
	
    $("#checkAll").click(function() {
        
            // Thêm thuộc tính checked cho ô checkAll
            var checked = $(this).attr("checked");
            
            // Thêm thuộc tính checked cho ô checkbox khác
            $("#cartTable tr td input:checkbox").attr("checked", checked);
    });
    
	
});

function openDiv(divSelector)
{
	
	$(divSelector).show();
	return false;
}
function openPopup(URL,data,width,height){
	data.postAjax=1;
	jQuery.ajax({
        url: URL,
        type: "post",
		data: data,
        success: function (response) {
           // you will get response from your php page (what you echo or print)                 
		   var obj = jQuery.parseJSON(response);
			if(obj.Response=='Error')
			{
				alert(obj.Error);
			}else{
				jQuery("#ajaxPopup").css('width',width+"px");
				jQuery("#ajaxPopup").css('height',height+"px");
				jQuery("#ajaxPopup").html(obj.Message);
				jQuery("#ajaxPopup").w2popup();
			}
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }
    });
	return false;
}

function format_curency(nStr){
  nStr += '';
  x = nStr.split('.');
  x1 = x[0];
  x2 = x.length > 1 ? '.' + x[1] : '';
  var rgx = /(\d+)(\d{3})/;
  while (rgx.test(x1))
    x1 = x1.replace(rgx, '$1' + ',' + '$2');
  return x1 + x2;
}


function checkPayment(self)
{
	var payment = document.getElementById("payment");
    if (payment.selectedIndex==1) {
        $('#user_receive').addClass('hidden');
		$('#bank').removeClass('hidden');
		$('#method_type').val('1');
    }else if (payment.selectedIndex==0) {
		$('#bank').addClass('hidden');
		$('#user_receive').removeClass('hidden');
		$('#method_type').val('0');
    } 
}

function list_ship_submit(self,message=""){
	var so_shipid = $('#so_shipid').val();
	var so_cusommer = $('#so_cusommer').val();
	if (!so_shipid.trim() || !so_cusommer.trim()) {
		alert('Bạn chưa nhập đủ thông tin bắt buộc (*)');
	}else{
	var so_description = $('#so_description').val();
	
	var tr_ship = 	$('<tr><td style="width: 5%;"><input type="checkbox" value="' + so_shipid + '" name="checkbox[]""></td><td style="width: 5%;"></td><td style="width: 30%;">'+so_shipid+'</td><td class="left" style="width: 30%;">'+so_cusommer+'</td><td class="center" style="width:30%;">'+so_description+'</td></tr>');
	$('#list_ship_code').append(tr_ship);
	}

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

