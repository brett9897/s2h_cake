<?php

App::uses('AppModel', 'Model');

/**
 * Grouping Model
 *
 * @property Survey $Survey
 * @property Question $Question
 */
class Grouping extends AppModel {

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
        'ordering' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
            'numeric' => array(
                'rule' => array('numeric'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
        ),
        'is_used' => array(
            'boolean' => array(
                'rule' => array('boolean'),
            //'message' => 'Your custom message here',
            //'allowEmpty' => false,
            //'required' => false,
            //'last' => false, // Stop validation after this rule
            //'on' => 'create', // Limit validation to 'create' or 'update' operations
            ),
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

    /**
     * Model function
     *
     */
    public function getByOrderNumber($survey_id, $sort = "DESC") {
        return $this->find('all', array('conditions' => array('Grouping.survey_id' => $survey_id), 'order' => array('Grouping.ordering' => $sort)));
    }

    public function getListByOrderNumber($survey_id, $sort = "DESC") {
        return $this->find('list', array('conditions' => array('Grouping.survey_id' => $survey_id), 'order' => array('Grouping.ordering' => $sort)));
    }

    //The Associations below have been created with all possible keys, those that are not needed can be removed

    /**
     * belongsTo associations
     *
     * @var array
     */
    public $belongsTo = array(
        'Survey' => array(
            'className' => 'Survey',
            'foreignKey' => 'survey_id',
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
        'Question' => array(
            'className' => 'Question',
            'foreignKey' => 'grouping_id',
            'dependent' => false,
            'conditions' => '',
            'fields' => '',
            'order' => 'ordering',
            'limit' => '',
            'offset' => '',
            'exclusive' => '',
            'finderQuery' => '',
            'counterQuery' => ''
        )
    );

}
