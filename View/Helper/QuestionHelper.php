<?php

class QuestionHelper extends AppHelper {

    public $helpers = array('Html', 'Form');

    public function giveMeInputString($question) {
        $questionLabel = $question['label'];
        $type = $question['Type']['label'];
        $output;

        switch ($type) {

            //text fields or text areas
            case "text":

            //falling through
            case "textarea":
                $output = $this->Form->input($questionLabel, array(
                    'type' => $type
                        ));
                break;

            //multi-select checkboxes
            case "checkbox":
                $options = array();
                if (!empty($question['Option'])) {
                    $i = 0;
                    foreach ($question['Option'] as $individualOption) {
                        $options[$individualOption['label']] = $individualOption['label'];
                        $i++;
                    }
                }

                $output = $this->Form->input($questionLabel, array(
                    'multiple' => 'checkbox',
                    'type' => 'select',
                    'options' => $options
                        ));
                break;

            //dropdown menu box or radio buttons
            case "select":
                
            //falling through
            case "radio":
                $options = array();
                if (!empty($question['Option'])) {
                    $i = 0;
                    foreach ($question['Option'] as $individualOption) {
                        $options[$individualOption['label']] = $individualOption['label'];
                        $i++;
                    }
                }

                $output = $this->Form->input($questionLabel, array(
                    'type' => $type,
                    'options' => $options
                        ));
                break;
        }

        return $output;
    }

}

?>