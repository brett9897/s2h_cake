<?php 
	$this->Html->script('VI_Criteria/admin_add.js', false);
	$this->Html->css('VI_Criteria/admin_add', null, array('inline' => false));
?>
<div class="actionsNoButton">
	<?php echo $this->Html->link(__('List VI Criteria'), array('action' => 'index', $survey_id)); ?><br/>
</div>
<div class="viCriteria form">
<?php echo $this->Form->create('ViCriterium'); ?>
	<fieldset>
		<legend><?php echo __('Add VI Criterion'); ?></legend>
	<?php
		echo $this->Form->input('type', array('type' => 'select', 'options' => array_combine($type_options, $type_options)));
	?>
		<div id="question" class="doNotShow">
		<?php
			echo $this->Form->input('question_id', array('empty' => 'Choose Question...'));
			echo $this->Form->input('relational_operator', array('type' => 'select', 'options' => array_combine($relational_operator_options, $relational_operator_options)));
		?>
			<div id="values_text" class="doNotShow">
				<?php echo $this->Form->input('values'); ?>
			</div>
			<div id="values_select" class="doNotShow">
				<div id="values">
					<span id="plus_image">plus sign</span><span id="words">Click to add values</span>
				</div>

				<div id="value_options">
				</div>
			</div>
		</div>
		<div id="groupings" class="doNotShow">
			<div id="groupings_select">
				<div id="grouping_add">
					<span id="plus_image">plus sign</span><span id="words">Click to add values</span>
				</div>

				<div id="grouping_options">
				</div>
			</div>
		</div>
		<?php
			echo $this->Form->input('weight');
		?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>

	<div id="values_form" title="Select a value to add.">
		<form>
			<fieldset>
			</fieldset>
		</form>
	</div>
	<div id="groupings_form" title="Select a grouping to add.">
		<form>
			<fieldset>
				<?php echo $this->Form->input('grouping_id'); ?>
				<?php echo $this->Form->input('response_value', array('label' => 'Positive Response Value:')); ?>
			</fieldset>
		</form>
	</div>
</div>