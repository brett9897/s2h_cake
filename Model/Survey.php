<?php

App::uses('AppModel', 'Model');

/**
 * Survey Model
 *
 * @property Organization $Organization
 * @property Grouping $Grouping
 * @property Question $Question
 * @property SurveyInstance $SurveyInstance
 */
class Survey extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
    public $displayField = 'label';

    /**
     * Validation rules
     *
     * @var array
     */
    public $validate = array(
        'organization_id' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'label' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
    );

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Organization' => array(
            'className' => 'Organization',
            'foreignKey' => 'organization_id',
            'conditions' => '',
            'fields' => '',
            'order' => ''
        )
    );

    /**
     * hasMany associations
     *
     * @var array
     */
    public $hasMany = array(
        'Grouping' => array(
            'className' => 'Grouping',
            'foreignKey' => 'survey_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => 'ordering',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'Question' => array(
            'className' => 'Question',
            'foreignKey' => 'survey_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => 'ordering',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        ),
        'SurveyInstance' => array(
            'className' => 'SurveyInstance',
            'foreignKey' => 'survey_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => '',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

    public function updateActiveFieldToTrue($survey_id)
    {
        //get this survey to figure out the organization id
        $surveys = $this->find('first', array('conditions' => array('id' => $survey_id), 'recursive' => -1));

        //set all surveys in this organization to be inactive.
        $this->updateAll(
            array('Survey.isActive' => false), 
            array('Survey.organization_id' => $surveys['Survey']['organization_id'])
        );

        //set this survey to active.
        $this->id = $survey_id;
        $this->saveField('isActive', true);
    }

    public function getSurveysForOrganization($organization_id, $type = 'list')
    {
        $conditions = array('Survey.organization_id' => $organization_id);
        $params = array('recursive' => -1, 'conditions' => $conditions);
        return $this->find($type, $params);
    }
}
