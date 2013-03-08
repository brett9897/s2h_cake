<div class="actionsNoButton">
    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Organization.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Organization.id'))); ?> <br/>
    <?php echo $this->Html->link(__('List Organizations'), array('action' => 'index')); ?> <br/>
</div>

<div class="organizations form">
    <?php echo $this->Form->create('Organization'); ?>
    <fieldset>
        <legend><?php echo __('Admin Edit Organization'); ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('name');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>

