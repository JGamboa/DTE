<?php
namespace BOLETA_SERIALIZACION;
class CdgItem{
    private $TpoCodigo;
    private $VlrCodigo;
    
    public function CdgItem($TpoCodigo = "", $VlrCodigo = ""){
        $this->setTpoCodigo($TpoCodigo);
        $this->setVlrCodigo($VlrCodigo);
    }
    
    public function getTpoCodigo() {
        return $this->TpoCodigo;
    }

    public function getVlrCodigo() {
        return $this->VlrCodigo;
    }

    public function setTpoCodigo($TpoCodigo) {
        $this->TpoCodigo = $TpoCodigo;
    }

    public function setVlrCodigo($VlrCodigo) {
        $this->VlrCodigo = $VlrCodigo;
    }

}