<div class="surveys view">
<h2><?php  echo __('Survey'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($survey['Survey']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Organization'); ?></dt>
		<dd>
			<?php echo $this->Html->link($survey['Organization']['name'], array('controller' => 'organizations', 'action' => 'view', $survey['Organization']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Label'); ?></dt>
		<dd>
			<?php echo h($survey['Survey']['label']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('IsDeleted'); ?></dt>
		<dd>
			<?php echo h($survey['Survey']['isDeleted']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($survey['Survey']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($survey['Survey']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Surveys'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Survey'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('Edit Survey'), array('action' => 'edit', $survey['Survey']['id'])); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Groupings'); ?></h3>
	<?php if (!empty($survey['Grouping'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Survey Id'); ?></th>
		<th><?php echo __('Label'); ?></th>
		<th><?php echo __('Ordering'); ?></th>
		<th><?php echo __('Is Used'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($survey['Grouping'] as $grouping): ?>
		<tr>
			<td><?php echo $grouping['id']; ?></td>
			<td><?php echo $grouping['survey_id']; ?></td>
			<td><?php echo $grouping['label']; ?></td>
			<td><?php echo $grouping['ordering']; ?></td>
			<td><?php echo $grouping['is_used']; ?></td>
			<td><?php echo $grouping['created']; ?></td>
			<td><?php echo $grouping['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'groupings', 'action' => 'view', $grouping['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'groupings', 'action' => 'edit', $grouping['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'groupings', 'action' => 'delete', $grouping['id']), null, __('Are you sure you want to delete # %s?', $grouping['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Grouping'), array('controller' => 'groupings', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
