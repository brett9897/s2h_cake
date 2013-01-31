<?php

class QuestionHelper extends AppHelper {

    public $helpers = array('Html', 'Form');

    public function giveMeInputString($question) {
        $internalName = $question['internal_name'];
        $type = $question['Type']['label'];
        $output;

        switch ($type) {

            //text fields or text areas
            case "text":
            case "textarea":
                $output = $this->Form->input($internalName, array(
                    'type' => $type,
                    'label' => '',
                        ));
                break;
            
            //text fields with refused option
            case "textWithRefused":
            case "textAreaWithRefused":
                $output = $this->Form->input($internalName, array(
                    'type' => $type,
                    'label' => ''
                        ));
                $output .= "<br />";
                $output .= $this->Form->input($internalName.' - REFUSED', array(
                    'type' => 'checkbox',
                    'label' => 'Refused',
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

                $output = $this->Form->input($internalName, array(
                    'multiple' => 'checkbox',
                    'label' => '',
                    'type' => 'select',
                    'options' => $options
                        ));
                break;

            //dropdown menu box or radio buttons
            case "select":
            case "radio":
                $options = array();
                if (!empty($question['Option'])) {
                    $i = 0;
                    foreach ($question['Option'] as $individualOption) {
                        $options[$individualOption['label']] = $individualOption['label'];
                        $i++;
                    }
                }

                $output = $this->Form->input($internalName, array(
                    'type' => $type,
                    'options' => $options,
                    'label' => '',
                    'legend' => false
                        ));
                break;
                
            //combo box with other text field
            case "selectWithOther":
                $options = array();
                if (!empty($question['Option'])) {
                    $i = 0;
                    foreach ($question['Option'] as $individualOption) {
                        $options[$individualOption['label']] = $individualOption['label'];
                        $i++;
                    }
                }
                
                $output = $this->Form->input($internalName, array(
                    'type' => 'select',
                    'options' => $options,
                    'label' => ''
                        ));
                $output .= "<br />";
                $output .= $this->Form->input($internalName . " - OTHER", array(
                    'type' => 'text',
                    'label' => 'Other'
                        ));
                break;
        }

        return $output;
    }

}

?>