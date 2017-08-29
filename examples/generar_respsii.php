<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once('../libs/databaseConnect.php');
require_once('../libs/nusoap/nusoap.php');
require_once('../libs/extensions.php');
require_once('../libs/ConsultasWsSii.php');
require_once('../libs/RegistroAccionSii.php');

$empresa = $_GET["empresa"];
$rutEmisor = $_GET["rutEmisor"];
$tipoDoc =  $_GET["tipoDoc"];
$accionDoc = $_GET["accionDoc"];
$folio = $_GET["folio"];

if(!in_array($tipoDoc, array(33,34,43))){
    die('Error en tipo de documento');
}


$db->where("tipoDoc", $tipoDoc);
$db->where("accionDoc", $accionDoc);
$db->where("rutEmisor", $rutEmisor);
$db->where("folio", $folio);
$cnt = $db->getValue("registro_accion_sii", "count(idregistro_accion_sii)");

if($cnt > 0){
	echo "Accion registrada con anterioridad";
	exit();
}else{
    echo "Accion no registrada, procediendo a guardar <br/>";
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

$pRutEmisor   = substr ($rutEmisor, 0, -2);
$pDigEmisor   = substr ($rutEmisor, -1);
$consultas_ws = ConsultasWsSii::getModel($rutEmisor, $tipoDoc, $folio, $tokenSII, "",$empresa);

if($consultas_ws !== false){
    $date1 = new DateTime($consultas_ws->fechaRecepcionSii);
    $date2 = new DateTime(date('Y-m-d H:i:s'));
    $interval = $date1->diff($date2);

    if($interval->format('%a') < Constantes::PlazoDiasRespuestaSII){

        $cliente = new nusoap_client(Constantes::WSRegistroReclamoProduccion, true);
        $cliente->setCookie("TOKEN", $tokenSII);

        for ($i=0; $i<10; $i++) {
            $result = $cliente->call('ingresarAceptacionReclamoDoc',
                array(
                    'rutEmisor' => "$pRutEmisor",
                    'dvEmisor' => "$pDigEmisor",
                    'tipoDoc' => "$tipoDoc",
                    'folio' => "$folio",
                    'accionDoc' => "$accionDoc",
                )
            );

            if (!$cliente->fault) {
                $call = true;
                break;
            }else{
                $call = false;
            }
        }

        if($call == true) {

            if (isset($result['codResp'])) {
                if (in_array($result['codResp'], array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 19))) {
                	echo utf8_encode($result['descResp']);
        			exit();
                } else {
                    $registro = new RegistroAccionSii();
                    $registro->rutEmisor = $rutEmisor;
                    $registro->tipoDoc = $tipoDoc;
                    $registro->folio = $folio;
                    $registro->accionDoc = $accionDoc;
                    $registro->codResp = $result['codResp'];
                    $registro->descResp = utf8_encode($result['descResp']);
                    $registro->pendiente = 0;
                    $registro->fechaEvento = date('Y-m-d H:i:s');
                    $id = $registro->save();
                    if($id){
                        echo "Se registro la accion en la BD y en el SII <br/>";
                    }else{
                        echo "Se registro la accion en el SII, pero no en la BD, favor comunicarse con soporte <br/>";
                    }

                    echo $result['codResp'] . " - " . $result['descResp'];
                }
            }
        }else{
            $mensaje .= "<h2>Fault</h2><pre>";
            $mensaje .= "No se logro realizar la conexión con el SII";
            $mensaje .="</pre>";
            echo $mensaje;
        }
    }else{
        echo 'Plazo para realizar accion superada';
    }
}else{
    echo "Error no se logro guardar ni realizar la consulta";
}
