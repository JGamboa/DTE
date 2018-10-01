<?php
namespace BOLETA_SERIALIZACION;
require_once('DD.php');
/** 
 * @property DD $DD
*/
class TED{
    private $DD;
    
    function getDD() {
        return $this->DD;
    }

    function setDD() {
        $this->DD = new \BOLETA_SERIALIZACION\DD();
    }

}