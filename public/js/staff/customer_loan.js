// customer loan from staff login
if($("#frm_customer_loan_staff #customer_account_no").length){
	$("#frm_customer_loan_staff #customer_account_no").change(function(){
		var url = $("#url").val()+"/loan/getCustomerLoanInfoFromStaff";
		var data = $("#frm_customer_loan_staff").serialize();
		var customer_account_no = $( "#frm_customer_loan_staff #customer_account_no" ).val();
		if(customer_account_no!=''){
			$.ajax({
				url:url,
				type:'POST',
				data:data,
				dataType:'json',
				success:function(data){
					if(data.status=="success"){
						if(data.customer_name!=="undefined"){
							$("#customer_name").val(data.customer_name);
						}
						if(data.total_deposit!=="undefined"){
						$("#total_deposit").val(data.total_deposit);
						}
						if(data.agent_name!=="undefined"){
							$("#agent_name").val(data.agent_name);
						}
						if(data.previous_date_amount!=="undefined"){
							$("#previous_date_amount").val(data.previous_date_amount);
						}
						if(data.current_date_amount!=="undefined"){
							$("#current_date_amount").val(data.current_date_amount);
						}
						$("#agent_id").val(data.agent_id);
						$("#account_not_found").hide();
					}else{
						$("#account_not_found").show();
					}
				}
			});
		}else{
			$(".account_no").val("");
		  $("#total_deposit").val("");
		}
	});
}


