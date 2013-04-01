<?php echo $this->Form->input('id', array('type' => 'hidden', 'value' => $grouping['Grouping']['id'])); ?>
<?php echo $this->Form->input('survey_id', array('type' => 'hidden', 'value' => $grouping['Grouping']['id'])); ?>
<?php echo $this->element('survey_edit_question_table', array( 'questions' => $grouping['Question'])); ?>
<br/>
<br/>
<input type="button" value="Update Order" onClick="update_order(this)" />
<?php if(!$hasInstance): ?>
	<input type="button" value="Add Question" onClick="add_question(<?php echo $grouping['Grouping']['id'];?>)" />
<?php endif; ?>