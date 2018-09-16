if($(".customers-search").length){
	$("#reset-customers").click(function(){
		$(".customers-search").val("");
	});
}

//change event for customer  document list
if($("#txt-customers-data-list").length){
	$("#txt-customers-data-list").on('input', function () {
    var val = this.value;
    $('#customers-data-list').find('option').filter(function(){
			if(this.value==val){
				if(val!=''){
					customer_id =  $(this).attr("customer-id");
					window.location.href=$("#url").val()+"/loan_requirement/customerRequirement/"+customer_id;
				}
			}      
    });
	});
}

if($("#search_customer_id").length){
	searchCustomerId();
}

function searchCustomerId(){
	$("#search_customer_id").change(function(){
		var customer_id = $( "#search_customer_id option:selected" ).val();
		window.location.href=$("#url").val()+"/loan_requirement/customerRequirement/"+customer_id;
	});
}

if($("#search_customer_agent_id").length){
	$("#search_customer_agent_id").change(function(){
		var agent_id = $( "#search_customer_agent_id option:selected" ).val();
		var url = $("#url").val()+"/loan_requirement/getAgentCustomers/"+agent_id;
		if($(".agent_customers_list").length){
			$(".agent_customers_list").remove();
		}
		$.ajax({
			url:url,
			type:'GET',
			dataType:'html',
			success:function(data){
				$(".agent_customers").after(data);
				searchCustomerId();
			}
		});
	});
}

if($("#loan_received_date").length){
	$(".loan_closing_date").change(function(){
		getClosingDate();
	});
}



function getClosingDate(){
	var url = $("#url").val()+"/loan_requirement/getClosingDate";
	$.ajax({
		url:url,
		type:'post',
		data:$("#frm_edit_loan_requirement").serialize(),
		success:function(data){
			if(data!=''){
				$("#loan_closing_date").val(data);
			}
		}
	});
}


if($("#loan_account_status_id").length > 0){
	$("#loan_account_status_id").change(function(){
		var remove_req_attributes = ["loan_received_date","loan_closing_date","loan_tenure"];
		if($(this).val() == "3"){
			$.each(remove_req_attributes,function(index,val){
				$("#"+val).removeAttr("required");
				
			});
		}else{
			$.each(remove_req_attributes,function(index,val){
				if(!$("#"+val).attr("required")){
					$("#"+val).attr("attr","required");
				}
			});
		}
	});
}