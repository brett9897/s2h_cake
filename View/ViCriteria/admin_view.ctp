<div class="viCriteria view">
<h2><?php  echo __('Vi Criterium'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($viCriterium['ViCriterium']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Question'); ?></dt>
		<dd>
			<?php echo $this->Html->link($viCriterium['Question']['label'], array('controller' => 'questions', 'action' => 'view', $viCriterium['Question']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo h($viCriterium['ViCriterium']['type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Relational Operator'); ?></dt>
		<dd>
			<?php echo h($viCriterium['ViCriterium']['relational_operator']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Values'); ?></dt>
		<dd>
			<?php echo h($viCriterium['ViCriterium']['values']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Weight'); ?></dt>
		<dd>
			<?php echo h($viCriterium['ViCriterium']['weight']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($viCriterium['ViCriterium']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($viCriterium['ViCriterium']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Vi Criterium'), array('action' => 'edit', $viCriterium['ViCriterium']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Vi Criterium'), array('action' => 'delete', $viCriterium['ViCriterium']['id']), null, __('Are you sure you want to delete # %s?', $viCriterium['ViCriterium']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Vi Criteria'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vi Criterium'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
