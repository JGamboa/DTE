<?php
namespace BOLETA_SERIALIZACION;
class IdDoc{
    private $TipoDTE;
    private $Folio;
    private $FchEmis;
    private $IndServicio;
    private $IndMntNeto;
    private $PeriodoDesde;
    private $PeriodoHasta;
    private $FchVenc;
    
    function getTipoDTE() {
        return $this->TipoDTE;
    }

    function getFolio() {
        return $this->Folio;
    }

    function getFchEmis() {
        return $this->FchEmis;
    }

    function getIndServicio() {
        return $this->IndServicio;
    }

    function getIndMntNeto() {
        return $this->IndMntNeto;
    }

    function getPeriodoDesde() {
        return $this->PeriodoDesde;
    }

    function getPeriodoHasta() {
        return $this->PeriodoHasta;
    }

    function getFchVenc() {
        return $this->FchVenc;
    }

    function setTipoDTE($TipoDTE) {
        $this->TipoDTE = $TipoDTE;
    }

    function setFolio($folio) {
        $this->Folio = $folio;
    }

    function setFchEmis($FchEmis) {
        $this->FchEmis = $FchEmis;
    }

    function setIndServicio($IndServicio) {
        $this->IndServicio = $IndServicio;
    }

    function setIndMntNeto($IndMntNeto) {
        $this->IndMntNeto = $IndMntNeto;
    }

    function setPeriodoDesde($PeriodoDesde) {
        $this->PeriodoDesde = $PeriodoDesde;
    }

    function setPeriodoHasta($PeriodoHasta) {
        $this->PeriodoHasta = $PeriodoHasta;
    }

    function setFchVenc($FchVenc) {
        $this->FchVenc = $FchVenc;
    }    
}