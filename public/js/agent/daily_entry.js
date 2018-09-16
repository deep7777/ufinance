$("#btn-customer").click(function(){
	var data = {};
	data.customer_account_no = $("#customer_account_no").val();
	if($("#customer_account_no").val()!=''){
		var url = $("#url").val()+"/customer/getAccounts";
		var data = $("#frm_customer_daily_entry").serialize();
		$(".clear-all").val("");
		$.ajax({
			url:url,
			type:'POST',
			data:data,
			dataType:'json',
			success:function(data){
				if(data.status=="success"){
					$("#error_msg").hide();
					$("#btn-submit").show();
					$("#customer_name").val(data.customer_name);
					$("#total_saving_deposit").val(data.total_saving_deposit);
					if(data.is_loan_taken=="1"){
						$(".loan_account").show();
						$("#total_loan_deposit").val(data.total_loan_deposit);
					}else{
						$(".loan_account").hide();
					}
				}else{
					$("#btn-submit").hide();
					$("#error_msg").show();
				}
			}
		});
	}
});

