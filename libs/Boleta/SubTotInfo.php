<?php
namespace BOLETA_SERIALIZACION;
class SubTotInfo{
    private $NroSTI;
    private $GlosaSTI; 
    private $OrdenSTI;
    private $SubTotNetoSTI;
    private $SubTotIVASTI;
    private $SubTotAdicSTI;
    private $SubTotExeSTI;
    private $ValSubtotSTI;
    private $LineasDeta;
    
    function getNroSTI() {
        return $this->NroSTI;
    }

    function getGlosaSTI() {
        return $this->GlosaSTI;
    }

    function getOrdenSTI() {
        return $this->OrdenSTI;
    }

    function getSubTotNetoSTI() {
        return $this->SubTotNetoSTI;
    }

    function getSubTotIVASTI() {
        return $this->SubTotIVASTI;
    }

    function getSubTotAdicSTI() {
        return $this->SubTotAdicSTI;
    }

    function getSubTotExeSTI() {
        return $this->SubTotExeSTI;
    }

    function getValSubtotSTI() {
        return $this->ValSubtotSTI;
    }

    function getLineasDeta() {
        return $this->LineasDeta;
    }

    function setNroSTI($NroSTI) {
        $this->NroSTI = $NroSTI;
    }

    function setGlosaSTI($GlosaSTI) {
        $this->GlosaSTI = $GlosaSTI;
    }

    function setOrdenSTI($OrdenSTI) {
        $this->OrdenSTI = $OrdenSTI;
    }

    function setSubTotNetoSTI($SubTotNetoSTI) {
        $this->SubTotNetoSTI = $SubTotNetoSTI;
    }

    function setSubTotIVASTI($SubTotIVASTI) {
        $this->SubTotIVASTI = $SubTotIVASTI;
    }

    function setSubTotAdicSTI($SubTotAdicSTI) {
        $this->SubTotAdicSTI = $SubTotAdicSTI;
    }

    function setSubTotExeSTI($SubTotExeSTI) {
        $this->SubTotExeSTI = $SubTotExeSTI;
    }

    function setValSubtotSTI($ValSubtotSTI) {
        $this->ValSubtotSTI = $ValSubtotSTI;
    }

    function setLineasDeta($LineasDeta) {
        $this->LineasDeta[] = $LineasDeta;
    }

    
}