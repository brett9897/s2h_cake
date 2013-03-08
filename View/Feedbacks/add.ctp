<div class="actionsNoButton">

    <?php echo $this->Html->link(__('List Feedbacks'), array('action' => 'index')); ?><br />

</div>

<div class="feedbacks form">
    <?php echo $this->Form->create('Feedback'); ?>
    <fieldset>
        <legend><?php echo __('Add Feedback'); ?></legend>
        <?php
        echo $this->Form->input('feedback');
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>

