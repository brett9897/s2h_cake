<?php
App::uses('AppController', 'Controller');
/**
 * Groupings Controller
 *
 * @property Grouping $Grouping
 */
class GroupingsController extends AppController {

	public function isAuthorized($user = null)
	{
		//non admin pages can be accessed by anyone
		if( empty($this->request->params['admin']) )
		{
			return true;
		}

		//only admins can access admin actions
		if( isset($this->request->params['admin']) )
		{
			return (bool)($user['type'] === 'admin' || $user['type'] === 'superAdmin');
		}

		//default deny
		return false;
	}
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Grouping->recursive = 0;
		$this->set('groupings', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Grouping->id = $id;
		if (!$this->Grouping->exists()) {
			throw new NotFoundException(__('Invalid grouping'));
		}
		$this->set('grouping', $this->Grouping->read(null, $id));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index($id = null) {
		$this->Grouping->recursive = 0;
		if( $id != null )
		{
			$this->paginate = array( 'conditions' => array('Grouping.survey_id' => $id));
		}
		$this->set('groupings', $this->paginate('Grouping'));
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Grouping->id = $id;
		if (!$this->Grouping->exists()) {
			throw new NotFoundException(__('Invalid grouping'));
		}
		$this->set('grouping', $this->Grouping->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Grouping->create();
			if ($this->Grouping->save($this->request->data)) {
				$this->Session->setFlash(__('The grouping has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The grouping could not be saved. Please, try again.'));
			}
		}
		$surveys = $this->Grouping->Survey->find('list');
		$this->set(compact('surveys'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Grouping->id = $id;
		if (!$this->Grouping->exists()) {
			throw new NotFoundException(__('Invalid grouping'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Grouping->save($this->request->data)) {
				$this->Session->setFlash(__('The grouping has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The grouping could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Grouping->read(null, $id);
		}
		$surveys = $this->Grouping->Survey->find('list');
		$this->set(compact('surveys'));
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
		$this->Grouping->id = $id;
		if (!$this->Grouping->exists()) {
			throw new NotFoundException(__('Invalid grouping'));
		}
		if ($this->Grouping->delete()) {
			$this->Session->setFlash(__('Grouping deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Grouping was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
