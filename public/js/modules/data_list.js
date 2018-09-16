if($('#data-keytable-list').length){
  $.fn.dataTable.moment( 'D/M/YYYY'); 
	$('#data-keytable-list').DataTable({
		keys: true,
		"aaSorting": [],
		aoColumnDefs: [
			{
				 bSortable: false,
				 aTargets: [ -1 ]
			}
		]
	});
}

if($('#data-all-agent-summary-list').length){
  dataAgentSummarList();
}

function dataAgentSummarList(){
	$.fn.dataTable.moment( 'D/M/YYYY'); 
	$('#data-all-agent-summary-list').DataTable({
		keys: true,
		"aaSorting": [],
		"order": [[ 3, "desc" ]],
		aoColumnDefs: [
			{
				 bSortable: true,
				 aTargets: [ -1 ]
			}
		]
	});
}

if($('#data-all-list').length){
  $.fn.dataTable.moment( 'D/M/YYYY'); 
	$('#data-all-list').DataTable({
		keys: true,
		"aaSorting": []
	});
}
