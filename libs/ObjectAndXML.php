<?php
class ObjectAndXML {
	private $xml;
    public $uri;
	public $id;
 
	// Constructor
	public function __construct($iddte, $rutEmpresa) {
		$this->xml = new XmlWriter();
		$this->xml->openMemory();
	    touch(Constantes::systemPath . "empresas/$rutEmpresa/emisiones/$iddte.xml");
	    $uri = realpath(Constantes::systemPath . "empresas/$rutEmpresa/emisiones/$iddte.xml");
	    //$temp = tempnam(sys_get_temp_dir(), 'TMP_');
	    $this->xml->openURI("$uri");
		$this->xml->startDocument('1.0', 'ISO-8859-1');
		$this->xml->setIndent(TRUE);
	    $this->xml->setIndentString("");
	}
        
    public function setUri($uri){
        $this->uri = $uri;
    }
    
    public function getUri(){
        return $this->uri;
    }
    
    public function unlink(){
        unlink($this->uri);
    }
    
    public function setStartElement($startElement = ""){
        $this->xml->startElement($startElement);
        $this->xml->writeAttribute("version", "1.0");
    }
    
    public function setId($id){
        $this->id = $id;
    }
    
    public function getId(){
        return $this->id;
    }
 
	// Method to convert Object into XML string
	public function objToXML($obj) {
		$this->getObject2XML($this->xml, $obj);
		$this->xml->endElement();
        $this->xml->endDocument();
		return $this->xml->outputMemory(true);
	}
 
	// Method to convert XML string into Object
	public function xmlToObj($xmlString) {
		return simplexml_load_string($xmlString);
	}
 
	private function getObject2XML(XMLWriter $xml, $data) {
		foreach($data as $key => $value) {
			if(is_object($value)) {
				$xml->startElement($key);
                                
                if($key == "Documento" || $key == "Exportaciones"){
                    $xml->writeAttribute("ID", $this->id);      
                }
               if($key == "TED"){
                    $xml->writeAttribute("version", "1.0");      
                }                                
				$this->getObject2XML($xml, $value);
				$xml->endElement();
				continue;
			}
			else if(is_array($value)) {
				$this->getArray2XML($xml, $key, $value);
			}
 
			if (is_string($value)) {
				$xml->writeElement($key, $value);
			}
		}
	}
 
	private function getArray2XML(XMLWriter $xml, $keyParent, $data) {
		foreach($data as $key => $value) {
			if (is_string($value)) {
				$xml->writeElement($keyParent, $value);
				continue;
			}
 
			if (is_numeric($key)) {
				$xml->startElement($keyParent);
			}
 
			if(is_object($value)) {
				$this->getObject2XML($xml, $value);
			}
			else if(is_array($value)) {
				$this->getArray2XML($xml, $key, $value);
				continue;
			}
 
			if (is_numeric($key)) {
				$xml->endElement();
			}
		}
	}
}

?>