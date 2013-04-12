defaults = []
defaults['columns'] = ['Client.first_name', 'Client.last_name', 'Client.dob', 'Client.ssn', 'SurveyInstace.vi_score']
defaults['columnLabels'] = ['First Name', 'Last Name', 'DOB', 'SSN', 'VI Score']
defaults['columnTableOptions'] = [
	{"bSortable": true, "bSearchable": true},
	{"bSortable": true, "bSearchable": true},
	{"bSortable": false, "bSearchable": false},
	{"bSortable": false, "bSearchable": false},
	{"bSortable": true, "bSearchable": false},
]

columns = defaults['columns']
columnTableOptions = defaults['columnTableOptions']

$ ->
	$(document).ready ->
		header_string = ''

		draw_table = ->
			$("#clientsResults").dataTable
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

		oTable = draw_table()

		$('#clientsResults').on 'click', 'tbody tr', (event)->
			id = $(this).attr('id')
			location.href = "#{global.base_url}/clients/view/#{id.substr(id.indexOf('_')+1)}"

		$('#custom-report-select').dialog
			autoOpen: false
			modal: true
			width: 815
			height: 500
			show:
				effect: 'slide'
				direction: 'left'
			hide:
				effect: 'slide'
				direction: 'right'
			buttons:
				Ok: ->
					setFields()
					$(@).dialog('close')
					$('#custom-report-options').dialog('open')

		$('#custom-report-options').dialog
			autoOpen: false
			modal: true
			width: 500
			show:
				effect: 'slide'
				direction: 'left'
			hide:
				effect: 'slide'
				direction: 'right'

		$('#selectable').selectable()

		setFields = ->
			options_html = "<td class='sortable'><select><option>true</option><option>false</option></td><td class='sortable'><select><option>true</option><option>false</option></td>"
			header_string = ''
			options_body = $("#custom-report-options > table > tbody")
			options_body.html('')

			for column in $('#selectable > li.ui-selected')
				header_string += "<th>#{$(column).html()}</th>"
				options_body.append("<tr><td>#{$(column).html()}</td>#{options_html}</tr>")

#oTable.fnDestroy()
#header = $('#clientsResults')
#header.html("<thead>#{header_string}</thead>")
#oTable = draw_table()


create_custom_report = ->
	$('#custom-report-select').dialog('open')

window.create_custom_report = create_custom_report