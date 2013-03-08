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

		if( $survey_id != null )
		{
			$this->ViCriterium->Survey->id = $survey_id;
			if( $this->ViCriterium->Survey->hasInstance() )
			{
				$this->redirect(array('controller' => 'surveys', 'action' => 'edit', $survey_id));
			}
		}

		$values_array = array();
		if ($this->request->is('post')) {
			
			$this->request->data['ViCriterium']['weight'] = $this->request->data['ViCriterium']['weight'];
			
			if( isset($this->request->data['ViCriterium']['values_array']) )
			{
				$this->request->data['ViCriterium']['values'] = implode(',', $this->request->data['ViCriterium']['values_array']);
				$values_array = $this->request->data['ViCriterium']['values_array']; //save for possible later use
				unset($this->request->data['ViCriterium']['values_array']);
			}
			if( $this->request->data['ViCriterium']['type'] === 'grouping' || $this->request->data['ViCriterium']['type'] === 'age' )
			{
				$this->request->data['ViCriterium']['question_id'] = null;
			}

			$this->request->data['ViCriterium']['survey_id'] = $survey_id;

			$this->ViCriterium->create();
			if ($this->ViCriterium->save($this->request->data)) {
				$this->Session->setFlash(__('The VI criterion has been saved'));
				$this->redirect(array('controller' => 'surveys',  'action' => 'edit', $survey_id));
			} else {
				$this->Session->setFlash(__('The vi criterium could not be saved. Please, try again.'));
				$this->set('errors', $this->ViCriterium->validationErrors);
			}
		}
		$questions = $this->ViCriterium->Question->find('list', array('conditions' => array('Question.survey_id' => $survey_id )));
		$groupings = $this->Grouping->find('list', array('conditions' => array('Grouping.survey_id' => $survey_id )));
		$this->set(compact('questions', 'groupings'));
		$this->set('survey_id', $survey_id);
		$this->set('values_array', $values_array);
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
		$survey_id = $this->ViCriterium->getSurveyId();

		if( $survey_id != null )
		{
			$this->ViCriterium->Survey->id = $survey_id;
			if( $this->ViCriterium->Survey->hasInstance() )
			{
				$this->redirect(array('controller' => 'surveys', 'action' => 'edit', $survey_id));
			}
		}
		
		$values_array = array();

		if (!$this->ViCriterium->exists()) {
			throw new NotFoundException(__('Invalid vi criterium'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->request->data['ViCriterium']['weight'] = $this->request->data['ViCriterium']['weight'];
			
			if( isset($this->request->data['ViCriterium']['values_array']) )
			{
				$this->request->data['ViCriterium']['values'] = implode(',', $this->request->data['ViCriterium']['values_array']);
				$values_array = $this->request->data['ViCriterium']['values_array']; //save for possible later use
				unset($this->request->data['ViCriterium']['values_array']);
			}
			if( $this->request->data['ViCriterium']['type'] === 'grouping' )
			{
				$this->request->data['ViCriterium']['question_id'] = null;
			}

			$this->request->data['ViCriterium']['survey_id'] = $survey_id;

			if ($this->ViCriterium->save($this->request->data)) {
				$this->Session->setFlash(__('The vi criterium has been saved'));
				$this->redirect(array('action' => 'index', $survey_id));
			} else {
				$this->Session->setFlash(__('The vi criterium could not be saved. Please, try again.'));
				$this->set('errors', $this->ViCriterium->validationErrors);
			}
		} else {
			$this->request->data = $this->ViCriterium->read(null, $id);
			if( strpos($this->request->data['ViCriterium']['values'], ',') === false )
			{
				$values_array[] = $this->request->data['ViCriterium']['values'];
			}
			else
			{
				$values_array = explode(',', $this->request->data['ViCriterium']['values']);
			}
		}
		$questions = $this->ViCriterium->Question->find('list', array('conditions' => array('Question.survey_id' => $survey_id )));
		$groupings = $this->Grouping->find('list', array('conditions' => array('Grouping.survey_id' => $survey_id )));
		$this->set(compact('questions', 'groupings'));
		$this->set('survey_id', $survey_id);
		$this->set('selected_type', $this->request->data['ViCriterium']['type']);
		$this->set('values_array', $values_array);
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
		$survey_id = $this->ViCriterium->getSurveyId();
		if (!$this->ViCriterium->exists()) {
			throw new NotFoundException(__('Invalid vi criterium'));
		}
		if ($this->ViCriterium->delete()) {
			$this->Session->setFlash(__('Vi criterium deleted'));
			$this->redirect(array('action' => 'index', $survey_id));
		}
		$this->Session->setFlash(__('Vi criterium was not deleted'));
		$this->redirect(array('action' => 'index', $survey_id));
	}


	public function admin_get_values($questionId = null)
	{
		$result = $this->get_values($questionId);
		if( count($result) > 0 )
		{
			$this->set('response', array( 'response' => array('status' => 'good', 'timestamp' => date('m-d-Y H:i:s'), 'options' => $result)));
		}
		else
		{
			$this->set('response', array( 'response' => array('status' => 'good', 'timestamp' => date('m-d-Y H:i:s'), 'options' => 'NULL')));
		}
	}

	private function get_values($questionId)
	{
		//if there are any options for the question present them as the possible values.
		$this->Option->recursive = -1;
		$result = $this->Option->find('all', array('conditions' => array('Option.question_id' => $questionId), 'fields' => array('Option.id', 'Option.label')));
		return $result;
	}
}
