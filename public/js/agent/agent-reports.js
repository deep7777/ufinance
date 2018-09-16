if($("#frm_agent_daily_collection #collection_date").length > 0){
	$("#frm_agent_daily_collection #collection_date").change(function(){
		var url = $("#url").val()+"/getAgentDailyCollectionReport";
		var data = $("#frm_agent_daily_collection").serialize();
		$("#frm_agent_daily_collection .agent_customer_daily_collection").html("");
		$.ajax({
			url:url,
			type:'POST',
			data:data,
			dataType:'html',
			success:function(data){
				$("#frm_agent_daily_collection .agent_customer_daily_collection").html(data);
			}
		});
	});
}