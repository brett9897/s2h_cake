<?php
App::uses('AppController', 'Controller');
/**
 * Options Controller
 *
 * @property Option $Option
 */
class OptionsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Option->recursive = 0;
		$this->set('options', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Option->id = $id;
		if (!$this->Option->exists()) {
			throw new NotFoundException(__('Invalid option'));
		}
		$this->set('option', $this->Option->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Option->create();
			if ($this->Option->save($this->request->data)) {
				$this->Session->setFlash(__('The option has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The option could not be saved. Please, try again.'));
			}
		}
		$questions = $this->Option->Question->find('list');
		$this->set(compact('questions'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->Option->id = $id;
		if (!$this->Option->exists()) {
			throw new NotFoundException(__('Invalid option'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Option->save($this->request->data)) {
				$this->Session->setFlash(__('The option has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The option could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Option->read(null, $id);
		}
		$questions = $this->Option->Question->find('list');
		$this->set(compact('questions'));
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
		$this->Option->id = $id;
		if (!$this->Option->exists()) {
			throw new NotFoundException(__('Invalid option'));
		}
		if ($this->Option->delete()) {
			$this->Session->setFlash(__('Option deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Option was not deleted'));
		$this->redirect(array('action' => 'index'));
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Option->recursive = 0;
		$this->set('options', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Option->id = $id;
		if (!$this->Option->exists()) {
			throw new NotFoundException(__('Invalid option'));
		}
		$this->set('option', $this->Option->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Option->create();
			if ($this->Option->save($this->request->data)) {
				$this->Session->setFlash(__('The option has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The option could not be saved. Please, try again.'));
			}
		}
		$questions = $this->Option->Question->find('list');
		$this->set(compact('questions'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Option->id = $id;
		if (!$this->Option->exists()) {
			throw new NotFoundException(__('Invalid option'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Option->save($this->request->data)) {
				$this->Session->setFlash(__('The option has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The option could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Option->read(null, $id);
		}
		$questions = $this->Option->Question->find('list');
		$this->set(compact('questions'));
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
		$this->Option->id = $id;
		if (!$this->Option->exists()) {
			throw new NotFoundException(__('Invalid option'));
		}
		if ($this->Option->delete()) {
			$this->Session->setFlash(__('Option deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Option was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
