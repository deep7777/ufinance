if ($(".date_class").length) {
	$('.date_class').datetimepicker({
		format: 'd/m/Y',
		timepicker: false
	});
}

if($('input.month-picker').length){
	$('input.month-picker').monthpicker({
		changeYear: true,
		onClose:""
	});
	//https://www.npmjs.com/package/jquery-ui-monthpicker
}