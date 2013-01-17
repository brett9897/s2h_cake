<?php
App::uses('AppController', 'Controller');
/**
 * Groupings Controller
 *
 * @property Grouping $Grouping
 */
class GroupingsController extends AppController {

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
 * add method
 *
 * @return void
 */
	public function add() {
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
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
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
