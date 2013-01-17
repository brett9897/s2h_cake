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
		<li><?php echo $this->Html->link(__('List Validation Uses'), array('controller' => 'validation_uses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Validation Use'), array('controller' => 'validation_uses', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Validation Uses'); ?></h3>
	<?php if (!empty($validation['ValidationUse'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Question Id'); ?></th>
		<th><?php echo __('Validations Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($validation['ValidationUse'] as $validationUse): ?>
		<tr>
			<td><?php echo $validationUse['id']; ?></td>
			<td><?php echo $validationUse['question_id']; ?></td>
			<td><?php echo $validationUse['validations_id']; ?></td>
			<td><?php echo $validationUse['created']; ?></td>
			<td><?php echo $validationUse['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'validation_uses', 'action' => 'view', $validationUse['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'validation_uses', 'action' => 'edit', $validationUse['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'validation_uses', 'action' => 'delete', $validationUse['id']), null, __('Are you sure you want to delete # %s?', $validationUse['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Validation Use'), array('controller' => 'validation_uses', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
