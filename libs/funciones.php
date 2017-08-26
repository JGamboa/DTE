<?php
require_once("nusoap/nusoap.php");
require_once("xmlseclibs/XmlseclibsAdapter.php");
        if(!function_exists("array_column"))
        {

            function array_column($array,$column_name)
            {

                return array_map(function($element) use($column_name){return $element[$column_name];}, $array);

            }

        }
        
function getTextBetweenTags($string, $tagname, $tagnameEnd)
 {
    $pattern = "/<$tagname>(.*?)<$tagnameEnd>/";
    preg_match($pattern, $string, $matches);
    return $matches[1];
 }
 
 function getTextBetweenTagsENV($string, $tagname)
 {
    $pattern = "/<$tagname>(.*?)<\/$tagname>/";
    $matches = array();
    preg_match($pattern, $string, $matches);
    return $matches[1];
 }         
        
    function multipart_build_query($fields, $boundary, $file = ""){
      $retval = '';
      $ruta = realpath($file);
      foreach($fields as $key => $value){
          if($key=="archivo"){
           $retval .= "$boundary\r\nContent-Disposition: form-data; name=\"$key\"; filename=\"$ruta\"\r\n"; 
           $retval .= "Content-Type: text/xml\r\n\r\n";
           $dom4 = new DOMDocument;
           $dom4->formatOutput = False;
           $dom4->preserveWhiteSpace = True;
           $dom4->loadXML(file_get_contents($ruta));
           $retval .= $dom4->saveXML() . "\r\n\r\n";  
          }else{
           $retval .= "$boundary\r\nContent-Disposition: form-data; name=\"$key\"\r\n\r\n$value\r\n";  
          }

      }
      $retval .= "$boundary--\r\n";
      return $retval;
    }        
  
  
function ConexionAutomaticaSII($empresa){     
    /*@var $empresa Emisores */
        try{
            $cliente = new nusoap_client(Constantes::SemillaProduccion, false);
            $result = $cliente->call('getSeed');
            
            if ($cliente->fault) { 
                   return false;
                }    
                
        $seed = new DOMDocument;
        $seed->loadXML($result);
        $semilla = $seed->getElementsByTagName("SEMILLA")->item(0)->nodeValue;
        $estado = $seed->getElementsByTagName("ESTADO")->item(0)->nodeValue;

        if($estado == "00"){
            $xmlr = simplexml_load_string($result);
            $nombre_semilla = md5(uniqid());
            $xmlr->saveXML("semillas/" . $nombre_semilla .".xml");           
            $body = "<getToken><item><Semilla>$semilla</Semilla></item></getToken>";
            $dom = new DOMDocument;
            $dom->formatOutput = FALSE;
            $dom->preserveWhiteSpace = TRUE;
            $dom->loadXML($body);
            
            $xmlTool = new FR3D\XmlDSig\Adapter\XmlseclibsAdapter();
            $key = array();
            $pfx = file_get_contents("certif/".$empresa.".pfx");
            $clave = file_get_contents("certif/".$empresa.".txt");
            openssl_pkcs12_read($pfx, $key, $clave);
            $xmlTool->setPrivateKey($key["pkey"]);
            $xmlTool->setpublickey($key["cert"]);
            $xmlTool->addTransform(FR3D\XmlDSig\Adapter\XmlseclibsAdapter::ENVELOPED);
            $xmlTool->sign($dom);
            $nombre_token = md5(uniqid());
            $dom->save("semillas/". $nombre_token .".xml");

            $TokenClient = new nusoap_client(Constantes::TokenProduccion, false);
            $rs = $TokenClient->call('getToken', array($dom->saveXML()));
            
                if ($TokenClient->fault) {
                       return false;
                }
                
            /***** OBTENER EL TOKEN *****/
            $formato = str_replace( 'SII:', '', $rs );
            $xml = simplexml_load_string($formato);
            $tokenSII = $xml->RESP_BODY->TOKEN;
            /***** OBTENER EL TOKEN *****/  
            
            unlink("semillas/". $nombre_token .".xml");     
            unlink("semillas/". $nombre_semilla .".xml");       
            
            if($tokenSII == NULL){
               return false;
            }
                
            return $tokenSII;
            
            }else{
                echo "Error con conexion SII, Error numero : " . $estado;
                return false;
            }
            
        }catch(SoapFault $exception){
            echo "ERROR <br/>";
            echo $exception->getTraceAsString();
            echo $exception->getMessage();
            die();
        }            
}    
    	
    function buildSign($toSign, $privkey) {

        $signature = null;
	$priv_key = $privkey;
	$pkeyid = openssl_get_privatekey($priv_key);
        openssl_sign($toSign, $signature, $priv_key, OPENSSL_ALGO_SHA1);
	openssl_free_key($pkeyid);
	$base64 = base64_encode($signature);
	return $base64;
    }    
   
function enviarAlReceptor($model, $correo = ""){
    /* @var $model EnviosDtes */
    /* @var $parametros ParametrosSistema */
    /* @var $empresas_sii EmpresasSii */
    require_once('lib/mailer/PHPMailerAutoload.php');
            
    /* EN ESTA LINEAS BUSCA EN LA BASE DE DATOS QUE SE BAJA DESDE EL SII, SI LA EMPRESA EXISTE COMO RECEPTOR ELECTRONICO
       SI EXISTE OBTIENE LOS DATOS PARA ENVIAR LOS XML A SU CORREO, SI NO LOS ENVIA COMO RESPALDO A FACTURAELECTRONICA GESTIONDTE
    */
            $empresas_sii = new EmpresasSii();
            $empresas_sii = $empresas_sii->ObjectBuilder()->where('rut',$model->rutreceptor);
                      
            $mensaje = "";
            
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';
            $mail->Host = "smtp.gmail.com";
            $mail->Port = 465;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
            $mail->Username = "facturaelectronica@gestiondte.cl";
            $mail->Password = "gestpyme2018";
            $mail->setFrom('facturaelectronica@gestiondte.cl', 'SERVICIO GESTPYME');
            
            if(isset($empresas_sii->mail_intercambio)){
                $mail->addAddress($empresas_sii->mail_intercambio);
                $mail->addCC("facturaelectronica@gestiondte.cl");
                
                if($correo != ""){
                    $mail->addCC($correo);
                }
                
            }elseif(!isset($empresas_sii->mail_intercambio)){
                $mail->addAddress("facturaelectronica@gestiondte.cl"); 
            }
            
            $empresa_nombre = "";
            
            if(isset($empresas_sii->razon_social)){
                $empresa_nombre = $empresas_sii->razon_social;
            }
            
            $mail->Subject = "ENVIO DOCUMENTO ELECTRONICO";
            $body = "";
            $body .= "<b>SRES. $empresa_nombre</b>";
            $body .= "<br><br>DE ACUERDO A LA NORMATIVA LEGAL VIGENTE, ENVIAMOS DOCUMENTO TRIBUTARIO ELECTRONICO";
            $body .= "<br><br>SE ADJUNTA XML.";	            
            $mail->isHTML(true);
            $mail->msgHTML($body);
            $mail->AddAttachment($model->rutemisor . "/envios/" . $model->setdte_id . ".xml", $model->setdte_id. ".xml" , 'base64', 'application/octet-stream');

            //send the message, check for errors
            if (!$mail->send()) {
                echo "Mailer Error: " . $mail->ErrorInfo;
                $mensaje .= "Error al enviar el correo $mail->ErrorInfo<br/>";
            } else {
                echo "<br/> <h1>XML ENVIADO AL RECEPTOR</h1>";
                //$valid = $valid && true;
                //$mensaje .= "RESPUESTAS RECEPCION ENVIADAS<br/>";
            }
}    

    function enviarAlSII($model){
        //MODEL REPRESENTA A LOS DATOS REPRESENTATIVOS DEL UPLOAD AL SII
        $empresa = $model->rutemisor;
        
        for ($i=0; $i<10; $i++) {
            $tokenSII = ConexionAutomaticaSII($empresa);
                if ($tokenSII != FALSE){
                    break;
                }
        }      
        
        if($tokenSII === FALSE){
            return false;
        }
        
        $mensaje = "";
            
        $pRutEnvia   = substr ($model->rutenvia,0, -2);
        $pDigEnvia   = substr ($model->rutenvia, -1);
        $pRutEmpresa  =  substr ($model->rutemisor,0, -2);
        $pDigEmpresa  = substr ($model->rutemisor, -1);  

        $file = $empresa . "/envios/" . $model->setdte_id . ".xml";
        $data = array('rutSender'=>$pRutEnvia,
                      'dvSender'=>$pDigEnvia,
                      'rutCompany'=>$pRutEmpresa,
                      'dvCompany'=>$pDigEmpresa,
                      'archivo'=>$model->setdteid . ".xml");
        $agent = "Mozilla/5.0 (compatible; PROG 1.0; Windows NT 5.0; YComp 5.0.2.4)";
        $boundary = '--7d23e2a11301c4';
        //lo que hace es generar el cuerpo de la query segun cada dato que se debe enviar
        $cuerpo = multipart_build_query($data, $boundary, $file);
        //$bodyLength = strlen($cuerpo);  

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, Constantes::UploadProduccion);
        //$host = "palena.sii.cl";

        curl_setopt($ch, CURLOPT_PORT, 443);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $cuerpo);          
        curl_setopt($ch, CURLOPT_HTTPHEADER, 
                    array("POST /cgi_dte/UPL/DTEUpload HTTP/1.0", 
                    "Accept: */*", 
                    "Content-Type:multipart/form-data: boundary=7d23e2a11301c4", 
                    "User-Agent: $agent",
                    "Cookie: TOKEN=$tokenSII")); 
            
        //AQUI SE REALIZAN 10 INTENTOS DE UPLOAD, SI EN UNO DE ESOS INTENTOS SALE SATISFACTORIO AUTOMATICAMENTE SALE
        //DEL LOOP
        for ($i=0; $i<10; $i++) {
            $response = curl_exec($ch);
            if ($response and $response!='Error 500')
                break;
        }            
        
        //si no hay error se genera una variable como simplexml para poder manejar sus nodos
        //y así obtener status, trackid, etc.
        $responseXML = ($response and $response!='Error 500') ? new \SimpleXMLElement($response, LIBXML_COMPACT) : false;
        
        if($responseXML === false)
        {
            $mensaje .= 'Curl error: ' . curl_error($ch);
        }elseif(!is_numeric((string)$responseXML->TRACKID)){
                $mensaje .= 'Curl error: ' . curl_error($ch);
        }else{
            $estadoUpload = (int)(string)$responseXML->STATUS;
            $rspUpload = "";
            
            if($estadoUpload == 0){
                $rspUpload = "Upload OK";
                $TRACKID = (int)(string)$responseXML->TRACKID;;
                //Yii::app()->user->setFlash('success', $TRACKID); 
                $model->trackid = $TRACKID;          
            }

            if($estadoUpload == 1){
                $rspUpload = "El Sender no tiene permiso para enviar";
            }

                
            if($estadoUpload == 2){
                $rspUpload = "Error en tamaño del archivo(muy grande o muy chico)";
            }

            if($estadoUpload == 3){
                $rspUpload = "Archivo cortado(tamaño <> al parámetro size";
            }

            if($estadoUpload == 5){
                $rspUpload = "No está autenticado";
            }

            if($estadoUpload == 6){
                $rspUpload = "Empresa no autorizada a enviar archivos";
            }

            if($estadoUpload == 7){
                $rspUpload = "Esquema Invalido";
            }

            if($estadoUpload == 8){
                $rspUpload = "Firma del Documento";
            }

            if($estadoUpload == 9){
                $rspUpload = "Sistema Bloqueado";
            }
            
            $model->timestamp =  date("Y-m-d H:i:s"); 
            $model->status = $estadoUpload;
            $model->rspUpload = $rspUpload;
            $model->update();           
         }
      
            echo "$response";
            echo "<br/> <h1>$mensaje</h1>";
            if(isset($rspUpload)) echo "<br/> RESPUESTA:".$rspUpload;
            if(isset($estadoUpload)) echo"<br/> ESTADO:".$estadoUpload;
            if(isset($TRACKID)) echo "<br/> TRACKID: $TRACKID";
          
            curl_close ($ch);
        }
        
        function generarXMLReceptor($idenvio){
        /*@var $db MysqliDb */  
        /*@var $model EnviosDtes */ 
        $model = EnviosDtes::ObjectBuilder()->where("idenvio_dte", $idenvio)->getOne();    
            
        $doc = new DOMDocument("1.0", "ISO-8859-1");
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
        $fragment = $doc->createDocumentFragment();            
            
        $timezone = new DateTimeZone('America/Santiago'); 
        $date = new DateTime('', $timezone);
        $fechaTimbre = $date->format('Y-m-d\TH:i:s');  
        $subtotalDTE = "";
        $caratulaXML = "<Caratula version=\"1.0\">\n<RutEmisor>" . $model->rutemisor . "</RutEmisor>\n<RutEnvia>" . $model->rutenvia . "</RutEnvia>\n";    
        $caratulaXML .="<RutReceptor>" . $model->rutreceptor . "</RutReceptor>\n<FchResol>". $model->fecha_resolucion . "</FchResol>\n<NroResol>" . $model->numero_resolucion . "</NroResol>\n";
        $caratulaXML .="<TmstFirmaEnv>" . $fechaTimbre . "</TmstFirmaEnv>\n";
            
        $detalles = DetalleEnviosDtes::ObjectBuilder()->where("idenvio_contribuyente", $idenvio)->get();
                       
        $SubTotDTE = array();
        foreach($detalles AS $detalle){
                $SubTotDTE[] = array('TpoDTE'=>$detalle->tipo_dte);
            }
            
        $SubTotDTEF = array_count_values(array_column($SubTotDTE, 'TpoDTE'));
        foreach($SubTotDTEF AS $tipo => $cantidad){
            $subtotalDTE .= "<SubTotDTE>\n<TpoDTE>" . $tipo . "</TpoDTE>\n<NroDTE>" . $cantidad . "</NroDTE>\n</SubTotDTE>\n";
        }        
    
        $caratulaXML .= $subtotalDTE . "</Caratula>\n";
        $EnvioDTE = "<EnvioDTE version=\"1.0\" xmlns=\"http://www.sii.cl/SiiDte\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sii.cl/SiiDte EnvioDTE_v10.xsd\">\n";
        $EnvioDTE .= "<SetDTE ID=\"" . $model->setdte_id . "\">\n" . $caratulaXML . "</SetDTE>\n</EnvioDTE>";
            
        $fragment->appendXML($EnvioDTE);  
        $doc->appendChild($fragment);
            
        $SetDTE = $doc->getElementsByTagName("SetDTE")->item(0);

        foreach($detalles AS $detalle){
            $Documento = new DOMDocument();
            $Documento->formatOutput = FALSE;
            $Documento->preserveWhiteSpace = TRUE;
            $Documento->load($detalle->rutemisor . "/output/" . $detalle->archivo_xml);
            $Documento->encoding = "ISO-8859-1";
            $NodoDTE = $Documento->getElementsByTagName("DTE")->item(0);                
            $importar = $doc->importNode($NodoDTE, true);
            $SetDTE->appendChild($importar);             
        }          
            
        $DTE = $doc->getElementsByTagName('DTE');
        foreach($DTE as $DT){
            $DT->removeAttributeNS('http://www.w3.org/2000/09/xmldsig#','default');
        }    
            
        $key = array();
        $xmlTool = new FR3D\XmlDSig\Adapter\XmlseclibsAdapter();
    	$pfx = file_get_contents("certif/". $model->rutemisor .".pfx");
    	$clave = file_get_contents("certif/". $model->rutemisor .".txt");
    	openssl_pkcs12_read($pfx, $key, $clave);
    	$xmlTool->setPrivateKey($key["pkey"]);
    	$xmlTool->setpublickey($key["cert"]);
    	$xmlTool->addTransform(FR3D\XmlDSig\Adapter\XmlseclibsAdapter::ENVELOPED);
    	$xmlTool->sign($doc, "ENVIO");                
    	$doc->save($model->rutemisor . "/envios/$model->setdte_id.xml"); 
        
        enviarAlReceptor($model);
        }    
        
    function generarXMLEmpaque($idenvio){
        /*@var $db MysqliDb */  
        $model = new EnviosDtes();
        $model = $model->ObjectBuilder()->where("idenvio_dte", $idenvio)->getOne();                    

        $doc = new DOMDocument("1.0", "ISO-8859-1");
        $doc->formatOutput = FALSE;
        $doc->preserveWhiteSpace = TRUE;
   
        $fragment = $doc->createDocumentFragment();            
        $subtotalDTE = "";    
        $timezone = new DateTimeZone('America/Santiago'); 
        $date = new DateTime('', $timezone);
        $fechaTimbre = $date->format('Y-m-d\TH:i:s');  
        $caratulaXML = "<Caratula version=\"1.0\">\n<RutEmisor>" . $model->rutemisor . "</RutEmisor>\n<RutEnvia>" . $model->rutenvia . "</RutEnvia>\n";    
        $caratulaXML .="<RutReceptor>" . $model->rutreceptor . "</RutReceptor>\n<FchResol>". $model->fecha_resolucion . "</FchResol>\n<NroResol>" . $model->numero_resolucion . "</NroResol>\n";
        $caratulaXML .="<TmstFirmaEnv>" . $fechaTimbre . "</TmstFirmaEnv>\n";
            
        $detalles = DetalleEnviosDtes::ObjectBuilder()->where("idenvio_dte", $idenvio)->get();
            
        $SubTotDTE = array();
        foreach($detalles AS $detalle){
                $SubTotDTE[] = array('TpoDTE'=>$detalle->tipo_dte);
            }
            
        $SubTotDTEF = array_count_values(array_column($SubTotDTE, 'TpoDTE'));
        foreach($SubTotDTEF AS $tipo => $cantidad){
            $subtotalDTE .= "<SubTotDTE>\n<TpoDTE>" . $tipo . "</TpoDTE>\n<NroDTE>" . $cantidad . "</NroDTE>\n</SubTotDTE>\n";
        }        
    
        $caratulaXML .= $subtotalDTE . "</Caratula>\n";
        $EnvioDTE = "<EnvioDTE version=\"1.0\" xmlns=\"http://www.sii.cl/SiiDte\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sii.cl/SiiDte EnvioDTE_v10.xsd\">\n";
        $EnvioDTE .= "<SetDTE ID=\"" . $model->setdte_id . "\">\n" . $caratulaXML . "</SetDTE>\n</EnvioDTE>";
            
        $fragment->appendXML($EnvioDTE);  
        $doc->appendChild($fragment);
            
        $SetDTE = $doc->getElementsByTagName("SetDTE")->item(0);

        foreach($detalles AS $detalle){
            $Documento = new DOMDocument();
            $Documento->formatOutput = FALSE;
            $Documento->preserveWhiteSpace = TRUE;
            $Documento->load($detalle->rutemisor . "/output/" . $detalle->archivo_xml);
            $Documento->encoding = "ISO-8859-1";
            $NodoDTE = $Documento->getElementsByTagName("DTE")->item(0);                
            $importar = $doc->importNode($NodoDTE, true);
            $SetDTE->appendChild($importar);             
        }                     
            
        $DTE = $doc->getElementsByTagName('DTE');
        foreach($DTE as $DT){
            $DT->removeAttributeNS('http://www.w3.org/2000/09/xmldsig#','default');
        }    
            
        $key = array();
        $xmlTool = new FR3D\XmlDSig\Adapter\XmlseclibsAdapter();
    	$pfx = file_get_contents("certif/". $model->rutemisor .".pfx");
    	$clave = file_get_contents("certif/". $model->rutemisor .".txt");
    	openssl_pkcs12_read($pfx, $key, $clave);
    	$xmlTool->setPrivateKey($key["pkey"]);
    	$xmlTool->setpublickey($key["cert"]);
    	$xmlTool->addTransform(FR3D\XmlDSig\Adapter\XmlseclibsAdapter::ENVELOPED);
    	$xmlTool->sign($doc, "ENVIO");                
    	$doc->save($model->rutemisor . "/envios/$model->setdte_id.xml"); 
        
        enviarAlSII($model);
    }
    
    function obtenerSinUpload(){
        exit();
        $db = MysqliDb::getInstance();
        $db->where("status", NULL, "<=>");
        $db->where("setdte_id", "%_EC", "NOT LIKE");
        $results = EnviosDtes::ObjectBuilder()->get();

        foreach($results as $envio){
            generarXMLEmpaque($envio->idenvio_dte);
            generarXMLReceptor($envio->idenvio_dte);
        }
    }