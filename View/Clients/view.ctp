<?php $this->Html->css('Clients/view', null, array('inline' => false)); ?>
<div class="actionsNoButton">
    <a href="#">List Survey Instances</a><br/>
</div>
<div class="clients view">
    <h2><?php echo __('Client'); ?></h2>
    
    <?php echo $this->Html->image($photoName, array(
        'style' => "float: left; width:267px; height:200px"
        )); ?>
        <div class="data-area">
            <div class="clear">
                <div class="label"><?php echo __('Organization'); ?></div>
                <div class="data">
                    <?php echo $this->Html->link($client['Organization']['name'], array('controller' => 'organizations', 'action' => 'view', $client['Organization']['id'])); ?>
                </div>
            </div>
            <div class="clear">
                <div class="label"><?php echo __('First Name'); ?></div>
                <div class="data">
                    <?php echo h($client['Client']['first_name']); ?>
                    &nbsp;
                </div>
            </div>
            <div class="clear">
                <div class="label"><?php echo __('Last Name'); ?></div>
                <div class="data">
                    <?php echo h($client['Client']['last_name']); ?>
                    &nbsp;
                </div>
            </div>
            <div class="clear">
                <div class="label"><?php echo __('Ssn'); ?></div>
                <div class="data">
                    <?php echo h($client['Client']['ssn']); ?>
                    &nbsp;
                </div>
            </div>
            <div class="clear">
                <div class="label"><?php echo __('Dob'); ?></div>
                <div class="data">
                    <?php echo h($client['Client']['dob']); ?>
                    &nbsp;
                </div>
            </div>
            <?php foreach( $vi_scores as $vi_score ): ?>
                <div class="clear">
                    <div class="label"><?php echo h($vi_score['Survey']['label']) . __(' score'); ?></div>
                    <div class="data">
                        <?php echo h($vi_score['SurveyInstance']['vi_score']); ?>
                        &nbsp;
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
</div>