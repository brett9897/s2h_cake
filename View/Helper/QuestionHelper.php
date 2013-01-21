<?php

class QuestionHelper extends AppHelper {

    public $helpers = array('Html');

    public function giveMeInputTag($question) {
        $questionLabel = $question['label'];
        $type = $question['Type']['label'];
        $output;
        
        switch ($type) {
           
            //text fields
            case "text":
                $output = $questionLabel . "<input type=\"text\">";
                break;
            
            //text box
            case "textarea":
                $output = $questionLabel . "<input type=\"textarea\">";
                break;
            
            case "checkbox":
                break;
            
            case "radio":
                break;
            
            //dropdown menu box
            case "select":
                $output = "<select>";
                foreach($question['Option'] as $option) {
                    $optionTag = "<option>". $option['label'] . "</option>";
                    $output .= $optionTag;
                }
                $output .= "</select>";
                break;
        }

        return $output;
    }
}

?>