laundry_holder=document.getElementById('laundry');
var sites_urls=document.getElementById('laundry').getAttribute('data-url');

laundry_holder.innerHTML='<object id="laundry_content" style="width:100%; height:101%;" type="text/html" data="'+sites_urls+'" onload="laundrydivload()" ></object>';

function laundrydivload(){
	setInterval(function() {
		var new_page_height = jQuery('#laundry object').contents().find('.ld-main-wrapper').height()+50;
		jQuery('#laundry').height(new_page_height);
	}, 500);
}