$(document).ready(function(){
	oTable = $("#clientsResults").dataTable({
		//"bJQueryUI": true,                    //tells it to use the JQuery UI theme
		"sPaginationType": "full_numbers",
		"bProcessing": true,
		"bServerSide": true,
		"sAjaxSource": global.base_url + "/clients/dataTables.json",            //dataTables.json is really dataTables.ctp and is is /app/webroot/ putting the .json tells CakePHP to remove all its html visual wrappers.
                //"sAjaxSource": global.base_url + "/Controller/ClientController.php",
		"aoColumns": [
		              	{"bSortable": true, "bSearchable": true},
		              	{"bSortable": true, "bSearchable": true},
		              	{"bSortable": false, "bSearchable": false}
		             ],
		"aaSorting": [[1, 'asc']]
	});//.fnSetFilteringDelay(1000);                                        //this was for the seach delay
	
	$('#clientsResults').on('click', 'tbody tr', function(event){
		var id = $(this).attr('id');
		location.href = global.base_url + "/clients/view/" + id.substr(id.indexOf('_') + 1);
	});
});