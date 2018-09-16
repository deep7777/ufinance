if($("#admin_dashboard").length){
	$("#admin_dashboard").click(function(){
		var url = $("#url").val()+"/admin";
		window.location.href=url;
	});
}