<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Groupings'), array('action' => 'index')); ?><br/>
	<?php echo $this->Html->link(__('List Surveys'), array('controller' => 'surveys', 'action' => 'index')); ?> <br/>
	<?php echo $this->Html->link(__('New Survey'), array('controller' => 'surveys', 'action' => 'add')); ?> <br/>
	<?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> <br/>
	<?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> <br/>
</div>
<div class="groupings form">
<?php echo $this->Form->create('Grouping'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Grouping'); ?></legend>
	<?php
		echo $this->Form->input('survey_id');
		echo $this->Form->input('label');
		echo $this->Form->input('ordering');
		echo $this->Form->input('is_used');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>