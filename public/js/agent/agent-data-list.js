if($('#data-agent-summary-list').length){
	//agent_summary_list();
}

if($("#agent_dashboard").length){
	$("#agent_dashboard").click(function(){
		var url = $("#url").val()+"/agent";
		window.location.href=url;
	});
}

function agent_summary_list(){
	$('#data-agent-summary-list').DataTable({
		keys: true,
		"order": [[ 3, "desc" ]],
		aoColumnDefs: [
			{
				 bSortable: true,
				 aTargets: [ -1 ]
			}
		]
	});
}
