<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Vi Criteria'), array('action' => 'index')); ?><br/>
</div>
<div class="viCriteria form">
<?php echo $this->Form->create('ViCriterium'); ?>
	<fieldset>
		<legend><?php echo __('Add Vi Criterium'); ?></legend>
	<?php
		echo $this->Form->input('question_id');
		echo $this->Form->input('survey_id');
		echo $this->Form->input('option_id');
		echo $this->Form->input('vi_grouping_id');
		echo $this->Form->input('threshold');
		echo $this->Form->input('weight');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>