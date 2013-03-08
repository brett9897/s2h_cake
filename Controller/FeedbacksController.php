<?php

App::uses('AppController', 'Controller');

/**
 * Feedbacks Controller
 *
 * @property Feedback $Feedback
 */
class FeedbacksController extends AppController {

    /**
     * index method
     *
     * @return void
     */
    public function index() {
        $this->Feedback->recursive = 0;
        $this->set('feedbacks', $this->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null) {
        $this->Feedback->id = $id;
        if (!$this->Feedback->exists()) {
            throw new NotFoundException(__('Invalid feedback'));
        }
        $this->set('feedback', $this->Feedback->read(null, $id));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add() {
        if ($this->request->is('post')) {
            $user = $this->Auth->user();
            $this->request->data['Feedback']['user_id'] = $user['id'];
            $this->Feedback->create();
            if ($this->Feedback->save($this->request->data)) {
                $this->Session->setFlash(__('The feedback has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The feedback could not be saved. Please, try again.'));
            }
        }
        $users = $this->Feedback->User->find('list');
        $this->set(compact('users'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null) {
        $this->Feedback->id = $id;
        if (!$this->Feedback->exists()) {
            throw new NotFoundException(__('Invalid feedback'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            
            $user = $this->Auth->user();
            $this->request->data['Feedback']['user_id'] = $user['id'];
            
            if ($this->Feedback->save($this->request->data)) {
                $this->Session->setFlash(__('The feedback has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The feedback could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Feedback->read(null, $id);
        }
        $users = $this->Feedback->User->find('list');
        $this->set(compact('users'));
    }

    /**
     * delete method
     *
     * @throws MethodNotAllowedException
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null) {
        if (!$this->request->is('post')) {
            throw new MethodNotAllowedException();
        }
        $this->Feedback->id = $id;
        if (!$this->Feedback->exists()) {
            throw new NotFoundException(__('Invalid feedback'));
        }
        if ($this->Feedback->delete()) {
            $this->Session->setFlash(__('Feedback deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Feedback was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

    /**
     * admin_index method
     *
     * @return void
     */
    public function admin_index() {
        $this->Feedback->recursive = 0;
        $this->set('feedbacks', $this->paginate());
    }

    /**
     * admin_view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_view($id = null) {
        $this->Feedback->id = $id;
        if (!$this->Feedback->exists()) {
            throw new NotFoundException(__('Invalid feedback'));
        }
        $this->set('feedback', $this->Feedback->read(null, $id));
    }

    /**
     * admin_add method
     *
     * @return void
     */
    public function admin_add() {
        if ($this->request->is('post')) {
            $this->Feedback->create();
            if ($this->Feedback->save($this->request->data)) {
                $this->Session->setFlash(__('The feedback has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The feedback could not be saved. Please, try again.'));
            }
        }
        $users = $this->Feedback->User->find('list');
        $this->set(compact('users'));
    }

    /**
     * admin_edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function admin_edit($id = null) {
        $this->Feedback->id = $id;
        if (!$this->Feedback->exists()) {
            throw new NotFoundException(__('Invalid feedback'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Feedback->save($this->request->data)) {
                $this->Session->setFlash(__('The feedback has been saved'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The feedback could not be saved. Please, try again.'));
            }
        } else {
            $this->request->data = $this->Feedback->read(null, $id);
        }
        $users = $this->Feedback->User->find('list');
        $this->set(compact('users'));
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
        $this->Feedback->id = $id;
        if (!$this->Feedback->exists()) {
            throw new NotFoundException(__('Invalid feedback'));
        }
        if ($this->Feedback->delete()) {
            $this->Session->setFlash(__('Feedback deleted'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Feedback was not deleted'));
        $this->redirect(array('action' => 'index'));
    }

}
