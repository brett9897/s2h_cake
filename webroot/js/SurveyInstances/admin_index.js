$(document).ready(function(){
	oTable = $("#clientsResults").dataTable({
		//"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": global.base_url + "/survey_instances/dataTables.json",
		"fnServerParams" : function ( aoData )
		{
			aoData.push( {"name": "survey_id", "value": location.href.substring(location.href.lastIndexOf("/") + 1)} );
		},
		"aoColumns": [
		              	{"bSortable": true, "bSearchable": true},
		              	{"bSortable": true, "bSearchable": true},
		              	{"bSortable": false, "bSearchable": false},
		              	{"bSortable": false, "bSearchable": false},
		              	{"bSortable": true, "bSearchable": false},
		             ],
		"aaSorting": [[1, 'asc']]
	}).fnSetFilteringDelay(1000);
	
	$('#clientsResults').on('click', 'tbody tr', function(event){
		var id = $(this).attr('id');
		location.href = global.base_url + "/clients/view/" + id.substr(id.indexOf('_') + 1);
	});
});