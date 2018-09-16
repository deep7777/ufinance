if($("#staff_dashboard").length){
	$("#staff_dashboard").click(function(){
		var url = $("#url").val()+"/staff";
		window.location.href=url;
	});
}