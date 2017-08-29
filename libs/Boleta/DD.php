<?php
namespace BOLETA_SERIALIZACION;
class DD{
    public $RE; // Representa el rut del emisor del documento
    public $TD; // Representa el tipo de documento actual del documento
    public $F; //Representa el folio del documento actual 
    public $FE; // Representa la fecha de emision del documento actual
    public $RR; // Representa el rut del receptor del documento actual
    public $RSR; // Representa razon social del documento actual
    public $MNT; // Representa el monto total del documento actual
    public $IT1; // Representa el nombre del primer item del documento
    public $CAF; //Representa el nodo caf temporal
    public $TSTED;
    
    function getRE() {
        return $this->RE;
    }

    function getTD() {
        return $this->TD;
    }

    function getF() {
        return $this->F;
    }

    function getFE() {
        return $this->FE;
    }

    function getRR() {
        return $this->RR;
    }

    function getRSR() {
        return $this->RSR;
    }

    function getMNT() {
        return $this->MNT;
    }

    function getIT1() {
        return $this->IT1;
    }

    function getCAF() {
        return $this->CAF;
    }

    function getTSTED() {
        return $this->TSTED;
    }
    
    function setRE($RE) {
        $this->RE = $RE;
    }

    function setTD($TD) {
        $this->TD = $TD;
    }

    function setF($F) {
        $this->F = $F;
    }

    function setFE($FE) {
        $this->FE = $FE;
    }

    function setRR($RR) {
        $this->RR = $RR;
    }

    function setRSR($RSR) {
        $this->RSR = $RSR;
    }

    function setMNT($MNT) {
        $this->MNT = $MNT;
    }

    function setIT1($IT1) {
        $this->IT1 = $IT1;
    }

    function setCAF($CAF) {
        $this->CAF = $CAF;
    }
    
    function setTSTED($TSTED) {
        $this->TSTED = $TSTED;
    }    

}