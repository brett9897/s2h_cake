<?php $this->Html->script('SurveyInstances/select_survey.js', FALSE);?>
<div class="surveyInstances index no-border">
	<?php echo $this->Form->input('survey_id', array('label' => 'Choose Survey: '));?>
	<br/>
	<button onclick="load_survey_instances()">Submit</button>
</div>
