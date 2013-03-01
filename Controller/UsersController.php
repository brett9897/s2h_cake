<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {
    
    /**
     * Lee: Standard login method 
     */
    public function login() {
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
                $this->redirect($this->Auth->redirect());
            } else {
                $this->Session->setFlash('Your username/password combination was incorrect');
            }
        }
    }

    /**
     * Lee - standard logout method
     */
    public function logout() {
        $this->redirect($this->Auth->logout());
    }

    /**
     * Brett - Workaround for when an admin's session timesout.
     */
    public function admin_login()
    {
        $this->login();
        $this->render('login');
    }

    public function beforeFilter(){
        parent::beforeFilter();                                 //calls the parent's class before beforeFilter()...the AppControler
        $this->Security->ValidatePost=FALSE;
        $this->Security->csrfCheck=FALSE;
        $this->Security->requireSecure(array('login'));
    }
    
    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->User->recursive = 0;
        $this->set('users', $this->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        $this->set('user', $this->User->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->User->create();
            $this->request->data['User']['pwd'] = $this->request->data['User']['password'];             //this will allow the password to be hashed...and not rehash when you edit a user
            $user = $this->Auth->user();                                  //gives user obj for currently logged in 
            //var_dump($this->request->data);
            $this->request->data['User']['organization_id'] = $user['organization_id'];
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        }
        $organizations = $this->User->Organization->find('list');           //list just creats an assoc array btwn ID and display
        $this->set(compact('organizations'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
        $organizations = $this->User->Organization->find('list');
        $this->set(compact('organizations'));
    }

    /**
     * admin_delete method
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('User deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('User was not deleted'));
        $this->redirect(array('action' => 'index'));
    }
    
    
    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->User->id = $id;
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Invalid user'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->User->save($this->request->data)) {
                $this->Session->setFlash(__('The user has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The user could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->User->read(null, $id);
        }
        $organizations = $this->User->Organization->find('list');
        $this->set(compact('organizations'));
    }
    
        /**
     * change_password method
     *
     * @throws NotFoundException
     * @param string $id if ()
     * @return void
     */
    public function change_password($id = null) {
        $this->User->id = $id;                                                  //How does it get the user id?....it is set null!
        if (isset($this->request->data['cancel'])) {
            $this->Session->setFlash(__('Password changes were cancelled.', true));
            $this->redirect( array('action' => 'edit', $this->User->id) );  
        }
        else {

            if (!$this->User->exists()) {
                throw new NotFoundException(__('Invalid user'));
            }
            if ($this->request->is('post') || $this->request->is('put')) {                  //this checks to see if the form has been submitted
                 $this->request->data['User']['pwd'] = $this->request->data['User']['password'];
                 //$this->User->save($this->request->data);   
                 if( $this->User->save($this->request->data) ){
                    $this->Session->setFlash(__('Password has been Saved.'));
                    $this->redirect( array('action' => 'edit', $this->User->id) );                 
                 }
            }else {
                $this->request->data = $this->User->read(null, $id);
            }   
        }
    }

}

