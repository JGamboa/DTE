<?php
namespace BOLETA_SERIALIZACION;
class DD{
    private $RE; // Representa el rut del emisor del documento
    private $TD; // Representa el tipo de documento actual del documento
    private $F; //Representa el folio del documento actual 
    private $FE; // Representa la fecha de emision del documento actual
    private $RR; // Representa el rut del receptor del documento actual
    private $RSR; // Representa razon social del documento actual
    private $MNT; // Representa el monto total del documento actual
    private $IT1; // Representa el nombre del primer item del documento
    private $CAF; //Representa el nodo caf temporal
    private $TSTED;
    
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