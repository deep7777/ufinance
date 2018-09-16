if($("#dashboard_date").length){
	var dashboard_date = $("#dashboard_date").val();
	$("#dashboard_date").change(function(){
		var url = $("#url").val()+"/admin/getAgentSummaryList";
		var data = $("#frm_dashboard").serialize();
		if(dashboard_date!==$("#dashboard_date").val()){
			$(".agent_list").html("");
			$.ajax({
				url:url,
				type:'POST',
				data:data,
				dataType:'html',
				success:function(data){
					$(".agent_list").html(data);
					dataAgentSummarList();
					dashboard_date = $("#dashboard_date").val();
					return false;
				}
			});
		}
	});
}