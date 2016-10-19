function loadAjax(URL,div){
var URL = URL;
var div = div;
$.ajax({
   type:'POST',
   url:URL,
   success: function (response) {
           // you will get response from your php page (what you echo or print)                 
		   var obj = jQuery.parseJSON(response);
			if(obj.Response=='Error')
			{
				alert(obj.Error);
			}else{
				$("#customer .customer_div").removeAttr('id');
				$("#customer .customer_div").attr('id', div);
				jQuery('#'+div).html(obj.Message);
				//jQuery("#ajaxPopup").w2render('quickview');
			}
   },
   error: function(result)
   {
      $('#'+div).html("Error"); 
   },
   fail:(function(status) {
      $('#'+div).html("Fail");
   }),

  }); 
};