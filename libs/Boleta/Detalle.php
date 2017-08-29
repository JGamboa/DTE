<?php
namespace BOLETA_SERIALIZACION;
/** 
 * @property CdgItem $CdgItem Esta propiedad referencia a la clase Documento
 * @property InfoTicket $InfoTicket Esta propiedad referencia a la clase InfoTicket
*/
class Detalle{
    public $NroLinDet;
    public $CdgItem;
    public $IndExe;
    public $ItemEspectaculo;
    public $RUTMandante;
    public $NmbItem;
    public $InfoTicket;
    public $DscItem;
    public $QtyItem;
    public $UnmdItem;
    public $PrcItem;
    public $DescuentoPct;
    public $DescuentoMonto;
    public $RecargoPct;
    public $RecargoMonto;
    public $MontoItem;

    function getNroLinDet() {
        return $this->NroLinDet;
    }

    function getCdgItem() {
        return $this->CdgItem;
    }

    function getIndExe() {
        return $this->IndExe;
    }

    function getItemEspectaculo() {
        return $this->ItemEspectaculo;
    }

    function getRUTMandante() {
        return $this->RUTMandante;
    }

    function getNmbItem() {
        return $this->NmbItem;
    }

    function getInfoTicket() {
        return $this->InfoTicket;
    }

    function getDscItem() {
        return $this->DscItem;
    }

    function getQtyItem() {
        return $this->QtyItem;
    }

    function getUnmdItem() {
        return $this->UnmdItem;
    }

    function getPrcItem() {
        return $this->PrcItem;
    }

    function getDescuentoPct() {
        return $this->DescuentoPct;
    }

    function getDescuentoMonto() {
        return $this->DescuentoMonto;
    }

    function getRecargoPct() {
        return $this->RecargoPct;
    }

    function getRecargoMonto() {
        return $this->RecargoMonto;
    }

    function getMontoItem() {
        return $this->MontoItem;
    }

    function setNroLinDet($NroLinDet) {
        $this->NroLinDet = $NroLinDet;
    }

    function setCdgItem() {
        $this->CdgItem = new \BOLETA_SERIALIZACION\CdgItem();
    }

    function setIndExe($IndExe) {
        $this->IndExe = $IndExe;
    }

    function setItemEspectaculo($ItemEspectaculo) {
        $this->ItemEspectaculo = $ItemEspectaculo;
    }

    function setRUTMandante($RUTMandante) {
        $this->RUTMandante = $RUTMandante;
    }

    function setNmbItem($NmbItem) {
        $this->NmbItem = $NmbItem;
    }

    function setInfoTicket() {
        $this->InfoTicket = new \BOLETA_SERIALIZACION\InfoTicket;
    }

    function setDscItem($DscItem) {
        $this->DscItem = $DscItem;
    }

    function setQtyItem($QtyItem) {
        $this->QtyItem = $QtyItem;
    }

    function setUnmdItem($UnmdItem) {
        $this->UnmdItem = $UnmdItem;
    }

    function setPrcItem($PrcItem) {
        $this->PrcItem = $PrcItem;
    }

    function setDescuentoPct($DescuentoPct) {
        $this->DescuentoPct = $DescuentoPct;
    }

    function setDescuentoMonto($DescuentoMonto) {
        $this->DescuentoMonto = $DescuentoMonto;
    }

    function setRecargoPct($RecargoPct) {
        $this->RecargoPct = $RecargoPct;
    }

    function setRecargoMonto($RecargoMonto) {
        $this->RecargoMonto = $RecargoMonto;
    }

    function setMontoItem($MontoItem) {
        $this->MontoItem = $MontoItem;
    }

    
}