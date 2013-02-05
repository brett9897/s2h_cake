<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Vi Criterium'), array('action' => 'edit', $viCriterium['ViCriterium']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Vi Criterium'), array('action' => 'delete', $viCriterium['ViCriterium']['id']), null, __('Are you sure you want to delete # %s?', $viCriterium['ViCriterium']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Vi Criteria'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Vi Criterium'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Surveys'), array('controller' => 'surveys', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Survey'), array('controller' => 'surveys', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Options'), array('controller' => 'options', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Option'), array('controller' => 'options', 'action' => 'add')); ?> </li>
	</ul>
</div>
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
		<dt><?php echo __('Survey'); ?></dt>
		<dd>
			<?php echo $this->Html->link($viCriterium['Survey']['label'], array('controller' => 'surveys', 'action' => 'view', $viCriterium['Survey']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Option'); ?></dt>
		<dd>
			<?php echo $this->Html->link($viCriterium['Option']['label'], array('controller' => 'options', 'action' => 'view', $viCriterium['Option']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Vi Grouping Id'); ?></dt>
		<dd>
			<?php echo h($viCriterium['ViCriterium']['vi_grouping_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Threshold'); ?></dt>
		<dd>
			<?php echo h($viCriterium['ViCriterium']['threshold']); ?>
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