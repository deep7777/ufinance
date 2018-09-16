if($("frm_agent_salary #agent_joining_date").length){
	$('#agent_joining_date').datetimepicker({
		format:'d/m/Y',
		timepicker: false
	});
}

if($("#frm_agent_salary .cal_comission").length){
	$("#frm_agent_salary .cal_comission").change(function(){
		if($("#agent_comission_per").val()!='' && $("#agent_month_saving_deposit").val()!=''){
			var url = $("#url").val()+"/salary/calculateSalary";
			$.ajax({
				url:url,
				type: 'post',
				data: $("#frm_agent_salary").serialize(),
				success:function(resp){
					$("#agent_comission").val(resp);
					getTotalSalary();
				}
			});
		}
	});
}

if($("#frm_agent_salary .agent_salary").length){
	$("#frm_agent_salary .agent_salary").change(function(){
		getTotalSalary();
	});
}

function clearSalaryFields(){
	$("#agent_fixed_salary","#agent_month_saving_deposit","#agent_comission").val("");
	$("#agent_total_salary").val("");
}

if($("#frm_agent_salary #agent_id").length){
	$("#agent_id").change(function(){
		clearSalaryFields();
		getAgentSalary();
	});
}

if($("#frm_agent_salary #agent_salary_paid_date").length){
	$("#agent_salary_paid_date").change(function(){
		clearSalaryFields();
		getAgentSalary();
	});
}

function getAgentSalary(){
	var agent_id = $("#agent_id option:selected").val();
	if(agent_id!==''){
		var url = $("#url").val()+"/salary/getAgentSalary";
		$.ajax({
			url:url,
			type: 'post',
			data:$("#frm_agent_salary").serialize(),
			dataType:'json',
			success:function(resp){
				if(resp.agent_fixed_salary!=='null'){
					$("#agent_fixed_salary").val(resp.agent_fixed_salary);
				}
				if(resp.total_month_deposit!=='null'){
					$("#agent_month_saving_deposit").val(resp.total_month_deposit);
				}
				if(resp.comission!=='null'){
					$("#agent_comission").val(resp.comission);
				}
				getTotalSalary();
			}
		});
	}else{
		$("#frm_agent_salary")[0].reset();
	}
}
function getTotalSalary(){
	if($("#agent_comission").val()!='' && $("#agent_fixed_salary").val()!=''){
		var url = $("#url").val()+"/salary/totalSalary";
		$.ajax({
			url:url,
			type: 'post',
			data: $("#frm_agent_salary").serialize(),
			success:function(resp){
				$("#agent_total_salary").val(resp);
			}
		});
	}
}
