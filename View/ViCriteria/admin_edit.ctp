<div class="viCriteria form">
<?php echo $this->Form->create('ViCriterium'); ?>
	<fieldset>
		<legend><?php echo __('Admin Edit Vi Criterium'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('question_id');
		echo $this->Form->input('type');
		echo $this->Form->input('relational_operator');
		echo $this->Form->input('values');
		echo $this->Form->input('weight');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ViCriterium.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('ViCriterium.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Vi Criteria'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
