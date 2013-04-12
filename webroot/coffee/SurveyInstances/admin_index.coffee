defaults = []
defaults['columns'] = ['Client.first_name', 'Client.last_name', 'Client.dob', 'Client.ssn', 'SurveyInstance.vi_score']
defaults['columnLabels'] = ['First Name', 'Last Name', 'DOB', 'SSN', 'VI Score']
defaults['columnTableOptions'] = [
	{"bSortable": true, "bSearchable": true},
	{"bSortable": true, "bSearchable": true},
	{"bSortable": false, "bSearchable": false},
	{"bSortable": false, "bSearchable": false},
	{"bSortable": true, "bSearchable": false},
]

columns = defaults['columns'].slice(0)
columnTableOptions = defaults['columnTableOptions'].slice(0)
columnLabels = defaults['columnLabels'].slice(0)
oTable = null

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

$ ->
	$(document).ready ->
		oTable = draw_table()

		$('#clientsResults').on 'click', 'tbody tr', (event)->
			id = $(this).attr('id')
			location.href = "#{global.base_url}/clients/view/#{id.substr(id.indexOf('_')+1)}"

		$('#custom-report-select').dialog
			autoOpen: false
			modal: true
			width: 780
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
			buttons:
				Ok: ->
					get_custom_data()
					oTable.fnDestroy()
					build_header()
					oTable = draw_table()
					$(@).dialog('close')

		$('#selectable').selectable()

		setFields = ->
			options_html = "<td><select class='sortable'><option>true</option><option>false</option></td><td><select class='searchable'><option>true</option><option>false</option></td>"
			options_body = $("#custom-report-options > table > tbody")
			options_body.html('')

			for column in $('#selectable > li.ui-selected')
				id = $(column).find('.element').attr('id')
				console.log(id)
				options_body.append("<tr><td id='#{id}' class='col_val'>#{$(column).text().trim()}</td>#{options_html}</tr>")

		get_custom_data = ->
			columns.length = 0
			columnTableOptions.length = 0
			columnLabels.length = 0
			for row in $('#custom-report-options > table > tbody > tr')
				columns.push($(row).find('.col_val').attr('id').trim())
				columnTableOptions.push
					'bSortable': $(row).find('.sortable').val().toLowerCase() == 'true'
					'bSearchable': $(row).find('.searchable').val().toLowerCase() == 'true'
				columnLabels.push($(row).find('.col_val').text().trim())
		return

build_header = ->
	header = $('#clientsResults')
	header.html("<thead><tr><th>#{columnLabels.join('</th><th>')}</th></tr></thead>")
	return

create_custom_report = ->
	$('#custom-report-select').dialog('open')

use_default_report = ->
	columns = defaults['columns'].slice(0)
	columnTableOptions = defaults['columnTableOptions'].slice(0)
	columnLabels = defaults['columnLabels'].slice(0)
	oTable.fnDestroy()
	build_header()
	oTable = draw_table()

window.create_custom_report = create_custom_report
window.use_default_report = use_default_report