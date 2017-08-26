<?php
/**
 * This is the model class for table "consultas_ws_sii".
 *
 * The followings are the available columns in table 'consultas_ws_sii':
 * @property string $idconsulta_ws_sii
 * @property string $rutEmisor
 * @property integer $tipoDoc
 * @property string $folio
 * @property string $fechaRecepcionSii
 * @property integer $codResp_cedible
 * @property string $desc_cedible
 * @property string $empresa
 */
class ConsultasWsSii extends dbObject
{

    protected $dbTable = "consultas_ws_sii";
    protected $primaryKey = "idconsulta_ws_sii";	

	protected $dbFields = Array(
		'rutEmisor' => Array('text', 'required'),
		'tipoDoc' => Array('int'),
		'folio' => Array('int'),
		'fechaRecepcionSii' => Array('datetime'),
		'empresa' => Array('text', 'required'),
	);	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'idconsulta_ws_sii' => 'Idconsulta Ws Sii',
			'rutEmisor' => 'Rut Emisor',
			'tipoDoc' => 'Tipo Doc',
			'folio' => 'Folio',
			'fechaRecepcionSii' => 'Fecha Recepcion Sii',
			'codResp_cedible' => 'Cod Resp Cedible',
			'desc_cedible' => 'Desc Cedible',
		);
	}

	public function findByAttributes($array){
		foreach($array as $key => $value){
			$this->where($key, $value);
		}
		
		return $this->getOne();
	}

	/**
	 * Returns the static model date of SII WebService, if exist doenst create
	 * If not exist creates it
	 * 
	 * 
	 */
	public static function getModel($rutEmisor, $tipoDoc, $folio, $tokenSII, $idemisor = "", $empresa){
		$cs = new ConsultasWsSii();
	    $consultas_ws = $cs->findByAttributes(array('rutEmisor'=>$rutEmisor,'tipoDoc'=>$tipoDoc,'folio'=>$folio, 'empresa'=>$empresa));

	    
	    if($consultas_ws === NULL){
	        $consultas_ws = ConsultasWsSii::consultarFRecepcionSII($rutEmisor, $tipoDoc, $folio, $tokenSII, $empresa);
	    }
		
	    return $consultas_ws;
	}

	public static function consultarFRecepcionSII($rutEmisor, $tipoDoc, $folio, $tokenSII, $empresa){
	    
	    $pRutEmisor   = substr ($rutEmisor, 0, -2);
	    $pDigEmisor   = substr ($rutEmisor, -1);
	    
        $cliente = new nusoap_client(Constantes::WSRegistroReclamoProduccion, true);

	   
	    $cliente->setCookie("TOKEN", $tokenSII);
	    $result = $cliente->call('consultarFechaRecepcionSii', 
	                                array(          
	                                        'rutEmisor' => "$pRutEmisor",
	                                        'dvEmisor' => "$pDigEmisor",
	                                        'tipoDoc' => "$tipoDoc",
	                                        'folio' => "$folio",
	                                    ) 
	                            );

	    if ($cliente->fault) {
	        return false;
	    }else{
	        if(isset($result) & $result != ""){
	            $date = DateTime::createFromFormat('d-m-Y H:i:s', $result);
	            $consultas_ws = new ConsultasWsSii();
	            $consultas_ws->empresa = $empresa;
	            $consultas_ws->fechaRecepcionSii = $date->format('Y-m-d H:i:s');
	            $consultas_ws->folio = $folio;
	            $consultas_ws->rutEmisor = $rutEmisor;
	            $consultas_ws->tipoDoc = $tipoDoc;
	            $id = $consultas_ws->save();
	            if($id){
	            	echo "Tabla consultas_ws_sii, ingresado con ID" . $id . "<br/>";
	            	return $consultas_ws;
	            }else{
	            	echo "Valor no ingresado en tabla consultas_ws_sii";
	            	return false;	
	            }
	            
	        }
	    }
	}

	public static function listarEventosHistDoc($rutEmisor, $tipoDoc, $folio, $tokenSII){
        $cliente = new nusoap_client(Constantes::WSRegistroReclamoProduccion, true);

        $pRutEmisor   = substr ($rutEmisor, 0, -2);
        $pDigEmisor   = substr ($rutEmisor, -1);

	    $cliente->setCookie("TOKEN", $tokenSII);

	    $result = $cliente->call('listarEventosHistDoc', 
	                                array(          
	                                        'rutEmisor' => "$pRutEmisor",
	                                        'dvEmisor' => "$pDigEmisor",
	                                        'tipoDoc' => "$tipoDoc",
	                                        'folio' => "$folio",
	                                    ) 
	                            );
	    if ($cliente->fault) {
	        return false;
	    }else{
	    	return $result;
	   	}  
	}


}


