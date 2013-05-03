<?php echo $this->Html->script('ajaxupload-min.js', FALSE); ?>
<?php echo $this->Html->css('classicTheme/style'); ?>
<?php echo $this->Html->script("SurveyInstances/add.js", FALSE); ?>
<?php $this->Html->css('Clients/view', null, array('inline' => false)); ?>
<div class="actionsNoButton">
    <?php echo $this->Html->link(__('View'), array('action' => 'index')); ?> <br/>
    <a href="#">List Survey Instances</a><br/>
    <?php echo $this->Html->link(__('Update Photo'), array('action' => 'add_photo', $client_id), array('class' => 'active_link'));?><br/>
</div>



<div class="clientAddPhoto form">
    <table>
        <tr><td> <?php echo $this->Form->create('Client'); ?></td></tr>
        <tr>
            <td>
                        <!-------------------UPLOAD PHOTO ----------------------------------->
                        <h2>Upload Photo</h2>
                        <div class="white-background black-text">
                            <div id="image_upload" style="width:500px">
                                <script type="text/javascript">
                                    $('#image_upload').ajaxupload({
                                        url: global.base_url + '/webroot/upload.php',
                                        remotePath:<?php echo $remotePath; ?>,
                                        editFilename: true
                                    });
                                </script>
                            </div>
                        </div>

                        <?php
                        //hidden field to map photo to client
                        echo $this->Form->input('photoName', array(
                            'type' => 'hidden',
                            'id' => 'photoName',
                            'value' => 'none.png'
                        ));
                        ?>

                        <?php
                        echo $this->Form->submit('Submit', array(
                            'onClick' => 'bindPhoto()'
                        ));
                        ?>
            </td>
        </tr>
    </table>
            
</div>