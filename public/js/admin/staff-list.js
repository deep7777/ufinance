if($('#staff-list').length){
	$('#staff-list').DataTable({
		keys: true,
		aoColumnDefs: [
			{
				 bSortable: false,
				 aTargets: [ -1 ]
			}
		]
	});
}

$(".delStaff").click(function(){
	var token = $(this).data('token');
	var id = $(this).data('staff-id');
	var data = {_token :token,id:id};
	var url = $("#delete_url").val();
	var list_staff = $("#list_staff").val();
	if(confirm("Are you sure you want to delete record")){
		$.ajax({
			url:url,
			type: 'post',
			data: data,
			success:function(resp){
        window.location.href = list_staff;
			}
		});
	}
});