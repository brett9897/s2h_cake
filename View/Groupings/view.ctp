<div class="groupings view">
<h2><?php  echo __('Grouping'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($grouping['Grouping']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Survey'); ?></dt>
		<dd>
			<?php echo $this->Html->link($grouping['Survey']['label'], array('controller' => 'surveys', 'action' => 'view', $grouping['Survey']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Label'); ?></dt>
		<dd>
			<?php echo h($grouping['Grouping']['label']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ordering'); ?></dt>
		<dd>
			<?php echo h($grouping['Grouping']['ordering']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Used'); ?></dt>
		<dd>
			<?php echo h($grouping['Grouping']['is_used']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($grouping['Grouping']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($grouping['Grouping']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Grouping'), array('action' => 'edit', $grouping['Grouping']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Grouping'), array('action' => 'delete', $grouping['Grouping']['id']), null, __('Are you sure you want to delete # %s?', $grouping['Grouping']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Groupings'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Grouping'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Surveys'), array('controller' => 'surveys', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Survey'), array('controller' => 'surveys', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('controller' => 'questions', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Questions'); ?></h3>
	<?php if (!empty($grouping['Question'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Grouping Id'); ?></th>
		<th><?php echo __('Internal Name'); ?></th>
		<th><?php echo __('Label'); ?></th>
		<th><?php echo __('Type Id'); ?></th>
		<th><?php echo __('Ordering'); ?></th>
		<th><?php echo __('Is Used'); ?></th>
		<th><?php echo __('Is Required'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($grouping['Question'] as $question): ?>
		<tr>
			<td><?php echo $question['id']; ?></td>
			<td><?php echo $question['grouping_id']; ?></td>
			<td><?php echo $question['internal_name']; ?></td>
			<td><?php echo $question['label']; ?></td>
			<td><?php echo $question['type_id']; ?></td>
			<td><?php echo $question['ordering']; ?></td>
			<td><?php echo $question['is_used']; ?></td>
			<td><?php echo $question['is_required']; ?></td>
			<td><?php echo $question['created']; ?></td>
			<td><?php echo $question['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'questions', 'action' => 'view', $question['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'questions', 'action' => 'edit', $question['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'questions', 'action' => 'delete', $question['id']), null, __('Are you sure you want to delete # %s?', $question['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Question'), array('controller' => 'questions', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
