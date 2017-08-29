<?php
namespace BOLETA_SERIALIZACION;
class CdgItem{
    public $TpoCodigo;
    public $VlrCodigo;
    
    public function CdgItem($TpoCodigo = "", $VlrCodigo = ""){
        $this->setTpoCodigo($TpoCodigo);
        $this->setVlrCodigo($VlrCodigo);
    }
    
    function getTpoCodigo() {
        return $this->TpoCodigo;
    }

    function getVlrCodigo() {
        return $this->VlrCodigo;
    }

    function setTpoCodigo($TpoCodigo) {
        $this->TpoCodigo = $TpoCodigo;
    }

    function setVlrCodigo($VlrCodigo) {
        $this->VlrCodigo = $VlrCodigo;
    }

}