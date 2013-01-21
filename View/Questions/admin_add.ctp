<div class="questions form">
<?php echo $this->Form->create('Question'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Question'); ?></legend>
	<?php
		echo $this->Form->input('survey_id');
		echo $this->Form->input('grouping_id');
		echo $this->Form->input('internal_name');
		echo $this->Form->input('label');
		echo $this->Form->input('type_id');
		echo $this->Form->input('ordering');
		echo $this->Form->input('is_used');
		echo $this->Form->input('is_required');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Questions'), array('action' => 'index')); ?></li>
		<li>
			<?php echo $this->Html->link(__('New Grouping'), array('controller' => 'groupings', 'action' => 'add')); ?>
		</li>
	</ul>
</div>
