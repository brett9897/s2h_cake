<div class="actionsNoButton">
        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?> <br/>
        <?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> <br/>
        <?php echo $this->Html->link(__('List Organizations'), array('controller' => 'organizations', 'action' => 'index')); ?> <br/>
        <?php echo $this->Html->link(__('New Organization'), array('controller' => 'organizations', 'action' => 'add')); ?> <br/>
        <?php echo $this->Html->link(__('List Survey Instances'), array('controller' => 'survey_instances', 'action' => 'index')); ?> <br/>
        <?php echo $this->Html->link(__('New Survey Instance'), array('controller' => 'survey_instances', 'action' => 'add')); ?> <br/>
</div>

<div class="users form">
<?php echo $this->Form->create('User'); ?>
	<fieldset>
		<legend><?php echo __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('password');
                echo $this->Form->input('password_confirmation', array('type'=>'password'));
	?>
     <div class="submit">
         <?php echo $this->Form->submit(__('Submit', true), array('name' => 'submit', 'div' => false)); ?>
         <?php echo $this->Form->submit(__('Cancel', true), array('name' => 'cancel','div' => false)); ?>
     </div>
     </fieldset>                   
 <?php echo $this->Form->end();?>

</div>

