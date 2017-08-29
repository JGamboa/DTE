<?php
namespace BOLETA_SERIALIZACION;
class Emisor{
    public $RUTEmisor;
    public $RznSocEmisor;
    public $GiroEmisor;
    public $CdgSIISucur;
    public $DirOrigen;
    public $CmnaOrigen;
    public $CiudadOrigen;
    
    function getRUTEmisor() {
        return $this->RUTEmisor;
    }

    function getRznSocEmisor() {
        return $this->RznSocEmisor;
    }

    function getGiroEmisor() {
        return $this->GiroEmisor;
    }

    function getCdgSIISucur() {
        return $this->CdgSIISucur;
    }

    function getDirOrigen() {
        return $this->DirOrigen;
    }

    function getCmnaOrigen() {
        return $this->CmnaOrigen;
    }

    function getCiudadOrigen() {
        return $this->CiudadOrigen;
    }

    function setRUTEmisor($RUTEmisor) {
        $this->RUTEmisor = $RUTEmisor;
    }

    function setRznSocEmisor($RznSocEmisor) {
        $this->RznSocEmisor = $RznSocEmisor;
    }

    function setGiroEmisor($GiroEmisor) {
        $this->GiroEmisor = $GiroEmisor;
    }

    function setCdgSIISucur($CdgSIISucur) {
        $this->CdgSIISucur = $CdgSIISucur;
    }

    function setDirOrigen($DirOrigen) {
        $this->DirOrigen = $DirOrigen;
    }

    function setCmnaOrigen($CmnaOrigen) {
        $this->CmnaOrigen = $CmnaOrigen;
    }

    function setCiudadOrigen($CiudadOrigen) {
        $this->CiudadOrigen = $CiudadOrigen;
    }
 
}