<?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $grouping['Grouping']['id'])); ?>
<?php echo $this->Form->input('survey_id', array('type' => 'hidden', 'value' => $grouping['Grouping']['id'])); ?>
<table>
	<tr>
		<th>Order</th>
		<th>Question</th>
		<th>Type</th>
		<th>Options</th>
		<th>Used?</th>
		<th>Edit</th>
	</tr>
<?php foreach( $grouping['Question'] as $question ): ?>
	<tr id="question_<?php echo $question['id'];?>" class="question">
		<td><?php echo $this->Form->input('ordering', array( 'type' => 'text', 'label' => '', 'size' => 2, 'class' => 'ordering', 'value' => $question['ordering']));?></td>
		<td><?php echo $question['label'];?></td>
		<td><?php echo $question['type_id'];?></td>
		<td></td>
		<td><?php echo $this->Binary->convertToTF($question['is_used']);?></td>
		<td><?php echo $this->Html->link('edit', array('controller' => 'questions', 'action' => 'edit', $question['id']));?></td>
	</tr>
<?php endforeach; ?>
</table>
<br/>
<br/>
<input type="button" value="Update Order" onClick="update_order(this)" />