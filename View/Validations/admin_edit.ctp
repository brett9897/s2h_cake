<div class="validations form">
<?php echo $this->Form->create('Validation'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Validation'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('label');
		echo $this->Form->input('regex');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Validation.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Validation.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Validations'), array('action' => 'index')); ?></li>
	</ul>
</div>
