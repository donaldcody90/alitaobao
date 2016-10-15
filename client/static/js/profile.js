function AjaxProfile(url,divAppend)
{
	var data = $(this).serializeArray();
	data.push({name: 'postAjax', value: 1});
	var URL= url;
	console.log(URL);
	$.ajax({
		url: URL,
		type: "post",
		data: data,
		success: function (response) {
		   // you will get response from your php page (what you echo or print)                 
		   var obj = $.parseJSON(response);
			console.log(obj);
		},
		error: function(jqXHR, textStatus, errorThrown) {
		   console.log(textStatus, errorThrown);
		}
	});
}