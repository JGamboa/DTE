<?php
namespace BOLETA_SERIALIZACION;
class DscRcgGlobal{
    public $NroLinDR; //N�mero de descuento o recargo. De 1 a 20.
    public $TpoMov; //D(descuento) o R(recargo) 
    public $GlosaDR; //Especificaci�n de descuento o recargo 
    public $TpoValor; //Indica si es Porcentaje o Monto 
    public $ValorDR; //Valor del descuento o recargo en 16  enteros y 2 decimales
    public $IndExeDR; //Indica si el descuento o recargo afecta a �tems exentos o no afectos a IVA.

    function getNroLinDR() {
        return $this->NroLinDR;
    }

    function getTpoMov() {
        return $this->TpoMov;
    }

    function getGlosaDR() {
        return $this->GlosaDR;
    }

    function getTpoValor() {
        return $this->TpoValor;
    }

    function getValorDR() {
        return $this->ValorDR;
    }

    function getIndExeDR() {
        return $this->IndExeDR;
    }

    function setNroLinDR($NroLinDR) {
        $this->NroLinDR = $NroLinDR;
    }

    function setTpoMov($TpoMov) {
        $this->TpoMov = $TpoMov;
    }

    function setGlosaDR($GlosaDR) {
        $this->GlosaDR = $GlosaDR;
    }

    function setTpoValor($TpoValor) {
        $this->TpoValor = $TpoValor;
    }

    function setValorDR($ValorDR) {
        $this->ValorDR = $ValorDR;
    }

    function setIndExeDR($IndExeDR) {
        $this->IndExeDR = $IndExeDR;
    }

}