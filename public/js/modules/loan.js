if($("#frm_loan  #txt-loan-customers-data-list").length){
	$("#frm_loan #txt-loan-customers-data-list").on('input', function () {
    var val = this.value;
		
    $('#loan-customers-data-list').find('option').filter(function(){
			if(this.value==val){
				if(val!=''){
					customer_account_no =  $(this).attr("customer-account-no");
					$("#frm_loan #customer_account_no").val(customer_account_no);
					getCustomerLoanAccountInfo();
				}
			}      
    });
	});
}

if($("#frm_loan_report #agent_id").length){
	$("#frm_loan_report #agent_id").change(function(){
		var agent_id = $(this).val();
		var url = $("#url").val()+"/reports/getAgentCustomers/"+agent_id;
		$("#frm_loan_report .customer_loan_report_data").html("");
		if(agent_id!=''){
			$.ajax({
				url:url,
				type:'GET',
				dataType:'html',
				success:function(data){
					$("#frm_loan_report .customer_details").html(data);
				}
			});
		}
	});
}

if($("#frm_loan_report #customer_loan_report").length){
	$("#frm_loan_report #customer_loan_report").click(function(){
		var url = $("#url").val()+"/getCustomerLoanSummary"
		var data = $("#frm_loan_report").serialize();
		$("#frm_loan_report .customer_loan_report_data").html("");
		$.ajax({
			url:url,
			type:'POST',
			data:data,
			dataType:'html',
			success:function(data){
				$("#frm_loan_report .customer_loan_report_data").html(data);
				$.fn.dataTable.moment( 'D/M/YYYY'); 
				$('#data-all-list').DataTable({
					keys: true,
					"aaSorting": []
				});
			}
		});
	});
}

if($("#frm_loan .loan-month-year").length){
	$('.loan-month-year').datetimepicker({
		format:'d/m/Y',
		datepicker:true,
		timepicker: false
	});
}

//https://www.npmjs.com/package/jquery-ui-monthpicker
if($('#frm_loan input.month-picker').length){
	$('#frm_loan input.month-picker').monthpicker({
		changeYear: true,
		onClose:getLoanMonthYearValues
	});
}

if($("#frm_loan #customer_account_no").length){
	$("#frm_loan #customer_account_no").change(function(){
		getCustomerLoanAccountInfo();
	});
}

if($("#frm_loan #customer_account_no").length){
	if($("#frm_loan #customer_account_no").val().length > 3){
		getCustomerLoanAccountInfo();
	}
}

function getCustomerLoanAccountInfo(){
	var url = $("#url").val()+"/loan/getCustomerAccountInfo";
	var data = $("#frm_loan").serialize();
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
				$("#frm_loan .loan_customer_data").html("");
				getCustomerLoanTemplate(data.customer_id);
			}else{
				$("#frm_loan .loan_customer_data").html("<div class='red'>Loan Account Not Found.</div>");
				$(".clear-all").val("");
			}
		}
	});
	
}

if($("#frm_loan #search_loan_customer_id").length){
	bindLoanCustomerId();
}


if($("#frm_loan #month_year").length){
	bindLoanMonthYear();
}

function bindLoanMonthYear(){
	$("#frm_loan #month_year").click(function(){
		getLoanMonthYearValues();
	});
}

function getLoanMonthYearValues(){
	var customer_id = $("#customer_id").val();
	if(customer_id!='' && typeof(customer_id)!= "undefined"){
		getCustomerLoanTemplate(customer_id);
	}
}

function getCustomerLoanTemplate(customer_id){
	var url = $("#url").val()+"/loan/getMonthlyCustomerData/"+customer_id;
	var data = $("#frm_loan").serialize();
	$.ajax({
		url:url,
		type:'POST',
		data:data,
		dataType:'html',
		success:function(data){
			$("#frm_loan .loan_customer_data").html(data);
		}
	});
}