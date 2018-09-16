if($("#frm_all_agent_daily_collection #collection_date").length > 0){
	var agent_id = "";
	var collection_date = '';
	$("#frm_all_agent_daily_collection #collection_date").change(function(){
		getAgentCustomerDailyCollection();
	});
	
	$("#frm_all_agent_daily_collection #agent_id").change(function(){
		collection_date = '';
		getAgentCustomerDailyCollection();
	});
	function initDataTableList(){
		$('#data-keytable-list').DataTable({
			keys: true,
			"aaSorting": []
		});
	}
	function getAgentCustomerDailyCollection(){
		var url = $("#url").val()+"/getAgentCustomersDailyCollection";
		var data = $("#frm_all_agent_daily_collection").serialize();
		
		if(collection_date!==$("#frm_all_agent_daily_collection #collection_date").val()){
			$("#frm_all_agent_daily_collection .agent_customer_daily_collection").html("");
			$.ajax({
				url:url,
				type:'POST',
				data:data,
				dataType:'html',
				success:function(data){
					$("#frm_all_agent_daily_collection .agent_customer_daily_collection").html(data);
					agent_id = $("#frm_all_agent_daily_collection #agent_id option:selected").val();
					collection_date = $("#frm_all_agent_daily_collection #collection_date").val();
					initDataTableList();
				}
			});
		}
	}
}

$("#agent_monthly_collection_report").click(function(){
	var url = $("#url").val()+"/getAgentMonthlyCollectionData";
	var data = $("#frm_agent_monthly_collection_report").serialize();
	$.ajax({
		url:url,
		type:'POST',
		data:data,
		dataType:'html',
		success:function(data){
			$(".agent_monthly_collection_data").html(data);
		}
	});
});

$("#agent_monthly_daily_collection_report").click(function(){
	var url = $("#url").val()+"/getAgentMonthlyDailyCollection";
	var data = $("#frm_agent_monthly_daily_collection_report").serialize();
	$.ajax({
		url:url,
		type:'POST',
		data:data,
		dataType:'html',
		success:function(data){
			$(".agent_monthly_daily_collection_report_data").html(data);
		}
	});
});

$("#customer_transaction_report").click(function(){
	var url = $("#url").val()+"/getCustomerTransaction";
	var data = $("#frm_customer_transaction_report").serialize();
	$.ajax({
		url:url,
		type:'POST',
		data:data,
		dataType:'html',
		success:function(data){
			$(".customer_transaction_report_data").html(data);
			customerTransactionList();
		}
	});
});


function customerTransactionList(){
	$.fn.dataTable.moment( 'D/M/YYYY'); 
	$('#customer-transaction-list').DataTable({
		keys: true,
		"aaSorting": [],
		"order": [[ 1, "desc" ]],
		aoColumnDefs: [
			{
				 bSortable: true,
				 aTargets: [ -1 ]
			}
		]
	});
}

$("#loan_report").click(function(){
	var url = $("#url").val()+"/getLoanSummary";
	var data = $("#frm_loan_report").serialize();
	$.ajax({
		url:url,
		type:'POST',
		data:data,
		dataType:'html',
		success:function(data){
			$(".loan_report_data").html(data);
		}
	});
});


$("#balance_sheet_report").click(function(){
	var url = $("#url").val()+"/getBalanceSheet";
	var data = $("#frm_balance_sheet_report").serialize();
	$.ajax({
		url:url,
		type:'POST',
		data:data,
		dataType:'html',
		success:function(data){
			$(".balance_sheet_report_data").html(data);
		}
	});
});


if($("#frm_customer_report #customer_report").length){
	$("#frm_customer_report #customer_report").click(function(){
		var url = $("#url").val()+"/getCustomerSummary"
		var data = $("#frm_customer_report").serialize();
		$("#frm_customer_report .customer_report_data").html("");
		$.ajax({
			url:url,
			type:'POST',
			data:data,
			dataType:'html',
			success:function(data){
				$("#frm_customer_report .customer_report_data").html(data);
				$.fn.dataTable.moment( 'D/M/YYYY'); 
				$('#data-all-list').DataTable({
					keys: true,
					"aaSorting": []
				});
			}
		});
	});
}

if($("#frm_balance_sheet_report").length){
	$("#frm_balance_sheet_report #balance_sheet_reset").click(function(){
		$("#frm_balance_sheet_report")[0].reset();
	});
}

if($("#frm_loan_report").length){
	$("#frm_loan_report #customer_loan_report_reset").click(function(){
		$("#frm_loan_report")[0].reset();
		$("#frm_loan_report #customer_account_no").hide();
	});
}

if($("#frm_customer_transaction_report").length){
	$("#frm_customer_transaction_report #customer_transaction_report_reset").click(function(){
		$("#frm_customer_transaction_report")[0].reset();
	});
}

if($("#frm_customer_report").length){
	$("#frm_customer_report #customer_report_reset").click(function(){
		$("#frm_customer_report")[0].reset();
	});
}




