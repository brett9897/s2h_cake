<div class="organizations view no-border">
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


