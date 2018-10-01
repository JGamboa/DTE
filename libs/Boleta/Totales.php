<?php
namespace BOLETA_SERIALIZACION;
/** 
 * @property ImptoReten[] $ImptoReten
*/
class Totales{
    private $MntNeto;
    private $MntExe;
    private $IVA;
    private $MntTotal;
    private $MontoNF;
    private $TotalPeriodo;
    private $SaldoAnterior;
    private $VlrPagar;

    function getMntNeto() {
        return $this->MntNeto;
    }

    function getMntExe() {
        return $this->MntExe;
    }

    function getIVA() {
        return $this->IVA;
    }

    function getMntTotal() {
        return $this->MntTotal;
    }

    function getMontoNF() {
        return $this->MontoNF;
    }

    function getTotalPeriodo() {
        return $this->TotalPeriodo;
    }

    function getSaldoAnterior() {
        return $this->SaldoAnterior;
    }

    function getVlrPagar() {
        return $this->VlrPagar;
    }

    function setMntNeto($MntNeto) {
        $this->MntNeto = $MntNeto;
    }

    function setMntExe($MntExe) {
        $this->MntExe = $MntExe;
    }

    function setIVA($IVA) {
        $this->IVA = $IVA;
    }

    function setMntTotal($MntTotal) {
        $this->MntTotal = $MntTotal;
    }

    function setMontoNF($MontoNF) {
        $this->MontoNF = $MontoNF;
    }

    function setTotalPeriodo($TotalPeriodo) {
        $this->TotalPeriodo = $TotalPeriodo;
    }

    function setSaldoAnterior($SaldoAnterior) {
        $this->SaldoAnterior = $SaldoAnterior;
    }

    function setVlrPagar($VlrPagar) {
        $this->VlrPagar = $VlrPagar;
    }

}