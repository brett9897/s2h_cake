<?php $this->Html->css('SurveyInstances/admin_index', null, array('inline' => false)); ?>
<?php echo $this->element('reports_data_tables');?>
<?php $this->Html->script('SurveyInstances/admin_index.js', FALSE); ?>

<div id="custom_report_button" class="clear">
	<button onClick="create_custom_report()">Custom Report</button>
</div>

<div id="custom-report-select" title="Select Columns For Custom Report">
	<ol id="selectable">
		<li class="ui-state-default">Client.first_name</li>
		<li class="ui-state-default">Client.middle_name</li>
		<li class="ui-state-default">Client.last_name</li>
		<li class="ui-state-default">Client.nickname</li>
		<li class="ui-state-default">Client.dob</li>
		<li class="ui-state-default">Client.ssn</li>
		<li class="ui-state-default">Client.phone_number</li>
		<li class="ui-state-default">SurveyInstance.vi_score</li>
		<?php foreach( $internal_names as $id => $internal_name ): ?>
			<li class="ui-state-default"><?php echo $internal_name; ?></li>
		<?php endforeach; ?>
	</ol>
</div>

<div id="custom-report-options" title="Select Options For Each Column">
	<table>
		<thead>
			<tr>
				<th>Field</th>
				<th>Sortable</th>
				<th>Searchable</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>