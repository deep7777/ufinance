
if($("#frm_customer_saving #customer_account_no").length){
	$("#frm_customer_saving #customer_account_no").change(function(){
		var url = $("#url").val()+"/customer/getSavingInfo";
		var data = $("#frm_customer_saving").serialize();
		var customer_account_no = $( "#frm_customer_saving #customer_account_no option:selected" ).val();
		if(customer_account_no!=''){
			$.ajax({
				url:url,
				type:'POST',
				data:data,
				dataType:'json',
				success:function(data){
				  $(".account_no").val(customer_account_no);
					if(data.status=="success"){
						var total_deposit = data.total_deposit;
						$("#total_deposit").val(total_deposit);
					}
				}
			});
		}else{
			$(".account_no").val("");
		  $("#total_deposit").val("");
		}
	});
}

