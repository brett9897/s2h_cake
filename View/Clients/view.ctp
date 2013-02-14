<div class="actionsNoButton">
    <a href="#">List Survey Instances</a><br/>
</div>
<div class="clients view">
    <h2><?php echo __('Client'); ?></h2>
    
    <?php echo $this->Html->image($imagePath, array(
        'style' => "float: left; width:200px; height:200px",
        'fullBase' => true
        )); ?>
    <dl>
        <dt><?php echo __('Organization'); ?></dt>
        <dd>
            <?php echo $this->Html->link($client['Organization']['name'], array('controller' => 'organizations', 'action' => 'view', $client['Organization']['id'])); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('First Name'); ?></dt>
        <dd>
            <?php echo h($client['Client']['first_name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Last Name'); ?></dt>
        <dd>
            <?php echo h($client['Client']['last_name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Ssn'); ?></dt>
        <dd>
            <?php echo h($client['Client']['ssn']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Dob'); ?></dt>
        <dd>
            <?php echo h($client['Client']['dob']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('IsDeleted'); ?></dt>
        <dd>
            <?php echo h($client['Client']['isDeleted']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Created'); ?></dt>
        <dd>
            <?php echo h($client['Client']['created']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Modified'); ?></dt>
        <dd>
            <?php echo h($client['Client']['modified']); ?>
            &nbsp;
        </dd>
    </dl>
</div>