<?php

/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    /**
     * Lee: User authorization code
     * Sets the path to where the user goes after logging in/out, and 
     * sets an authorization failed message.
     */
    public $components = array(
        'Session',
        'Auth' => array(
            'loginRedirect' => array('controller' => 'welcome', 'action' => 'index'),
            'logoutRedirect' => array('controller' => 'welcome', 'action' => 'index'),
            'authError' => "You can't access that page",
            'authorize' => array('Controller')
        ),
        'Security'
    );
    
    /**
     * Lee: this function checks to see if a user is authorized
     * 
     * @param type $user The user to be authorized
     */
    public function isAuthorized($user) {
        return true;
    }
    
    public function beforeFilter() {
        $this->Security->blackHoleCallback = 'forceSSL';
        $this->set('logged_in', $this->Auth->loggedIn());
        $this->set('current_user', $this->Auth->user());
        $authUser = $this->Auth->user();
        $isAtLeastAdmin = false;
        $isSuperAdmin = false;
        if ($authUser['type'] == 'admin' || $authUser['type'] == 'superAdmin') $isAtLeastAdmin = true;
        if ($authUser['type'] == 'superAdmin') $isSuperAdmin = true;
        $this->set('isAtLeastAdmin', $isAtLeastAdmin);
        $this->set('isSuperAdmin', $isSuperAdmin);
        $this->set('tip_render', null);
    }

    public function forceSSL()
    {
        if( !isset($_SERVER['REDIRECT_HTTPS']) )
            $this->redirect('https://' . $_SERVER['SERVER_NAME'] . $this->here);
    }
}
