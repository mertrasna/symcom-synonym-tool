$(document).ready(function () {
	$('#dataTable').on('init.dt',function() {
        $("#dataTable").removeClass('table-loader').show();
	});
	$('#dataTable').DataTable({ 
		"stateSave": true,
		"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
		"responsive": true,
		"language": {
	       "url": absoluteUrl+"lang/dataTableEnglish.json"
	   	}
	});
	$('.reset-datatable-state a').click( function() {
		table.state.clear();
		//window.location.reload();
	});
});