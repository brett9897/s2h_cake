columnTableOptions = [
				{"bSortable": true, "bSearchable": true},
		        {"bSortable": true, "bSearchable": true},
		        {"bSortable": false, "bSearchable": false},
		        {"bSortable": false, "bSearchable": false},
		        {"bSortable": true, "bSearchable": false},
]

columns = ['Client.first_name', 'Client.last_name', 'Client.dob', 'Client.ssn', 'SurveyInstace.vi_score']
columnLabels = ['First Name', 'Last Name', 'DOB', 'SSN', 'VI Score']

$ ->
	$(document).ready ->
		oTable = $("#clientsResults").dataTable
			"sPaginationType": "full_numbers"
			"bProcessing": true
			"bServerSide": true
			"sAjaxSource": "#{global.base_url}/survey_instances/dataTables.json"
			"fnServerParams": (aoData) ->
				aoData.push
					"name": "survey_id"
					"value": location.href.substring(location.href.lastIndexOf("/") + 1)
				aoData.push
					"name": "aColumns"
					"value": columns
			"aoColumns": columnTableOptions,
			"aaSorting": [[1, 'asc']]
		.fnSetFilteringDelay(1000)

		$('#clientsResults').on 'click', 'tbody tr', (event)->
			id = $(this).attr('id')
			location.href = "#{global.base_url}/clients/view/#{id.substr(id.indexOf('_')+1)}"

		$('#custom-report-select').dialog
			autoOpen: false
			modal: true
			show:
				effect: 'slide'
				direction: 'left'
			hide:
				effect: 'slide'
				direction: 'right'
			buttons:
				Ok: ->
					$(@).dialog('close')
					$('#custom-report-options').dialog('open')

		$('#custom-report-options').dialog
			autoOpen: false
			modal: true
			show:
				effect: 'slide'
				direction: 'left'
			hide:
				effect: 'slide'
				direction: 'right'

create_custom_report = ->
	$('#custom-report-select').dialog('open')

window.create_custom_report = create_custom_report