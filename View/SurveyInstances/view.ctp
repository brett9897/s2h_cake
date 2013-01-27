<?php include("surveyInstanceDiv.ctp"); ?>

<div class="surveyInstances view">
    <h2><?php echo __('Survey for Client ' . $surveyInstance['Client']['first_name']); ?></h2>
    <dl>
        <dt><?php echo __('Vi Score'); ?></dt>
        <dd>
            <?php echo h($surveyInstance['SurveyInstance']['vi_score']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Client First Name'); ?></dt>
        <dd>
            <?php echo h($surveyInstance['Client']['first_name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Client Last Name'); ?></dt>
        <dd>
            <?php echo h($surveyInstance['Client']['last_name']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Client SSN'); ?></dt>
        <dd>
            <?php echo h($surveyInstance['Client']['ssn']); ?>
            &nbsp;
        </dd>
        <dt><?php echo __('Client DOB'); ?></dt>
        <dd>
            <?php echo h($surveyInstance['Client']['dob']); ?>
            &nbsp;
        </dd>
        <?php foreach ($surveyInstance['Survey']['Question'] as $question): ?>
            <dt><?php echo __($question['label']); ?></dt>
            <dd>
                <?php foreach ($question['Answer'] as $answer): ?>
                    <?php echo h($answer['value']); ?>
                    <br />
                <?php endforeach; ?>
            </dd>
        <?php endforeach; ?>
    </dl>
</div>

