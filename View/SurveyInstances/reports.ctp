<?php echo $this->element('reports_data_tables');?>
<?php $this->Html->script('SurveyInstances/reports.js', FALSE); ?>
<?php echo $this->Form->input('', array('type' => 'hidden', 'value' => $user_id, 'id' => 'user_id')); ?>

<?php echo "blah"; ?>