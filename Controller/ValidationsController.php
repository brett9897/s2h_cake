<?php
App::uses('AppController', 'Controller');
/**
 * Validations Controller
 *
 * @property Validation $Validation
 */
class ValidationsController extends AppController {

	public $uses = array('InternalValidation');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Validation->recursive = 0;
		$this->set('validations', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Validation->id = $id;
		if (!$this->Validation->exists()) {
			throw new NotFoundException(__('Invalid validation'));
		}
		$this->set('validation', $this->Validation->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Validation->create();
			if ($this->Validation->save($this->request->data)) {
				$this->Session->setFlash(__('The validation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The validation could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Validation->id = $id;
		if (!$this->Validation->exists()) {
			throw new NotFoundException(__('Invalid validation'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Validation->save($this->request->data)) {
				$this->Session->setFlash(__('The validation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The validation could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Validation->read(null, $id);
		}
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
		$this->Validation->id = $id;
		if (!$this->Validation->exists()) {
			throw new NotFoundException(__('Invalid validation'));
		}
		if ($this->Validation->delete()) {
			$this->Session->setFlash(__('Validation deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Validation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Validation->recursive = 0;
		$this->set('validations', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Validation->id = $id;
		if (!$this->Validation->exists()) {
			throw new NotFoundException(__('Invalid validation'));
		}
		$this->set('validation', $this->Validation->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Validation->create();
			if ($this->Validation->save($this->request->data)) {
				$this->Session->setFlash(__('The validation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The validation could not be saved. Please, try again.'));
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Validation->id = $id;
		if (!$this->Validation->exists()) {
			throw new NotFoundException(__('Invalid validation'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Validation->save($this->request->data)) {
				$this->Session->setFlash(__('The validation has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The validation could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Validation->read(null, $id);
		}
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
		$this->Validation->id = $id;
		if (!$this->Validation->exists()) {
			throw new NotFoundException(__('Invalid validation'));
		}
		if ($this->Validation->delete()) {
			$this->Session->setFlash(__('Validation deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Validation was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
