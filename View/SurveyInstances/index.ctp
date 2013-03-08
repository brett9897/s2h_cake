<?php include("surveyInstanceDiv.ctp"); ?>

<div class="surveyInstances index">
    <h2><?php echo __('My Surveys'); ?></h2>
    <table cellpadding="0" cellspacing="0">
        <tr>
            <th><?php echo $this->Paginator->sort('survey_id'); ?></th>
            <th><?php echo $this->Paginator->sort('client_id'); ?></th>
            <th><?php echo $this->Paginator->sort('user_id'); ?></th>
            <th><?php echo $this->Paginator->sort('vi_score'); ?></th>
            <th class="actions"><?php echo __(''); ?></th>
        </tr>
        <?php foreach ($surveyInstances as $surveyInstance): ?>
            <tr>
                <td>
                    <?php if ($isAtLeastAdmin): ?>
                        <?php echo $this->Html->link($surveyInstance['Survey']['label'], array('controller' => 'surveys', 'action' => 'view', $surveyInstance['Survey']['id'])); ?>
                    <?php else: ?>
                        <strong><?php echo $surveyInstance['Survey']['label']; ?></strong>
                    <?php endif; ?>
                </td>
                <td>
                    <?php echo $this->Html->link($surveyInstance['Client']['first_name'] . ' ' . $surveyInstance['Client']['last_name'], array('controller' => 'clients', 'action' => 'view', $surveyInstance['Client']['id'])); ?>
                </td>
                <td>
                    <?php echo $this->Html->link($surveyInstance['User']['first_name'], array('controller' => 'users', 'action' => 'view', $surveyInstance['User']['id'])); ?>
                </td>
                <td><?php echo h($surveyInstance['SurveyInstance']['vi_score']); ?>&nbsp;</td>
                <td class="actions">
                    <?php echo $this->Html->link(__('View'), array('action' => 'view', $surveyInstance['SurveyInstance']['id'])); ?>
                    <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $surveyInstance['SurveyInstance']['id'])); ?>
                    <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $surveyInstance['SurveyInstance']['id']), null, __('Are you sure you want to delete # %s?', $surveyInstance['SurveyInstance']['id'])); ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
        <?php
        echo $this->Paginator->counter(array(
            'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
        ));
        ?>	</p>

    <div class="paging">
        <?php
        echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
        echo $this->Paginator->numbers(array('separator' => ''));
        echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
        ?>
    </div>
</div>

