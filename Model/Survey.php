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

    public function hasInstance()
    {
        $conditions = array(
            'survey_id' => $this->id
        );
        $params = array('recursive' => -1, 'conditions' => $conditions);
        return ($this->SurveyInstance->find('count', $params) > 0) ? true : false;
    }

    public function getSurveyName()
    {
        $conditions = array(
            'id' => $this->id
        );
        $fields = array('Survey.label');
        $params = array('recursive' => -1, 'fields' => $fields, 'conditions' => $conditions);

        $result = $this->find('first', $params);

        return $result['Survey']['label'];
    }

    public function clone_survey($data)
    {
        $dataSource = $this->getDataSource();
        $old_survey = $this->find('first', array('conditions' => array('Survey.id' => $this->id)));
        $this->create();

        $new_survey = array();
        $new_survey['Survey'] = $data['Survey'];

        $dataSource->begin();

        if( $this->save($new_survey['Survey']) )
        {
            $new_survey['Grouping'] = $old_survey['Grouping'];
            foreach( $new_survey['Grouping'] as &$grouping )
            {
                unset($grouping['id']);
                $grouping['survey_id'] = $this->id;
            }
            unset($grouping);

            $new_survey['Question'] = array();

            $i = 0;
            foreach( $new_survey['Grouping'] as $grouping )
            {
                $this->Grouping->create();
                if( $this->Grouping->save($grouping) )
                {
                    //find questions that should be associated with this grouping
                    foreach( $old_survey['Question'] as $question )
                    {
                        if( $question['grouping_id'] == $old_survey['Grouping'][$i]['id'] )
                        {
                            $new_question = $question;
                            unset($new_question['id']);
                            unset($new_question['created']);
                            unset($new_question['modified']);
                            $new_question['survey_id'] = $this->id;
                            $new_question['grouping_id'] = $this->Grouping->id;
                            $new_survey['Question'][] = $new_question;
                        }
                    }
            
                }
                else
                {
                    $dataSource->rollback();
                    return false;
                }

                $i++;
            }

            //now save questions
            //can't do saveAll because it creates a nested transaction.
            foreach( $new_survey['Question'] as $question )
            {
                $this->Question->create();
                if( !$this->Question->save($question) )
                {
                    $dataSource->rollback();
                    return false;
                }
            }
        }
        else
        {
            $dataSource->rollback();
            return false;
        }

        $dataSource->commit();
        return true;
    }

    public static function myNotEmpty($check) {
        if (is_array($check)) {
            extract(self::_defaults($check));
        }

        if (empty($check) && $check != '0') {
            return false;
        }
        return preg_match('/[^\s]+/m', $check);
    }
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
