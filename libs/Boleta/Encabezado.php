<?php
namespace BOLETA_SERIALIZACION;
/** 
 * @property IdDoc $IdDoc 
 * @property Emisor $Emisor 
 * @property Receptor $Receptor
 * @property Totales $Totales
*/
class Encabezado{
    private $IdDoc; // Representa la zona de descripcion del DTE actual
    private $Emisor; // Representa la zona del emisor del DTE actual
    private $Receptor; // Representa la zona del Receptor del DTE actual
    private $Transporte; // Representa la zona del transporte
    private $Totales; // Representa la zona totales del DTE actual
        
    function getIdDoc() {
        return $this->IdDoc;
    }

    function getEmisor() {
        return $this->Emisor;
    }

    function getReceptor() {
        return $this->Receptor;
    }

    function getTransporte() {
        return $this->Transporte;
    }

    function getTotales() {
        return $this->Totales;
    }

    function setIdDoc() {
        $this->IdDoc = new IdDoc();
    }

    function setEmisor() {
        $this->Emisor = new Emisor();
    }

    function setReceptor() {
        $this->Receptor = new \BOLETA_SERIALIZACION\Receptor();
    }

    function setTotales() {
        $this->Totales = new Totales();
    }
    
}