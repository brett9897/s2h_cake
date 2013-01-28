<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
//users, clients, feeback, help(go nowhere), reports(go nowhere), resources, Admin(go nowhere) 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo __('S2H 2.0'); ?>
		<?php echo $title_for_layout; ?>
	</title>

        <?php echo $this->Html->script('jquery-1.9.0.min.js'); ?>
        <?php echo $this->Html->script('jquery-ui-1.10.0.custom.min.js'); ?>
        <?php echo $this->Html->script('global'); ?>
        <?php echo $this->Html->script('NavActions.js'); ?>

        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('cake.generic');
        echo $this->fetch('meta');
        echo $this->fetch('css');
        echo $this->Html->css('overcast/jquery-ui-1.10.0.custom.min');
        echo $this->Html->css('styles');
        echo $this->fetch('script');
        echo $this->Html->script("toggle.js");
        echo $this->Html->script("button.js");
        ?>

        
    </head>
    
    <body>
         

        <div id="container">

            <div id="header">
                <h1>
                <?php 
                	if ($logged_in)
                	{	
                		echo $this->Html->link('S2H 2.0', array('controller' => 'welcome', 'action' => 'index'));
                	}
                	else
                	{
                		echo $this->Html->link('S2H 2.0', array('controller' => 'welcome', 'action' => 'index'));
                	}
                ?>
                </h1>
                <?php
                /*  * **************************************** 
                 *  Lee: this snippet below fixes the "login"/"logout"
                 *  message in the top right hand corner of every page
                 * **************************************** */
                ?>
                <div style="text-align: right; float: right;">
                    <?php if ($logged_in): ?>
                        Currently Logged in as: <?php echo $current_user['username']; ?> | 
                        <?php echo $this->Html->link('Edit Profile', array('controller' => 'users', 'action' => 'edit', $current_user['id'])); ?> | 
                        <script>
                            jQuery(document).ready(function(){  
                                jQuery('#top_links').removeClass('do_not_show');
                            });
                        </script>
                        <?php echo $this->Html->link('Sign Out', array('controller' => 'users', 'action' => 'logout', 'admin' => false)); ?>
                    <?php endif; ?>
                </div>

                <?php /******************************************************/ ?>

    
                <h1>&nbsp;</h1>
                <ul id="top_links" class="do_not_show">
                    <?php if ($isAtLeastAdmin): ?>
                        <li><input type="radio" id="radioSurveyAdmin" name="radioSurveyAdmin" /><label for="radioSurveyAdmin">Surveys</label></li>
                    <?php else: ?>
                        <li><input type="radio" id="radioSurvey" name="radioSurvey" /><label for="radioSurvey">Surveys</label></li>
                    <?php endif; ?>
                    <li><input type="radio" id="radio3" name="radio" /><label for="radio3">Reports</label></li>
                </ul>

            </div>

            <div id="bodyContainer" style="width:100%; ">
                <div id="content" style="width:97%;float:left; border-radius: 5px;">
                    <?php echo $this->Session->flash(); ?>

                    <?php echo $this->fetch('content'); ?>
					<div id="tipArea">
					<?php if( $tip_render != null ): ?>
                        <div id="tips" class="tipsBox">
                            <div class="tipsContent">
                                <p id="tip_header">Tips</p>
                                <!--<p>If you cannot remember your password, please talk to your organizations administrator to change it.</p> -->
                                <?php echo $tip_render; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    </div>
                </div>
                <div class="clear"></div>

                
            
            </div>
            <div id="footer" style="text-align: center; margin-left:auto; margin-left:auto;">
                <?php if ($logged_in): ?>
                    We would appreciate your <?php echo $this->Html->link('Feedback', array('controller' => 'feedbacks', 'action' => 'add')); ?> | 
                    <a href="javascript:toggle('22');">Contact</a> |
                    <?php echo $this->Html->link('Home', array('controller' => 'welcome', 'action' => 'index')); ?>
                    <p id ="22" style ="display: none">
                        <br />United Way of Metropolitan Atlanta
                        <br />100 Edgewood Avenue, N.E.
                        <br />Atlanta, Georgia 30303
                        <br /><a href="mailto:test@test.com">Send e-mail to United Way</a>
                    </p>

                <?php endif; ?>
            </div>
        </div>
    
        <?php echo $this->element('sql_dump'); ?>
        <!-- Lee commented out because I don't know what this does
        <div class="do_not_show">
            <?php //echo $this->Html->link('Resources', array('controller' => 'resources', 'action' => 'index'), array('id' => 'resources')); ?>
            <?php //echo $this->Html->link('Organizations', array('controller' => 'organizations', 'action' => 'index'), array('id' => 'organizations')); ?>
            <?php // echo $this->Html->link('Reports', array('controller' => 'reports', 'action' => 'index'), array('id' => 'reports')); ?>
            <?php //echo $this->Html->link('Users', array('controller' => 'users', 'action' => 'index'), array('id' => 'users')); ?>
            <?php //echo $this->Html->link('Customize', array('controller' => 'customize', 'action' => 'index'), array('id' => 'customize')); ?>
        </div>
        -->
        
    </body>
</html>
