<?php
App::uses('AppController', 'Controller');
/**
 * ViCriteria Controller
 *
 * @property ViCriterium $ViCriterium
 */
class ViCriteriaController extends AppController {

	public $uses = array('ViCriterium', 'Option', 'Grouping');
	public $components = array('RequestHandler');

	function beforeFilter()
	{
		parent::beforeFilter();

		//turn off security just for these requests
		{
			if( $this->request->action === 'admin_add' )
			{
				$this->Security->validatePost = false;
				$this->Security->csrfCheck = false;
			}
		}
	}

	function beforeRender() 
	{ 
		parent::beforeRender();
		// get column type
		$type = $this->ViCriterium->getColumnType('type');
		 
		// extract values in single quotes separated by comma
		preg_match_all("/'(.*?)'/", $type, $enums);
		 
		// enums
		$this->set('type_options', $enums[1]);

		// get column type
		$type = $this->ViCriterium->getColumnType('relational_operator');
		 
		// extract values in single quotes separated by comma
		preg_match_all("/'(.*?)'/", $type, $enums);
		 
		// enums
		$this->set('relational_operator_options', $enums[1]);
  	}	 
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index($survey_id) {
		$this->paginate = array(
			'conditions' => array('ViCriterium.survey_id' => $survey_id)
		);
		$this->ViCriterium->recursive = 0;
		$this->set('viCriteria', $this->paginate());
		$this->set('survey_id', $survey_id);
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
	public function admin_add($survey_id) {
		if ($this->request->is('post')) {
			if( isset($this->request->data['ViCriterium']['values_array']) )
			{
				$values = '';
				foreach( $this->request->data['ViCriterium']['values_array'] as $value )
				{
					$values .= $value . ',';
				}

				$values = substr($values, 0, -1);

				$this->request->data['ViCriterium']['values'] = $values;
				unset($this->request->data['ViCriterium']['values_array']);
			}

			$this->ViCriterium->create();
			if ($this->ViCriterium->save($this->request->data)) {
				$this->Session->setFlash(__('The VI criterion has been saved'));
				$this->redirect(array('action' => 'index', $survey_id));
			} else {
				$this->Session->setFlash(__('The vi criterium could not be saved. Please, try again.'));
			}
		}
		$questions = $this->ViCriterium->Question->find('list', array('conditions' => array('Question.survey_id' => $survey_id )));
		$groupings = $this->Grouping->find('list', array('conditions' => array('Grouping.survey_id' => $survey_id )));
		$this->set(compact('questions', 'groupings'));
		$this->set('survey_id', $survey_id);
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


	public function admin_get_values($questionId = null)
	{
		//if there are any options for the question present them as the possible values.
		$this->Option->recursive = -1;
		$result = $this->Option->find('all', array('conditions' => array('Option.question_id' => $questionId), 'fields' => array('Option.id', 'Option.label')));
		if( count($result) > 0 )
		{
			$this->set('response', array( 'response' => array('status' => 'good', 'timestamp' => date('m-d-Y H:i:s'), 'options' => $result)));
		}
		else
		{
			$this->set('response', array( 'response' => array('status' => 'good', 'timestamp' => date('m-d-Y H:i:s'), 'options' => 'NULL')));
		}
	}
}
