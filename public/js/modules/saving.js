/*
function bindCustomerId(){
	$("#frm_saving #search_saving_customer_id").change(function(){
		customer_id = $( "#frm_saving #search_saving_customer_id option:selected" ).val();
		getCustomerSavingTemplate(customer_id);
	});
}

if($("#frm_saving #search_saving_customer_agent_id").length){
	$("#frm_saving #search_saving_customer_agent_id").change(function(){
		var agent_id = $( "#frm_saving #search_saving_customer_agent_id option:selected" ).val();
		var url = $("#url").val()+"/saving/getAgentCustomers/"+agent_id;
		if($("#frm_saving .agent_customers_list").length){
			$("#frm_saving .agent_customers_list").remove();
		}
		$.ajax({
			url:url,
			type:'GET',
			dataType:'html',
			success:function(data){
				$("#frm_saving .agent_saving_customers").after(data);
				$("#frm_saving .saving_customer_data").html("");
				bindCustomerId();
			}
		});
	});
}

if($("#frm_saving  #txt-saving-customers-data-list").length){
	$("#frm_saving #txt-saving-customers-data-list").on('input', function () {
    var val = this.value;
		
    $('#saving-customers-data-list').find('option').filter(function(){
			if(this.value==val){
				if(val!=''){
					if($('#frm_saving #search_saving_customer_id').length){
						$('#frm_saving #search_saving_customer_id ').get(0).selectedIndex = 0;
					}
					customer_id =  $(this).attr("saving-customer-id");
					getCustomerSavingTemplate(customer_id);
				}
			}      
    });
	});
}

$("#frm_saving #txt-saving-customers-data-list").change(function(){
	customer_id = $( "#frm_saving #txt-saving-customers-data-list option:selected" ).val();
	getCustomerSavingTemplate(customer_id);
});


if($("#frm_saving #search_saving_customer_id").length){
	bindCustomerId();
}
*/

if($("#frm_saving  #txt-saving-customers-data-list").length){
	$("#frm_saving #txt-saving-customers-data-list").on('input', function () {
    var val = this.value;
		
    $('#saving-customers-data-list').find('option').filter(function(){
			if(this.value==val){
				if(val!=''){
					customer_account_no =  $(this).attr("customer-account-no");
					$("#frm_saving #customer_account_no").val(customer_account_no);
					getCustomerSavingAccountInfo();
				}
			}      
    });
	});
}


//https://www.npmjs.com/package/jquery-ui-monthpicker
if($('#frm_saving input.month-picker').length){
	$('#frm_saving input.month-picker').monthpicker({
		changeYear: true,
		onClose:getMonthYearValues
	});
}

if($("#frm_saving .saving-month-year").length){
	$('.saving-month-year').datetimepicker({
		format:'d/m/Y',
		datepicker:true,
		timepicker: false
	});
}

if($("#frm_saving #customer_account_no").length){
	$("#frm_saving #customer_account_no").change(function(){
		getCustomerSavingAccountInfo();
	});
}

if($("#frm_saving #customer_account_no").length){
	if($("#frm_saving #customer_account_no").val().length > 3){
		getCustomerSavingAccountInfo();
	}
}

function getCustomerSavingAccountInfo(){
	var url = $("#url").val()+"/saving/getCustomerAccountInfo";
	var data = $("#frm_saving").serialize();
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
				$("#frm_saving .saving_customer_data").html("");
				getCustomerSavingTemplate(data.customer_id);
			}else{
				$("#frm_saving .saving_customer_data").html("");
				$(".clear-all").val("");
			}
		}
	});
}


if($("#frm_saving #month_year").length){
	bindMonthYear();
}

function bindMonthYear(){
	$("#frm_saving #month_year").click(function(){
		getMonthYearValues();
	});
}

function getMonthYearValues(){
	var customer_id = $("#customer_id").val();
	if(customer_id!='' && typeof(customer_id)!= "undefined"){
		getCustomerSavingTemplate(customer_id);
	}
}

function getCustomerSavingTemplate(customer_id){
	if(customer_id===''){
		customer_id = $( "#frm_saving #search_saving_customer_id option:selected" ).val();
	}
	var url = $("#url").val()+"/saving/getMonthlyCustomerData/"+customer_id;
	var data = $("#frm_saving").serialize();
	$("#frm_saving .saving_customer_data").html("");
	$.ajax({
		url:url,
		type:'POST',
		data:data,
		dataType:'html',
		success:function(data){
			$("#frm_saving .saving_customer_data").html(data);
		}
	});
}