<?php
namespace BOLETA_SERIALIZACION;
class InfoTicket{
    public $FolioTicket;
    public $FchGenera;
    public $NmbEvento;
    public $TpoTiket;
    public $CdgEvento;
    public $FchEvento;
    public $LugarEvento;
    public $UbicEvento;
    public $FilaUbicEvento;
    public $AsntoUbicEvento;
    
    function getFolioTicket() {
        return $this->FolioTicket;
    }

    function getFchGenera() {
        return $this->FchGenera;
    }

    function getNmbEvento() {
        return $this->NmbEvento;
    }

    function getTpoTiket() {
        return $this->TpoTiket;
    }

    function getCdgEvento() {
        return $this->CdgEvento;
    }

    function getFchEvento() {
        return $this->FchEvento;
    }

    function getLugarEvento() {
        return $this->LugarEvento;
    }

    function getUbicEvento() {
        return $this->UbicEvento;
    }

    function getFilaUbicEvento() {
        return $this->FilaUbicEvento;
    }

    function getAsntoUbicEvento() {
        return $this->AsntoUbicEvento;
    }

    function setFolioTicket($FolioTicket) {
        $this->FolioTicket = $FolioTicket;
    }

    function setFchGenera($FchGenera) {
        $this->FchGenera = $FchGenera;
    }

    function setNmbEvento($NmbEvento) {
        $this->NmbEvento = $NmbEvento;
    }

    function setTpoTiket($TpoTiket) {
        $this->TpoTiket = $TpoTiket;
    }

    function setCdgEvento($CdgEvento) {
        $this->CdgEvento = $CdgEvento;
    }

    function setFchEvento($FchEvento) {
        $this->FchEvento = $FchEvento;
    }

    function setLugarEvento($LugarEvento) {
        $this->LugarEvento = $LugarEvento;
    }

    function setUbicEvento($UbicEvento) {
        $this->UbicEvento = $UbicEvento;
    }

    function setFilaUbicEvento($FilaUbicEvento) {
        $this->FilaUbicEvento = $FilaUbicEvento;
    }

    function setAsntoUbicEvento($AsntoUbicEvento) {
        $this->AsntoUbicEvento = $AsntoUbicEvento;
    }

}