<?php echo $this->element('reports_data_tables');?>
<?php $this->Html->script('SurveyInstances/admin_index.js', FALSE); ?>

<div class="clear">
	<button onClick="create_custom_report()">Custom Report</button>
</div>

<div id="custom-report-select" title="Select Columns For Custom Report">
	<p>
		Testy
	</p>
</div>

<div id="custom-report-options" title="Select Options For Each Column">
	<p>
		Testy 2
	</p>
</div>