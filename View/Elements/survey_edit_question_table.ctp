<table>
	<tr>
		<th>Order</th>
		<th>Question</th>
		<th>Type</th>
		<th>Options</th>
		<th>Used?</th>
		<th>Edit</th>
	</tr>
<?php foreach( $questions as $question ): ?>
	<tr id="question_<?php echo $question['id'];?>" class="question <?php echo str_replace(' ', '_', $question['label']);?>">
		<td><?php echo $this->Form->input('ordering', array( 'type' => 'text', 'label' => '', 'size' => 2, 'class' => 'ordering '. str_replace(' ', '_', $question['label']), 'value' => $question['ordering']));?></td>
		<td><?php echo $question['label'];?></td>
		<td><?php echo $question['Type']['label'];?></td>
		<?php
			$options = '';
			foreach($question['Option'] as $option)
			{
				$options .= $option['label'] . ', ';
			}

			if( $options != '' )
			{
				$options = substr($options, 0, -2);
			}
		?>
		<td><?php echo $options;?></td>
		<td><?php echo $this->Binary->convertToTF($question['is_used']);?></td>
		<td>
			<?php 
				if( $question['Type']['id'] != null )
				{
					echo $this->Html->link('edit', 
						array('controller' => 'questions', 'action' => 'edit', $question['id']));
				}
			?>
		</td>
	</tr>
<?php endforeach; ?>
</table>