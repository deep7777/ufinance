if($("#customer_account_opening_date").length){
	$('#customer_account_opening_date').datetimepicker({
		format:'d/m/Y',
		timepicker: false
	});
}

if($("#customer_account_reopening_date").length){
	$('#customer_account_reopening_date').datetimepicker({
		format:'d/m/Y',
		timepicker: false
	});
}

if($("#customer_account_maturity_date").length){
	$('#customer_account_maturity_date').datetimepicker({
		format:'d/m/Y',
		timepicker: false
	});
}

if($(".account_fd_or_rd").length){
	$(".account_fd_or_rd").hide();
}

if($("#customer_account_status_id").length){
	var customer_account_status_id = $( "#customer_account_status_id option:selected" ).val();
	$("#customer_account_status_id").change(function(){
		customer_account_status_id = $( "#customer_account_status_id option:selected" ).val();
		account_reopen_date(customer_account_status_id);
	});
	account_reopen_date(customer_account_status_id);
}

if($("#account_type_id").length){
	var account_type_id = $( "#account_type_id option:selected" ).val();
	var text = getAccountType(account_type_id);
	
	$("#account_type_id").change(function(){
		account_type_id = $( "#account_type_id option:selected" ).val();
		text = (account_type_id==="3")?"RD":"FD";
		account_details(account_type_id,text);
	});
	
	account_details(account_type_id,text);
}

function getAccountType(account_type_id){
	var text = '';
	if($("#frm_type").val()==="add"){
		text = getAccountTypeVal(account_type_id);
	}
	return text;
}

function getAccountTypeVal(account_type_id){
	var text = (account_type_id==="3")?"RD":"FD";
	return text;
}

function getCustomerRegNo(){
	if($("#frm_type") == "add"){
		return $(".customer_reg_no").val();//hidden field class
	}else{
		var number_series = parseInt($("#customer_id").val()) + 1000;
		var reg_no = "UF-"+number_series;
		return reg_no;
	}
}
function account_details(account_type_id,text){
	
	if(account_type_id==="3" || account_type_id==="4"){
		$(".account_fd_or_rd").show();
		$(".account_details").each(function() {
				$(this).attr("required","");
		});
		
		var reg_no = getCustomerRegNo();
		var text = (account_type_id==="3")?"RD":"FD";
		var customer_reg_no = reg_no+""+text;
		$(".customer_reg_no").val(customer_reg_no);
	}else{
		$(".account_fd_or_rd").hide();
		$(".customer_reg_no").val($(".org_customer_reg_no").val());
		$(".account_details").each(function() {
			$(this).removeAttr("required","");
		});
	}
}

function account_reopen_date(customer_account_status_id){
	//account status active,inactive,reopen
	if(customer_account_status_id==="3"){
		$("#customer_account_reopening_date").val("");
		$(".customer_account_reopening_date").show();
		$("#customer_account_reopening_date").attr("required","");
	}else{
		$(".customer_account_reopening_date").hide();
		$("#customer_account_reopening_date").val("");
		$("#customer_account_reopening_date").removeAttr("required","");
	}
}

if($("#customer_amount").length){
	$("#customer_amount").change(function(){
		calculateMaturityValue();
	});
}

if($("#customer_interest_rate").length){
	$("#customer_interest_rate").change(function(){
		calculateMaturityValue();
	});
}

if($("#customer_maturity_value").length){
	$("#customer_maturity_value").change(function(){
		calculateMaturityValue();
	});
}

function calculateMaturityValue(){
	//Amount+((Amount/100)*Interest Rate)
	if($("#customer_interest_rate").val()!='' && $("#customer_amount").val()!=''){
		var cir = $("#customer_interest_rate").val();
		var ca = $("#customer_amount").val();
		var per = (parseInt(ca)/100*parseFloat(cir));
		var maturity_value = (parseInt(ca)+per);
		$("#customer_maturity_value").val(maturity_value);
	}
}


