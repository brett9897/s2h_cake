<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Surveys'), array('controller' => 'surveys', 'action' => 'index')); ?> <br/>
	<?php echo $this->Html->link(__('New Survey'), array('controller' => 'surveys', 'action' => 'add')); ?> <br/>
	<?php echo $this->Html->link(__('Edit Survey'), array('controller' => 'surveys', 'action' => 'edit', $selected_index)); ?> <br/>
	<?php echo $this->Html->link(__('New Grouping'), array('controller' => 'groupings', 'action' => 'add', $selected_index), 
		array('class' => 'active_link')); ?> <br/>
	<?php echo $this->Html->link(__('New VI Criterion'), array('controller' => 'vi_criteria', 'action' => 'add', $selected_index)); ?><br/>
	<?php echo $this->Html->link(__('List VI Criteria'), array('controller' => 'vi_criteria', 'action' => 'index', $selected_index)); ?><br/>
</div>
<div class="groupings form">
<?php echo $this->Form->create('Grouping'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Grouping'); ?></legend>
	<?php
		echo $this->Form->input('survey_id', array('selected' => $selected_index, 'disabled' => true));
		echo $this->Form->input('survey_id', array('value' => $selected_index, 'type'=>'hidden'));
		echo $this->Form->input('label');
		echo $this->Form->input('ordering');
		echo $this->Form->input('is_used');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>