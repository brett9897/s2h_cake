<div class="actionsNoButton">

    <?php echo $this->Html->link(__('Edit Organization'), array('action' => 'edit', $organization['Organization']['id'])); ?><br />
    <?php echo $this->Form->postLink(__('Delete Organization'), array('action' => 'delete', $organization['Organization']['id']), null, __('Are you sure you want to delete # %s?', $organization['Organization']['id'])); ?><br />
    <?php echo $this->Html->link(__('List Organizations'), array('action' => 'index')); ?><br />
    <?php echo $this->Html->link(__('New Organization'), array('action' => 'add')); ?><br />
    

</div>

<div class="organizations view">
    <h2><?php echo __('Organization'); ?></h2>
    <dl>
        <dt><?php echo __('Id'); ?></dt>
        <dd>
            <?php echo h($organization['Organization']['id']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Name'); ?></dt>
        <dd>
            <?php echo h($organization['Organization']['name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('IsDeleted'); ?></dt>
        <dd>
            <?php echo h($organization['Organization']['isDeleted']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php echo h($organization['Organization']['created']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php echo h($organization['Organization']['modified']); ?>
            &nbsp;
        </dd>
    </dl>
</div>


