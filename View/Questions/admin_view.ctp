<div class="questions view">
<h2><?php  echo __('Question'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($question['Question']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Survey'); ?></dt>
		<dd>
			<?php echo $this->Html->link($question['Survey']['label'], array('controller' => 'surveys', 'action' => 'view', $question['Survey']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Grouping'); ?></dt>
		<dd>
			<?php echo $this->Html->link($question['Grouping']['label'], array('controller' => 'groupings', 'action' => 'view', $question['Grouping']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Internal Name'); ?></dt>
		<dd>
			<?php echo h($question['Question']['internal_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Label'); ?></dt>
		<dd>
			<?php echo h($question['Question']['label']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Type'); ?></dt>
		<dd>
			<?php echo $this->Html->link($question['Type']['label'], array('controller' => 'types', 'action' => 'view', $question['Type']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ordering'); ?></dt>
		<dd>
			<?php echo h($question['Question']['ordering']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Used'); ?></dt>
		<dd>
			<?php echo h($question['Question']['is_used']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Required'); ?></dt>
		<dd>
			<?php echo h($question['Question']['is_required']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($question['Question']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($question['Question']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Validation 1'); ?></dt>
		<dd>
			<?php echo h($question['Question']['validation_1']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Validation 2'); ?></dt>
		<dd>
			<?php echo h($question['Question']['validation_2']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Validation 3'); ?></dt>
		<dd>
			<?php echo h($question['Question']['validation_3']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Validation 4'); ?></dt>
		<dd>
			<?php echo h($question['Question']['validation_4']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Question'), array('action' => 'edit', $question['Question']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Question'), array('action' => 'delete', $question['Question']['id']), null, __('Are you sure you want to delete # %s?', $question['Question']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Questions'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Question'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Surveys'), array('controller' => 'surveys', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Survey'), array('controller' => 'surveys', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Groupings'), array('controller' => 'groupings', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Grouping'), array('controller' => 'groupings', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Types'), array('controller' => 'types', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Type'), array('controller' => 'types', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Answers'), array('controller' => 'answers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Answer'), array('controller' => 'answers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Options'), array('controller' => 'options', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Option'), array('controller' => 'options', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Answers'); ?></h3>
	<?php if (!empty($question['Answer'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Question Id'); ?></th>
		<th><?php echo __('Client Id'); ?></th>
		<th><?php echo __('Value'); ?></th>
		<th><?php echo __('IsDeleted'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($question['Answer'] as $answer): ?>
		<tr>
			<td><?php echo $answer['id']; ?></td>
			<td><?php echo $answer['question_id']; ?></td>
			<td><?php echo $answer['client_id']; ?></td>
			<td><?php echo $answer['value']; ?></td>
			<td><?php echo $answer['isDeleted']; ?></td>
			<td><?php echo $answer['created']; ?></td>
			<td><?php echo $answer['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'answers', 'action' => 'view', $answer['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'answers', 'action' => 'edit', $answer['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'answers', 'action' => 'delete', $answer['id']), null, __('Are you sure you want to delete # %s?', $answer['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Answer'), array('controller' => 'answers', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Options'); ?></h3>
	<?php if (!empty($question['Option'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Question Id'); ?></th>
		<th><?php echo __('Label'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($question['Option'] as $option): ?>
		<tr>
			<td><?php echo $option['id']; ?></td>
			<td><?php echo $option['question_id']; ?></td>
			<td><?php echo $option['label']; ?></td>
			<td><?php echo $option['created']; ?></td>
			<td><?php echo $option['modified']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'options', 'action' => 'view', $option['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'options', 'action' => 'edit', $option['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'options', 'action' => 'delete', $option['id']), null, __('Are you sure you want to delete # %s?', $option['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Option'), array('controller' => 'options', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
