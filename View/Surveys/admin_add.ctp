<div class="surveys form">
<?php echo $this->Form->create('Survey'); ?>
	<fieldset>
		<legend><?php echo __('Admin Add Survey'); ?></legend>
	<?php
		echo $this->Form->input('organization_id');
		echo $this->Form->input('label');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Surveys'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('New Survey'), array('action' => 'add')); ?></li>
	</ul>
</div>
