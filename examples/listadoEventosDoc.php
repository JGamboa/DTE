<?php
error_reporting(E_ALL ^ E_WARNING);
ini_set('display_errors', 1);
require_once('../libs/databaseConnect.php');
require_once('../libs/nusoap/nusoap.php');
require_once('../libs/extensions.php');
require_once('../libs/ConsultasWsSii.php');
require_once('../libs/RegistroAccionSii.php');

$empresa = $_GET["empresa"];
$tipoDoc =  $_GET["tipoDoc"];
$folio = $_GET["folio"];

if(!in_array($tipoDoc, array(33,34,43))){
    die('Error en tipo de documento');
}

for ($i=0; $i<10; $i++) {
    $tokenSII = ConexionAutomaticaSII($empresa, $mensaje);

    //1 => No se encontro el certificado
    if($tokenSII == "1"){
        break;
    }

    if ($tokenSII != FALSE){
        break;
    }
}

$pRutEmisor   = substr ($empresa, 0, -2);
$pDigEmisor   = substr ($empresa, -1);
$consultas_ws = ConsultasWsSii::getModel($empresa, $tipoDoc, $folio, $tokenSII, "",$empresa);

if($consultas_ws !== false){

	$consultas_listado = ConsultasWsSii::listarEventosHistDoc($empresa, $tipoDoc, $folio, $tokenSII);

	if($consultas_listado !== false){
	    
	    if(isset($consultas_listado['listaEventosDoc'])){

	        foreach($consultas_listado['listaEventosDoc'] as $listado){

	            if(isset($consultas_listado['listaEventosDoc']['codEvento'])){
	                $accionDoc = $consultas_listado['listaEventosDoc']['codEvento'];  
	                $descResp = utf8_encode($consultas_listado['listaEventosDoc']['descEvento']);
	                $date = DateTime::createFromFormat('d-m-Y H:i:s', $consultas_listado['listaEventosDoc']['fechaEvento']);
	            }else{
	                $accionDoc = $listado['codEvento'];
	                $descResp = utf8_encode($listado['descEvento']);
	                $date = DateTime::createFromFormat('d-m-Y H:i:s', $listado['fechaEvento']);
	            }

				$db->where("tipoDoc", $tipoDoc);
				$db->where("accionDoc", $accionDoc);
				$db->where("rutEmisor", $empresa);
				$db->where("folio", $folio);
				$cnt = $db->getValue("registro_accion_sii", "count(idregistro_accion_sii)");

				if($cnt == 0){
	                $registro = new RegistroAccionSii();
	                $registro->rutEmisor = $empresa;
	                $registro->tipoDoc = $tipoDoc;
	                $registro->folio = $folio;
	                $registro->accionDoc = $accionDoc;
	                $registro->descResp = $descResp;
	                $registro->fechaEvento = $date->format('Y-m-d H:i:s');                                        
	                $registro->pendiente = 0;
	                $id = $registro->save();  
                    if($id){
                        echo "Se registro la accion en la BD<br/>";
                    }else{
                    	echo "No se logro registrar la accion en la BD<br/>";
                    }  
				}

	            if(isset($consultas_listado['listaEventosDoc']['codEvento'])){
	                break;
	            }
	        }

		}else{
			if(isset($consultas_listado['codResp'])){
				print_r($consultas_listado);
			}else{
				echo "Error no se logro guardar ni realizar la consulta";
			}
		}


	}else{
		echo "Existio un error al intertar conectar con el SII";    
	}
}else{
	echo "Error de conexion";
}
