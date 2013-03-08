<div class="users form no-border">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('password', array('autocomplete' => 'off', 'value' => '', 'required' => false));
        echo $this->Form->input('password_confirmation', array('type'=>'password', 'required' => false));
	?>
     <div class="submit">
         <?php echo $this->Form->submit(__('Submit', true), array('name' => 'submit', 'div' => false)); ?>
         <?php echo $this->Form->submit(__('Cancel', true), array('name' => 'cancel','div' => false)); ?>
     </div>
     </fieldset>                   
 <?php echo $this->Form->end();?>

</div>

