<div class="actionsNoButton">
    <?php echo $this->Html->link(__('List Organizations'), array('action' => 'index')); ?> <br/>
</div>

<div class="organizations form">
    <?php echo $this->Form->create('Organization'); ?>
    <fieldset>
        <legend><?php echo __('Admin Add Organization'); ?></legend>
        <?php
        echo $this->Form->input('name');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>

