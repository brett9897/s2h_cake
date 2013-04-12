<?php $this->Html->css('SurveyInstances/admin_index', null, array('inline' => false)); ?>
<?php echo $this->element('reports_data_tables');?>
<?php $this->Html->script('SurveyInstances/admin_index.js', FALSE); ?>

<div id="custom_report_button" class="clear">
	<button onClick="create_custom_report()">Custom Report</button>
	<button onClick="use_default_report()">Use Default Report</button>
</div>

<div id="custom-report-select" title="Select Columns For Custom Report">
	<ul id="selectable">
		<li class="ui-state-default">
			<div class="outerContainer">
				<div class="innerContainer">
					<div class="element" id="Client.first_name">First Name</div>
				</div>
			</div>
		</li>
		<li class="ui-state-default">
			<div class="outerContainer">
				<div class="innerContainer">
					<div class="element" id="Client.middle_name">Middle Name</div>
				</div>
			</div>
		</li>
		<li class="ui-state-default">
			<div class="outerContainer">
				<div class="innerContainer">
					<div class="element" id="Client.last_name">Last Name</div>
				</div>
			</div>
		</li>
		<li class="ui-state-default">
			<div class="outerContainer">
				<div class="innerContainer">
					<div class="element" id="Client.nickname">Nickname</div>
				</div>
			</div>
		</li>
		<li class="ui-state-default">
			<div class="outerContainer">
				<div class="innerContainer">
					<div class="element" id="Client.dob">DOB</div>
				</div>
			</div>
		</li>
		<li class="ui-state-default">
			<div class="outerContainer">
				<div class="innerContainer">
					<div class="element" id="Client.ssn">SSN</div>
				</div>
			</div>
		</li>
		<li class="ui-state-default">
			<div class="outerContainer">
				<div class="innerContainer">
					<div class="element" id="Client.phone_number">Phone Number</div>
				</div>
			</div>
		</li>
		<li class="ui-state-default">
			<div class="outerContainer">
				<div class="innerContainer">
					<div class="element" id="SurveyInstance.vi_score">VI Score</div>
				</div>
			</div>
		</li>
		<?php foreach( $internal_names as $id => $internal_name ): ?>
			<li class="ui-state-default">
				<div class="outerContainer">
					<div class="innerContainer">
						<div class="element" id="<?php echo $internal_name; ?>"><?php echo $internal_name; ?></div>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
	</ul>
	<div class="footer"><strong><em>*Use Ctrl + left-click to select multiple fields</em></strong></div>
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