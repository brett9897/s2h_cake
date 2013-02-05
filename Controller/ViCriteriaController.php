<?php
App::uses('AppController', 'Controller');
/**
 * ViCriteria Controller
 *
 * @property ViCriterium $ViCriterium
 */
class ViCriteriaController extends AppController {

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->ViCriterium->recursive = 0;
		$this->set('viCriteria', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->ViCriterium->id = $id;
		if (!$this->ViCriterium->exists()) {
			throw new NotFoundException(__('Invalid vi criterium'));
		}
		$this->set('viCriterium', $this->ViCriterium->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->ViCriterium->create();
			if ($this->ViCriterium->save($this->request->data)) {
				$this->Session->setFlash(__('The vi criterium has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vi criterium could not be saved. Please, try again.'));
			}
		}
		$questions = $this->ViCriterium->Question->find('list');
		$surveys = $this->ViCriterium->Survey->find('list');
		$options = $this->ViCriterium->Option->find('list');
		$this->set(compact('questions', 'surveys', 'options'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->ViCriterium->id = $id;
		if (!$this->ViCriterium->exists()) {
			throw new NotFoundException(__('Invalid vi criterium'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ViCriterium->save($this->request->data)) {
				$this->Session->setFlash(__('The vi criterium has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The vi criterium could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ViCriterium->read(null, $id);
		}
		$questions = $this->ViCriterium->Question->find('list');
		$surveys = $this->ViCriterium->Survey->find('list');
		$options = $this->ViCriterium->Option->find('list');
		$this->set(compact('questions', 'surveys', 'options'));
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
		$this->ViCriterium->id = $id;
		if (!$this->ViCriterium->exists()) {
			throw new NotFoundException(__('Invalid vi criterium'));
		}
		if ($this->ViCriterium->delete()) {
			$this->Session->setFlash(__('Vi criterium deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Vi criterium was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
