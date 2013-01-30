<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Surveys'), array('action' => 'index')); ?><br/>
	<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Survey.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Survey.id'))); ?><br/>
	<?php echo $this->Html->link(__('List Groupings'), array('controller' => 'groupings', 'action' => 'index', $this->Form->value('Survey.id'))); ?><br/>
	<?php echo $this->Html->link(__('New Grouping'), array('controller' => 'groupings', 'action' => 'add')); ?> <br/>
</div>
<div class="surveys form">
<?php echo $this->Form->create('Survey'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Survey'); ?></legend>
	<?php
		echo $this->Form->input('id');
		if( isset( $organizations ) )
		{
			echo $this->Form->input('organization_id');
		}
		echo $this->Form->input('label');
		echo $this->Form->input('isActive');
		echo $this->Form->input('isDeleted');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
<?php foreach( $groupings as $grouping): ?>
	<div><? var_dump($grouping['Grouping']); ?></div>
<?php endforeach; ?>
</div>