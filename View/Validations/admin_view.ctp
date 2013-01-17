<div class="validations view">
<h2><?php  echo __('Validation'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($validation['Validation']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Label'); ?></dt>
		<dd>
			<?php echo h($validation['Validation']['label']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Regex'); ?></dt>
		<dd>
			<?php echo h($validation['Validation']['regex']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($validation['Validation']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($validation['Validation']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Validation'), array('action' => 'edit', $validation['Validation']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Validation'), array('action' => 'delete', $validation['Validation']['id']), null, __('Are you sure you want to delete # %s?', $validation['Validation']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Validations'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Validation'), array('action' => 'add')); ?> </li>
	</ul>
</div>
