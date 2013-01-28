<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List Questions'), array('action' => 'index', $question['Question']['grouping_id'])); ?><br/>
	<?php echo $this->Html->link(__('Edit Question'), array('action' => 'edit', $question['Question']['id'])); ?><br/>
	<?php echo $this->Form->postLink(__('Delete Question'), array('action' => 'delete', $question['Question']['id']), null, __('Are you sure you want to delete # %s?', $question['Question']['id'])); ?><br/>
	<?php echo $this->Html->link(__('New Question'), array('action' => 'add', $question['Question']['grouping_id'])); ?><br/>
	<?php echo $this->Html->link(__('List Groupings'), array('controller' => 'groupings', 'action' => 'index', $question['Question']['survey_id'])); ?> <br/>
	<?php echo $this->Html->link(__('New Grouping'), array('controller' => 'groupings', 'action' => 'add')); ?> <br/>
</div>
<div class="questions view">
<h2><?php  echo __('Question'); ?></h2>
	<dl>
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
		<dt><?php echo __('Options'); ?></dt>
		<dd>
			<?php 
				$output = '';
				foreach( $question['Option'] as $option )
				{
					$output .= h($option['label']) . ', ';
				}
				$output = substr($output, 0, -2);

				echo $output;
			?>
			&nbsp;
		</dd>
		<dt><?php echo __('Ordering'); ?></dt>
		<dd>
			<?php echo h($question['Question']['ordering']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Used'); ?></dt>
		<dd>
			<?php echo $this->Binary->convertToTF($question['Question']['is_used']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Required'); ?></dt>
		<dd>
			<?php echo $this->Binary->convertToTF($question['Question']['is_required']); ?>
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