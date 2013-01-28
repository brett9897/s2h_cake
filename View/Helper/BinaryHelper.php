<?php

class BinaryHelper extends AppHelper {

    public function convertToTF($val) 
    {
       return ( $val == 0 ) ? 'false' : 'true';
    }

}

?>