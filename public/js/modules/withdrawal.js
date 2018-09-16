if($("#frm_withdrawal #customer_account_no").length){
	$("#frm_withdrawal #customer_account_no").change(function(){
		var url = $("#url").val()+"/withdrawal/getCustomerAccountInfo";
		var data = $("#frm_withdrawal").serialize();
		$.ajax({
			url:url,
			type:'POST',
			data:data,
			dataType:'json',
			success:function(data){
				if(data.status=="success"){
					$("#agent_id").val(data.agent_id);
					$("#customer_name").val(data.customer_first_name+" "+data.customer_last_name);
					$("#agent_name").val(data.agent_name);
					$("#total_deposit").val(data.total_deposit);
					getWithDrawalHistory();
				}else{
					$(".clear-all").val("");
				  $("#frm_withdrawal .withdrawal_history").html("");
				}
			}
		});
	});
}

if($("#frm_withdrawal .amount_in_hand").length){
	$("#frm_withdrawal .amount_in_hand").change(function(){
		var url = $("#url").val()+"/withdrawal/getAmountInHand";
		var data = $("#frm_withdrawal").serialize();
		$.ajax({
			url:url,
			type:'POST',
			data:data,
			dataType:'json',
			success:function(data){
				if(data.amount_in_hand!==''){
					var amount_in_hand = data.amount_in_hand;
					$("#amount_in_hand").val(amount_in_hand);
				}
				if(data.total_balance!==''){
					$("#total_balance").val(data.total_balance);
				}
			}
		});
	});
}

function getWithDrawalHistory(){
	var url = $("#url").val()+"/withdrawal/getCustomerWithdrawalHistory";
	var data = $("#frm_withdrawal").serialize();
	$.ajax({
		url:url,
		type:'POST',
		data:data,
		dataType:'html',
		success:function(data){
			$("#frm_withdrawal .withdrawal_history").html(data);
			bindWithDrawalDataKeyTableList();
		}
	});
}

function bindWithDrawalDataKeyTableList(){
	$.fn.dataTable.moment( 'D-MMM-YYYY'); 
	$('#data-withdrawal-keytable-list').DataTable({
		keys: true,
		"aaSorting": [],
		aoColumnDefs: [
			{
				 bSortable: false
				 //aTargets: [ -1 ]
			}
		]
	});
	/*
	if ($("#datatable-buttons").length) {
		$("#datatable-buttons").DataTable({
			dom: "Bfrtip",
			buttons: [
				{
					extend: "print",
					className: "btn-sm"
				},
			],
			responsive: true
		});
	}*/
}